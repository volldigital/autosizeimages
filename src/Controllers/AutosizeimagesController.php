<?php

namespace VOLLdigital\Autosizeimages\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Statamic\Facades\YAML;

class AutosizeimagesController extends Controller
{
    private $pageInfo;

    private $config_path;


    public function __construct()
    {
        $this->pageInfo = array_filter(
            $this->getPackageInfo(),
            function ($key) {
                return in_array($key, ['name', 'description', 'keywords', "version", "homepage", "authors"]);
            },
            ARRAY_FILTER_USE_KEY
        );

        $this->config_path = config_path() . '/statamic/autosizeimages.yaml';
        if (!file_exists($this->config_path)) {
            $this->publishFiles();
        }
    }

    public function index()
    {
        return view("autosizeimages::index")
            ->with("pageInfo", $this->pageInfo);
    }

    public function settings()
    {
        return view("autosizeimages::settings")
            ->with("pageInfo", $this->pageInfo)
            ->with("sizeconfigs", $this->getSizeConfigs());
    }

    public function saveSettings(Request $request)
    {
        file_put_contents($this->config_path, YAML::dump($request->input()));

        return response()->json([]);
    }

    private function getSizeConfigs()
    {
        return json_encode(YAML::parse(file_get_contents($this->config_path)), true);
    }

    private function getPackageInfo()
    {
        return json_decode(file_get_contents(__DIR__ . '/../../composer.json'), true);
    }

    private function publishFiles()
    {
        Artisan::call('vendor:publish --provider="VOLLdigital\Autosizeimages\ServiceProvider"');
    }
}
