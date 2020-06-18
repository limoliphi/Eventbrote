<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'attr' => ['autofocus' => true,
                ],
                'required' => true,
            ])
            ->add('location', TextType::class)
            ->add('price', NumberType::class, ['html5' => true, 'scale' => 2])
            ->add('description', TextareaType::class, ['attr' => ['rows' => 5]])
            ->add('startAt', DateTimeType::class, ['label' => 'Starts at'])
            ->add('imageFileName', null, ['empty_data' => 'placeholder.jpg'])
            ->add('capacity', null, ['empty_data' => '1'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
