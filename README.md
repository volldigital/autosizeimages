# Autosize Images

This statamic 3 addon provides you with the ability to get automagically resized images upon uploading.

## Get started

### Installation

Use the statamic marketplace to install the addon.

For evaluation purposes you may install the plugin directly via

```composer require volldigital/autosizeimages```

### Publish the config
```php artisan vendor:publish --provider="VOLLdigital\Autosizeimages\ServiceProvider" --tag="config"```

You may modify the published config and add as many formats as you need.
The config is provided in YAML format.

Example:
```
size_configs:
  -
    width: 480
  -
    width: 640
  -
    width: 900
  -
    width: 1200
  - 
    width: 400
    height: 400
```

The following resized images will be created while keeping the aspect ratio
- Width: 480px
- Width: 640px
- Width: 900px
- Width: 1200px

The following resized images will be created while _NOT_ keeping the aspect ratio
- Width: 400px, Height: 400px

### Regenerate all resized images
You can use the console command ```php artisan autosizeimages:refresh``` to delete and recreate all resized images.
You should use this with caution though, especially if you made changes to the config in between image generations.
You may need to manually link them to all entries again.
