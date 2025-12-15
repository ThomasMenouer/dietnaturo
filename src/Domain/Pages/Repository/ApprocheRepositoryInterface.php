<?php


namespace App\Domain\Pages\Repository;


interface ApprocheRepositoryInterface
{
    public function getAllApproche(): array; 

    public function getAllApprocheOrderedByPosition(): array;
}

