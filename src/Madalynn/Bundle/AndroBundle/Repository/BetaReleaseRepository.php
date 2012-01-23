<?php

/*
 * This file is part of the AndroIRC website.
 *
 * (c) 2010-2012 Julien Brochet <mewt@androirc.com>
 * (c) 2010-2012 Sébastien Brochet <blinkseb@androirc.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Madalynn\Bundle\AndroBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class BetaReleaseRepository extends EntityRepository
{
    public function getLastBeta()
    {
        $query = $this->createQueryBuilder('b')
                      ->where('b.downloadable = true')
                      ->orderBy('b.created', 'desc')
                      ->getQuery()
                      ->setMaxResults(1);
        
        try {
            return $query->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }
}