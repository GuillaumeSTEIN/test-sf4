<?php

namespace App\AdminBundle\Controller;

use App\ArticleBundle\Entity\Article;
use App\ArticleBundle\Form\ArticleType;
use App\ArticleBundle\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Article controller.
 *
 * @Route("articles/")
 */
class ArticleController extends Controller
{
    /**
     * @Route("")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = $this->getRepository()->getIndexQuery();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10,
            [
                'defaultSortFieldName' => 'a.postedAt',
                'defaultSortDirection' => 'desc'
            ]
        );

        return $this->render('@Admin/article/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->addFlash('success','Your article has been successfully saved');

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
     * @param Article $article
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
     * @param Request $request
     * @param Article $article
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success','Your article has been successfully saved');

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
     * @param Article $article
     * @return RedirectResponse
     */
    public function remove(Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        $this->addFlash('success','Your article has been successfully removed');

        return $this->redirectToRoute('app_admin_article_index');
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
