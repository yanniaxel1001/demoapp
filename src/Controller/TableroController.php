<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class TableroController extends AbstractController
{
    #[Route('/dashboard', name:'productos')]
    public function inicio(): Response
    {
        $this->$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $thi->getUser();

        return $this->render('dashboard/productos.html.twig',[
            'username' => $user-> getUsername()
        ]);
    }
}
?>