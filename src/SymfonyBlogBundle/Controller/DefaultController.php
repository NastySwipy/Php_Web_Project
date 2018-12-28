<?php

namespace SymfonyBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyBlogBundle\Entity\Article;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="blog_index")
     */
    public function indexAction()
    {
        
        $articles = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        return $this->render('default/index.html.twig',
            ['articles' => $articles]);
    }
}
