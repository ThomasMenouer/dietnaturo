<?php

namespace App\Presentation\Web\Twig\Components;


use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use App\Application\Pages\Accompagnement\GetAllAccompagmentUseCase;

#[AsTwigComponent(
    name: 'NavbarAccompagnements',
    template: 'components/navbarAccompagnements.html.twig'
)]
final class NavbarAccompagnements
{
    public array $accompagnements;

    public function __construct(GetAllAccompagmentUseCase $getAllAccompagmentUseCase)
    {
        $this->accompagnements = $getAllAccompagmentUseCase->execute();
    }
}
