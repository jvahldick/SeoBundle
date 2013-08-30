<?php

namespace JHV\Bundle\SeoBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\QueryBuilder;
use JHV\Bundle\SeoBundle\Model\SeoInterface;

/**
 * SeoManager.
 * 
 * @author      Jorge Vahldick <jvahldick@gmail.com>
 * @license     Please view /Resources/meta/LICENSE
 * @copyright   (c) 2013
 */
class SeoManager implements SeoManagerInterface
{

    protected $seoAlias = 's';
    protected $manager;
    protected $repository;

    public function __construct(ObjectManager $manager, ObjectRepository $repository)
    {
        $this->manager      = $manager;
        $this->repository   = $repository;
    }

    /**
     * @inheritdoc
     */
    public function getClass()
    {
        return $this->repository->getClassName();
    }

    /**
     * @inheritdoc
     */
    public function create()
    {
        $class = $this->getClass();
        return new $class;
    }

    /**
     * @inheritdoc
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @inheritdoc
     */
    public function findBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    /**
     * @inheritdoc
     */
    public function findOneBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * @inheritdoc
     */
    public function findByLinkCanonical($canonical)
    {
        return $this->repository->findOneBy(array(
            'linkCanonical' => $canonical
        ));
    }

    /**
     * @inheritdoc
     */
    public function findSimilars(SeoInterface $object, array $criteria = null, $mode = AbstractQuery::HYDRATE_OBJECT)
    {
        $alias          = $this->seoAlias;
        $queryBuilder   = $this->getQueryBuilder();

        $queryBuilder
            ->select($alias)
            ->from($this->getClass(), $alias)
            ->where(
                $queryBuilder->expr()->eq($alias . 'linkCanonical', ':canonical')
            )
        ;

        // Aplicar parâmetros adicionais
        $this->applyCriteria($queryBuilder, $criteria);

        return $queryBuilder->getQuery()->getResult($mode);
    }

    /**
     * @inheritdoc
     */
    public function persist(SeoInterface $object, $flush = true)
    {
        $this->manager->persist($object);

        if (true === $flush) {
            $this->manager->flush();
        }
    }

    /**
     * @inheritdoc
     */
    public function remove(SeoInterface $object)
    {
        $this->manager->remove($object);
        $this->manager->flush();
    }

    /**
     * Efetuar criação do queryBuilder para realização
     * de busca de objetos.
     *
     * @return QueryBuilder
     */
    protected function getQueryBuilder()
    {
        return $this->manager->createQueryBuilder();
    }

    /**
     * Efetuar a aplicação de filtros no QueryBuilder.
     *
     * @param   QueryBuilder    $queryBuilder
     * @param   array           $criteria
     */
    protected function applyCriteria(QueryBuilder $queryBuilder, array $criteria = null)
    {
        if (null === $criteria) {
            return;
        }

        // Percorrer os parâmetros para adicionar novos parâmetros ao item
        foreach ($criteria as $property => $value) {
            if (!empty($value)) {
                $queryBuilder
                    ->andWhere($this->getPropertyName($property).' = :'.$property)
                    ->setParameter($property, $value)
                ;
            }
        }
    }

    /**
     * Localizar o nome real da propriedade vinda do criteria.
     * Acréscimo do alias no caso de não existir.
     *
     * @param   string  $name
     * @return  string
     */
    protected function getPropertyName($name)
    {
        if (false === strpos($name, '.')) {
            return $this->seoAlias . '.' . $name;
        }

        return $name;
    }

}