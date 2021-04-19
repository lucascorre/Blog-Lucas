<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    
    public function index(ArticleRepository $articleRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $articleRepository->findAll();

        $article = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3
    );
        return $this->render('acceuil.html.twig', [
            'articles' => $article,
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/article/{id}", name="article")
     */
    public function showArticle(ArticleRepository $articleRepository, $id): Response
    {
        $article = $articleRepository->find($id);
        //dd($article);
        return $this->render('article/index.html.twig', [
            'article' => $article,
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * @Route("/user/admin/article", name="admin.article")
     */
    public function gestionArticle(ArticleRepository $articleRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $articleRepository->findAll();

        $article = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3
    );
        return $this->render('user/admin_article.html.twig', [
            'articles' => $article,
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/user/admin/edit/article{id}", name="admin.edit.article")
     */
    public function editArticle(ArticleRepository $articleRepository, Request $request, $id)
    {
        $article = $articleRepository->find($id);
        $form = $this->createForm(ArticleType::class, $article);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Article mis a jour');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
        }

        return $this->render('user/edit_article.html.twig', [ 
            'article' => $article,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/user/admin/new/article", name="admin.new.article")
     */
    public function newArticle(ArticleRepository $articleRepository, Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $articleRepository);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Article Créé');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
        }

        return $this->render('user/edit_article.html.twig', [ 
            'article' => $article,
            'form' => $form->createView()
        ]);
    }
}
