<?php


namespace App\Presentation\Web\Controller\Pages;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Domain\Pages\Entity\Accompagnement\Accompagnement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;


class AccompagnementController extends AbstractController
{
    #[Route('/mes-accompagnements/{slug}', name: 'accompagnement_show')]
    public function show(#[MapEntity(mapping: ['slug' => 'slug'])] Accompagnement $accompagnement): Response
    {
        return $this->render('pages/accompagnement.html.twig', [
            'accompagnement' => $accompagnement,
        ]);
    }
}
