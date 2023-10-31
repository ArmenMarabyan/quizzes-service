<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class VacanciesController extends AbstractController
{

    public function __construct(
        private HttpClientInterface $client,
        private CompanyRepository $companyRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    #[Route('/vacancies', name: 'app_vacancies')]
    public function index(Request $request): Response
    {

        $term = $request->get('q');

        $hhApi = $this->getParameter('hh_api');
        $hhVacanciesEndpoint = $hhApi . '/vacancies';
        $params = [
            'text' => $term,
            //
        ];
        $hhVacanciesEndpoint = $hhVacanciesEndpoint . '?' . http_build_query($params);

        $response = $this->client->request(
            'GET',
            $hhVacanciesEndpoint
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
//dd($content);

        return $this->render('vacancies/index.html.twig', [
            'items' => $content,
            'term' => $term
        ]);
    }

    #[Route('/vacancies/{vacancy<\d+>}', name: 'app_vacancies_show')]
    public function show($vacancy): Response
    {



        $companies = $this->companyRepository->findAll();

        $response = $this->client->request(
            'GET',
            'https://api.hh.ru/employers/2059392'
        );

        $content = $response->toArray();

        $company = new Company();
        $company->setName($content['name']);
        $company->setDescription($content['description']);
        $company->setSiteUrl($content['site_url']);
        $company->setLogo($content['logo_urls']['original']);

        $this->entityManager->persist($company);
        $this->entityManager->flush();

        dd($companies);

        return $this->render('vacancies/show.html.twig', [
            'controller_name' => 'VacanciesController',
        ]);
    }
}
