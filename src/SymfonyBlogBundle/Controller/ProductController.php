<?php

namespace SymfonyBlogBundle\Controller;

use SymfonyBlogBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 * @Route("SkyStore")
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("/", name="SkyStore_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('SymfonyBlogBundle:Product')->findAll();

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));
    }

//    /**
//     * Creates a new product entity.
//     *
//     * @Route("/newProduct0", name="SkyStore_new0")
//     * @Method({"GET", "POST"})
//     */
//    public function createNewProductAction(Request $request)
//    {
//        $product = new Product();
//        $form = $this->createForm('SymfonyBlogBundle\Form\ProductType', $product);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $currentUser = $this->getUser();
//            $product->setAuthor($currentUser);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($product);
//            $em->flush();
//
//            return $this->redirectToRoute('SkyStore_show', array('id' => $product->getId()));
//        }
//
//        return $this->render('product/new0.html.twig', array(
//            'product' => $product,
//            'form' => $form->createView(),
//        ));
//    }

    /**
     * Creates a new product entity.
     *
     * @Route("/newProduct", name="SkyStore_new")
     * @Method({"GET", "POST"})
     */
    public function createNewProductAction2(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('SymfonyBlogBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $currentUser = $this->getUser();
            $product->setAuthor($currentUser);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('SkyStore_show', array('id' => $product->getId()));
        }

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="SkyStore_show")
     * @Method("GET")
     */
    public function viewProductAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('product/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/editProduct", name="SkyStore_edit")
     * @Method({"GET", "POST"})
     */
    public function editProductAction(Request $request, Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('SymfonyBlogBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $product->setDateAdded(new \DateTime('now'));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('SkyStore_edit', array('id' => $product->getId()));
        }

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/delete/{id}", name="SkyStore_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('SkyStore_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('SkyStore_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
