TGM Plugin Activation
=====================

**Contributors:** Thomas Griffin (@jthomasgriffin / thomasgriffinmedia.com), Gary Jones (Github: @GaryJones / Twitter: GaryJ)  
**Version:** 2.4.0  
**Requires at least:** 3.0.0  
**Tested up to:** 3.9-beta1  

## Description ##

TGM Plugin Activation is a PHP library that allows you to easily require or recommend plugins for your WordPress themes (and plugins). It allows your users to install and even automatically activate plugins in singular or bulk fashion using native WordPress classes, functions and interfaces. You can reference pre-packaged plugins, plugins from the WordPress Plugin Repository or even plugins hosted elsewhere on the internet.

## Installation ##

1. Drop the class file somewhere in your theme hierarchy.
2. Add a `require_once` call within `functions.php` (or other theme file) referencing the class file.
3. Create a function, hooked to `tgmpa_register`, that registers the plugin and configurations.

For steps 2 and 3, it is recommended you view, copy and paste the contents of `example.php`
and amend to suit. The `example.php` file is a model for how you should include the class in your theme.

*Some important things to note:*

1. With the `require_once` call, make sure to amend the path to the correct location within your theme.
2. For plugins pulled from the .org repo, the source argument is optional. Otherwise it is required and should point
   to the absolute path for the plugin zips within your theme, or to a URL for zips elsewhere online.
3. The `$config` variable holds an array of arguments that can be used to customize aspects of the class.
   If you define an absolute default path for packaged plugins, you do not need to specify the directory path
   for your pre-packaged plugin within the `'source'` argument. You will only need to specify the zip file name.
