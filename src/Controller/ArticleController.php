<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
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
    public function showArticle(ArticleRepository $articleRepository, CommentRepository $commentRepository, Request $request, $id): Response
    {
        $article = $articleRepository->find($id);
        //$allComment = $commentRepository->findAll();
        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findBy(['article_id' => [$article]]);
        $addComment = new Comment();
        $form = $this->createForm(CommentType::class, $addComment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Article mis a jour');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($addComment);
            $entityManager->flush();
        }
        return $this->render('article/index.html.twig', [
            'article' => $article,
            'comment' => $comments,
            'form' => $form->createView(),
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

            return $this->redirectToRoute('admin.article');
        }

        return $this->render('user/edit_article.html.twig', [
            'articles' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/admin/new/article", name="admin.new.article")
     */
    public function newArticle(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $article->setCreatedAt(new \DateTime());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Article Créé');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('admin.article');
        }

        return $this->render('user/edit_article.html.twig', [
            'articles' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/admin/delete/article/{id}", name="admin.delete.article")
     */
    public function deleteArticle(ArticleRepository $articleRepository, PaginatorInterface $paginator, Request $request, $id)
    {
        $oneArticle = $articleRepository->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($oneArticle);
        $entityManager->flush();

        return $this->redirectToRoute('admin.article');
    }
}
