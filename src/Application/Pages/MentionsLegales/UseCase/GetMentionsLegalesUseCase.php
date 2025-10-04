<?php 


namespace App\Application\Pages\MentionsLegales\UseCase;

use App\Domain\Pages\Entity\MentionsLegales\MentionsLegales;
use App\Domain\Pages\Repository\MentionsLegalesRepositoryInterface;

class GetMentionsLegalesUseCase
{

    public function __construct(private MentionsLegalesRepositoryInterface $mentionsLegalesRepository){}

    public function execute(): MentionsLegales
    {
        return $this->mentionsLegalesRepository->getMentionsLegales();
    }
}