<?php

namespace App\Form;

use App\Entity\Registration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['attr' => ['autofocus' => true]])
            ->add('email')
            ->add('howHeard', ChoiceType::class, [
                'placeholder' => 'Choose an option',
                'choices' => [
                    'Twitter' => 'Twitter',
                    'Facebook' => 'Facebook',
                    'Medias' => 'Medias',
                    'Friends' => 'Friends',
                    'Other' => 'Other',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Registration::class,
        ]);
    }
}
