<?php

namespace App\Controller;

use App\Entity\Quiz;
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
    public function __construct(private QuizRepository $quizRepository)
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
                'choices' => [
                    'answer1' => '1',
                    'answer2' => '2',
                    'answer3' => '3',
                    'answer4' => '4'
                ],
                'multiple'=>false,'expanded'=>true
                ]);
        }

        $form = $form->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dd($data);
        }

        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz,
            'form' => $form
        ]);
    }
}
