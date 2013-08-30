<?php

namespace JHV\Bundle\SeoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jhv_seo');

        // Dados gerais
        $rootNode
            ->children()
                ->scalarNode('db_driver')->defaultValue('orm')->cannotBeEmpty()->end()
                ->scalarNode('db_manager')->defaultValue('default')->cannotBeEmpty()->end()
            ->end()
        ;

        $this->addOptionsSection($rootNode);
        $this->addClassesSection($rootNode);
        $this->addDefaultDataSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Opções:
     * Definição das opções gerais da configuração.
     * 1. Utilizar banco de dados
     * 2. Diretório do DUMP referente ao sitemap
     *
     * @param   ArrayNodeDefinition     $node
     */
    protected function addOptionsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('options')
                    ->children()
                        ->scalarNode('use_database')->defaultTrue()->end()
                        ->scalarNode('sitemap_dir')->defaultValue('%kernel.root_dir%/../web')->cannotBeEmpty()->end()
                    ->end()
                    ->addDefaultsIfNotSet()
                ->end()
            ->end()
        ;
    }

    /**
     * Classes:
     * Definição das classes do objeto SEO.
     *
     * Definições:
     * Entidade, gerenciador, manuseador e gerenciador de sitemap.
     *
     * @param ArrayNodeDefinition $node
     */
    protected function addClassesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('classes')
                    ->children()
                        ->arrayNode('seo')
                            ->children()
                                ->scalarNode('entity')->defaultValue('JHV\\Bundle\\SeoBundle\\Model\\Seo')->cannotBeEmpty()->end()
                                ->scalarNode('handler')->defaultValue('JHV\\Bundle\\SeoBundle\\Handler\\SeoDataHandler')->cannotBeEmpty()->end()
                                ->scalarNode('factory')->defaultValue('JHV\\Bundle\\SeoBundle\\Factory\\SeoFactory')->cannotBeEmpty()->end()
                                ->scalarNode('manager')->defaultValue('JHV\\Bundle\\SeoBundle\\Manager\\SeoManager')->cannotBeEmpty()->end()
                                ->scalarNode('sitemap_manager')->defaultValue('JHV\\Bundle\\SeoBundle\\Manager\\SitemapManager')->cannotBeEmpty()->end()
                            ->end()
                            ->addDefaultsIfNotSet()
                        ->end()
                    ->end()
                ->addDefaultsIfNotSet()
                ->end()
            ->end()
        ;
    }

    /**
     * Dados padrões:
     * Definição dos dados principais caso as especificidades do
     * objeto SEO não exista, buscando desta forma do geral.
     *
     * @param   ArrayNodeDefinition     $node
     */
    protected function addDefaultDataSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('defaults')
                    ->children()
                        // Definições gerais
                        ->scalarNode('charset')->defaultValue('utf-8')->cannotBeEmpty()->end()
                        ->scalarNode('title')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('title_prefix')->defaultNull()->end()
                        ->scalarNode('title_suffix')->defaultNull()->end()

                        // Separadores
                        ->arrayNode('separators')
                            ->children()
                                ->scalarNode('title')->defaultValue(' ')->end()
                                ->scalarNode('keywords')->defaultValue(', ')->end()
                            ->end()
                            ->addDefaultsIfNotSet()
                        ->end()

                        // Metas
                        ->arrayNode('metas')
                            ->children()
                                ->arrayNode('name')
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->addDefaultsIfNotSet()
                ->end()
            ->end()
        ;
    }

}
