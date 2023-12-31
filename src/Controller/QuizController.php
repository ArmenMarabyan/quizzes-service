<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\QuizComment;
use App\Entity\QuizResult;
use App\Form\QuizCommentType;
use App\Message\QuizCommentMessage;
use App\Repository\AnswerRepository;
use App\Repository\CommentRepository;
use App\Repository\QuizCommentRepository;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class QuizController extends AbstractController
{
    public function __construct(
        private QuizRepository $quizRepository,
        private AnswerRepository $answerRepository,
        private EntityManagerInterface $entityManager,
        private QuizCommentRepository $quizCommentRepository,
        private MessageBusInterface $bus
    ) {
    }

    #[Route('/quizzes', name: 'app_quizzes')]
    public function index(): Response
    {
        $quizzes = $this->quizRepository->findBy([], ['id' => 'DESC']);

        return $this->render('quiz/index.html.twig', [
            'quizzes' => $quizzes,
        ]);
    }

//    #[Route('/quizzes/{quiz<\d+>}', name: 'app_quiz')]
    #[Route('/quizzes/{slug}', name: 'app_quiz')]
    public function show(Request $request, $slug, #[Autowire('%photo_dir%')] string $photoDir): Response
    {
        $quiz = $this->quizRepository->findBy(['slug' => $slug]);

        $quiz = isset($quiz[0]) ? $quiz[0] : null;

        $comment = new QuizComment();
        $form = $this->createForm(QuizCommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUser($this->getUser());
            $comment->setQuiz($quiz);

            if ($photo = $form['photo']->getData()) {
                $filename = bin2hex(random_bytes(6)) . '.' . $photo->guessExtension();
                $photo->move($photoDir, $filename);
                $comment->setPhotoFilename($filename);
            }

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            $this->bus->dispatch(new QuizCommentMessage($comment->getId()));

            return $this->redirectToRoute('app_quiz', ['slug' => $quiz->getSlug()]);
        }

        if (null === $quiz) {
            throw $this->createNotFoundException('The quiz does not exist');
        }
        
//        $comments = $this->quizCommentRepository->findBy(['quiz' => $quiz->getId()], ['id' => 'desc']);
        $comments = $this->quizCommentRepository->getComments($quiz);

        return $this->render('quiz/show.html.twig', [
            'quiz' => $quiz,
            'comment_form' => $form,
            'comments' => $comments
        ]);
    }

    #[Route('/quizzes/{quiz<\d+>}/questions', name: 'app_quiz_questions')]
    public function questions(Request $request, $quiz): Response
    {
        $quiz = $this->quizRepository->find($quiz);

        if (null === $quiz) {
            throw $this->createNotFoundException('The quiz does not exist');
        }

        $defaultData = [];
        $form = $this->createFormBuilder($defaultData);

        $questions = $quiz->getQuestions();

        foreach ($questions as $question) {
            $form = $form->add('question' . $question->getId(),ChoiceType::class, options: [
                'label' => $question->getTitle(),
                'choices' => array_flip($question->getAnswersForSelect()),
                'multiple'=>true,'expanded'=>true
            ]);
        }

        $form = $form->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $answeredIds = [];
            foreach ($data as $questionKey => $answerIds) {
                foreach ($answerIds as $answerId) {
                    $answeredIds[] = $answerId;
                }
            }
            $user = $this->getUser();
//            $userId = $this->getUser()?->getId();
            $userId = isset($user) ? $user->getId() : null;
            $quizId = $quiz->getId();
            $score = 0;
            $correctAnswersCount = 0;
            $questionsCount = count($quiz->getQuestions());

            $answers = $this->answerRepository->findBy(['id' => $answeredIds]);

            foreach ($answers as $answer) {
                $score += $answer->getPoint();
            }

            //todo refactor, bad code
            $correctAnswerIds = [];
            foreach ($quiz->getQuestions() as $question) {
                $correctAnswerIds['question' . $question->getId()] = [];
                foreach ($question->getAnswers() as $questionAnswer) {
                    if ($questionAnswer->isIsTrue()) {
                        $correctAnswerIds['question' . $question->getId()][] = $questionAnswer->getId();
                    }
                }

                if ($correctAnswerIds['question' . $question->getId()] == $data['question' . $question->getId()]) {
                    $correctAnswersCount++;
                }
            }

            //save results
            $quizResult = new QuizResult();
            $quizResult->setQuiz($quiz);
            $quizResult->setUser($user);
            $quizResult->setAnswersCount($questionsCount);
            $quizResult->setCorrectAnswersCount($correctAnswersCount);
            $quizResult->setScore($score);

            $this->entityManager->persist($quizResult);
            $this->entityManager->flush();

            $session = $request->getSession();
            $session->set('answeredIds', $answeredIds);

            return $this->redirectToRoute('app_quiz_result', ['quiz' => $quiz->getId()]);
        }

        return $this->render('quiz/questions.html.twig', [
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
