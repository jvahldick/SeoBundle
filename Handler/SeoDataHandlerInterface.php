<?php

namespace JHV\Bundle\SeoBundle\Handler;

use JHV\Bundle\SeoBundle\Model\SeoInterface;

/**
 * SeoDataHandlerInterface.
 * 
 * @author      Jorge Vahldick <jvahldick@gmail.com>
 * @license     Please view /Resources/meta/LICENSE
 * @copyright   (c) 2013
 */
interface SeoDataHandlerInterface 
{

    /**
     * Definição do objeto SEO.
     * Utilizando callMethod como construtor.
     *
     * @param   SeoInterface    $object
     * @return  self
     */
    public function setObject(SeoInterface $object);

    /**
     * Localizar objeto SEO definido.
     *
     * @return  SeoInterface
     */
    public function getObject();

    /**
     * Localizar os dados padrões definidos.
     *
     * @return  array
     */
    public function getDefaultData();

    /**
     * Localizar o meta charset da página.
     * No caso de não existir, busca do definido na configuração.
     *
     * @return  string
     */
    public function getCharset();

    /**
     * Localizar o título.
     * No caso de não existir, busca do definido na configuração.
     *
     * @return  string
     */
    public function getTitle();

    /**
     * Localizar a descrição referente a página.
     * No caso de não existir, busca do definido na configuração.
     *
     * @return  string
     */
    public function getDescription();

    /**
     * Localizar os keywords já formatados da página.
     * No caso de não existir, busca do definido na configuração.
     *
     * @return  string
     */
    public function getKeywords();

    /**
     * Localizar as metas, não passando parâmetro buscará do objeto.
     * No caso de não existir, busca do definido na configuração.
     *
     * @param   null|string     $key
     * @return  array
     */
    public function getMetas($key = null);

    /**
     * Localizar meta específica.
     * No caso de não existir, busca do definido na configuração.
     *
     * @param   string  $key
     * @param   string  $property
     * @return  array
     */
    public function getMeta($key, $property);

}