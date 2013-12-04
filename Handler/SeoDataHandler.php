<?php

namespace JHV\Bundle\SeoBundle\Handler;

use JHV\Bundle\SeoBundle\Model\SeoInterface;

/**
 * SeoDataHandler.
 * 
 * @author      Jorge Vahldick <jvahldick@gmail.com>
 * @license     Please view /Resources/meta/LICENSE
 * @copyright   (c) 2013
 */
class SeoDataHandler implements SeoDataHandlerInterface
{

    /**
     * @var SeoInterface $seo
     */
    protected $object;

    /**
     * @var array
     */
    protected $defaultData;

    public function __construct(array $defaults)
    {
        $this->defaultData = $defaults;
    }

    /**
     * @inheritdoc
     */
    public function setObject(SeoInterface $seo)
    {
        $this->object = $seo;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @inheritdoc
     */
    public function getDefaultData()
    {
        return $this->defaultData;
    }

    /**
     * @inheritdoc
     */
    public function getCharset()
    {
        $defaultCharset = (isset($this->defaultData['charset'])) ? $this->defaultData['charset'] : 'utf-8';
        $charset        = $this->object->getCharset();

        return $charset ?: $defaultCharset;
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        $titleSeparator = (isset($this->defaultData['separators']['title'])) ? $this->defaultData['separators']['title'] : '';
        $prefix         = (isset($this->defaultData['title_prefix'])) ? $this->defaultData['title_prefix'] : '';
        $suffix         = (isset($this->defaultData['title_suffix'])) ? $this->defaultData['title_suffix'] : '';
        $defaultTitle   = (isset($this->defaultData['title'])) ? $this->defaultData['title'] : '';
        $title          = $this->object->getTitle();

        $realTitle      = $title ?: $defaultTitle;
        $fullTitle      = ($prefix) ? $prefix . $titleSeparator : '';
        $fullTitle      .= $realTitle;
        $fullTitle      .= (!empty($suffix)) ? $titleSeparator . $suffix : '';

        return $fullTitle;
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        $defaultDescription     = (isset($this->defaultData['description'])) ? $this->defaultData['description'] : '';
        $description            = $this->object->getDescription();

        return $description ?: $defaultDescription;
    }

    /**
     * @inheritdoc
     */
    public function getKeywords()
    {
        $keywordsSeparator  = (isset($this->defaultData['separators']['keywords'])) ? $this->defaultData['separators']['keywords'] : ', ';
        $defaultKeywords    = $this->getMeta('name', 'keywords');
        $keywords           = $this->object->getKeywords();

        if (empty($keywords)) {
            $keywords = $defaultKeywords;
        }

        return (true === is_array($keywords)) ? join($keywordsSeparator, $keywords) : $keywords;
    }

    /**
     * @inheritdoc
     */
    public function getMetas($key = null)
    {
        $defaultMetas   = (isset($this->defaultData['metas'])) ? $this->defaultData['metas'] : array();
        $metas          = $this->object->getMetas();
        $data           = array();

        if (null !== $key) {
            if (isset($metas[$key]) && count($metas[$key])) {
                $data = $metas[$key];
                if (isset($defaultMetas[$key]) && is_array($defaultMetas[$key])) {
                    foreach ($defaultMetas[$key] as $k => $v) {
                        if (false == array_key_exists($k, $data)) {
                            $data[$k] = $v;
                        }
                    }
                }
            } else if (isset($defaultMetas[$key])) {
                $data = $defaultMetas[$key];
            }
        } else {
            $data = $metas;
        }

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function getMeta($key, $property)
    {
        $metas  = $this->getMetas($key);
        $data   = (isset($metas[$property])) ? $metas[$property] : array();

        return $data;
    }

}