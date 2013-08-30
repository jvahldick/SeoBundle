<?php

namespace JHV\Bundle\SeoBundle\Model;

/**
 * SeoInterface.
 * 
 * @author      Jorge Vahldick <jvahldick@gmail.com>
 * @license     Please view /Resources/meta/LICENSE
 * @copyright   (c) 2013
 */
interface SeoInterface 
{

    /**
     * Definição do título da página.
     *
     * @param   string  $title
     * @return  self
     */
    public function setTitle($title);

    /**
     * Localizar o título da página.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Definição da descrição da página.
     *
     * @param   string  $description
     * @return  self
     */
    public function setDescription($description);

    /**
     * Localizar descrição da página.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Definição das palavras chaves referentes ao conteúdo da página.
     *
     * @param   array|string    $keywords
     * @return  self
     */
    public function setKeywords($keywords);

    /**
     * Localizar palavras chaves referentes a página.
     *
     * @return array
     */
    public function getKeywords();

    /**
     * Adicionar uma nova palavra chave.
     *
     * @param   string  $keyword
     * @return  self
     */
    public function addKeyword($keyword);

    /**
     * Remover uma palavra chave.
     *
     * @param   $keyword
     * @return  self
     */
    public function removeKeyword($keyword);

    /**
     * Definição de tags referentes a metas.
     *
     * @param   array   $metas
     * @return  self
     */
    public function setMetas(array $metas);

    /**
     * Localizar metas tags.
     *
     * @return array
     */
    public function getMetas();

    /**
     * Adicionar uma nova meta tag.
     *
     * @param   string  $type
     * @param   string  $name
     * @param   string  $content
     * @return  self
     */
    public function addMeta($type, $name, $content);

    /**
     * Definição do link canônico referente a página.
     *
     * @param   string  $canonical
     * @return  self
     */
    public function setLinkCanonical($canonical);

    /**
     * Localizar o link canônico referente a página.
     *
     * @return  self
     */
    public function getLinkCanonical();

    /**
     * Definição do charset da página.
     *
     * @param   string  $charset
     * @return  self
     */
    public function setCharset($charset);

    /**
     * Localização do charset da página.
     *
     * @return  string
     */
    public function getCharset();

    /**
     * Definição da data de criação dos dados SEO
     * relacionados a página.
     *
     * @param   \DateTime   $datetime
     * @return  self
     */
    public function setCreatedAt(\DateTime $datetime);

    /**
     * Localizar a data de criação do registro SEO.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Definir a data da última atualização relacionada
     * ao registro SEO da página.
     *
     * @param   \DateTime   $datetime
     * @return  self
     */
    public function setUpdatedAt(\DateTime $datetime);

    /**
     * Localizar o registro da última modificação relacionada
     * ao registro de SEO da página.
     *
     * @return  \DateTime
     */
    public function getUpdatedAt();

}