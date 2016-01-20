<?php

/*
 * This file is part of the ApacheTikaBundle Project.
 *
 * (c) Mathieu Santo Stefano--Féron <mathieu.santostefano@gmail.com>
 */

namespace welcoMattic\ApacheTikaBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ApacheTikaExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('apache_tika.config.tika_path', isset($config['config']['tika_path']) ? $config['config']['tika_path'] : null);
        $container->setParameter('apache_tika.config.tika_host', isset($config['config']['tika_host']) ? $config['config']['tika_host'] : null);
        $container->setParameter('apache_tika.config.tika_port', isset($config['config']['tika_port']) ? $config['config']['tika_host'] : null);

        if ($container->getParameter('apache_tika.config.tika_path')) {
            $client = new Definition('Vaites\ApacheTika\Clients\CLIClient');
            $client->setArguments(array(
                'apache_tika.config.tika_path' => isset($config['config']['tika_path']) ? $config['config']['tika_path'] : null,
            ));
        } else {
            $client = new Definition('Vaites\ApacheTika\Clients\WebClient');
            $client->setArguments(array(
                'apache_tika.config.tika_host' => isset($config['config']['tika_host']) ? $config['config']['tika_host'] : '127.0.0.1',
                'apache_tika.config.tika_port' => isset($config['config']['tika_port']) ? $config['config']['tika_host'] : '9998',
            ));
        }

        $container->setDefinition('apache_tika.client', $client);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yml');
    }
}
