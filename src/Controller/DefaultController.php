<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    
    public function index(ArticleRepository $articleRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = ;

        $articles = $paginator->paginate($this->$articleRepository->findAll(),
        $request->query->getInt('page', 1),
        3
    );
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
