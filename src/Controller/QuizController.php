<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function show($quiz): Response
    {
        $quiz = $this->quizRepository->find($quiz);

//        dd($quiz->getQuestions());

        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz,
        ]);
    }
}
