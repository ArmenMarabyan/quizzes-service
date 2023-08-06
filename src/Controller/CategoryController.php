<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    #[Route('/categories', name: 'app_categories')]
    public function index(): Response
    {

        $categories = $this->categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/categories/{category<\d+>}', name: 'app_category')]
    public function show($category): Response
    {
        $category = $this->categoryRepository->find(['id' => $category]);

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'quizzes' => $category->getQuizzes(),
        ]);
    }
}
