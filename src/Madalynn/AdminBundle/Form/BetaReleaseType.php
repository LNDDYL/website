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

namespace Madalynn\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class BetaReleaseType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('version')
                ->add('revision')
                ->add('file')
                ->add('downloadable', null, array('required' => false));
    }

    public function getName()
    {
        return 'admin_beta_release';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Madalynn\AndroBundle\Entity\BetaRelease',
        );
    }
}