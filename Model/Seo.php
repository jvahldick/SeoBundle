<?php

namespace JHV\Bundle\SeoBundle\Model;

/**
 * Seo.
 * 
 * @author      Jorge Vahldick <jvahldick@gmail.com>
 * @license     Please view /Resources/meta/LICENSE
 * @copyright   (c) 2013
 */
class Seo implements SeoInterface
{

    protected $keywords;
    protected $linkCanonical;
    protected $metas;
    protected $title;
    protected $charset;

    protected $createdAt;
    protected $updatedAt;

    /**
     * Construtor.
     * Definição dos parâmetros iniciais do objeto.
     */
    public function __construct()
    {
        $this->keywords = array();
        $this->metas    = array(
            'http-equiv' => array(),
            'name'       => array(),
            'schema'     => array(),
            'property'   => array(),
        );
    }

    /**
     * @inheritdoc
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @inheritdoc
     */
    public function setDescription($description)
    {
        $this->addMeta('name', 'description', $description);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        $metas = $this->getMetas();
        return (isset($metas['name']['description'])) ? $metas['name']['description'] : null;
    }

    /**
     * @inheritdoc
     */
    public function setKeywords($keywords)
    {
        if (true === is_string($keywords)) {
            $this->addKeyword($keywords);
        }
        // Se for array, verificar existência
        else if (true === is_array($keywords)) {
            $this->keywords = $keywords;
        }
        
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @inheritdoc
     */
    public function addKeyword($keyword)
    {
        if (true === is_array($keyword)) {
            $this->setKeywords($keyword);
        }
        // Senão verificar se é uma string
        else if (true === is_string($keyword) && false === in_array($keyword, $this->keywords)) {
            $this->keywords[] = $keyword;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function removeKeyword($keyword)
    {
        if (false !== $key = array_search($keyword, $this->keywords)) {
            unset($this->keywords[$key]);
        }

        return $this;
    }

    /**
     * @inheritdoc
     * @throws  \RuntimeException
     */
    public function setMetas(array $metadatas)
    {
        $this->metas = array();

        foreach ($metadatas as $type => $metas) {
            if (!is_array($metas)) {
                throw new \RuntimeException('$metas must be an array');
            }

            foreach ($metas as $name => $content) {
                $this->addMeta($type, $name, $content);
            }
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getMetas()
    {
        return $this->metas;
    }

    /**
     * @inheritdoc
     */
    public function addMeta($type, $name, $content)
    {
        if (!isset($this->metas[$type])) {
            $this->metas[$type] = array();
        }

        $this->metas[$type][$name] = $content;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setLinkCanonical($canonical)
    {
        $this->linkCanonical = trim($canonical, '/ ');
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getLinkCanonical()
    {
        return $this->linkCanonical;
    }

    /**
     * @inheritdoc
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @inheritdoc
     */
    public function setCreatedAt(\DateTime $datetime)
    {
        $this->createdAt = $datetime;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @inheritdoc
     */
    public function setUpdatedAt(\DateTime $datetime)
    {
        $this->updatedAt = $datetime;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

}