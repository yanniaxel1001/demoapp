<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/dashboard')]
class TableroController extends AbstractController
{
    #[Route('/', name: 'product_index')]
    public function index(EntityManagerInterface $em, AuthenticationUtils $authenticationUtils): Response
    {
        $products = $em->getRepository(Product::class)->findBy([
            'owner' => $this->getUser()
        ]);

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('dashboard/index.html.twig', [
            'products' => $products,
            'last_username' => $lastUsername
        ]);
    }

    #[Route('/create', name: 'product_create', methods: ['GET', 'POST'])]
    public function create(
        Request $request, 
        EntityManagerInterface $em): Response
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

    #[Route('/{id}/edit', name: 'product_edit', methods: ['GET','POST'])]
    public function edit(
        int $id,
        Request $request,
        EntityManagerInterface $em): Response
    {
        $product = $em->getRepository(Product::class)->find($id);

        if($request->isMethod('POST')){
            $product->setName($request->request->get('name'));
            $product->setDescription($request->request->get('description'));
            $product->setPrice((float)$request->request->get('price'));
            $em->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('dashboard/edit.html.twig',[
            'product'=>$product
        ]);
    }

    #[Route('/{id}/delete', name: 'product_delete', methods: ['POST'])]
    public function delete(
        int $id,
        Request $request,
        EntityManagerInterface $em): Response
    {
        $product = $em->getRepository(Product::class)->find($id);

        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('product_index');
    }
    #[Route('/dashboard/buscar', name: 'product_search', methods: ['GET'])]
    public function search(Request $request, 
        EntityManagerInterface $em): JsonResponse
    {
        $termino = $request->query->get('q');
        $usuario = $this->getUser();

        $qb = $em->createQueryBuilder();
        $qb->select('p')
            ->from(Product::class, 'p')
            ->where('p.owner = :user')
            ->andWhere('p.name LIKE :term')
            ->setParameter('user', $usuario)
            ->setParameter('term', '%' . $termino . '%');

        $productos = $qb->getQuery()->getResult();

        $resultados = [];

        foreach ($productos as $producto) {
            $resultados[] = [
                'id' => $producto->getId(),
                'name' => $producto->getName(),
                'price' => $producto->getPrice(),
                'description' => $producto->getDescription()
            ];
        }
        return new JsonResponse($resultados);
    }
}
?>