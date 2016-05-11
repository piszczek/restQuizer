<?php

namespace QuizBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class QuizType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('questions', 'collection', [
              'type' => new QuestionType(),
              'allow_add' => true,
              'prototype' => true,
              'by_reference' => false,
              'allow_delete' => true
              ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QuizBundle\Entity\Quiz'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'quizbundle_quiz';
    }
}
