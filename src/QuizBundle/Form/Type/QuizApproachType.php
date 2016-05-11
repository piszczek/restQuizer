<?php

namespace QuizBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizApproachType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', null, [
              'required' => true,
              'data' => 'Twój nick'
              ])
            ->add('questionsApproach', 'collection', [
              'type' => new QuestionApproachType(),
              'allow_add' => false,
              'prototype' => false,
              'delete_empty' => true,
              'label_attr' => [
                'style' => 'display:none'
                ]
              ])
            ->add('end', 'submit',[
              'label' => 'Zapisz do rankingów',
              'attr' =>[
                'data-role' => "button",
                 'data-inline' => "true",
                 'data-theme' => "b"
                ]
              ])
            ->add('check', 'submit',[
                'label' => 'Sprawdź!',
                'attr' =>[
                   'data-role' => "button",
                   'data-inline' => "true",
                   'data-theme' => "b"
                  ]
                ])

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QuizBundle\Entity\QuizApproach'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'quizbundle_quizapproach';
    }
}
