<?php

namespace SymfonyBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyBlogBundle\Entity\Article;
use SymfonyBlogBundle\Form\ArticleType;

class ArticleController extends Controller
{
    /**
     * @Route("article/create", name="article_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $currentUser = $this->getUser();
            $article->setAuthor($currentUser);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('blog_index');
        }
        return $this->render('article/create.html.twig',
            ['form' => $form->createView()]);
    }

    /**
     * @Route("/article/{id}", name="article_view")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewArticle($id)
    {
        /**
         * @var Article $article
         */
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        return $this->render('article/article.html.twig', ['article' => $article]);
    }

    /**
     * @Route("article/edit/{id}", name="article_edit")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editAction(Request $request, $id)
    {
        /**
         * @var Article $article
         */
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentUser = $this->getUser();
            $article->setAuthor($currentUser);
            $article->setDateAdded(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->merge($article);
            $entityManager->flush();

            return $this->redirectToRoute('blog_index');
        }
        return $this->render('article/edit.html.twig',
            ['form' => $form->createView(), 'article' => $article]);
    }

    /**
     * @Route("article/delete/{id}", name="article_delete")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, $id)
    {
        /**
         * @var Article $article
         */
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentUser = $this->getUser();
            $article->setAuthor($currentUser);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();

            return $this->redirectToRoute('blog_index');
        }
        return $this->render('article/delete.html.twig',
            ['form' => $form->createView(), 'article' => $article]);
    }
}
