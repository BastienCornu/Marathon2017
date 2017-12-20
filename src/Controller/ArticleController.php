<?php

namespace App\Controller;

use App\AppEvent;
use App\Entity\Article;
use App\Event\ArticleEvent;
use App\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ArticleController
 * @package App\Controller
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /**
     * @Route("/show", name="app_article_show")
     */
    public function show()
    {
        $em = $this->getDoctrine()->getManager();
        //$articles = $em->createQuery("select a from \App\Entity\Article a join a.user")->getResult();
        $articles = $em->getRepository(Article::class)->findAll();
        return $this->render('article/show.html.twig',['articles'=>$articles]);
    }

    /**
     * @Route("/edit/{id}", name="app_article_edit")
     */
    public function edit(Request $request, Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            /** @var ArticleEvent $articleEvent */
            $articleEvent = $this->get(\App\Event\ArticleEvent::class);
            $articleEvent->setArticle($article);

            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(AppEvent::EDIT_ARTICLE, $articleEvent);


            return $this->redirectToRoute('welcome');
        }
        return $this->render("article/edit.html.twig", ['form' => $form->createView(),]);

    }


    /**
     * @Route("/creation", name="app_article_creation")
     */
    public function creation(Request $request)
    {
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $article = $form->getData();
            /** @var ArticleEvent $articleEvent */
            $articleEvent = $this->get(ArticleEvent::class);
            $articleEvent->setArticle($article);

            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(AppEvent::CREATE_ARTICLE, $articleEvent);


            return $this->redirectToRoute('welcome');
        }
        return $this->render("article/edit.html.twig", ['form' => $form->createView(),]);

    }
}