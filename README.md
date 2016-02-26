# ApacheTikaBundle

[![Travis](https://img.shields.io/travis/jolicode/ApacheTikaBundle.svg?style=flat-square)](https://travis-ci.org/jolicode/ApacheTikaBundle)
[![Latest Stable Version](https://img.shields.io/packagist/v/jolicode/apache-tika-bundle.svg?style=flat-square)](https://packagist.org/packages/jolicode/apache-tika-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/jolicode/apache-tika-bundle.svg?style=flat-square)](https://packagist.org/packages/jolicode/apache-tika-bundle)
[![License](https://img.shields.io/packagist/l/jolicode/apache-tika-bundle.svg?style=flat-square)](https://packagist.org/packages/jolicode/apache-tika-bundle)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/a80176e6-ecea-42a6-a707-2b9dc5d641d3.svg?style=flat-square)](https://insight.sensiolabs.com/projects/a80176e6-ecea-42a6-a707-2b9dc5d641d3)

This bundle integrates the [php-apache-tika](https://github.com/vaites/php-apache-tika) library into Symfony2.

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require jolicode/apache-tika-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Joli\ApacheTikaBundle\ApacheTikaBundle(),
            // ...
        ];
    }
}
```

Step 3: Configuration
-------------------------
For tika-server :

Add configuration in the `app/config/config.yml` file:

```yaml
apache_tika:
    host: 127.0.0.1
    port: 9998
```

For tika-app :

Add configuration in the `app/config/config.yml` file:

```yaml
apache_tika:
    path: path/to/tika.jar
```

Step 4: Instantiate a client
-------------------------

In your controller, you can instantiate a client like this:

```php
<?php

/**
 * @Route("/", name="homepage")
 */
public function indexAction()
{
    $client = $this->get('apache_tika.client');
    return new Response($client->getText('robots.txt'));
}
```
