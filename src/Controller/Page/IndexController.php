<?php

namespace App\Controller\Page;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/feedback', name: 'app_page_feedback')]
    public function feedback(): Response
    {
        return $this->render('page/feedback.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
