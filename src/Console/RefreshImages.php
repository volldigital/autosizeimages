<?php

namespace VOLLdigital\Autosizeimages\Console;

use Illuminate\Console\Command;
use Statamic\Assets\AssetContainer;
use VOLLdigital\Autosizeimages\Facades\Autosizer;

class RefreshImages extends Command
{
    protected $signature = "autosizeimages:refresh";

    protected $description = "Deletes and recreates all resized images";

    public function handle()
    {
        $this->error("");
        $this->error("This will delete all your resized images and create them from scratch according to the current config.");
        $this->warn("You may need to manually link them to all entries again.");
        $execute = $this->anticipate("Are you sure you want to do this? (y/n)", ['y', 'n'], 'y');

        if ($execute === "n") {
            return;
        }

        $files = [
            "unlink" => [],
            "refresh" => []
        ];

        foreach (AssetContainer::all() as $container) {
            foreach ($container->assets('/', true) as $asset) {
                if (!$asset->isImage()) continue;

                $file_path = $asset->resolvedPath();
                if (preg_match("/_resized(-(h|w)\d+)+\./", $file_path)) {
                    $files["unlink"][] = $file_path;
                } else {
                    $files["refresh"][] = $file_path;
                }
            }
        }

        foreach ($files["unlink"] as $file) {
            $this->warn("Deleting file: " . $file);
            unlink($file);
        }

        foreach ($files["refresh"] as $file) {
            $this->info("Recreating files for: " . $file);
            Autosizer::resizeFile($file);
        }
    }
}
