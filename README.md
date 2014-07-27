## WordPress Twig Helper ![Build Status][1]&nbsp; [![Scrutinizer Code Quality][3]][4]

A tiny Library for using [Twig][2] Templates in WordPress Plugins & Themes.

Deprecated. This repo has been merged into
[Arrow](https://github.com/dsawardekar/arrow).

# Usage

The `WpTwigHelper\TwigHelper` is a helper class that provides the bulk of
the functionality.

First give the `TwigHelper` a base directory. This will usually
correspond to your plugin or theme directory. It must contain a
`templates` sub directory that contains the `.twig` templates.

```php
<?php use WpTwigHelper\TwigHelper;

$helper = new TwigHelper();
$helper->setBaseDir(plugin_dir_path(__FILE__));
```

Then if you have the template `hello.twig` in the `templates` directory
with the contents,

```twig
Hello {{ name }}
```

You can render the template with the `render` method. It returns the
output of rendering the twig template. Use the `display` method to `echo` the output instead.

```php
<?php
$helper->render('hello', array('name' => 'there'));
```

# Precompiling Templates

You can optionally precompile the templates using the provided command
line tool, `twig_compile`. It takes the source directories to compile
and the destination to put the compiled twig templates into.

```bash
$ twig_compile -s templates -t dist/templates
```

This command can be added to your build process.

By default the `TwigHelper` looks for compiled templates in the
`dist/templates` directory. If present the Twig compilation phase is skipped.
This will speed up rendering of your templates as it's equivalent to
using inline PHP.

When `dist/templates` is absent caching is turned off instead.

# System Requirements

* Same as Twig, ie:- PHP 5.3.2+

# License

MIT License. Copyright © 2014 Darshan Sawardekar.

[1]: https://travis-ci.org/dsawardekar/wordpress-twig-helper.png
[2]: http://twig.sensiolabs.org/
[3]: https://scrutinizer-ci.com/g/dsawardekar/wordpress-twig-helper/badges/quality-score.png?s=02941b0925a4ba4ec2d9c1efcfa3e488e56d7c4c
[4]: https://scrutinizer-ci.com/g/dsawardekar/wordpress-twig-helper/
