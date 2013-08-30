<?php

namespace JHV\Bundle\SeoBundle\Twig\Extension;

use JHV\Bundle\SeoBundle\Handler\SeoDataHandlerInterface;
use JHV\Bundle\SeoBundle\Templating\SeoRendererInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * SeoExtension.
 * 
 * @author      Jorge Vahldick <jvahldick@gmail.com>
 * @license     Please view /Resources/meta/LICENSE
 * @copyright   (c) 2013
 */
class SeoExtension extends \Twig_Extension
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('seo_get_title', array($this, 'getTitle')),
            new \Twig_SimpleFunction('seo_get_description', array($this, 'getMetaDescription')),
            new \Twig_SimpleFunction('seo_get_keywords', array($this, 'getMetaKeywords')),
            new \Twig_SimpleFunction('seo_get_title', array($this, 'getTitle')),
            new \Twig_SimpleFunction('seo_get_meta_names', array($this, 'getMetaNames')),
            new \Twig_SimpleFunction('seo_get_meta_charset', array($this, 'getMetaCharset')),
            new \Twig_SimpleFunction('seo_get_meta_properties', array($this, 'getMetaProperties')),
            new \Twig_SimpleFunction('seo_render_meta_names', array($this, 'renderMetaNames'), array("is_safe" => array("html"))),
            new \Twig_SimpleFunction('seo_render_meta_charset', array($this, 'renderMetaCharset'), array("is_safe" => array("html"))),
            new \Twig_SimpleFunction('seo_render_meta_properties', array($this, 'renderMetaProperties'), array("is_safe" => array("html"))),
            new \Twig_SimpleFunction('seo_render_title', array($this, 'renderTitle'), array("is_safe" => array("html"))),
        );
    }

    /**
     * Localizar o título referente ao objeto SEO definido.
     * Caso o título original não esteja definido, irá buscar do padrão.
     *
     * @return  string
     */
    public function getTitle()
    {
        return $this->container->get('jhv.handler.seo')->getTitle();
    }

    /**
     * Localizar os meta names definidos no formato de array.
     *
     * @return  array
     */
    public function getMetaNames()
    {
        return $this->container->get('jhv.handler.seo')->getMetas('name');
    }

    /**
     * Efetuar renderização dos metas name definidos.
     *
     * @return  string
     */
    public function renderMetaNames()
    {
        return $this->container->get('jhv.templating.seo')->renderMetaNames();
    }

    /**
     * Renderização do título em arquivo html.twig.
     *
     * @return string
     */
    public function renderTitle()
    {
        return $this->container->get('jhv.templating.seo')->renderTitle();
    }

    /**
     * Localizar meta description do objeto SEO.
     *
     * @return  string
     */
    public function getMetaDescription()
    {
        return $this->container->get('jhv.handler.seo')->getDescription();
    }

    /**
     * Localizar meta keywords referente ao objeto SEO.
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->container->get('jhv.handler.seo')->getKeywords();
    }

    /**
     * Localizar o charset definido ao objeto SEO.
     *
     * @return  string
     */
    public function getMetaCharset()
    {
        return $this->container->get('jhv.handler.seo')->getCharset();
    }

    /**
     * Localizar os meta properties definidos no objeto SEO.
     *
     * @return array
     */
    public function getMetaProperties()
    {
        return $this->container->get('jhv.handler.seo')->getMetas('property');
    }

    /**
     * Efetuar a renderização do meta charset.
     *
     * @return  string
     */
    public function renderMetaCharset()
    {
        return $this->container->get('jhv.templating.seo')->renderMetaCharset();
    }

    /**
     * Efetuar renderização dos meta property referente ao objeto SEO.
     *
     * @return string
     */
    public function renderMetaProperties()
    {
        return $this->container->get('jhv.templating.seo')->renderMetaProperties();
    }

    /**
     * Localizar o objeto SEO.
     *
     * @return  \JHV\Bundle\SeoBundle\Model\SeoInterface
     */
    protected function getSeo()
    {
        return $this->container->get('jhv.handler.seo')->getSeo();
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'seo_extension';
    }

}