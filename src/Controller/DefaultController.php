<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->render('acceuil.html.twig', [
            'articles' => $articles,
            'controller_name' => 'DefaultController',
        ]);
    }

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
