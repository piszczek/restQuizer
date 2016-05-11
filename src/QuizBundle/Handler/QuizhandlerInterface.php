<?php

namespace QuizBundle\Handler;
use QuizBundle\Model\QuizInterface;

interface QuizHandlerInterface
{
    /**
     * Get a Quiz given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return QuizInterface
     */
    public function get($id);

    /**
     * Get a list of Quizs.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * Post Quiz, creates a new Quiz.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return QuizInterface
     */
    public function post(array $parameters);

    /**
     * Edit a Quiz.
     *
     * @api
     *
     * @param QuizInterface   $quiz
     * @param array           $parameters
     *
     * @return QuizInterface
     */
    public function put(QuizInterface $quiz, array $parameters);

    /**
     * Partially update a Quiz.
     *
     * @api
     *
     * @param QuizInterface   $quiz
     * @param array           $parameters
     *
     * @return QuizInterface
     */
    public function patch(QuizInterface $quiz, array $parameters);
}