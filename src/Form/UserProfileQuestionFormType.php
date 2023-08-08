<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileQuestionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', options: [
                'label' => 'Title',
                'attr' => [
                    'placeholder' => 'Enter title',
                ]
            ])
            ->add('summary', options: [
                'label' => 'Summary',
                'attr' => [
                    'placeholder' => 'Enter summary',
                ]
            ])
            ->add('description', options: [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Enter description',
                ]
            ])
//            ->add('quiz', options: [
//                'label' => 'Category',
//                'attr' => [
//                    'placeholder' => 'Enter category',
//                ]
//            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
