<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Panther\PantherTestCase;

class QuizControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
//        $client = static::createPantherClient(['external_base_uri' => '/']);
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Quizzes');
    }

    public function testQuizPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertCount(2, $crawler->filter('h5'));

//        $client->clickLink('Пройти');
        $client->click($crawler->filter('.card-body a')->link());

        $this->assertPageTitleContains('Quiz: Quiz 2'); //2 потому что DESC
        $this->assertPageTitleSame('Quiz: Quiz 2');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Quiz 2');
        $this->assertSelectorExists('h6:contains("Comments (1)")');
    }

    public function testCommentSubmission()
    {
        $client = static::createClient();
        $client->request('GET', '/quizzes/quiz_2');

        $client->submitForm('Submit', [
            'quiz_comment[text]' => 'Text comment from test',
            'quiz_comment[photo]' => dirname(__DIR__, 2).'/public/upload/photos/45f8fa00a9e5.jpg'
        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('h6:contains("Comments (2)")');
    }
}
