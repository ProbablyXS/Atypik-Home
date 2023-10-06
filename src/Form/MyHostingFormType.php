<?php

namespace App\Form;

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

class MyHostingFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'required' => false,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                    'placeholder' => 'Rechercher dans vos hébergements'
                ]
            ])
            ->add('types', EntityType::class, [
                'label' => false,
                'required' => false,
                'choice_label' => 'name',
                'class' => 'App\Entity\Types',
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
                'placeholder' => 'Tous',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->addSelect('CASE WHEN t.name = :autre THEN 1 ELSE 0 END as HIDDEN customOrder')
                        ->addOrderBy('customOrder', 'ASC')
                        ->addOrderBy('t.name', 'ASC')
                        ->setParameter('autre', 'Autre');
                },
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
