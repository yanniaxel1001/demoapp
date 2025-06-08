<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SignInController extends AbstractController
{
    #[Route('/login', name:'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Obtener error login
        $error = $authenticationUtils->getLastAuthenticationError();

        // Ultimo nombre de usuario ingresado
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig',[
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
?>