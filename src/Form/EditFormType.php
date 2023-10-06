<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class EditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('genders', EntityType::class, [
                'label' => false,
                'row_attr' => ['class' => 'account-panel-info-account-gender-input'],
                'attr' => ['class' => 'edit_form_account_info_radio'],
                'class' => 'App\Entity\Genders',
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('firstname', TextType::class, [
                'label' => 'account.edit.firstname',
                'row_attr' => ['class' => 'account-panel-info-text'],
                'attr' => ['class' => 'edit_form_account_info'],
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
            ->add('lastname', TextType::class, [
                'label' => 'account.edit.lastname',
                'row_attr' => ['class' => 'account-panel-info-text'],
                'attr' => ['class' => 'edit_form_account_info'],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez votre nom",
                    ]),
                    new Length([
                        'max' => 16,
                        'maxMessage' => "Votre nom doit être au maximum de {{ limit }} caractères",
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'account.edit.description',
                'row_attr' => ['class' => 'desc-panel-info-text'],
                'attr' => [
                    'class' => 'edit_form_account_info hosting_form_new_hosting_info vertical-resize description',
                    'maxlength' => 6000,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez une description",
                    ]),
                    new Length([
                        'min' => 16,
                        'maxMessage' => "Votre description doit être au minimum {{ limit }} caractères",
                    ]),
                ],
            ])
            ->add('date_of_birth', DateType::class, [
                'widget' => 'single_text',
                'label' => 'account.edit.date_of_birth',
                'input' => 'datetime_immutable',
                'row_attr' => ['class' => 'account-panel-info-text'],
                'attr' => ['class' => 'edit_form_account_info'],
            ])
            ->add('phone', TelType::class, [
                'label' => 'account.edit.phone',
                'row_attr' => ['class' => 'account-panel-info-text'],
                'attr' => ['class' => 'edit_form_account_info'],
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
            ->add('imageFile', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' =>
                    'edit_form_account_info_image_file',
                    'style' => 'display: none;'
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '20M',
                        'maxSizeMessage' => 'The file is too large. Maximum allowed size is 1 GB.',
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'account.edit.address',
                'row_attr' => ['class' => 'account-panel-info-text'],
                'attr' => ['class' => 'edit_form_account_info'],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez une adresse",
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => "Votre adresse doit être au minimum de {{ limit }} caractères",
                    ]),
                ],
            ])
            ->add('zipcode', NumberType::class, [
                'label' => 'account.edit.zipcode',
                'row_attr' => ['class' => 'account-panel-info-text'],
                'attr' => ['class' => 'edit_form_account_info'],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez un code postal",
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]+$/',
                        'message' => 'Votre code postal peut seulement contenir des nombres.',
                    ]),

                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'account.edit.city',
                'row_attr' => ['class' => 'account-panel-info-text'],
                'attr' => ['class' => 'edit_form_account_info'],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez une Ville",
                    ]),

                ],
            ])
            ->add('country', EntityType::class, [
                'label' => 'account.edit.country',
                'row_attr' => ['class' => 'account-panel-info-text'],
                'attr' => ['class' => 'edit_form_account_info'],
                'class' => 'App\Entity\Country',
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez un pays",
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'account.edit.email',
                'invalid_message' => 'Veuillez saisir une adresse électronique valide.',
                'row_attr' => ['class' => 'account-panel-info-text'],
                'attr' => ['class' => 'edit_form_account_info'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une adresse électronique.',
                    ]),
                    new Email([
                        'message' => 'Veuillez saisir une adresse électronique valide.',
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
