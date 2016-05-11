<?php

namespace QuizBundle\Entity;

use AppBundle\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionApproach
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class QuestionApproach extends AbstractEntity
{
    /**
     * @ORM\ManyToOne(targetEntity="QuizApproach", inversedBy="questionsApproach")
     */
    private $quizApproach;

    /**
     * @ORM\ManyToOne(targetEntity="Answer")
     **/
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity="Question")
     */
    private $question;
    

    /**
     * Set quizApproach
     *
     * @param \QuizBundle\Entity\QuizApproach $quizApproach
     * @return QuestionApproach
     */
    public function setQuizApproach(\QuizBundle\Entity\QuizApproach $quizApproach = null)
    {
        $this->quizApproach = $quizApproach;

        return $this;
    }

    /**
     * Get quizApproach
     *
     * @return \QuizBundle\Entity\QuizApproach
     */
    public function getQuizApproach()
    {
        return $this->quizApproach;
    }

    /**
     * Set answer
     *
     * @param \QuizBundle\Entity\Answer $answer
     * @return QuestionApproach
     */
    public function setAnswer(\QuizBundle\Entity\Answer $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return \QuizBundle\Entity\Answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Get the value of Qestion
     *
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set the value of Qestion
     *
     * @param mixed qestion
     *
     * @return self
     */
    public function setQuestion($qestion)
    {
        $this->question = $qestion;

        return $this;
    }

}
