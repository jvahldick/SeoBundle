<?php

namespace JHV\Bundle\SeoBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use JHV\Bundle\SeoBundle\Model\SeoInterface;

/**
 * SeoSubscriber.
 * 
 * @author      Jorge Vahldick <jvahldick@gmail.com>
 * @license     Please view /Resources/meta/LICENSE
 * @copyright   (c) 2013
 */
class SeoSubscriber implements EventSubscriber
{

    /**
     * @inheritdoc
     */
    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
        );
    }

    /**
     * Efetuar a execução da pre atualização do objeto junto ao banco.
     *
     * @param   LifecycleEventArgs  $args
     * @return  void
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->defineDate($args);
    }

    /**
     * Efetuar a execução da pre persistência com o banco de dados.
     *
     * @param   LifecycleEventArgs  $args
     * @return  void
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->defineDate($args, true);
    }

    /**
     * Efetuar a operação de modificações de datas conforme
     * operação solicitada, ou de pre persistência ou atualização.
     *
     * @param   LifecycleEventArgs  $args
     * @param   bool                $new
     */
    public function defineDate(LifecycleEventArgs $args, $new = false)
    {
        $entity             = $args->getEntity();

        if ($entity instanceof SeoInterface) {
            $datetime           = new \DateTime('now');
            if (true === $new) {
                $entity->setCreatedAt($datetime);
                $entity->setUpdatedAt($datetime);
            } else {
                $entity->setUpdatedAt($datetime);
            }
        }
    }

}