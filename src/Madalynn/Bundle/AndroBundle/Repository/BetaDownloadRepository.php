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

use Madalynn\Bundle\AndroBundle\Entity\BetaRelease;

use Doctrine\ORM\EntityRepository;

class BetaDownloadRepository extends EntityRepository
{
    public function getDownloadsRepartition(BetaRelease $release)
    {
        return $this->createQueryBuilder('d')
                    ->select('d.location, COUNT(d.id) AS downloadsCount')
                    ->groupBy('d.location')
                    ->getQuery()
                    ->execute();
    }
}