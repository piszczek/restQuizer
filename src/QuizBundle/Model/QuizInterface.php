<?php

namespace QuizBundle\Model;


use QuizBundle\Entity\Question;

Interface QuizInterface
{
    /**
     * Get id
     *
     * @return int
     */
    public function getId();

    /**
     * Set title
     *
     * @param string $title
     * @return QuizInterface
     */
    public function setTitle($title);

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Add question
     *
     * @param Question $question
     * @return QuizInterface
     */
    public function addQuestion(Question $question);

    /**
     * Remove questions
     *
     * @param Question $question
     * @return QuizInterface
     */
    public function removeQuestion(Question $question);

    /**
     * Get questions
     *
     * @return Question
     */
    public function getQuestions();
}