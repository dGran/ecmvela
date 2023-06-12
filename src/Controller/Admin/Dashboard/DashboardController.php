<?php

declare(strict_types=1);

namespace App\Controller\Admin\Dashboard;

use App\View\DashboardViewManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_dashboard', methods: 'GET')]
class DashboardController extends AbstractController
{
    private DashboardViewManager $dashboardViewManager;

    public function __construct(DashboardViewManager $dashboardViewManager)
    {
        $this->dashboardViewManager = $dashboardViewManager;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     * @throws \Exception
     */
    public function __invoke(Request $request): Response
    {
        $dateFrom = new \DateTime('2023-01-01 0:00:00');
        $dateTo = new \DateTime('2023-12-31 23:59:59');

        $view = $this->dashboardViewManager->build($dateFrom, $dateTo);

        return $this->render('admin/dashboard.html.twig', [
            'view' => $view,
        ]);
    }
}