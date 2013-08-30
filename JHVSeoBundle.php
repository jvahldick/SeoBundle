<?php

namespace JHV\Bundle\SeoBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;

class JHVSeoBundle extends Bundle
{

    /**
     * @inheritdoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $this->addRegisterMappingPass($container);
    }

    /**
     * Efetuar o registro de mapeamentos para o banco de dados
     * através de modelos, e não diretamente entidades.
     *
     * @param   ContainerBuilder    $container
     * @return  void
     */
    public function addRegisterMappingPass(ContainerBuilder $container)
    {
        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'JHV\Bundle\SeoBundle\Model'
        );

        // Registro do mapeamento
        $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver(
            $mappings, array('jhv_seo.db_manager.name'), 'jhv_seo.db_driver.orm')
        );
    }

}
