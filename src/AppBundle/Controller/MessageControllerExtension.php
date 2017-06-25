<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 4/9/17
 * Time: 7:21 PM
 */

namespace AppBundle\Controller;



use AppBundle\Entity\ItemPost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;


class MessageControllerExtension extends Controller
{
    /**
     * @Security("is_granted('ROLE_USER')")
     * @Route("/fos_message/new/{id}", name="fos_message_thread_contact_seller")
     */
    public function contactSellerAction(ItemPost $itemPost){
        $form = $this->get('fos_message.new_thread_form.factory')->create();
        $formHandler = $this->get('fos_message.new_thread_form.handler');

        $seller = $itemPost->getUser();
        $subject = 'Regarding ' . $itemPost->getName();

        $form->get('recipient')->setData($seller);
        $form->get('subject')->setData($subject);

        if ($message = $formHandler->process($form)) {
            return new RedirectResponse($this->get('router')->generate('fos_message_thread_view', array(
                'threadId' => $message->getThread()->getId(),
            )));
        }

        return $this->get('templating')->renderResponse('FOSMessageBundle:Message:newThread.html.twig', array(
            'form' => $form->createView(),
            'data' => $form->getData(),
        ));
    }
}