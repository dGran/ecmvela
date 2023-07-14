<?php

declare(strict_types=1);

namespace App\Controller\Admin\Customer\Ajax;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Manager\CustomerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/customer/save', name: 'admin_customer_store', methods: ['POST'])]
class StoreController extends AbstractController
{
    private CustomerManager $customerManager;

    public function __construct(CustomerManager $customerManager)
    {
        $this->customerManager = $customerManager;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $form = $this->createForm(CustomerType::class, new Customer());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $customer->setActive($request->get('active') === "on");
            $this->customerManager->save($customer);

            $this->addFlash('success','El cliente se ha creado correctamente');

            return new JsonResponse(['status' => 'success',]);
        }

        return new JsonResponse([
            'status' => 'error',
            'errors' => $this->getErrorsFromForm($form),
        ]);
    }

    private function getErrorsFromForm($form): array
    {
        $errors = [];

        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorsFromForm($child);
            }
        }

        return $errors;
    }
}
