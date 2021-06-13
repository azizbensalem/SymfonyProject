<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser() != NULL) {
            if ($this->getUser()->getRoles() == ["ROLE_CANDIDAT"]) {
                return $this->redirectToRoute('user_show');
            } 
    
            if ($this->getUser()->getRoles() == ["ROLE_RECRUTEUR"]) {
                return $this->redirectToRoute('offre_emploi_byrecuiter');
            } 
    
            if ($this->getUser()->getRoles() == ["ROLE_ADMIN"]) {
                return $this->redirectToRoute('admin');
            } 
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
