<?php

namespace JHV\Bundle\SeoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class JHVSeoExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $xmlLoader      = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $configuration  = new Configuration();
        $config         = $this->processConfiguration($configuration, $configs);
        $xmlLoader->load('templating.xml');
        $xmlLoader->load('services.xml');


        // Configuração de informações referente a banco de dados
        $driver = $config['db_driver'];

        // Verificar driver
        if (false === in_array($driver, array('orm'))) {
            throw new \InvalidArgumentException(sprintf(
                'The driver %s was not allowed',
                $driver
            ));
        }

        // Verificar mapeamento de banco de dados
        if (true == $config['options']['use_database']) {
            // Efetuar carregamento de configurações para o banco
            $xmlLoader->load(sprintf('driver/%s.xml', $driver));
            $container->setParameter('jhv_seo.db_driver', $driver);
            $container->setParameter('jhv_seo.db_driver.'.$driver, true);

            // Verificar qual banco de dados utilizar
            $container->setParameter('jhv_seo.db_manager.name', $config['db_manager']);

            // Substituir dados para envio do serviço de gerenciador do objeto junto ao banco de dados e sitemap
            $container->getDefinition('jhv.factory.seo')->replaceArgument(2, new Reference('jhv.manager.seo'));

            // Substituir o parâmetro referente ao diretório para salvar dados do sitemap
            $container->getDefinition('jhv.sitemap_manager.seo')->replaceArgument(2, $config['options']['sitemap_dir']);
        }

        $defaultData = (isset($config['defaults'])) ? $config['defaults'] : array();
        $container->setParameter('jhv.default_data.seo.parameter', $defaultData);

        // Mapeamento de classes
        $classes = $config['classes'];
        $this->remapClassParameters($classes, $container);
    }

    /**
     * Re(mapeamento) dos parâmetros das classes.
     *
     * @param   array               $classes
     * @param   ContainerBuilder    $container
     */
    protected function remapClassParameters(array $classes, ContainerBuilder $container)
    {
        foreach ($classes as $model => $serviceClasses) {
            foreach ($serviceClasses as $service => $class) {
                $container->setParameter(sprintf('jhv.%s.%s.class', $service, $model), $class);
            }
        }
    }

}
