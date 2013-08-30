<?php

namespace JHV\Bundle\SeoBundle\Templating;

/**
 * SeoRenderer.
 * 
 * @author      Jorge Vahldick <jvahldick@gmail.com>
 * @license     Please view /Resources/meta/LICENSE
 * @copyright   (c) 2013
 */
class SeoRenderer implements SeoRendererInterface
{

    protected $twig;

    /**
     * Construtor.
     * Recebimento do TWIG para renderização.
     *
     * @param   \Twig_Environment $twig
     * @return  \JHV\Bundle\SeoBundle\Templating\SeoRenderer
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @inheritdoc
     */
    public function renderSitemap(array $entities)
    {
        return $this->twig->render('JHVSeoBundle:Generator:sitemap.xml.twig', array(
            'entities'  => $entities
        ));
    }

    /**
     * @inheritdoc
     */
    public function renderMetaCharset()
    {
        return $this->twig->render('JHVSeoBundle:Metas:meta_charset.html.twig');
    }

    /**
     * @inheritdoc
     */
    public function renderMetaNames()
    {
        return $this->twig->render('JHVSeoBundle:Metas:meta_name.html.twig');
    }

    /**
     * @inheritdoc
     */
    public function renderTitle()
    {
        return $this->twig->render('JHVSeoBundle:Metas:title.html.twig');
    }

    /**
     * @return string
     */
    public function renderMetaProperties()
    {
        return $this->twig->render('JHVSeoBundle:Metas:meta_property.html.twig');
    }

}