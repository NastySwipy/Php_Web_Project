<?php

namespace SymfonyBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyBlogBundle\Entity\Article;
use SymfonyBlogBundle\Entity\Comment;
use SymfonyBlogBundle\Entity\User;
use SymfonyBlogBundle\Form\ArticleType;

class ArticleController extends Controller
{
    /**
     * @Route("article/create", name="article_create")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $file */
            $file = $form->getData()->getImage();


            $fileName = md5(uniqid('', true)) . '.' . $file->guessExtension();

            try {
                $file->move($this->getParameter('article_directory'), $fileName);
            } catch (FileException $e) {
            }

            $currentUser = $this->getUser();
            $article->setImage($fileName);
            $article->setAuthor($currentUser);
            $article->setViewCount(0);
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
        /** @var Article $article */
        $article = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);


        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findBy(['article' => $id], ['dateAdded' => 'asc']);

        $article->setViewCount($article->getViewCount() + 1);
        /**
         * Here we send it the count to the dataBase!
         */
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($article);
        $entityManager->flush();

        return $this->render('article/article.html.twig',
            ['article' => $article, 'comments' => $comments]);
    }

    /**
     * @Route("article/edit/{id}", name="article_edit")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
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
        $currentImage = $article->getImage();
        $currentYtUrl = $article->getYtUrl();


        if ($article === null) {
            return $this->redirectToRoute('blog_index');
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();
        if (!$currentUser->isAuthor($article) && !$currentUser->isAdmin()) {
            return $this->redirectToRoute('blog_index');
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {


            /** @var UploadedFile $file */
            $file = $form->getData()->getImage();

            if (null !== $file) {
                $fileName = md5(uniqid('', true)) . '.' . $file->guessExtension();
                try {
                    $file->move($this->getParameter('article_directory'), $fileName);
                } catch (FileException $e) {
                }
                $article->setImage($fileName);
            }else{
                $article->setImage($currentImage);
            }
            if ($form->getData()->getYtUrl() === null) {
                $article->setYtUrl($currentYtUrl);
            }


            $currentUser = $this->getUser();
            $article->setAuthor($currentUser);
            $article->setDateAdded(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->merge($article);
            $entityManager->flush();

            return $this->redirectToRoute('myArticles');
        }
        return $this->render('article/edit.html.twig',
            ['form' => $form->createView(), 'article' => $article]);
    }

    /**
     * @Route("article/delete/{id}", name="article_delete")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
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

        if ($article === null) {
            return $this->redirectToRoute('blog_index');
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();
        if (!$currentUser->isAuthor($article) && !$currentUser->isAdmin()) {
            return $this->redirectToRoute('blog_index');
        }

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

    /**
     * @Route("/myArticles", name="myArticles")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     */
    public function myArticles()
    {
//        /** @var User $currentUserId */
//        $currentUserId = $currentUserId->getId();
//        $currentUserId = $this->getUser()->getId();

       $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(['author' => $this->getUser()]);

        return $this->render('article/myArticles.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/article/like/{id}", name="article_likes")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function likes($id)
    {
        return $this->redirectToRoute('blog_index');
    }
}
