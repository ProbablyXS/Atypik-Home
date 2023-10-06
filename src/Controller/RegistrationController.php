<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Status;
use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, KernelInterface $kernel, SerializerInterface $serializer, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UsersAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {

        if ($this->getUser()) {
            return $this->redirectToRoute('app_account');
        }

        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $status = $entityManager->find(Status::class, 1);
            $user->setStatus($status);

            //create default account picture
            $sourceImagePath = $kernel->getProjectDir() . '/public/images/default.png';
            $destinationFolderPath = $this->getParameter('images_directory');
            $newFileName = md5(uniqid()) . '.png';
            $destinationFilePath = $destinationFolderPath . '/' . $newFileName;
            copy($sourceImagePath, $destinationFilePath);

            $images = new Images();
            $images->setName($newFileName);
            $user->setImages($images);

            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'title' => 'Inscription',
            'registrationForm' => $form->createView(),
            'entity_status' => null
        ]);
    }
}
