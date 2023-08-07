<?php

namespace App\Form;

use App\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileQuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', options: [
                'label' => 'Title',
                'attr' => [
                    'placeholder' => 'Enter title',
//                    'value' => $options['data']->getFirstName()
                ]
            ])
            ->add('slug', options: [
                'label' => 'Slug',
                'attr' => [
                    'placeholder' => 'Enter slug',
//                    'value' => $options['data']->getLastName()
                ]
            ])
            ->add('duration', options: [
                'label' => 'Duration',
                'attr' => [
                    'placeholder' => 'Enter duration',
//                    'value' => $options['data']->getLastName()
                ]
            ])
            ->add('category', options: [
                'label' => 'Category',
                'attr' => [
                    'placeholder' => 'Enter category',
//                    'value' => $options['data']->getLastName()
                ]
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}
