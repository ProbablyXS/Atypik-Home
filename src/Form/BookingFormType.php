<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Hostings;
use App\Entity\Types;
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

class BookingFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('hostingName', TextType::class, [
            'label' => false,
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'hosting_form_new_hosting_info',
                'placeholder' => 'Rechercher un logement',
            ],
        ])
        ->add('total_price', TextType::class, [
            'label' => false,
            'required' => false,
            'row_attr' => ['class' => 'question-panel-info-text'],
            'attr' => [
                'class' => 'hosting_form_new_hosting_info',
                'placeholder' => 'Prix'
            ]
        ])
            ->add('comment', TextType::class, [
                'label' => false,
                'required' => false,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                    'placeholder' => 'Rechercher dans vos reservation'
                ]
            ])
            ->add('sendBtn', SubmitType::class, [
                'label' => 'Rechercher',
                'row_attr' => ['class' => 'btn-hosting'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
