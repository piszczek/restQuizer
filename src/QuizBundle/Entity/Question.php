<?php

namespace QuizBundle\Entity;

use AppBundle\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Question
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Question extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Quiz", inversedBy="questions")
     */
    private $quiz;

    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question", cascade={"persist"})
     **/
    private $answers;
    
    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }
    /**
     * Set title
     *
     * @param string $title
     * @return Question
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
     * Set quiz
     *
     * @param \QuizBundle\Entity\Quiz $quiz
     * @return Question
     */
    public function setQuiz(\QuizBundle\Entity\Quiz $quiz = null)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get quiz
     *
     * @return \QuizBundle\Entity\Quiz
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * Add answers
     *
     * @param \QuizBundle\Entity\Answer $answers
     * @return Question
     */
    public function addAnswer(\QuizBundle\Entity\Answer $answers)
    {
        $answers->setQuestion($this);
        $this->answers[] = $answers;

        return $this;
    }

    /**
     * Remove answers
     *
     * @param \QuizBundle\Entity\Answer $answers
     */
    public function removeAnswer(\QuizBundle\Entity\Answer $answers)
    {
        $this->answers->removeElement($answers);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }
}
