<?php

/*
 * This file is part of the ApacheTikaBundle Project.
 *
 * (c) Mathieu Santo Stefano--Féron <mathieu.santostefano@gmail.com>
 */

namespace Joli\ApacheTikaBundle\Tests;

use Joli\ApacheTikaBundle\DependencyInjection\ApacheTikaExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ApacheTikaExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var ApacheTikaExtension */
    private $extension;

    /** @var ContainerBuilder */
    private $container;

    protected function setUp()
    {
        $this->extension = new ApacheTikaExtension();
        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);
    }

    protected function loadConfiguration(ContainerBuilder $container, $file)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/app/config/'));
        $loader->load($file . '.yml');
    }

    /**
     * @test
     */
    public function testCliConfiguration()
    {
        $this->loadConfiguration($this->container, 'apache_tika_cli');
        $this->container->compile();

        $this->assertInstanceOf('\Vaites\ApacheTika\Clients\CLIClient', $this->container->get('apache_tika.client'));
    }

    /**
     * @test
     */
    public function testWebConfiguration()
    {
        $this->loadConfiguration($this->container, 'apache_tika_web');
        $this->container->compile();

        $this->assertInstanceOf('\Vaites\ApacheTika\Clients\WebClient', $this->container->get('apache_tika.client'));
    }
}
