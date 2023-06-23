<?php

declare(strict_types=1);

namespace App\Controller\Main;

use App\View\HomeViewManager;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home')]
class HomeController extends AbstractController
{
    private HomeViewManager $homeViewManager;

    public function __construct(HomeViewManager $homeViewManager)
    {
        $this->homeViewManager = $homeViewManager;
    }

    /**
     * @throws GuzzleException
     */
    public function __invoke(): Response
    {
        $view = $this->homeViewManager->build();

        return $this->render('main/index.html.twig', [
            'view' => $view,
        ]);
    }
}
