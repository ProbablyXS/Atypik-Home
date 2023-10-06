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

class CheckOutFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $defaultNumberOfPeople = $options['data']->getNumberOfPeoples();
        $defaultName = $options['data']->getUsers()->getFirstName();

        $builder
            ->add('number_of_peoples', ChoiceType::class, [
                'label' => "Nombre de personnes",
                'required' => true,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info',
                ],
                'choices' => $this->generateChoices($defaultNumberOfPeople),
                'data' => $defaultNumberOfPeople,
            ])
            ->add('comment', TextareaType::class, [
                'label' => false,
                'mapped' => false,
                'row_attr' => ['class' => 'question-panel-info-text'],
                'attr' => [
                    'class' => 'hosting_form_new_hosting_info vertical-resize',
                    'placeholder' => "Exemple : Bonjour " . $defaultName . " nous avons hâte de venir séjourner chez vous. Nous prévoyons d'arriver vers 18h.",
                    'maxlength' => 6000,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => "S'il vous plait entrez un commentaire",
                    ]),
                    new Length([
                        'min' => 6,
                        'maxMessage' => "Votre commentaire doit être au minimum {{ limit }} caractères",
                    ]),
                ],
            ])
            ;
    }

    private function generateChoices($defaultNumberOfPeople)
    {
        $choices = [];
        
        // Start from the default value and decrease by 1 until 0
        for ($i = $defaultNumberOfPeople; $i >= 0; $i--) {
            $choices["$i"] = $i;
        }
        
        return $choices;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hostings::class,
        ]);
    }
}
