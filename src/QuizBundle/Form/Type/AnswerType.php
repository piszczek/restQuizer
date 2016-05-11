<?php

namespace QuizBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
              'attr' => [
                'placeholder' => 'Treść odpowiedzi'
                ]
              ])
            ->add('correct', null, [
              'label' => "Prawda",
              'data' => false,
              'required' => false
              ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'QuizBundle\Entity\Answer'
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'quizbundle_answer';
    }
}
