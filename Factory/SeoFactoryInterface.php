<?php

namespace JHV\Bundle\SeoBundle\Factory;

use JHV\Bundle\SeoBundle\Model\SeoInterface;

/**
 * SeoFactoryInterface.
 * 
 * @author      Jorge Vahldick <jvahldick@gmail.com>
 * @license     Please view /Resources/meta/LICENSE
 * @copyright   (c) 2013
 */
interface SeoFactoryInterface
{

    /**
     * Efetuar criação de um objeto SEO para utilização.
     *
     * @return SeoInterface
     */
    public function create();

    /**
     * Localizar o objeto SEO através da URL atual,
     * no caso de não encontrar retornar null.
     *
     * @return  SeoInterface
     */
    public function getSeo();

    /**
     * Localizar a URL atual no qual o usuário se encontra.
     *
     * @return  string
     */
    public function getUri();

}