<?php

namespace App\MessageHandler;

use App\Message\QuizCommentMessage;
use App\Repository\QuizCommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class QuizCommentMessageHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private QuizCommentRepository $quizCommentRepository,
        private MailerInterface $mailer,
//        #[Autowire('%admin_email%')] private string $adminEmail,
    ) {
    }

    public function __invoke(QuizCommentMessage $message)
    {
        $comment = $this->quizCommentRepository->find($message->getId());
        if (!$comment) {
            return;
        }

//        if (2 === $this->spamChecker->getSpamScore($comment, $message->getContext())) {
//            $comment->setState('spam');
//        } else {
//            $comment->setState('published');
//        }

        //some logic
        sleep(10);

//        $this->mailer->send((new NotificationEmail()))
//            ->subject('New comment posted')
//            ->htmlTemplate('emails/quiz_comment_notification.html.twig')
//            ->from($this->adminEmail)
//            ->to($this->adminEmail)
//            ->context(['comment' => $comment]);
        $comment->setState('published');

        $this->entityManager->flush();
    }
}