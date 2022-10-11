<?php

namespace App\Controller;

use App\Service\LanguageService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    #[Route(path: [
        'en' => '/en/',
        'nl' => '/nl/',
        'de' => '/de/',
        'fr' => '/'
    ], name: 'home')]
    public function index(LanguageService $language, TranslatorInterface $translator): Response
    {
        $lg = $language->getLanguage();
        $controller_name = $translator->trans("L'économie par l'écologie");
        return $this->render('page/index.html.twig', [
            'controller_name' => $controller_name,
        ]);
    }
}
