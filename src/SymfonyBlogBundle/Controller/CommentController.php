<?php

namespace SymfonyBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyBlogBundle\Entity\Article;
use SymfonyBlogBundle\Entity\Comment;
use SymfonyBlogBundle\Entity\User;
use SymfonyBlogBundle\Form\CommentType;

class CommentController extends Controller
{
    /**
     * @Route("/article/{id}/comment", name="add_comment")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @param Request $request
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addComment(Request $request, Article $article)
    {
        $user = $this->getUser();

        /** @var User $author */
        $author = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find($user->getId());

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        $comment->setAuthor($author);
        $comment->setArticle($article);

        $author->addComment($comment);
        $article->addComment($comment);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->redirectToRoute('article_view', [
            'id' => $article->getId()
        ]);
    }
}
