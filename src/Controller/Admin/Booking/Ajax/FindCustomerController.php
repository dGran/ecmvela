<?php

declare(strict_types=1);

namespace App\Controller\Admin\Booking\Ajax;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Manager\CustomerManager;
use App\Manager\PetManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/booking/find-customer', name: 'admin_booking_find_customer', methods: ['POST'])]
class FindCustomerController extends AbstractController
{
    private PetManager $petManager;

    public function __construct(PetManager $petManager)
    {
        $this->petManager = $petManager;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $petId = $request->get('petId');
        $pet = $this->petManager->findOneById($petId);


        return new JsonResponse([
            'status' => 'error',
            'errors' => $this->getErrorsFromForm($form),
        ]);
    }
}
