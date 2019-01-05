<?php

namespace SymfonyBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     */
    public function indexAction()
    {
        
        $articles = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findBy([], ['viewCount' => 'desc', 'dateAdded' => 'desc']);

        return $this->render('default/index.html.twig',
            ['articles' => $articles]);
    }

    /**
     * @Route("/SkyStore", name="store_index")
     */
    public function storeIndexAction()
    {
//        /** @var Product $product */
//        $product = new Product();
//        $product->setName('Coca Cola' . rand(1, 1000));
//        $product->setPrice(2.50);
//        $product->setDescription('Coca-Cola, or Coke is a carbonated soft drink manufactured by The Coca-Cola Company.
//        Originally intended as a patent medicine,
//        it was invented in the late 19th century by John Pemberton and was bought out by businessman Asa Griggs Candler,
//        whose marketing tactics led Coca-Cola to its dominance of the world soft-drink market throughout the 20th century.
//        The drink\'s name refers to two of its original ingredients: coca leaves, and kola nuts (a source of caffeine).
//        The current formula of Coca-Cola remains a trade secret,
//        although a variety of reported recipes and experimental recreations have been published.');
//        $product->setCreateDate(new \DateTime('now'));
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($product);
//        $em->flush();

        return $this->render('default/storeIndex.html.twig',
            []);
    }
//
//    /**
//     * @Route("/SkyStore/ViewAll")
//     */
//    public function viewProducts()
//    {
//        /** @var Product $products */
//        $products = $this
//            ->getDoctrine()
//            ->getRepository(Product::class)
//            ->findAll();
//        return $this->render('default/storeIndex.html.twig',
//            ['products' => $products]);
//
//    }
//
//    /**
//     * @Route("/SkyStore/edit")
//     */
//    public function editProduct()
//    {
//        /** @var Product $product */
//        $product = $this
//            ->getDoctrine()
//            ->getRepository(Product::class)
//            ->find(6);
//        $product->setName('Pepsi');
//        $em = $this->getDoctrine()->getManager();
//        $em->flush();
//
//        return $this->redirect('/SkyStore/ViewAll');
//
//    }
//
//    /**
//     * @Route("/SkyStore/delete")
//     */
//    public function deleteProduct()
//    {
//        /** @var Product $product */
//        $product = $this
//            ->getDoctrine()
//            ->getRepository(Product::class)
//            ->find(6);
//
//        if (!$product) {
//            throw $this->createNotFoundException('Product not found!');
//        }
//
//        $em = $this->getDoctrine()->getManager();
//        $em->remove($product);
//        $em->flush();
//
//        return $this->redirect('/SkyStore/ViewAll');
//
//    }
}
