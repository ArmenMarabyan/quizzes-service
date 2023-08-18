<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Quiz;
use App\Entity\QuizComment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuizFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $quiz1 = new Quiz();
        $quiz1->setTitle('Quiz 1');
        $quiz1->setSlug('quiz_1');
        $quiz1->setDuration(1);
        $quiz1->setStatus(1);
        $manager->persist($quiz1);

        $quiz2 = new Quiz();
        $quiz2->setTitle('Quiz 2');
        $quiz2->setSlug('quiz_2');
        $quiz2->setDuration(2);
        $quiz2->setStatus(1);
        $manager->persist($quiz2);

        $comment = new QuizComment();
        $comment->setText('test comment for quiz 2');
        $comment->setQuiz($quiz1);
        $manager->persist($comment);

        $manager->flush();
    }
}
