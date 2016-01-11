<?php

namespace welcoMattic\ApacheTikaBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use welcoMattic\ApacheTikaBundle\DependencyInjection\Configuration;

class ApacheTikaExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yml');

        $container->setParameter('apache_tika.config.tika_path', isset($config['tika_config']['tika_path']) ? $config['tika_config']['tika_path'] : null);
        $container->setParameter('apache_tika.config.tika_host', $config['tika_config']['tika_host']);
        $container->setParameter('apache_tika.config.tika_port', $config['tika_config']['tika_port']);
        $clientClass = $container->getParameter('apache_tika.config.tika_path') ? 'Vaites\\ApacheTika\\Clients\\CliClient' : 'Vaites\\ApacheTika\\Clients\\WebClient';
        $container->setParameter('apache_tika.config.tika_client_class', $clientClass);
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     * @return Configuration
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration($container->getParameter('apache_tika'));
    }
}
