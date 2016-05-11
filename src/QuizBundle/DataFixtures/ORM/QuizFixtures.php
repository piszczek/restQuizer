<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use QuizBundle\Entity\Answer;
use QuizBundle\Entity\Question;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use QuizBundle\Entity\Quiz;
use Symfony\Component\Yaml\Parser;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $parser = new Parser();
        $quizes = $parser->parse(file_get_contents(__DIR__ . '/quizes.yml'));

        foreach ($quizes as $title => $questions) {
            $quizEntity = new Quiz();
            $quizEntity->setTitle($title);

            foreach ($questions as $questionTitle => $answers) {
                $questionEntity = new Question();
                $questionEntity->setTitle($questionTitle);

                $first = true;
                foreach ($answers as $answer) {
                    $answerEntity = new Answer($answer, $first);
                    $first = false;
                    $questionEntity->addAnswer($answerEntity);
                }
                
                $quizEntity->addQuestion($questionEntity);
            }

            $manager->persist($quizEntity);
        }
        $manager->flush();

    }
}