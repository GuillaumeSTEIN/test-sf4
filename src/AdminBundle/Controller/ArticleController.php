<?php

namespace App\AdminBundle\Controller;

use App\AdminBundle\Entity\Article;
use App\AdminBundle\Form\ArticleType;
use App\AdminBundle\Repository\ArticleRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    /**
     * @Route("articles")
     */
    public function index()
    {
        return $this->render('@Admin/article/index.html.twig', [
            'articles' => $this->getRepository()->findLast(10),
        ]);
    }

    /**
     * @Route("articles/create")
     */
    public function create(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->add('create',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('app_admin_article_view',[
                'id' => $article->getId(),
            ]);
        }

        return $this->render('@Admin/article/create.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("articles/{id}")
     */
    public function view($id)
    {
        return $this->render('@Admin/article/view.html.twig', [
            'article' => $this->getRepository()->find($id),
        ]);
    }

    /**
     * @Route("articles/edit/{id}")
     */
    public function edit(Request $request, $id)
    {
        $article = $this->getRepository()->find($id);
        $form = $this->createForm(ArticleType::class, $article);
        $form->add('edit',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('app_admin_article_view',[
                'id' => $article->getId(),
            ]);
        }
        return $this->render('@Admin/article/edit.html.twig',[
            'form' => $form->createView(),
        ]);
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
