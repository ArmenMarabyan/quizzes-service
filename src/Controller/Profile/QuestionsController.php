<?php

namespace App\Controller\Profile;

use App\Entity\Question;
use App\Entity\Quiz;
use App\Form\UserProfileQuestionFormType;
use App\Form\UserProfileQuizType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class QuestionsController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager, private QuizRepository $quizRepository)
    {
    }

    #[Route('/profile/quizzes/{quiz<\d+>}/questions', name: 'app_profile_quizzes_questions')]
    public function index(): Response
    {
        return $this->render('profile/quiz/questions/index.html.twig', [
            'controller_name' => 'QuestionsController',
        ]);
    }

    #[Route('/profile/quizzes/{quiz<\d+>}/questions/{question<\d+>}', name: 'app_profile_quizzes_questions_show')]
    public function show(Request $request, Quiz $quiz, Question $question): Response
    {
        return $this->render('profile/quiz/questions/show.html.twig', [
            'quiz' => $quiz,
            'question' => $question,
            'answers' => $question->getAnswers(),
            'contentTitle' => $question->getTitle()
        ]);
    }

    #[Route('/profile/quizzes/{quiz<\d+>}/questions/create', name: 'app_profile_quizzes_questions_create')]
    public function create(Request $request, Quiz $quiz): Response
    {
        $entity = new Question();
        $form = $this->createForm(UserProfileQuestionFormType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setQuiz($quiz);

            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            $this->addFlash('INFO', 'Question created successfully!!!');

            return $this->redirectToRoute('app_profile_quizzes_show', ['quiz' => $quiz->getId()]);
        }

        return $this->render('profile/form.html.twig', [
            'contentTitle' => 'Add question',
            'form' => $form
        ]);
    }

    #[Route('/profile/quizzes/{quiz<\d+>}/questions/{question<\d+>}/edit', name: 'app_profile_quizzes_questions_edit')]
    public function edit(Request $request, Quiz $quiz, Question $question): Response
    {
        $entity = $question;
        $form = $this->createForm(UserProfileQuestionFormType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setQuiz($quiz);

            $this->entityManager->persist($entity);
            $this->entityManager->flush();

            $this->addFlash('INFO', 'Question edited successfully!!!');

            return $this->redirectToRoute('app_profile_quizzes_questions_edit', ['quiz' => $quiz->getId(), 'question' => $question->getId()]);
        }

        return $this->render('profile/form.html.twig', [
            'contentTitle' => 'Add question',
            'form' => $form
        ]);
    }

    #[Route('/profile/quizzes/{quiz<\d+>}/questions/{question<\d+>}/delete', name: 'app_profile_quizzes_questions_delete', methods: ['POST', 'GET'])]
    public function delete(Quiz $quiz, Question $question): Response
    {
        $entityTitle = $question->getTitle();
        $this->entityManager->remove($question);
        $this->entityManager->flush();

        $this->addFlash('INFO', "Question '{$entityTitle}' deleted successfully!!!");

        return $this->redirectToRoute('app_profile_quizzes_show', ['quiz' => $quiz->getId()]);
    }
}
