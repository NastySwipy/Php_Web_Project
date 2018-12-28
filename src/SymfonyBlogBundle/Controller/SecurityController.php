<?php

namespace SymfonyBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyBlogBundle\Entity\User;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="security_login")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/logut", name="security_logout")
     * @throws \Exception
     */
    public function logoutAction()
    {
        throw new \Exception('Logout failed!');
    }
}
