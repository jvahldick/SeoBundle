<?php

namespace JHV\Bundle\SeoBundle\Manager;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\AbstractQuery;
use JHV\Bundle\SeoBundle\Model\SeoInterface;

/**
 * SeoManagerInterface.
 * 
 * @author      Jorge Vahldick <jvahldick@gmail.com>
 * @license     Please view /Resources/meta/LICENSE
 * @copyright   (c) 2013
 */
interface SeoManagerInterface 
{

    /**
     * Localizar o nome da classe referente ao objeto SEO.
     *
     * @return  string
     */
    public function getClass();

    /**
     * Efetuará a criação do objeto seo, retornando
     * a classe modelo definida na configuração.
     *
     * @return SeoInterface
     */
    public function create();

    /**
     * Efetuar a busca junto ao banco de dados do objeto
     * SEO através do link passado por parâmetro.
     *
     * @param   string      $canonical
     * @return  string|null
     */
    public function findByLinkCanonical($canonical);

    /**
     * Efetuar a busca de objetos SEO similiares ao
     * objeto passado por parâmtero.
     *
     * @param   SeoInterface    $object
     * @param   array           $criteria
     * @param   integer         $mode
     * @return  SeoInterface|null
     */
    public function findSimilars(SeoInterface $object, array $criteria = null, $mode = AbstractQuery::HYDRATE_OBJECT);

    /**
     * Localizar um objeto SEO através de um conjunto
     * de critérios passados por parâmetro.
     *
     * @param   array               $criteria
     * @return  SeoInterface|null
     */
    public function findOneBy(array $criteria);

    /**
     * Localizar objetos SEO por um conjunto de critérios.
     *
     * @param   array                   $criteria
     * @return  ArrayCollection|null
     */
    public function findBy(array $criteria);

    /**
     * Localizar todos os objetos SEO registrados no banco de dados.
     *
     * @return  ArrayCollection
     */
    public function findAll();

    /**
     * Efetuar a persistencia do objeto junto ao banco de dados,
     * e como opcional definir se quer realizar a execução
     * da persistencia.
     *
     * @param   SeoInterface    $object
     * @param   bool            $flush
     * @return  void
     */
    public function persist(SeoInterface $object, $flush = true);

    /**
     * Efetuar a remoção de um objeto Seo junto ao banco de dados.
     *
     * @param   SeoInterface    $object
     * @return  void
     */
    public function remove(SeoInterface $object);

}