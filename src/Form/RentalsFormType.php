<?php

namespace App\Form;

use App\Entity\Hostings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RentalsFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $choices = [
            '1 Voyageur' => 1,
        ];
        for ($i = 1; $i <= 10; $i++) {
            if ($i == 1) {
                $choices["$i Voyageur"] = $i;
            } else {
                $choices["$i Voyageurs"] = $i;
            }
        }

        $builder
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'required' => false,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                    'placeholder' => 'Paris',
                ],
            ])
            ->add('country', EntityType::class, [
                'label' => 'Pays',
                'required' => false,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
                'class' => 'App\Entity\Country',
                'choice_label' => 'name',
                'placeholder' => 'Tous les pays',
            ])
            ->add('arrival', DateType::class, [
                'label' => 'Arrivée',
                'widget' => 'single_text',
                'required' => false,
                'trim' => true,
                'mapped' => false,
                'input' => 'datetime_immutable',
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ]
            ])
            ->add('departure', DateType::class, [
                'label' => 'Départ',
                'widget' => 'single_text',
                'required' => false,
                'trim' => true,
                'mapped' => false,
                'input' => 'datetime_immutable',
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ]
            ])
            ->add('number_of_peoples', ChoiceType::class, [
                'label' => 'Voyageur(s)',
                'required' => false,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
                'placeholder' => 'Tous',
                'choices' => $choices,
                'data' => 0,
            ])
            ->add('sendBtn', SubmitType::class, [
                'label' => 'Rechercher',
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
