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
        /** @var ArticleRepository $repo */
        $repo = $this->getDoctrine()->getRepository(Article::class);
        return $this->render('@Admin/article/index.html.twig', [
            'articles' => $repo->findLast(10),
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

            $this->redirect('app_admin_article_index');
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
        /** @var ArticleRepository $repo */
        $repo = $this->getDoctrine()->getRepository(Article::class);

        return $this->render('@Admin/article/view.html.twig', [
            'article' => $repo->find($id),
        ]);
    }
}
