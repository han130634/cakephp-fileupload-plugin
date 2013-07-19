# CakePHP File Upload plugin

This CakePHP 2.x plugin adds file upload functionality to your models.

## Installation

You can either download this plugin and use as is, or if you CakePHP application is version-controlled with Git (and it should be) then you can add it as a submodule.

### Downloading

If downloading, grab the [latest ZIP](https://github.com/martinbean/cakephp-fileupload-plugin/archive/master.zip) and extract it to your **app/Plugin** directory.

### Adding as a Git submodule

Navigate to the root of your Git repository and run the following command:

```
$ git submodule add https://github.com/martinbean/cakephp-fileupload-plugin app/Plugin
$ git submodule init
```

## Usage

Usage is simple. First, you need to initialize the plugin in your **app/Config/bootstrap.php** file. Add the following line somewhere:

```php
CakePlugin::load('FileUpload');
```

With the plugin loaded you can now use the model behavior in your app’s models.

## Example

A simple example usage would be as follows:

```php
<?php
class Image extends AppModel {
    
    public $actsAs = array(
        'FileUpload.FileUpload'
    );
}
```

This will add file upload functionality to your model with the default settings.

## Settings

The current settings are available:

* `allowedTypes`: an associative array; key names are a MIME type and values are the corresponding file extension
* `inputName`: the name of the input in your form (defaults to `filename`)
* `required`: a boolean; if set to `true` you’ll need to provide a file for the form to validate
* `uploadDir`: directory (relative from **app/webroot**) to move uploaded files to

## License

This plugin was created by [Martin Bean](http://www.martinbean.co.uk/) and is licensed under the MIT License.