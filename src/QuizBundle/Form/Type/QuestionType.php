<?php

namespace QuizBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use QuizBundle\Entity\Answer;
use QuizBundle\Entity\Question;

class QuestionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', 'text', [
              'attr' =>[
                'placeholder' => 'Treść pytania'
                ]
              ])
            ->add('answers', 'collection', [
              'type' => new AnswerType(),
              'allow_add' => true,
              'by_reference' => false,
              'allow_delete' => true
              ])
        ;
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            array($this, 'onPreSetData')
        );
    }

    public function onPreSetData(FormEvent $event)
    {
        $question = $event->getData();
        $form = $event->getForm();

        if (null === $question) {
          # example data
          $event->setData(
             (new Question())
              ->addAnswer(new Answer("", true))
              ->addAnswer(new Answer("", true))
              ->addAnswer(new Answer("", true))
              ->addAnswer(new Answer("", true))
          );
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QuizBundle\Entity\Question'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'quizbundle_question';
    }
}
