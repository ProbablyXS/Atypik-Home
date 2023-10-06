<?php

namespace App\Form;

use App\Entity\Hostings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RentalsFilterFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $choices = [
            'A' => 1,
            'B' => 2,
            'C' => 3,
            'D' => 4,
            'E' => 5,
        ];

        $choicesBathrooms = [
            '1 chambre' => 1,
        ];
        for ($i = 1; $i <= 10; $i++) {
            if ($i == 1) {
                $choicesBathrooms["$i chambre"] = $i;
            } else {
                $choicesBathrooms["$i chambres"] = $i;
            }
        }

        $choicesPrice = ['0 €' => 0];

        for ($i = 0; $i <= 1000; $i += 40) {
            $choicesPrice["$i €"] = $i;
        }

        $builder
            ->add('priceMin', ChoiceType::class, [
                'label' => 'Prix € min',
                'required' => false,
                'mapped' => false,
                'row_attr' => ['class' => 'panel-info-text-price'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
                'choices' => $choicesPrice,
                'placeholder' => 'Min',
            ])
            ->add('priceMax', ChoiceType::class, [
                'label' => 'Prix € max',
                'required' => false,
                'mapped' => false,
                'row_attr' => ['class' => 'panel-info-text-price'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
                'choices' => $choicesPrice,
                'placeholder' => 'Max',
            ])
            ->add('parking', CheckboxType::class, [
                'label' => 'Parking',
                'required' => false,
                'row_attr' => ['class' => 'panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('pets', CheckboxType::class, [
                'label' => 'Animaux',
                'required' => false,
                'mapped' => false,
                'row_attr' => ['class' => 'panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('wifi', CheckboxType::class, [
                'label' => 'Wifi',
                'required' => false,
                'mapped' => false,
                'row_attr' => ['class' => 'panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('electricity', CheckboxType::class, [
                'label' => 'Electricité',
                'required' => false,
                'mapped' => false,
                'row_attr' => ['class' => 'panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
            ])
            ->add('number_of_bathrooms', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'mapped' => false,
                'row_attr' => ['class' => 'panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
                'choices' => $choicesBathrooms,
                'placeholder' => 'Nombre de chambre(s)',
            ])
            ->add('ecoScore', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'mapped' => false,
                'row_attr' => ['class' => 'panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
                'choices' => $choices,
                'placeholder' => 'Eco-Score',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hostings::class,
        ]);
    }
}
