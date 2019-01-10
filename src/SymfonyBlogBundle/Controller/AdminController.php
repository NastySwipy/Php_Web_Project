<?php

namespace SymfonyBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyBlogBundle\Entity\Role;
use SymfonyBlogBundle\Entity\User;


/**
 * Class AdminController
 * @package SymfonyBlogBundle\Controller
 */
class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $allUsers = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('admin/index.html.twig',
            [
                'users' => $allUsers
            ]);
    }

    /**
     * @Route("/admin/userProfile/{id}", name="admin_user_profile")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewUserProfileAction($id)
    {
        /** @var User $user */
        $user = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        return $this->render('admin/userProfile.html.twig',
            ['user' => $user]);
    }

    /**
     * @Route("/admin/userProfile/makeadmin/{id}", name="make_user_admin")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function makeAdminAction($id)
    {
        /** @var User $user */
        $user = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $this->getDoctrine()->getRepository(Role::class)->makeAdmin($id);



        return $this->render('admin/userProfile.html.twig',
            ['user' => $user]);
    }

    /**
     * @Route("/admin/userProfile/makeuser/{id}", name="make_user_user")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function makeUserAction($id)
    {
        /** @var User $user */
        $user = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $this->getDoctrine()->getRepository(Role::class)->makeUser($id);



        return $this->render('admin/userProfile.html.twig',
            ['user' => $user]);
    }

    /**
     * @Route("/admin/userProfile/remove/{id}", name="remove_user")
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeUserAction($id)
    {

        $this->getDoctrine()->getRepository(Role::class)->removeUserRole($id);
        $this->getDoctrine()->getRepository(Role::class)->removeUserComments($id);
        $this->getDoctrine()->getRepository(Role::class)->removeUserMsg($id);
        $this->getDoctrine()->getRepository(Role::class)->removeUserArticle($id);
        $this->getDoctrine()->getRepository(Role::class)->removeUser($id);



        $allUsers = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('admin/index.html.twig',
            [
                'users' => $allUsers
            ]);
    }
}
