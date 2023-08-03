<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Repository\AnswerRepository;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class QuizController extends AbstractController
{
    public function __construct(private QuizRepository $quizRepository, private AnswerRepository $answerRepository)
    {
    }

    #[Route('/quizzes', name: 'app_quizzes')]
    public function index(): Response
    {
        $quizzes = $this->quizRepository->findAll();

        return $this->render('quiz/index.html.twig', [
            'quizzes' => $quizzes,
        ]);
    }

    #[Route('/quizzes/{quiz<\d+>}', name: 'app_quiz')]
    public function show(Request $request, $quiz): Response
    {
        $quiz = $this->quizRepository->find($quiz);

        $defaultData = [];
        $form = $this->createFormBuilder($defaultData);

        foreach ($quiz->getQuestions() as $question) {
            $form = $form->add('answer' . $question->getId(),ChoiceType::class, options: [
                'label' => $question->getTitle(),
                'choices' => array_flip($question->getAnswersForSelect()),
                'multiple'=>false,'expanded'=>true
                ]);
        }

        $form = $form->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $answerIds = array_values($data);


            $session = $request->getSession();
            $session->set('answeredIds', $answerIds);

            return $this->redirectToRoute('app_quiz_result', ['quiz' => $quiz->getId()]);
        }

        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz,
            'form' => $form
        ]);
    }

    #[Route('/quizzes/{quiz<\d+>}/result', name: 'app_quiz_result')]
    public function result(Request $request, $quiz): Response
    {
        $quiz = $this->quizRepository->find($quiz);
        $session = $request->getSession();
        $answerIds = $session->get('answeredIds', []);
//        $answers = $this->answerRepository->findBy(['id' => $answerIds]);

        return $this->render('quiz/result.html.twig', [
            'quiz' => $quiz,
            'answeredIds' => $answerIds
        ]);
    }
}
