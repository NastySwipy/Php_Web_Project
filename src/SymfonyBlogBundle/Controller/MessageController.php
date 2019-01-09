<?php

namespace SymfonyBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyBlogBundle\Entity\Message;
use SymfonyBlogBundle\Entity\User;
use SymfonyBlogBundle\Form\MessageType;

class MessageController extends Controller
{
    /**
     * @Route("/user/{id}/message/{articleId}", name="user_message")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @param Request $request
     * @param $articleId
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendMessageAction(Request $request, $articleId ,$id)
    {
//        $articleIdFromRequest = explode('/', $_SERVER['HTTP_REFERER']);
//        $articleIdFromRequest = end($articleIdFromRequest);

        $currentUser = $this->getUser();

        $recipient = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $message
                ->setSender($currentUser)
                ->setRecipient($recipient)
                ->setIsReaded(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash('message', 'Message sent!');
            return $this->redirectToRoute('article_view',
                ['id' => $articleId]);
        }

        return $this->render('user/send_message.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("user/messageBox", name="user_messageBox")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function messageBox(Request $request)
    {
        $currentUserId = $this->getUser()->getId();
        /** @var User $user */
        $user = $this
            ->getDoctrine()
            ->getRepository(User::class)
            ->find($currentUserId);

        $receivedMessages = $this
            ->getDoctrine()
            ->getRepository(Message::class)
            ->findBy(['recipient' => $user], ['dateAdded' => 'desc']);

//        $receivedMessages = $user->getRecipientsMessages();
//        $countReceiveMsg = count($receivedMessages);
//        $sentMessages = $user->getSendersMessages();
//        $coutSenteMsg = count($sentMessages);

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $receivedMessages, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/
        );

        return $this->render('user/messageBox.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/messageBox/message/{id}", name="user_readMessage")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function readMessage(Request $request, $id)
    {
        /** @var Message $message */
        $message = $this
            ->getDoctrine()
            ->getRepository(Message::class)
            ->find($id);

        $message->setIsReaded(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        $sendMessage = new Message();
        $form = $this->createForm(MessageType::class, $sendMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $sendMessage
                ->setSender($this->getUser())
                ->setRecipient($message->getSender())
                ->setIsReaded(false);
            $em->persist($sendMessage);
            $em->flush();

            $this->addFlash('message', 'Message sent!');

            return $this->redirectToRoute('user_readMessage',
                ['id' => $id]);
        }


        return $this->render('user/message.html.twig', [
            'message' => $message,
            'form' => $form->createView()
        ]);
    }

}
