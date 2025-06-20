<?php


namespace App\Domain\Ateliers\Repository;

use App\Domain\Ateliers\Entity\Ateliers;
use App\Domain\Ateliers\Entity\Participants;


interface ParticipantsRepositoryInterface
{
    public function save(Participants $participant): void;

    public function remove(Participants $participants): void;

    public function findAllEmails(): array;

    public function findEmailsByAtelier(Ateliers $atelier): array;

    public function findOneByEmailAndAtelier(string $email, Ateliers $atelier): ?Participants;
}