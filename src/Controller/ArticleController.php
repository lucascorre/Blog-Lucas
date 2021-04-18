<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/{id}", name="article")
     */
    public function index(ArticleRepository $articleRepository, $id): Response
    {
        $article = $articleRepository->find($id);
        //dd($article);
        return $this->render('article/index.html.twig', [
            'article' => $article,
            'controller_name' => 'ArticleController',
        ]);
    }
}
