<?php

namespace App\Controller\Profile;

use App\Entity\Quiz;
use App\Entity\User;
use App\Form\UserProfileEditFormType;
use App\Form\UserProfileQuizType;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private QuizRepository $quizRepository)
    {
    }

    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function edit(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserProfileEditFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('INFO', 'Profile edited');

            return $this->redirectToRoute('app_profile_edit');
        }

        return $this->render('profile/form.html.twig', [
//            'contentTitle' => $translator->trans('Create question'),
            'contentTitle' => 'Edit profile',
            'form' => $form
        ]);
    }

    #[Route('/profile/quizzes', name: 'app_profile_quizzes')]
    public function quizzes(Request $request): Response
    {
        $user = $this->getUser();
        $quizzes = $this->quizRepository->findBy(['_user' => $user->getId()]);


        return $this->render('profile/quiz/index.html.twig', [
            'quizzes' => $quizzes,
            'contentTitle' => 'Quizzes'
        ]);
    }

    #[Route('/profile/quizzes/create', name: 'app_profile_quizzes_create')]
    public function createQuiz(Request $request): Response
    {
        $quiz = new Quiz();
        $form = $this->createForm(UserProfileQuizType::class, $quiz);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $quiz->setUser($user);
            $quiz->setStatus(0);
            $this->entityManager->persist($quiz);
            $this->entityManager->flush();

            $this->addFlash('INFO', 'Quiz created successfully!!!');

            return $this->redirectToRoute('app_profile_quizzes_edit', ['quiz' => $quiz->getId()]);
        }

        return $this->render('profile/form.html.twig', [
//            'contentTitle' => $translator->trans('Create question'),
            'contentTitle' => 'Edit profile',
            'form' => $form
        ]);
    }

    #[Route('/profile/quizzes/{quiz<\d+>}/edit', name: 'app_profile_quizzes_edit')]
    public function editQuiz(Request $request, Quiz $quiz): Response
    {
        $form = $this->createForm(UserProfileQuizType::class, $quiz);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $quiz->setUser($user);
            $quiz->setStatus(0);
            $this->entityManager->persist($quiz);
            $this->entityManager->flush();

            $this->addFlash('INFO', 'Quiz edited successfully!!!');

            return $this->redirectToRoute('app_profile_quizzes_edit', ['quiz' => $quiz->getId()]);
        }

        return $this->render('profile/form.html.twig', [
//            'contentTitle' => $translator->trans('Create question'),
            'contentTitle' => 'Edit profile',
            'form' => $form
        ]);
    }

    #[Route('/profile/quizzes/{quiz<\d+>}/delete', name: 'app_profile_quizzes_delete', methods: ['POST', 'GET'])]
    public function delete(Quiz $quiz): Response
    {
        $quizTitle = $quiz->getTitle();
        $this->entityManager->remove($quiz);
        $this->entityManager->flush();

        $this->addFlash('INFO', "Quiz '{$quizTitle}' deleted successfully!!!");

        return $this->redirectToRoute('app_profile_quizzes');
    }
}
