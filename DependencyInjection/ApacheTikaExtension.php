<?php

/*
 * This file is part of the ApacheTikaBundle Project.
 *
 * (c) Mathieu Santo Stefano--Féron <mathieu.santostefano@gmail.com>
 */

namespace Joli\ApacheTikaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
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

        $path = isset($config['path']) ? $config['path'] : null;
        $host = isset($config['host']) ? $config['host'] : '127.0.0.1';
        $port = isset($config['port']) ? $config['port'] : '9998';

        if ($path) {
            $client = new Definition('Vaites\ApacheTika\Clients\CLIClient');
            $client->setArguments(array(
                $path,
            ));
        } else {
            $client = new Definition('Vaites\ApacheTika\Clients\WebClient');
            $client->setArguments(array(
                $host,
                $port,
            ));
        }

        $container->setDefinition('apache_tika.client', $client);
    }
}
