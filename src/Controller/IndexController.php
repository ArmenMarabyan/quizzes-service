<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    public function __construct(private QuizRepository $quizRepository, private CategoryRepository $categoryRepository)
    {
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
//        $categories = $this->categoryRepository->findAll();
        $quizzes = $this->quizRepository->findBy([], ['id' => 'DESC']);

        return $this->render('index/index.html.twig', [
//            'categories' => $categories ?? [],
            'quizzes' => $quizzes ?? [],
        ]);
    }
}
