<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

class HostingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'hosting.firstname',
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_account_info',
                    'placeholder' => 'hosting.firstname_placeholder'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez votre prénom",
                    ]),
                    new Length([
                        'max' => 16,
                        'maxMessage' => "Votre prénom doit être au maximum de {{ limit }} caractères",
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'hosting.email',
                'invalid_message' => 'Veuillez saisir une adresse électronique valide.',
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => ['class' => 'hosting_form_account_info',
                'placeholder' => 'hosting.email_placeholder'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une adresse électronique.',
                    ]),
                    new Email([
                        'message' => 'Veuillez saisir une adresse électronique valide.',
                    ]),
                ],
            ])
            ->add('phone', TelType::class, [
                'label' => 'hosting.phone',
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => ['class' => 'hosting_form_account_info',
                'placeholder' => 'hosting.phone_placeholder'],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez votre numéro de téléphone",
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => "Votre numéro de téléphone doit être au minimum de {{ limit }} chiffres",
                        'max' => 12,
                        'maxMessage' => "Votre numéro de téléphone doit être au maximum de {{ limit }} chiffres",
                    ]),
                ],
            ])
            ->add('sendBtn', SubmitType::class, [
                'label' => 'Envoyer',
                'row_attr' => ['class' => 'btn-hosting'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
