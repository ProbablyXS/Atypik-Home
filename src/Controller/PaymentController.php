<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Users;
use App\Entity\Images;
use App\Entity\Hostings;
use App\Entity\Unavailability;
use App\Form\HostingFormType;
use App\Form\NewHostingFormType;
use App\Form\MyHostingFormType;
use App\Form\EditFormType;
use App\Repository\HostingsRepository;
use App\Repository\UnavailabilityRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use PhpParser\Node\Name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Contracts\Translation\TranslatorInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController extends AbstractController
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

    #[Route('/payment/{hostingName}', name: 'app_payment')]
    public function payment(Request $request, HostingsRepository $HostingsRepository, $hostingName)
    {
        
        $data = $request->query->all();

        if ($data) {

            if (isset($data['hostingDate'])) {
                $dateRange = $data['hostingDate'];
            } else {
                $dateRange = date('Y-m-d' . " - " . date('Y-m-d'));
            }
            
            $comment = $data['hostingComment'];
            $Peoples = $data['hostingPeoples'];

            $normalizedPageName = str_replace('-', ' ', $hostingName);
            $hosting = $HostingsRepository->findBy(['name' => $normalizedPageName]);
            $hosting = reset($hosting);

            $amount = $hosting->getNightPrice();

            // Initialisez la bibliothèque Stripe avec votre clé secrète
            Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

            // Créez une session de paiement Stripe
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'eur',
                            'product_data' => [
                                'name' => $hosting->getName(),
                            ],
                            'unit_amount' => $amount * 100,  // Montant en cents
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => $this->generateUrl('app_payment_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'cancel_url' => $this->generateUrl('app_payment_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),
            ]);

            // Store some session data (e.g., session ID, hosting details) in the user's session

            $dataToStore = [
                'payment_session_id' => $session->id,
                'hosting_id' => $hosting->getId(),
                'hosting_date' => $dateRange,
                'hosting_amount' => $amount,
                'hosting_comment' => $comment,
                'hosting_number_of_peoples' => $Peoples,
            ];

            $request->getSession()->set('hosting_data', $dataToStore);

            return $this->redirect($session->url, 303);
        }
        
        return $this->redirectToRoute("app_default");
    }

    #[Route('reservation/success', name: 'app_payment_success')]
    public function paymentSuccess(Request $request, HostingsRepository $HostingsRepository)
    {
        // Retrieve the session and hosting details from the user's session
        $hostingData = $request->getSession()->get('hosting_data');

        // Access individual values from the array
        $sessionId = $hostingData['payment_session_id'];
        $hostingId = $hostingData['hosting_id'];
        $hostingDate = $hostingData['hosting_date'];
        $hostingAmount = $hostingData['hosting_amount'];
        $hostingComment = $hostingData['hosting_comment'];
        $hostingPeoples = $hostingData['hosting_number_of_peoples'];

        $hosting = $HostingsRepository->findBy(['id' => $hostingId]);
        $hosting = reset($hosting);

        // Initialize the Stripe library with your secret key
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        // Retrieve the session and payment details from Stripe
        $session = Session::retrieve($sessionId);

        // Check if the payment was successful
        if ($session->payment_status === 'paid') {

            list($startDate, $endDate) = explode(' - ', $hostingDate);

            $startDateTime = new \DateTimeImmutable($startDate);
            $endDateTime = new \DateTimeImmutable($endDate);

            //SET DATE INSIDE Unavailability TABLE
            $newDate = new Unavailability();
            $newDate->setStartDate($startDateTime);
            $newDate->setEndDate($endDateTime);
            $newDate->setHostings($hosting);
            $hosting->addUnavailability($newDate);

            //ADD RESERVATION
            $newReservation = new Reservation();
            $newReservation->setUsers($this->getUser());
            $newReservation->setHostings($hosting);
            $newReservation->setComment($hostingComment);
            $newReservation->setStartDate($startDateTime);
            $newReservation->setEndDate($endDateTime);
            $newReservation->setTotalPrice($hostingAmount);
            $newReservation->setNumberOfPeoples($hostingPeoples);
            $hosting->addReservation($newReservation);

            //FINALLY
            $this->entityManager->persist($hosting);
            $this->entityManager->flush();

            // Retrieve the session and hosting details from the user's session
            $request->getSession()->remove('hosting_data');

            return $this->render('success.html.twig', [
                'title' => $this->translator->trans('navbar.new-hosting'),
                'entity_status' => $this->entity_status,
            ]);
        }

        return $this->redirectToRoute('app_default');
    }

    #[Route('reservation/cancel', name: 'app_payment_cancel')]
    public function paymentCancel()
    {
        return $this->redirectToRoute('app_default');
    }
}
