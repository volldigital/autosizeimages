<?php

namespace VOLLdigital\Autosizeimages;

use Intervention\Image\ImageManagerStatic as Image;
use Statamic\Assets\Asset;
use Statamic\Facades\YAML;

class Autosizer
{
    private $config_path;

    private array $size_configs;

    /**
     * @param $asset
     * @param $size_configs
     * @throws \Exception
     */
    public function __construct()
    {
        $this->config_path = config_path() . '/statamic/autosizeimages.yaml';

        $this->size_configs = YAML::parse(file_get_contents($this->config_path), true)["size_configs"];
    }

    public function resizeAsset(Asset $asset)
    {
        $this->resizeFn($asset->resolvedPath());
    }

    public function resizeFile(string $path)
    {
        $this->resizeFn($path);
    }

    private function resizeFn($original_path)
    {
        foreach ($this->size_configs as $size_config) {
            $suffix = "_resized";
            $image = Image::make($original_path);

            if (array_key_exists("width", $size_config) && array_key_exists("height", $size_config)) {
                $suffix .= '-w' . $size_config["width"] . "-h" . $size_config["height"];
                $image = $image->resize($size_config["width"], $size_config["height"]);
            } elseif (array_key_exists("width", $size_config)) {
                $suffix .= '-w' . $size_config["width"];
                $image = $image->resize($size_config["width"], null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } elseif (array_key_exists("height", $size_config)) {
                $suffix .= '-h' . $size_config["height"];
                $image = $image->resize(null, $size_config["height"], function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $image->save(
                pathinfo($original_path, PATHINFO_DIRNAME) .
                '/' .
                pathinfo($original_path, PATHINFO_FILENAME) .
                $suffix .
                '.' .
                pathinfo($original_path, PATHINFO_EXTENSION)
            );
        }
    }
}
