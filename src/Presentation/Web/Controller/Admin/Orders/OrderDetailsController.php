<?php

namespace App\Presentation\Web\Controller\Admin\Orders;

use App\Domain\Shop\Entity\Orders;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMIN')]
class OrderDetailsController extends AbstractController
{
    #[Route('/admin/orders/{id}/details', name: 'admin_order_details')]
    public function viewOrderDetails(Orders $order): Response
    {
        return $this->render('admin/orders/details.html.twig', [
            'order' => $order,
        ]);
    }
}