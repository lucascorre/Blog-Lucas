<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route ("/propos", name="propos")
     */

    public function propos(): Response
    {
        return $this->render('propos.html.twig', [
            'controller_name' => 'ProposController',
        ]);
    }
}
