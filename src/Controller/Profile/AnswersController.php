<?php

namespace App\Controller\Profile;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Form\UserProfileAnswerFormType;
use App\Form\UserProfileQuestionFormType;
use App\Form\UserProfileQuizType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AnswersController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager, private QuizRepository $quizRepository)
    {
    }

//    #[Route('/profile/quizzes/{quiz<\d+>}/questions', name: 'app_profile_quizzes_questions')]
//    public function index(): Response
//    {
//        return $this->render('profile/quiz/questions/index.html.twig', [
//            'controller_name' => 'QuestionsController',
//        ]);
//    }

    #[Route('/profile/quizzes/{quiz<\d+>}/questions/{question<\d+>}/answers/create', name: 'app_profile_quizzes_questions_answers_create')]
    public function create(Request $request, Quiz $quiz, Question $question): Response
    {
        $entity = new Answer();
        $form = $this->createForm(UserProfileAnswerFormType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setQuestion($question);

            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            $this->addFlash('INFO', 'Answer created successfully!!!');

            return $this->redirectToRoute('app_profile_quizzes_questions_show', ['quiz' => $quiz->getId(), 'question' => $question->getId()]);
        }

        return $this->render('profile/form.html.twig', [
            'contentTitle' => 'Add question',
            'form' => $form
        ]);
    }

    #[Route('/profile/quizzes/{quiz<\d+>}/questions/{question<\d+>}/answers/{answer<\d+>}/edit', name: 'app_profile_quizzes_questions_answers_edit')]
    public function edit(Request $request, Quiz $quiz, Question $question, Answer $answer): Response
    {
        $entity = $answer;
        $form = $this->createForm(UserProfileAnswerFormType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setQuestion($question);

            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            $this->addFlash('INFO', 'Answer edited successfully!!!');

            return $this->redirectToRoute('app_profile_quizzes_questions_answers_edit', ['quiz' => $quiz->getId(), 'question' => $question->getId(), 'answer' => $answer->getId()]);
        }

        return $this->render('profile/form.html.twig', [
            'contentTitle' => 'Add question',
            'form' => $form
        ]);
    }

    #[Route('/profile/quizzes/{quiz<\d+>}/questions/{question<\d+>}/answers/{answer<\d+>}/delete', name:  'app_profile_quizzes_questions_answers_delete', methods: ['POST', 'GET'])]
    public function delete(Quiz $quiz, Question $question, Answer $answer): Response
    {
        $entityTitle = $answer->getTitle();
        $this->entityManager->remove($answer);
        $this->entityManager->flush();

        $this->addFlash('INFO', "Answer '{$entityTitle}' deleted successfully!!!");

        return $this->redirectToRoute('app_profile_quizzes_questions_show', ['quiz' => $quiz->getId(), 'question' => $question->getId()]);
    }
}
