<?php

namespace QuizBundle\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use QuizBundle\Entity\Quiz;
use QuizBundle\Exception\InvalidFormException;
use QuizBundle\Form\Type\QuizType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations;

class QuizController extends FOSRestController
{
    /**
     * List all quizes.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing quizs.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many quizes to return.")
     *
     * @Annotations\View(
     *  template = "QuizBundle:Quiz:quizes.html.twig",
     *  templateVar="quizes"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getQuizesAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->container->get('quizer.quiz.handler')->all($limit, $offset);
    }

    /**
     * Get single Quiz.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Quiz for a given id",
     *   output = "QuizBundle\Entity\Quiz",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the quiz is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="quiz")
     *
     * @param Quiz $quiz
     * @return array
     *
     */
    public function getQuizAction(Quiz $quiz)
    {

        return array('quiz' => $quiz);
    }

    /**
     * Presents the form to use to create a new quiz.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  templateVar = "form"
     * )
     *
     * @return FormTypeInterface
     */
    public function newQuizAction()
    {
        return $this->createForm(new QuizType());
    }

    /**
     * Create a Quiz from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new quiz from the submitted data.",
     *   input = "QuizBundle\Form\Type\QuizType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "QuizBundle:Quiz:new.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postQuizAction(Request $request)
    {
        try {
            $newQuiz = $this->container->get('quizer.quiz.handler')->post(
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $newQuiz->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_quiz', $routeOptions, Codes::HTTP_CREATED);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing quiz from the submitted data or create a new quiz at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Acme\DemoBundle\Form\Type\QuizType",
     *   statusCodes = {
     *     201 = "Returned when the Quiz is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "QuizBundle:Quiz:edit.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the quiz id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when quiz not exist
     */
    public function putQuizAction(Request $request, $id)
    {
        try {
            if (!($quiz = $this->container->get('quizer.quiz.handler')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $quiz = $this->container->get('quizer.quiz.handler')->post(
                    $request->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $quiz = $this->container->get('quizer.quiz.handler')->put(
                    $quiz,
                    $request->request->all()
                );
            }

            $routeOptions = array(
                'id' => $quiz->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_quiz', $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing quiz from the submitted data or create a new quiz at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "QuizBundle\Form\Type\QuizType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "QuizBundle:Quiz:edit.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param Quiz     $quiz      the quiz id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when quiz not exist
     */
    public function patchQuizAction(Request $request, Quiz $quiz)
    {
        try {
            $quiz = $this->container->get('quizer.quiz.handler')->patch(
                $quiz,
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $quiz->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_quiz', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }
}