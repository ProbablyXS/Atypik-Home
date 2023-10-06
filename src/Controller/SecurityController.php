<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_account', ['page' => 'home']);
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'title' => 'Connexion',
            'last_username' => $lastUsername,
            'error' => $error,
            'entity_status' => null
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/delete', name: 'delete_user', methods: ["get"])]
    public function delete(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {

            $user = $this->getUser();

            //delete image in local directory freed up space
            $filesystem = new Filesystem();
            $filesystem->remove($this->getParameter('images_directory') . '/' . $user->getImages()->getName());

            //delete account
            $tokenStorage->setToken(null);
            $entityManager->remove($user);
            $entityManager->flush();

            // Logout the user
            return $this->redirectToRoute('app_logout');
        }

        return $this->redirectToRoute('app_default');
    }
}
