<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => 'required',
                'trim' => true,
                'row_attr' => ['class' => 'register-panel-info-field'],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez votre prénom",
                    ]),
                    new Length([
                        'max' => 16,
                        'maxMessage' => "Votre prénom doit être au maximum de {{ limit }} caractères",
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Votre prénom peut seulement contenir des lettres.',
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => 'required',
                'trim' => true,
                'row_attr' => ['class' => 'register-panel-info-field'],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez votre nom",
                    ]),
                    new Length([
                        'max' => 16,
                        'maxMessage' => "Votre nom doit être au maximum de {{ limit }} caractères",
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z]+$/',
                        'message' => 'Votre nom peut seulement contenir des lettres.',
                    ]),
                ],
            ])
            ->add('username', TextType::class, [
                'label' => 'Identifiant',
                'required' => 'required',
                'trim' => true,
                'row_attr' => ['class' => 'register-panel-info-field'],
                'constraints' => [
                    new NotBlank(['message' => "Votre Identifiant ne peut pas contenir un caractère vide."]),
                    new Length([
                        'min' => 6,
                        'max' => 20,
                        'minMessage' => 'Votre identifiant doit être au minimum de {{ limit }} caractères.',
                        'maxMessage' => 'Votre identifiant doit être au maximum de {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9_]+$/',
                        'message' => 'Votre identifiant peut seulement contenir des lettres, nombres, et des soulignements.',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => 'required',
                'trim' => true,
                'invalid_message' => 'Veuillez saisir une adresse électronique valide.',
                'row_attr' => ['class' => 'register-panel-info-field'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une adresse électronique.',
                    ]),
                    new Email([
                        'message' => 'Veuillez saisir une adresse électronique valide.',
                    ]),
                ],
            ])
            ->add('date_of_birth', DateType::class, [
                'widget' => 'single_text',
                'required' => 'required',
                'trim' => true,
                'label' => 'Date de naissance',
                'input' => 'datetime_immutable',
                'row_attr' => ['class' => 'register-panel-info-field']
            ])
            ->add('RGPDConsent', CheckboxType::class, [
                'label' => "J'accepte les conditions (RGPD)",
                'required' => 'required',
                'row_attr' => ['class' => 'register-panel-info-agree'],
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => "Vous devez accepter les conditions.",
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => 'required',
                'trim' => true,
                'invalid_message' => 'Les champs du mot de passe doivent être identique.',
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation du mot de passe'],
                'mapped' => false,
                'options' => [
                    'attr' => ['autocomplete' => 'new-password'],
                    'row_attr' => ['class' => 'register-panel-info-field'],
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez votre mot de passe",
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit être au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
