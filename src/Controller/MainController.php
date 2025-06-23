<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class MainController extends AbstractController
{
    #[Route('/', name:'inicio')]
    public function index(): Response
    {
        return $this->render('inicio/index.html.twig');
    }

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

    #[Route('/registrar', name:'registrar', methods:['GET','POST'])]
    public function registrar(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response{
        if ($request->isMethod('POST')) 
        {
            $password = $request->request->get('password');
            $confirmPassword = $request->request->get('confirm_password');
            if ($password !== $confirmPassword) 
            {
                return $this->redirectToRoute('registrar');
            }
            // Procesar el formulario manualmente
            $user = new User();
            $user->setUsername($request->request->get('username'));
            $user->setEmail($request->request->get('email'));
            $user->setName($request->request->get('nombre'));
            $user->setLastname($request->request->get('apellido'));
            
            // Hashear la contraseña
            $user->setPassword(
                    $passwordHasher->hashPassword(
                    $user,
                    $request->request->get('password')
                )
            );
            
            $user->setRoles(['ROLE_USER']);
            
            $entityManager->persist($user);
            $entityManager->flush();
            
            return $this->redirectToRoute('login');
        }
        return $this->render('registro/registro.html.twig');
    }

    #[Route("/logout",name:"logout")]
    public function logout(): void
    {

    }
}
?>