<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Hostings;
use App\Entity\Reservation;
use App\Form\NewHostingFormType;
use App\Form\MyHostingFormType;
use App\Form\BookingFormType;
use App\Form\EditFormType;
use App\Repository\HostingsRepository;
use App\Repository\UnavailabilityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class AccountController extends AbstractController
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
    #[Route('/home', name: 'app_home', methods: ['GET'])]
    public function home(): Response
    {
        return $this->redirectToRoute('app_default');
    }

    //PAGE MON COMPTE
    #[Route('/account', name: 'app_account_home', methods: ['GET'])]
    public function myaccount_home(): Response
    {
        return $this->redirectToRoute('app_account', ['page' => 'home']);
    }

    //PAGE MON COMPTE
    #[Route('/account/{page}', name: 'app_account')]
    public function myaccount(string $page, Request $request, SerializerInterface $serializer): Response
    {

        if ($this->getUser()) {

            //if request page is /account/home
            if ($page == 'home') {
                return $this->render('account/home.html.twig', [
                    'title' => $this->translator->trans('navbar.account'),
                    'entity_status' => $this->entity_status,
                ]);
            }

            //if request page is /account/my-hosting
            if ($page == 'my-hostings') {
                if ($this->getUser()->getStatus()->getId() == 1) return $this->redirectToRoute('app_hosting');

                $hostingsList = $this->getUser()->getHostings();
                $filteredHostings = $hostingsList;

                $myHostings = new Hostings();
                $form = $this->createForm(MyHostingFormType::class, $myHostings);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $name = $form->get('name')->getData();
                    $type = $form->get('types')->getData();

                    $filteredHostings = $hostingsList->filter(function (Hostings $hosting) use ($type, $name) {
                        $matchesType = ($type === null) || ($hosting->getTypes() === $type);
                        $matchesName = empty($name) || (strpos(strtolower($hosting->getName()), strtolower($name)) !== false);
                        return $matchesType && $matchesName;
                    });
                }

                return $this->render('account/my_hostings.html.twig', [
                    'title' => $this->translator->trans('account.my_hostings.title'),
                    'myHostingForm' => $form->createView(),
                    'hostings_list' => $hostingsList,
                    'hostings_filter' => $filteredHostings,
                    'entity_status' => $this->entity_status,
                ]);
            }

            //if request page is /account/new-hosting
            if ($page == 'new-hosting') {
                if ($this->getUser()->getStatus()->getId() != 2) return $this->redirectToRoute('app_hosting');

                $hosting = new Hostings();
                $form = $this->createForm(NewHostingFormType::class, $hosting);
                $form->handleRequest($request);

                //if form send
                if ($form->isSubmitted() && $form->isValid()) {

                    $hosting->setUsers($this->getUser());

                    $images = $form->get('imageFiles')->getData();

                    foreach ($images as $image) {

                        if ($image) {
                            $file = md5(uniqid()) . '.' . $image->getClientOriginalExtension();
                            $image->move(
                                $this->getParameter('images_directory'),
                                $file
                            );

                            $images = new Images();
                            $images->setName($file);
                            $hosting->addImage($images);
                        }
                    }

                    //push
                    $this->entityManager->persist($hosting);
                    $this->entityManager->flush();

                    return $this->redirectToRoute('app_account', ['page' => 'done']);
                }

                return $this->render('account/new_hosting.html.twig', [
                    'title' => $this->translator->trans('navbar.new-hosting'),
                    'newHostingForm' => $form->createView(),
                    'entity_status' => $this->entity_status,
                ]);
            }


            //if request page is /account/done
            if ($page == 'done') {
                if ($this->getUser()) {
                    return $this->render('account/done.html.twig', [
                        'title' => $this->translator->trans('navbar.new-hosting'),
                        'entity_status' => $this->entity_status,
                    ]);
                }
            }


            //if request page is /account/booking
            if ($page == 'booking') {

                $reservationsList = $this->getUser()->getReservations();
                $filteredReservations = $reservationsList;

                $myReservations = new Reservation();
                $form = $this->createForm(BookingFormType::class, $myReservations);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $HostingName = $form->get('hostingName')->getData();
                    $totalPrice = $form->get('total_price')->getData();
                    $Comment = $form->get('comment')->getData();

                    $filteredReservations = $reservationsList->filter(function (Reservation $reservation) use ($HostingName, $totalPrice, $Comment) {
                        $matchesTotalHostingName = ($HostingName === null) || (strpos(strtolower($reservation->getHostings()->getName()), strtolower($HostingName)) !== false);
                        $matchesTotalPrice = ($totalPrice === null) || intval($reservation->getTotalPrice()) === intval($totalPrice);
                        $matchesComment = ($Comment === null) || (strpos(strtolower($reservation->getComment()), strtolower($Comment)) !== false);
                        return $matchesTotalHostingName && $matchesComment && $matchesTotalPrice;
                    });
                }

                return $this->render('account/booking.html.twig', [
                    'title' => $this->translator->trans('account.booking.title'),
                    'myReservationForm' => $form->createView(),
                    'reservations_list' => $reservationsList,
                    'reservations_filter' => $filteredReservations,
                    'entity_status' => $this->entity_status,
                ]);
            }

            //if request page is /account/edit
            if ($page == 'edit') {

                $user = $this->getUser();

                $form = $this->createForm(EditFormType::class, $user);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $image = $form->get('imageFile')->getData();

                    if ($image) {

                        //delete image in local directory freed up space
                        $filesystem = new Filesystem();
                        $filesystem->remove($this->getParameter('images_directory') . '/' . $user->getImages()->getName());

                        $file = md5(uniqid()) . '.' . $image->getClientOriginalExtension();

                        $image->move(
                            $this->getParameter('images_directory'),
                            $file
                        );

                        $this->getUser()->getImages()->setName($file);
                    }

                    $this->entityManager->persist($user);
                    $this->entityManager->flush();
                }

                $user = $this->getUser();

                return $this->render('account/edit.html.twig', [
                    'title' => $this->translator->trans('account.home.settings'),
                    'personal_info' => $user,
                    'editForm' => $form->createView(),
                    'entity_status' => $this->entity_status,
                    'profile_img' => $this->getUser()->getImages()->getName(),
                ]);
            }
        }

        return $this->redirectToRoute('app_login');
    }


    //ROUTE DELETE HOSTING
    #[Route(path: '/delete_hosting', name: 'delete_hosting', methods: ["GET"])]
    public function deleteHosting(Request $request, HostingsRepository $HostingsRepository, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {

            $data = $request->query->all();

            if ($data) {

                $user = $this->getUser();
                $hostingId = $data['hosting'];

                $hosting = $HostingsRepository->find($hostingId);

                //delete
                $user->removeHosting($hosting);
                $entityManager->persist($user);
                $entityManager->flush();

                //delete image in local directory freed up space
                foreach ($hosting->getImages() as $image) {
                    $filesystem = new Filesystem();
                    $filesystem->remove($this->getParameter('images_directory') . '/' . $image->getName());
                }

                return $this->redirectToRoute('app_account', ['page' => 'my-hostings']);
            }
        }

        return $this->redirectToRoute('app_default');
    }



    // (. Ils pourront également gérer
    // un planning de disponibilité pour l’ensemble de leurs biens.)
    // Clairement pas le temps pour ajouter un bundle qui permet de faire cela.
    // #[Route('/addUnavailableDate', name: 'app_add_unavailable_date', methods: ["GET"])]
    // public function addUnavailableDate(Request $request, HostingsRepository $HostingsRepository, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->getUser()) {

    //         $data = $request->query->all();

    //         if ($data) {

    //             $hostingId = $data['hostingId'];
    //             $dateRange = $data['hostingDate'];
    //             list($startDate, $endDate) = explode(' - ', $dateRange);

    //             $startDateTime = new \DateTimeImmutable($startDate);
    //             $endDateTime = new \DateTimeImmutable($endDate);

    //             $hosting = $HostingsRepository->find($hostingId);

    //             $newDate = new Unavailability();
    //             $newDate->setStartDate($startDateTime);
    //             $newDate->setEndDate($endDateTime);
    //             $newDate->setHostings($hosting);

    //             $hosting->addUnavailability($newDate);

    //             $entityManager->persist($hosting);
    //             $entityManager->flush();

    //             dd('done');

    //             return $this->redirectToRoute('app_account', ['page' => 'my-hostings']);
    //         }
    //     }

    //     return $this->redirectToRoute('app_default');
    // }

    // #[Route('/removeUnavailableDate', name: 'app_remove_unavailable_date', methods: ["GET"])]
    // public function removeUnavailableDate(Request $request, HostingsRepository $HostingsRepository, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->getUser()) {

    //         $data = $request->query->all();

    //         if ($data) {

    //             $hostingId = $data['hostingId'];
    //             $dateRange = $data['hostingDate'];
    //             list($startDate, $endDate) = explode(' - ', $dateRange);

    //             $startDateTime = new \DateTimeImmutable($startDate);
    //             $endDateTime = new \DateTimeImmutable($endDate);

    //             $deletionStartDateTime = $startDateTime->modify('-1 day');
    //             $deletionEndDateTime = $endDateTime->modify('+1 day');

    //             $qb = $entityManager->createQueryBuilder();
    //             $qb->delete(Unavailability::class, 'u')
    //                 ->where('u.hostings = :hostingId')
    //                 ->andWhere('u.end_date >= :deletionStartDateTime')
    //                 ->andWhere('u.start_date <= :deletionEndDateTime')
    //                 ->setParameter('hostingId', $hostingId)
    //                 ->setParameter('deletionStartDateTime', $deletionStartDateTime)
    //                 ->setParameter('deletionEndDateTime', $deletionEndDateTime);

    //             // Execute the delete query
    //             $qb->getQuery()->execute();

    //             return $this->redirectToRoute('app_account', ['page' => 'my-hostings']);
    //         }
    //     }

    //     return $this->redirectToRoute('app_default');
    // }

    //ROUTE getUnavailableDate
    #[Route('/getUnavailableDate/{hostingId}', name: 'app_get_unavailable_date', methods: ["GET"])]
    public function getUnavailableDates(UnavailabilityRepository $UnavailabilityRepository, SerializerInterface $serializer, $hostingId): JsonResponse
    {
        // Retrieve data from the repository
        $unavailableDates = $UnavailabilityRepository->findBy(['hostings' => $hostingId]);

        $formattedDates = [];
        foreach ($unavailableDates as $unavailability) {
            $formattedDates[] = [
                'start_date' => $unavailability->getStartDate()->format('Y-m-d'),
                'end_date' => $unavailability->getEndDate()->format('Y-m-d'),
            ];
        }

        // Create a JsonResponse and return it
        return new JsonResponse($formattedDates);
    }
}
