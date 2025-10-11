<?php

declare(strict_types=1);

namespace App\UI\Http;

use App\Core\Shared\Traits\WithEntityManager;
use App\Core\User\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/register', name: 'app_register')]
final class RegisterAction extends AbstractController
{
    use WithEntityManager;

    public function __invoke(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $plainPassword = $request->request->get('password');

            // Check if user already exists
            $existingUser = $this->getRepository(User::class)->findOneBy(['email' => $email]);
            if ($existingUser) {
                $this->addFlash('error', 'User with this email already exists.');
                return $this->render('security/register.html.twig');
            }

            // Create new user
            $user = new User(
                email: $email,
                password: ''
            );
            
            // Hash the password
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plainPassword
            );
            $user->setPassword($hashedPassword);
            
            // Save the user
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Registration successful! You can now log in.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig');
    }
}