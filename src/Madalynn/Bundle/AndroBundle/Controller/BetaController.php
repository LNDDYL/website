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

namespace Madalynn\Bundle\AndroBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Request;

use Madalynn\Bundle\AndroBundle\Entity\BetaDownload;

/**
 * Beta Controller
 *
 * @author Julien Brochet <mewt@androirc.com>
 */
class BetaController extends AbstractController
{
    public function showAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AndroBundle:BetaRelease');

        return $this->renderWithMobile('AndroBundle:Beta:show.html.twig', array(
            'beta' => $repo->getLastBeta()
        ));
    }

    public function latestAction()
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AndroBundle:BetaRelease');

        $beta = $repo->getLastBeta();

        return (null === $beta) ? new Response('-1') : new Response($beta->getVersion()->getCode());
    }

    public function downloadAction(Request $request)
    {
        $em   = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('AndroBundle:BetaRelease');

        $beta = $repo->getLastBeta();

        if (null === $beta) {
            throw $this->createNotFoundException('There is no beta to download at the moment');
        }

        $ip       = $request->getClientIp();
        $download = new BetaDownload();

        $download->setBetaRelease($beta);
        $download->setLocation($this->get('androirc.location')->searchLocation($ip));

        $em->persist($download);
        $em->flush();

        $response = new StreamedResponse(function () use ($beta) {
            return @readfile($beta->getAbsolutePath());
        });

        $response->headers->set('Content-Type', 'application/vnd.android.package-archive');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . basename($beta->getAbsolutePath()).'"');
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Content-Length', filesize($beta->getAbsolutePath()));

        return $response;
    }
}
