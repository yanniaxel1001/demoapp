<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SignUpController extends AbstractController
{
    #[Route('/registrar', name:'registrar')]
    public function registrar(): Response
    {
        return $this->render('');
    }
}
?>