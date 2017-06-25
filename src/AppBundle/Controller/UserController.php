<?php

namespace AppBundle\Controller;


use AppBundle\Form\UserRegistrationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

class UserController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request){
        $form = $this->createForm(UserRegistrationForm::class);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if($form->isValid() && $form->isSubmitted()){
            $user = $form->getData();
            //would like to find better way to handle this
            if($user->getEmail() == 'timbauer@mail.sfsu.edu'){
                $user->setRoles(['ROLE_SUPER_ADMIN']);
            }
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Welcome '.$user->getUsername());
            return $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('app.security.login_form_authenticator'),
                    'main'
                );
        }


        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    # get success response from recaptcha and return it to controller
    function captchaVerify($recaptcha){
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            "secret"=>"6Le5ECEUAAAAAHYDL0QDZ6ihQPUGcf1tgxuEmC7A", "response"=>$recaptcha));
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);

        return $data->success;
    }
}