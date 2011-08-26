<?php

/*
 * This file is part of the AndroIRC website.
 *
 * (c) 2010-2011 Julien Brochet <mewt@androirc.com>
 * (c) 2010-2011 Sébastien Brochet <blinkseb@androirc.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Madalynn\AdminBundle\Controller;

use Madalynn\AdminBundle\Form\UserType;

class UserController extends CRUDController
{
    protected function prePersist($entity)
    {
        $this->updatePassword($entity);
    }

    protected function preUpdate($entity)
    {
        $this->updatePassword($entity);
    }

    protected function getForm()
    {
        return new UserType();
    }

    protected function getClass()
    {
        return 'Madalynn\AndroBundle\Entity\User';
    }

    private function updatePassword($entity)
    {
        if (null !== $password = $entity->getPlainPassword()) {
            $factory = $this->container->get('security.encoder_factory');
            $encoder = $factory->getEncoder($entity);

            $entity->setPassword($encoder->encodePassword($password, $entity->getSalt()));
            $entity->setPlainPassword(null);
        }
    }

    public function showAction($id)
    {
        throw new \BadMethodCallException('The show action is not supported for this entity.');
    }
}