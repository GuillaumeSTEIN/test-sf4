<?php

namespace App\AdminBundle\Controller;

use App\AdminBundle\Entity\Article;
use App\AdminBundle\Form\ArticleType;
use App\AdminBundle\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * User controller.
 *
 * @Route("/articles/")
 */
class ArticleController extends Controller
{
    /**
     * @Route("")
     */
    public function index(Request $request)
    {
        $query = $this->getRepository()->getIndexQuery();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('@Admin/article/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("create")
     */
    public function create(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getEM();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('app_admin_article_view', [
                'id' => $article->getId(),
            ]);
        }

        return $this->render('@Admin/article/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("{id}")
     * @param Article $user
     * @return Response
     */
    public function view(Article $article)
    {
        return $this->render('@Admin/article/view.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("edit/{id}")
     */
    public function edit(Request $request, Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getEM();
            $em->flush();

            return $this->redirectToRoute('app_admin_article_view', [
                'id' => $article->getId(),
            ]);
        }
        return $this->render('@Admin/article/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("remove/{id}")
     */
    public function remove(Article $article)
    {
        $em = $this->getEM();
        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('app_admin_article_index');
    }

    /**
     * @return ObjectManager
     */
    private function getEM(): ObjectManager
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @return ArticleRepository
     */
    private function getRepository(): ArticleRepository
    {
        /** @var ArticleRepository $repo */
        $repo = $this->getDoctrine()->getRepository(Article::class);
        return $repo;
    }
}
