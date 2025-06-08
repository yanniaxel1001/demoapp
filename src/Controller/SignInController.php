<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SignInController extends AbstractController
{
    #[Route('/login', name:'login')]
    public function login(): Response
    {
        return $this->render('');
    }
}
?>