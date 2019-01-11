<?php

namespace SymfonyBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyBlogBundle\Entity\Article;

class HomeController extends Controller
{
    /**
     * @Route("/", name="slider_index")
     */
    public function sliderAction()
    {
        return $this->render('default/sliderIndex.html.twig');

    }

    /**
     * @Route("/SkyBlog", name="blog_index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        
        $articles = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findBy([], ['viewCount' => 'desc', 'dateAdded' => 'desc']);

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $articles, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/
        );


        return $this->render('default/index.html.twig',
            ['pagination' => $pagination]);
    }

    /**
     * @Route("/SkyBlog/orderLatest", name="blog_index_orderLatest")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexActionOrderLatest(Request $request)
    {


        $articles = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findBy([], ['dateAdded' => 'desc', 'viewCount' => 'desc']);


        $paginator  = $this->get('knp_paginator');


        $pagination = $paginator->paginate(
            $articles, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/
        );



        return $this->render('default/index.html.twig',
            ['pagination' => $pagination]);
    }

    /**
     * @Route("/SkyBlog/orderByComments", name="blog_index_orderComments")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexActionOrderComments(Request $request)
    {


        $articles = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findBy([], ['comments' => 'desc', 'viewCount' => 'desc']);


        $paginator  = $this->get('knp_paginator');


        $pagination = $paginator->paginate(
            $articles, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/
        );



        return $this->render('default/index.html.twig',
            ['pagination' => $pagination]);
    }

    /**
     * @Route("/SkyBlog/videos", name="blog_videos")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexVideos(Request $request)
    {

        $articles = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findBy([], ['viewCount' => 'desc', 'dateAdded' => 'desc']);

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $articles, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/
        );


        return $this->render('default/videos.html.twig',
            ['pagination' => $pagination]);
    }

    /**
     * @Route("/SkyBlog/Videos/orderLatest", name="blog_videos_orderLatest")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexVideosOrderLatest(Request $request)
    {

        $articles = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findBy([], ['dateAdded' => 'desc', 'viewCount' => 'desc']);

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $articles, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/
        );


        return $this->render('default/videos.html.twig',
            ['pagination' => $pagination]);
    }
}
