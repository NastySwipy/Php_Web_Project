<?php

namespace SymfonyBlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyBlogBundle\Entity\Message;
use SymfonyBlogBundle\Entity\Role;
use SymfonyBlogBundle\Entity\User;
use SymfonyBlogBundle\Form\UserType;

class UserController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {


            /**
             * Validation on existing email for registration and password length
             * First we take the emailInput from the form,
             * then is a query we send to DB to find if this email already exist!
             * At the end we check if result from the query is null or not and we send some msg!
             * Then we do some simple check for how long is the pass if les then 4 not good!
             */
            $emailInput = $form->getData()->getEmail();
            $passwordInput = $form->getData()->getPassword();
            $currentUser = $this
                ->getDoctrine()
                ->getRepository(User::class)
                ->findBy(['email' => $emailInput]);

            if ([] !== $currentUser) {
                $this->addFlash('warning', 'This email: ' . $emailInput . ' already exists!');
                return $this->render('user/register.html.twig', ['form' => $form->createView()]);
            }


            if (strlen($passwordInput) < 4) {
                $this->addFlash('warning', 'Password is too short!');
                return $this->render('user/register.html.twig', ['form' => $form->createView()]);
            }

//            if ($passwordInput['first'] !== $passwordInput['second']) {
//                $this->addFlash('warning', 'Password don\'t match!');
//                return $this->render('user/register.html.twig', ['form' => $form->createView()]);
//            }

            $password = $this->get('security.password_encoder')
            ->encodePassword($user, $user->getPassword());

            $role = $this
                ->getDoctrine()
                ->getRepository(Role::class)
                ->findOneBy(['name' => 'ROLE_USER']);

            /** @var Role $role */
            $user->addRole($role);

            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('user/register.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/profile", name="user_profile")
     *
     */
    public function profile()
    {
        $userId = $this->getUser()->getId();
        /**
         * @var User $user
         */
        $user = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find($userId);

        $unreadMsg = $this
            ->getDoctrine()
            ->getRepository(Message::class)
            ->findBy(['recipient' => $userId ,'isReaded' => false ]);

        $countReceiveMsg = count($unreadMsg);

        return $this->render('user/profile.html.twig', [
                'user' => $user,
                'countInbox' => $countReceiveMsg
        ]);
    }
}
