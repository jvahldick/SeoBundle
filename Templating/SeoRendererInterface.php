<?php

namespace JHV\Bundle\SeoBundle\Templating;

/**
 * SeoRendererInterface.
 * 
 * @author      Jorge Vahldick <jvahldick@gmail.com>
 * @license     Please view /Resources/meta/LICENSE
 * @copyright   (c) 2013
 */
interface SeoRendererInterface 
{

    /**
     * Efetuar a renderização das entidades, criando desta forma
     * o sitemap em formato XML.
     *
     * @param   array   $entities
     * @return  string
     */
    public function renderSitemap(array $entities);

    /**
     * Efetuar a renderização dos meta names.
     * Exemplo:
     * <meta name="" content="" />
     *
     * @return  string
     */
    public function renderMetaNames();

    /**
     * Renderização do título.
     *
     * @return  string
     */
    public function renderTitle();

    /**
     * Renderização do charset meta.
     *
     * @return  string
     */
    public function renderMetaCharset();

    /**
     * Renderização das metas propriedades.
     *
     * @return  string
     */
    public function renderMetaProperties();

}