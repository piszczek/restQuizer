<?php

namespace QuizBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class QuestionApproachType extends AbstractType
{
      //private $question;

      //public function __construct($question)
      //{
      //  $this->question = $question;
      //}
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        //$question = $builder->getData()->getQuestion();

        $builder->addEventListener(
              FormEvents::PRE_SET_DATA,
              array($this, 'onPreSetData')
          );
      }

      public function onPreSetData(FormEvent $event)
      {
        $builder = $event->getForm();

        $question = $event->getData()->getQuestion();

        if ($question ===  null)
          return;

        $builder
            ->add('answer', 'entity', [
              'class' => 'QuizBundle\Type\Entity\Answer',
              'label_attr' =>[
                'style' => 'display:none;'
              ],
              'expanded' => true,
              'query_builder' => function(EntityRepository $er) use ($question) {
                  return $er->createQueryBuilder('a')
                            ->where('a.question = :question')
                            ->setParameter('question', $question->getId());
                  },
              ])
        ;
      }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QuizBundle\Entity\QuestionApproach'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'quizbundle_questionapproach';
    }
}
