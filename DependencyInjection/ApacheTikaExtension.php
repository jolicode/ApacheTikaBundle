<?php

/*
 * This file is part of the ApacheTikaBundle Project.
 *
 * (c) Mathieu Santo Stefano--Féron <mathieu.santostefano@gmail.com>
 */

namespace Joli\ApacheTikaBundle\DependencyInjection;

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

        $container->setParameter('apache_tika.tika_path', isset($config['tika_path']) ? $config['tika_path'] : null);
        $container->setParameter('apache_tika.tika_host', isset($config['tika_host']) ? $config['tika_host'] : null);
        $container->setParameter('apache_tika.tika_port', isset($config['tika_port']) ? $config['tika_port'] : null);

        if ($container->getParameter('apache_tika.tika_path')) {
            $client = new Definition('Vaites\ApacheTika\Clients\CLIClient');
            $client->setArguments([
                'apache_tika.tika_path' => $container->getParameter('apache_tika.tika_path') ?: null,
            ]);
        } else {
            $client = new Definition('Vaites\ApacheTika\Clients\WebClient');
            $client->setArguments([
                'apache_tika.tika_host' => $container->getParameter('apache_tika.tika_host') ?: '127.0.0.1',
                'apache_tika.tika_port' => $container->getParameter('apache_tika.tika_port') ?: '9998',
            ]);
        }

        $container->setDefinition('apache_tika.client', $client);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yml');
    }
}
