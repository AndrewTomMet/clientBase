<?php

namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SecurityController
 */
class SecurityController extends Controller
{
    /**
     * @param Request $request
     * @Route("/login", name="login")
     * @Method({"GET", "POST"})
     * @return Response
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('ClientBundle:Security:login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @param Request $request
     * @Route("/checklogin", name="checklogin")
     * @Method({"GET", "POST"})
     * @return Response
     */
    public function checkloginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('ClientBundle:Security:login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
}
