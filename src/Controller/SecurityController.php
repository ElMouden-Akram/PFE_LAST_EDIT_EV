<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils,Security $security): Response
    {   
        //si il est deja connecte il sera rederiger vers sa page d'accueil .
        if ($this->getUser()) {
            /** @var \App\Entity\User $user */
            $user=$this->getUser();
        //mais avant tester si sa premiere connection !! ( en checkons si par exemple contien un email):
        if(!$user->getEmail()){
                return $this->redirectToRoute('app_insc');
        }
        else{
            return $this->redirectToRoute('app_home');
        }
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        dd("deco");
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
