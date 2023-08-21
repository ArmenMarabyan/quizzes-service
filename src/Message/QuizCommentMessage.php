<?php

namespace App\Message;

class QuizCommentMessage
{

    public function __construct(
        private int $id
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}