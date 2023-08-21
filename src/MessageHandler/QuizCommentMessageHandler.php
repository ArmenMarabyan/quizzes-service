<?php

namespace App\MessageHandler;

use App\Message\QuizCommentMessage;
use App\Repository\QuizCommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class QuizCommentMessageHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private QuizCommentRepository $quizCommentRepository,
    ) {
    }

    public function __invoke(QuizCommentMessage $message)
    {
//        throw new \Exception('asdsad');
        $comment = $this->quizCommentRepository->find($message->getId());
        if (!$comment) {
            return;
        }

//        if (2 === $this->spamChecker->getSpamScore($comment, $message->getContext())) {
//            $comment->setState('spam');
//        } else {
//            $comment->setState('published');
//        }

        sleep(10);
        $comment->setState('published');

        $this->entityManager->flush();
    }
}