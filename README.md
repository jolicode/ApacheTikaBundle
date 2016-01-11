[![Latest Stable Version](https://poser.pugx.org/welcomattic/apache-tika-bundle/v/stable)](https://packagist.org/packages/welcomattic/apache-tika-bundle)
[![Latest Unstable Version](https://poser.pugx.org/welcomattic/apache-tika-bundle/v/unstable)](https://packagist.org/packages/welcomattic/apache-tika-bundle)
[![Total Downloads](https://poser.pugx.org/welcomattic/apache-tika-bundle/downloads)](https://packagist.org/packages/welcomattic/apache-tika-bundle)
[![License](https://poser.pugx.org/welcomattic/apache-tika-bundle/license)](https://packagist.org/packages/welcomattic/apache-tika-bundle)

This bundle integrates the [php-apache-tika](https://github.com/vaites/php-apache-tika) library into Symfony2.

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require welcoMattic/apache-tika-bundle "~0.1"
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
            new welcoMattic\ApacheTikaBundle\ApacheTikaBundle(),
            // ...
        ];
    }
}
```

Step 3: Configuration
-------------------------

Add configuration in the `app/config/config.yml` file:

```yaml
apache_tika:
    tika_config:
        tika_host: 127.0.0.1
        tika_port: 9998
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
