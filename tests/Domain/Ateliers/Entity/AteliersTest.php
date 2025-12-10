<?php


namespace App\Tests\Domain\Ateliers\Entity;

use PHPUnit\Framework\TestCase;
use App\Domain\Ateliers\Entity\Ateliers;
use App\Domain\Ateliers\Enum\TypeAtelier;
use App\Domain\Ateliers\Entity\Participants;


class AteliersTest extends TestCase
{
    public function testRemainingPlaces(): void
    {
        $atelier = new Ateliers();
        $atelier->setPlaces(10);

        $p1 = new Participants();
        $p2 = new Participants();

        $atelier->addParticipant($p1);
        $atelier->addParticipant($p2);

        $this->assertEquals(8, $atelier->getRemainingPlaces());
    }

    public function testFormattedDate(): void
    {
        $atelier = new Ateliers();
        $date = new \DateTime('2025-05-10 14:00:00');
        $atelier->setDate($date);

        $this->assertEquals('10/05/2025', $atelier->getFormattedDate());
        $this->assertEquals('14h00', $atelier->getFormattedDateHour());
    }

    public function testSetAndGetTypeAtelier()
    {
        $atelier = new Ateliers();
        $atelier->setTypeAtelier(TypeAtelier::ATELIER);

        $this->assertEquals(TypeAtelier::ATELIER, $atelier->getTypeAtelier());
    }
}
