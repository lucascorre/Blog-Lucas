<?php

namespace App\Controller;

use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/user/admin/commentaire", name="admin.commentaire")
     */
    public function gestionCommentaire(): Response
    {
        return $this->render('user/admin_commentaire.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/admin/edit/article{id}", name="admin.edit.article")
     */
    public function edit(ArticleRepository $articleRepository, $id)
    {
        $article = $articleRepository->find($id);

        $form = $this->createForm(ArticleType::class, $article);
        return $this->render('user/edit_article.html.twig', [ 
            'article' => $article,
            'form' => $form->createView()
        ]);
    }
}
