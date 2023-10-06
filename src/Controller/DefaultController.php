<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\Users;
use App\Entity\Hostings;
use App\Form\CheckOutFormType;
use App\Form\HostingFormType;
use App\Form\EditFormType;
use App\Form\RentalsFormType;
use App\Form\RentalsFilterFormType;
use App\Repository\HostingsRepository;
use App\Repository\StatusRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;

class DefaultController extends AbstractController
{
    private TranslatorInterface $translator;
    private EntityManagerInterface $entityManager;

    private $tokenStorage;
    private $entity_status;

    public function __construct(TranslatorInterface $translator, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->translator = $translator;
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;

        // Check if there is a token in the TokenStorage
        $token = $this->tokenStorage->getToken();

        if ($token) {
            // Check if there is a user associated with the token
            $user = $token->getUser();

            if (is_object($user)) {
                $this->entity_status = $user->getStatus()->getId();
            }
        }
    }

    //PAGE D'ACCUEIL
    #[Route('/', name: 'app_default', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home.html.twig', [
            'title' => $this->translator->trans('home.title'),
            'entity_status' => $this->entity_status,
        ]);
    }

    //PAGE HOSTING
    #[Route('/hosting', name: 'app_hosting')]
    public function hosting(Request $request, StatusRepository $statusRepository): Response
    {
        if ($this->getUser()) {

            if ($this->getUser()->getStatus()->getId() == 2) return $this->redirectToRoute('app_account', ['page' => 'new-hosting']);

            $user = new Users();
            $form = $this->createForm(HostingFormType::class, $user);
            $form->handleRequest($request);

            //if form is submited
            if ($form->isSubmitted() && $form->isValid()) {

                $currentUser = $this->getUser();
                $newStatus = $statusRepository->find(2);
                $currentUser->setStatus($newStatus);

                $this->entityManager->persist($currentUser);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_default');
            }

            return $this->render('hosting.html.twig', [
                'title' => $this->translator->trans('navbar.hosting'),
                'hostingForm' => $form->createView(),
                'entity_status' => $this->entity_status,
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    //PAGE RENTALS
    #[Route('/rentals', name: 'app_rentals')]
    public function rentals(Request $request, HostingsRepository $HostingsRepository): Response
    {

        $hostingsList = $HostingsRepository->findAll();

        $filteredHostings = $hostingsList;

        $myHostings = new Hostings();
        $form = $this->createForm(RentalsFormType::class, $myHostings);
        $filterForm = $this->createForm(RentalsFilterFormType::class, $myHostings);
        $form->handleRequest($request);
        $filterForm->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() or $request->query->count() > 0) {

            $filteredHostings = array_filter($hostingsList, function (Hostings $hosting) use ($request, $form) {

                $city = $form->get('city')->getData();
                $country = $form->get('country')->getData();
                $number_of_peoples = $form->get('number_of_peoples')->getData();
                $priceMax = $request->query->get('priceMax');
                $priceMin = $request->query->get('priceMin');
                $ecoScore = $request->query->get('ecoScore');
                $wifi = $request->query->get('wifi');
                $pets = $request->query->get('pets');
                $parking = $request->query->get('parking');

                $electricity = $request->query->get('electricity');
                $number_of_bathrooms = $request->query->get('number_of_bathrooms');

                $matchesCity = empty($city) || (strpos(strtolower($hosting->getCity()), strtolower($city)) !== false);
                $matchesCountry = empty($country) || (strpos(strtolower($hosting->getCountry()->getName()), strtolower($country->getName())) !== false);
                $matchesNumberOfPeoples = empty($number_of_peoples) || ($hosting->getNumberOfPeoples() == $number_of_peoples);
                $matchesEcoScore = ($ecoScore === null) || intval($hosting->getEcoScore() == $ecoScore);
                $matchesWifi = ($wifi === null) || intval($hosting->getWifi() == $wifi);
                $matchesPets = ($pets === null) || intval($hosting->isPetsAllowed() == $pets);
                $matchesParking = ($parking === null) || intval($hosting->isParking() == $parking);
                $matchesElectricity = ($electricity === null) || intval($hosting->isElectricity() == $electricity);
                $matchesNumberOfBathrooms = ($number_of_bathrooms === null) || intval($hosting->getNumberOfBathrooms() == $number_of_bathrooms);

                $priceMin = empty($priceMin) || intval($hosting->getNightPrice() >= $priceMin);
                $priceMax = empty($priceMax) || intval($hosting->getNightPrice() <= $priceMax);

                return
                    $matchesCity &&
                    $matchesCountry &&
                    $matchesNumberOfPeoples &&
                    $priceMin &&
                    $priceMax &&
                    $matchesEcoScore &&
                    $matchesWifi &&
                    $matchesPets &&
                    $matchesParking &&
                    $matchesElectricity &&
                    $matchesNumberOfBathrooms;
            });
        }

        return $this->render('rentals.html.twig', [
            'title' => $this->translator->trans('navbar.location'),
            'myRentalsForm' => $form->createView(),
            'myRentalsFilterForm' => $filterForm->createView(),
            'hostings_list' => $hostingsList,
            'hostings_filter' => $filteredHostings,
            'entity_status' => $this->entity_status,
        ]);
    }

    //PAGE RENTALS SHOW INFO RENTALS
    #[Route('/rentals/{page}', name: 'app_rentals_info')]
    public function rentalsInfo(string $page, HostingsRepository $HostingsRepository): Response
    {
        $normalizedPageName = str_replace('-', ' ', $page);
        $hosting = $HostingsRepository->findBy(['name' => $normalizedPageName]);

        if ($hosting) {
            return $this->render('/rentals_info.html.twig', [
                'title' => $this->translator->trans('navbar.account'),
                'entity_status' => $this->entity_status,
                'hosting' => reset($hosting),
            ]);
        } else {
            return $this->redirectToRoute('app_rentals');
        }
    }

    //PAGE ABOUT-US
    #[Route('/about-us', name: 'app_about_us')]
    public function about(): Response
    {
        return $this->render('about_us.html.twig', [
            'title' => $this->translator->trans('navbar.about'),
            'entity_status' => $this->entity_status,
        ]);
    }

    //PAGE CHECKOUT
    #[Route('/checkout/{title}', name: 'app_checkout')]
    public function checkout(string $title, Request $request, HostingsRepository $HostingsRepository): Response
    {
        $normalizedTitleName = str_replace('-', ' ', $title);
        $hosting = $HostingsRepository->findBy(['name' => $normalizedTitleName]);

        $form = $this->createForm(CheckOutFormType::class, reset($hosting));
        $form->handleRequest($request);

        $user = $this->getUser();

        //IF USER HAVE NOT COMPLETED THE PROFIL
        if ($user !== null) {
            $propertiesNotNull = true;
            $reflectionClass = new \ReflectionClass($user);
            $properties = $reflectionClass->getProperties();

            foreach ($properties as $property) {
                $property->setAccessible(true);
                $propertyValue = $property->getValue($user);

                if ($propertyValue === null) {
                    $propertiesNotNull = false;
                    break;
                }
            }

            //IF IS COMPLETED
            if ($propertiesNotNull) {
                if ($hosting) {

                    if ($form->isSubmitted() && $form->isValid()) {

                        $childElements = $form->createView()->children;
                        // dd($childElements);

                        return $this->redirectToRoute('app_payment', [
                            'hostingPeoples' => $childElements['number_of_peoples']->vars['value'],
                            'hostingComment' => $childElements['comment']->vars['value'],
                            'hostingDate' => $request->query->get('hostingDate'),
                            'hostingName' => $form->getData()->getName(),
                        ]);
                    }
                    return $this->render('checkout.html.twig', [
                        'title' => $title,
                        'hostingForm' => $form->createView(),
                        'entity_status' => $this->entity_status,
                        'hosting' => reset($hosting),
                    ]);
                }
            } else {
                return $this->redirectToRoute('app_account', ['page' => 'edit']);
            }
        }

        return $this->redirectToRoute('app_account', ['page' => 'edit']);
    }





    //CHANGE LANGUAGE
    #[Route('/lang/{locale}', name: 'app_lang')]
    public function lang(string $locale, Request $request, SerializerInterface $serializer): Response
    {
        $locales = $this->getParameter('app.locales');

        if (in_array($locale, $locales, true)) {
            $request->getSession()->set('_locale', $locale);

            $referer = $request->headers->get('referer');
            if (!empty($referer)) {
                return $this->redirect($referer);
            }
        }

        $error = ([
            'type' => "error",
            'message' => "The request was not allowed by the server"
        ]);
        $message = $serializer->serialize($error, 'json');
        return new JsonResponse($message, Response::HTTP_OK, [], true);
    }
}
