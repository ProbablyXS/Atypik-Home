<?php

namespace App\Form;

use App\Entity\Hostings;
use App\Entity\Types;
use App\Validator\Constraints\MinFileCount;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class NewHostingFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', TextType::class, [
                'label' => "Titre",
                'required' => true,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                    'placeholder' => 'Le couvent des Cordelières option SPA / Jacuzzi'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez le titre de votre logement",
                    ]),
                    new Length([
                        'min' => 6,
                        'maxMessage' => "Votre titre du logement doit être au minimum {{ limit }} caractères",
                    ]),
                ],
            ])
            ->add('types', EntityType::class, [
                'label' => "Type d'hébergement",
                'required' => true,
                'choice_label' => 'name',
                'class' => 'App\Entity\Types',
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->addSelect('CASE WHEN t.name = :autre THEN 1 ELSE 0 END as HIDDEN customOrder')
                        ->addOrderBy('customOrder', 'ASC')
                        ->addOrderBy('t.name', 'ASC')
                        ->setParameter('autre', 'Autre');
                },
            ])
            ->add('imageFiles', FileType::class, [
                'label' => 'Photo(s)',
                'mapped' => false,
                'multiple' => true,
                'required' => true,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' =>'edit_form_account_info_image_file',
                    'style' => 'display: none;',
                    'data-max-files' => 20,
                ],
                'constraints' => [
                    new MinFileCount([
                        'limit' => 5,
                    ]),
                ],
            ])
            ->add('imageFilesBtn', ButtonType::class, [
                'label' => 'Ajouter des photo(s)',
                'row_attr' => ['class' => 'btn-hosting'],
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description",
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info vertical-resize description',
                    'placeholder' => 'Exemple : Flâner dans le village de Saint-Bertrand-de-Comminges, une ancienne cité romaine inscrite au patrimoine de l’UNESCO, devenue haut lieu de pèlerinage sur le chemin vers Compostelle 🦴 Marcher sur les traces des premiers hommes au musée de l’Aurignacien à Aurignac 🏺 Découvrir l’étonnant village gaulois de l’Archéosite 🏛️ Explorer les carrières gallo-romaines de Pédégas 🌤️ Prendre de l’altitude en parapente. École de parapente Surfair à Arbas : 06 23 10 89 36 🚵‍♀️ Prendre de la vitesse en VTT. O2Bike à Arbas, Aspet, Salies-du-Salat ou Saint-Martory : 06 13 09 81 07 🥾 Emprunter les chemins de randonnée du GR®861',
                    'maxlength' => 6000,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez la description de votre logement",
                    ]),
                    new Length([
                        'min' => 6,
                        'maxMessage' => "Votre description du logement doit être au minimum {{ limit }} caractères",
                    ]),
                ],
            ])
            ->add('suggested_activities', TextType::class, [
                'label' => "Suggestion d'activités",
                'required' => true,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                    'placeholder' => 'Visite du village de Saint-Emilion classé au Patrimoine Mondial de l’UNESCO ainsi que de son église monolithe (la plus grande d’Europe). Balades dans les vignobles '
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez le titre de votre logement",
                    ]),
                    new Length([
                        'min' => 6,
                        'maxMessage' => "Votre titre du logement doit être au minimum {{ limit }} caractères",
                    ]),
                ],
            ])
            ->add('night_price', NumberType::class, [
                'label' => "Prix € / nuit",
                'required' => true,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('number_of_peoples', NumberType::class, [
                'label' => "Nombre de personnes",
                'required' => true,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('number_of_sleeps', NumberType::class, [
                'label' => "Nombre de couchages",
                'required' => true,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('number_of_bedrooms', NumberType::class, [
                'label' => "Nombre de chambres",
                'required' => true,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('number_of_bathrooms', NumberType::class, [
                'label' => "Nombre de salle de bains",
                'required' => true,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('surface', NumberType::class, [
                'label' => "Surface en m2",
                'required' => true,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('arrival_time', TimeType::class, [
                'input' => 'datetime_immutable',
                'required' => true,
                'label' => "Horaire d'arrivée",
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_select',
                ],
            ])
            ->add('departure_time', TimeType::class, [
                'input' => 'datetime_immutable',
                'required' => true,
                'label' => "Horaire de départ",
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_select',
                ],
            ])
            ->add('address', TextType::class, [
                'label' => "Adresse",
                'required' => true,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                    'placeholder' => '17 avenue dreo'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez le titre de votre logement",
                    ]),
                    new Length([
                        'min' => 6,
                        'maxMessage' => "Votre titre du logement doit être au minimum {{ limit }} caractères",
                    ]),
                ],
            ])
            ->add('zipcode', NumberType::class, [
                'label' => "Code postal",
                'required' => true,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                    'placeholder' => '83170'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez le code postal de votre logement",
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => "Votre code postal doit être au minimum {{ limit }} caractères",
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'label' => "Ville",
                'required' => true,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                    'placeholder' => 'Brignoles'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez la ville de votre logement",
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => "Votre ville doit être au minimum {{ limit }} caractères",
                    ]),
                ],
            ])

            ->add('country', EntityType::class, [
                'label' => "Pays",
                'required' => true,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                    'placeholder' => 'France'
                ],
                'class' => 'App\Entity\Country',
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez le pays de votre logement",
                    ]),
                ],
            ])
            ->add('wifi', ChoiceType::class, [
                'label' => "Wifi",
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('pets_allowed', ChoiceType::class, [
                'label' => "Animaux autorisés",
                'required' => true,
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('parking', ChoiceType::class, [
                'label' => "Parking",
                'required' => true,
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('electricity', ChoiceType::class, [
                'label' => "Electricité",
                'required' => true,
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('smoking_allowed', ChoiceType::class, [
                'label' => "Fumeur",
                'required' => true,
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('eco_score', ChoiceType::class, [
                'label' => "Eco-score",
                'required' => true,
                'choices' => [
                    'A' => 5,
                    'B' => 4,
                    'C' => 3,
                    'D' => 2,
                    'E' => 1,
                ],
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('sendBtn', SubmitType::class, [
                'label' => 'Déposer',
                'row_attr' => ['class' => 'btn-hosting'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hostings::class,
        ]);
    }
}
