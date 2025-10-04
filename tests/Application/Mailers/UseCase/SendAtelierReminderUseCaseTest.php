<?php


namespace App\Tests\Application\Mailers\UseCase;

use PHPUnit\Framework\TestCase;
use App\Application\Mailers\UseCase\SendAtelierReminderUseCase;
use App\Domain\Ateliers\Repository\AteliersRepositoryInterface;
use App\Domain\Mailer\SendMailInterface;
use App\Domain\Ateliers\Entity\Ateliers;
use App\Domain\Ateliers\Entity\Participants;
use App\Domain\Ateliers\Enum\TypeAtelier;

class SendAtelierReminderUseCaseTest extends TestCase
{
    public function testExecuteSendsEmails()
    {
        // 1 Mock du repository
        $repository = $this->createMock(AteliersRepositoryInterface::class);

        // 2 Mock du mailer
        $mailer = $this->createMock(SendMailInterface::class);

        // 3 Atelier fictif
        $atelier = new Ateliers();
        $atelier->setTitle('Atelier Test')
            ->setDate(new \DateTimeImmutable('tomorrow'))
            ->setTypeAtelier(TypeAtelier::ATELIER)
            ->setIsAvailable(true);

        // Participant fictif
        $participant = new Participants();
        $participant->setEmail('test@example.com');
        $atelier->addParticipant($participant);

        // Le repository doit renvoyer notre atelier
        $repository->method('findBetweenDates')
            ->willReturn([$atelier]);

        // On vérifie que le mailer est appelé
        $mailer->expects($this->once())
            ->method('sendEmailReminderAtelier')
            ->with(
                $this->callback(fn($participants) => count($participants) === 1),
                $atelier
            );

        // 4️⃣ Exécution du Use Case
        $useCase = new SendAtelierReminderUseCase($repository, $mailer);
        $useCase->execute();
    }
}
