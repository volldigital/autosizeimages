<?php

namespace VOLLdigital\Autosizeimages\Listeners;

use Statamic\Events\AssetUploaded;
use VOLLdigital\Autosizeimages\Facades\Autosizer;

class AutosizeListener
{
    public function assetUploaded(AssetUploaded $event)
    {
        Autosizer::resizeAsset($event->asset);
    }
}
