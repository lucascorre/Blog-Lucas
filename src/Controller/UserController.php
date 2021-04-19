<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user/acceuil", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
   
    /**
     * @Route("/user/admin/commentaire", name="admin.commentaire")
     */
    public function gestionCommentaire(): Response
    {
        return $this->render('user/admin_commentaire.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
