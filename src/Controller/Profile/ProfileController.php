<?php

namespace App\Controller\Profile;

use App\Entity\User;
use App\Form\UserProfileEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
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


        return $this->render('profile/edit.html.twig', [
//            'contentTitle' => $translator->trans('Create question'),
            'contentTitle' => 'Edit profile',
            'form' => $form
        ]);
    }
}
