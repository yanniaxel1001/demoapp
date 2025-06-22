<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/dashboard')]
class TableroController extends AbstractController
{
    #[Route('/', name: 'product_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $products = $em->getRepository(Product::class)->findBy([
            'owner' => $this->getUser()
        ]);

        return $this->render('dashboard/index.html.twig', [
            'products' => $products
        ]);
    }

     #[Route('/create', name: 'product_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $product = new Product();
            $product->setName($request->request->get('name'));
            $product->setDescription($request->request->get('description'));
            $product->setPrice((float)$request->request->get('price'));
            $product->setOwner($this->getUser());

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('dashboard/create.html.twig');
    }

    #[Route("/logout",name:"logout")]
    public function logout(): void
    {

    }

}
?>