<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(ArticleRepository $articleRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $articleRepository->findAll();

        $article = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('user/index.html.twig', [
            'articles' => $article,
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/information", name="user.information")
     */
    public function userAccueil(ArticleRepository $articleRepository, UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Article mis a jour');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user.information');
        }


        $query = $articleRepository->findAll();
        $article = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('user/user_information.html.twig', [
            'articles' => $article,
            'form' => $form->createView(),
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route ("/user/article/liked", name="article.liked")
     */
    public function articleLiked(): Response
    {
        return $this->render('user/user_article_liked.html.twig', [
            'controller_name' => 'ProposController',
        ]);
    }

    /**
     * @Route ("/user/article/shared", name="article.shared")
     */
    public function articleShared(): Response
    {
        return $this->render('user/user_article_shared.html.twig', [
            'controller_name' => 'ProposController',
        ]);
    }

    /**
     * @Route ("/user/article/commented", name="article.commented")
     */
    public function articleCommented(): Response
    {
        return $this->render('user/user_article_commented.html.twig', [
            'controller_name' => 'ProposController',
        ]);
    }
}
