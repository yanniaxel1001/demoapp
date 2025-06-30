<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        for($i=1;$i<=5;$i++)
        {
            // Crear un usuario de prueba
        $user = new User();
        $user->setUsername('username'.$i);
        $user->setName('nombre');
        $user->setLastname('lastname');
        $user->setEmail('demo@ejemplo.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'test123'));
        $manager->persist($user);

        // Crear productos de ejemplo
        for ($j = 1; $j <= 5; $j++) {
            $producto = new Product();
            $producto->setName('Producto '.$i);
            $producto->setDescription('Descripción del producto '.$i);
            $producto->setPrice(mt_rand(10, 100));
            $producto->setOwner($user);
            $manager->persist($producto);
        }

        $manager->flush();
        }
    }
}
