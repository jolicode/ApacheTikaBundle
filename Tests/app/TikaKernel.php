<?php

/*
 * This file is part of the ApacheTikaBundle Project.
 *
 * (c) Mathieu Santo Stefano--Féron <mathieu.santostefano@gmail.com>
 */

namespace Joli\ApacheTikaBundle\Tests\app;

use Joli\ApacheTikaBundle\ApacheTikaBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class TikaKernel extends Kernel
{
    /** @var string */
    private $mode;

    /**
     * Constructor.
     *
     * @param string $mode 'cli' or 'web'
     */
    public function __construct($mode)
    {
        $this->mode = $mode;

        parent::__construct('dev', true);
    }

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = array(
            new FrameworkBundle(),
            new ApacheTikaBundle(),
        );

        return $bundles;
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->mode . '.yml');

        // graciously stolen from https://github.com/javiereguiluz/EasyAdminBundle/blob/master/Tests/Fixtures/App/AppKernel.php#L39-L45
        if ($this->isSymfony3()) {
            $loader->load(function (ContainerBuilder $container) {
                $container->loadFromExtension('framework', array(
                    'assets' => null,
                ));
            });
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tika' . ucfirst($this->mode);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return $this->getRootDir() . '/cache/' . $this->mode . '/' . $this->getEnvironment();
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return $this->getRootDir() . '/logs/' . $this->mode . '/' . $this->getEnvironment();
    }

    protected function isSymfony3()
    {
        return 3 === Kernel::MAJOR_VERSION;
    }
}
