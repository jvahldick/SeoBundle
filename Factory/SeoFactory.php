<?php

namespace JHV\Bundle\SeoBundle\Factory;

use JHV\Bundle\SeoBundle\Manager\SeoManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * SeoFactory.
 * 
 * @author      Jorge Vahldick <jvahldick@gmail.com>
 * @license     Please view /Resources/meta/LICENSE
 * @copyright   (c) 2013
 */
class SeoFactory implements SeoFactoryInterface
{

    protected $class;
    protected $container;
    protected $manager;
    protected static $seo;

    public function __construct($class, $container = null, SeoManagerInterface $manager = null)
    {
        $this->manager      = $manager;
        $this->container    = $container;
        $this->class        = $class;
    }

    /**
     * @inheritdoc
     */
    public function create()
    {
        $class = (null !== $this->manager) ? $this->manager->getClass() : $this->class;
        self::$seo = new $class;

        return self::$seo;
    }

    /**
     * @inheritdoc
     */
    public function getSeo()
    {
        $object = (null === self::$seo) ? $this->create() : self::$seo;
        if (null !== $this->manager) {
            $entity = $this->manager->findByLinkCanonical($this->getUri());
            $object = $entity ?: $object;
        }

        self::$seo = $object;
        return self::$seo;
    }

    /**
     * @inheritdoc
     */
    public function getUri()
    {
        if (null === $this->container || false === $this->container->hasScope('request') || false === $this->container->isScopeActive('request')) {
            return null;
        }

        return trim($this->container->get('request')->getUri(), '/ ');
    }

}