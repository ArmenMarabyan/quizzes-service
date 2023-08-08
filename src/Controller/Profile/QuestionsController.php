<?php

namespace App\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionsController extends AbstractController
{
    #[Route('/profile/quizzes/{quiz<\d+>}/questions', name: 'app_profile_quizzes_questions')]
    public function index(): Response
    {
        return $this->render('profile/quiz/questions/index.html.twig', [
            'controller_name' => 'QuestionsController',
        ]);
    }

    #[Route('/profile/quizzes/{quiz<\d+>}/questions/create', name: 'app_profile_quizzes_questions_create')]
    public function create(): Response
    {
        return $this->render('profile/quiz/questions/index.html.twig', [
            'controller_name' => 'QuestionsController',
        ]);
    }



    #[Route('/profile/quizzes/{quiz<\d+>}/questions/{question</d+>}/edit', name: 'app_profile_quizzes_questions_edit')]
    public function edit(): Response
    {
        return $this->render('profile/quiz/questions/index.html.twig', [
            'controller_name' => 'QuestionsController',
        ]);
    }
    #[Route('/profile/quizzes/{quiz<\d+>}/questions/{question</d+>}/delete', name: 'app_profile_quizzes_questions_delete')]
    public function delete(): Response
    {
        return $this->render('profile/quiz/questions/index.html.twig', [
            'controller_name' => 'QuestionsController',
        ]);
    }
}
