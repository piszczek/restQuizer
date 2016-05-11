<?php

namespace QuizBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use QuizBundle\Model\QuizInterface;
use QuizBundle\Form\Type\QuizType;
use QuizBundle\Exception\InvalidFormException;

class QuizHandler implements QuizHandlerInterface
{
    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

    /**
     * Get a Quiz.
     *
     * @param mixed $id
     *
     * @return QuizInterface
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get a list of Quizs.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0)
    {
        return $this->repository->findBy(array(), null, $limit, $offset);
    }

    /**
     * Create a new Quiz.
     *
     * @param array $parameters
     *
     * @return QuizInterface
     */
    public function post(array $parameters)
    {
        $page = $this->createQuiz();

        return $this->processForm($page, $parameters, 'POST');
    }

    /**
     * Edit a Quiz.
     *
     * @param QuizInterface $page
     * @param array         $parameters
     *
     * @return QuizInterface
     */
    public function put(QuizInterface $page, array $parameters)
    {
        return $this->processForm($page, $parameters, 'PUT');
    }

    /**
     * Partially update a Quiz.
     *
     * @param QuizInterface $page
     * @param array         $parameters
     *
     * @return QuizInterface
     */
    public function patch(QuizInterface $page, array $parameters)
    {
        return $this->processForm($page, $parameters, 'PATCH');
    }

    /**
     * Processes the form.
     *
     * @param QuizInterface $page
     * @param array         $parameters
     * @param String        $method
     *
     * @return QuizInterface
     *
     * @throws \QuizBundle\Exception\InvalidFormException
     */
    private function processForm(QuizInterface $page, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new QuizType(), $page, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {

            $page = $form->getData();
            $this->om->persist($page);
            $this->om->flush();

            return $page;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createQuiz()
    {
        return new $this->entityClass();
    }

}