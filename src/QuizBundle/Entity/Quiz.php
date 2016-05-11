<?php

namespace QuizBundle\Entity;

use AppBundle\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use QuizBundle\Model\QuizInterface;

/**
 * Quiz
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Quiz extends AbstractEntity implements QuizInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="adminlink", type="string", length=255)
     */
    private $adminlink;

    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="quiz", cascade={"persist"})
     **/
    private $questions;

    public function __construct() {
        $this->adminlink = md5(time());
        $this->questions = new ArrayCollection();
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Quiz
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Quiz
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return Quiz
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set adminlink
     *
     * @param string $adminlink
     * @return Quiz
     */
    public function setAdminlink($adminlink)
    {
        $this->adminlink = $adminlink;

        return $this;
    }

    /**
     * Get adminlink
     *
     * @return string
     */
    public function getAdminlink()
    {
        return $this->adminlink;
    }

    /**
     * Add questions
     *
     * @param Question $questions
     * @return Quiz
     */
    public function addQuestion(Question $questions)
    {
        $questions->setQuiz($this);
        $this->questions[] = $questions;

        return $this;
    }

    /**
     * Remove questions
     *
     * @param Question $questions
     * @return $this|QuizInterface
     */
    public function removeQuestion(Question $questions)
    {
        $this->questions->removeElement($questions);

        return $this;
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }
}
