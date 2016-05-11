<?php

namespace QuizBundle\Entity;

use AppBundle\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Answer extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var boolean
     *
     * @ORM\Column(name="correct", type="boolean")
     */
    private $correct;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers")
     */
    private $question;

    public function __construct($title = "", $correct = false)
    {
      $this->title = $title;
      $this->correct = $correct;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Answer
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set correct
     *
     * @param boolean $correct
     * @return Answer
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;

        return $this;
    }

    /**
     * Get correct
     *
     * @return boolean
     */
    public function getCorrect()
    {
        return $this->correct;
    }

    /**
     * Set question
     *
     * @param \QuizBundle\Entity\Question $question
     * @return Answer
     */
    public function setQuestion(Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \QuizBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    public function __toString()
    {
      return $this->getTitle();
    }
}
