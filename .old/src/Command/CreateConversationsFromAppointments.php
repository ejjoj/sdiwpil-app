<?php

namespace App\Command;

use App\Entity\Appointment;
use App\Entity\Conversation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Doctrine\ORM\QueryBuilder;

class CreateConversationsFromAppointments extends Command
{
    protected static $defaultName = 'app:create-conversations-from-appointments';
    protected static $defaultDescription = 'Creates conversations from appointments which didn\'t have them ' .
    'created at first';

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var Appointment[] $appointments */
        $appointments = $this->entityManager->getRepository(Appointment::class)->findAll();
        $progressBar = new ProgressBar($output, count($appointments));

        foreach ($appointments as $appointment) {
            $this->processAppointment($appointment, $progressBar);
        }

        $progressBar->finish();

        return Command::SUCCESS;
    }

    private function isExistingConversation(Appointment $appointment): bool
    {
        $qb = $this->entityManager->getRepository(Conversation::class)->createQueryBuilder('c');

        return (bool)$qb
            ->andWhere($qb->expr()->eq('c.patient', ':patient'))
            ->andWhere($qb->expr()->eq('c.doctor', ':doctor'))
            ->setParameters([
                'patient' => $appointment->getPatient(),
                'doctor' => $appointment->getDoctor(),
            ])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    private function createConversationFromAppointment(Appointment $appointment): void
    {
        $doctor = $appointment->getDoctor()->getDoctor();
        $patient = $appointment->getPatient()->getPatient();
        $title = sprintf(
            '%s %s i lek. %s %s',
            $patient->getFirstName(),
            substr($patient->getLastName(), 0, 1),
            $doctor->getFirstName(),
            substr($doctor->getLastName(), 0, 1),
        );
        $conversation = (new Conversation())
            ->setPatient($appointment->getPatient())
            ->setDoctor($appointment->getDoctor())
            ->setTitle($title)
            ->setChannelId($appointment->getChecksum());
        $this->entityManager->persist($conversation);
        $this->entityManager->flush();
    }

    private function processAppointment(Appointment $appointment, ProgressBar $progressBar): void
    {
        if ($this->isExistingConversation($appointment)) {
            $progressBar->advance();

            return;
        }

        $this->createConversationFromAppointment($appointment);
    }
}
