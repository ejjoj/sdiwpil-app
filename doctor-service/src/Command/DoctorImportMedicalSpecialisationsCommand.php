<?php

namespace App\Command;

use App\Entity\MedicalSpecialisation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'doctor:import-medical-specialisations',
    description: 'Imports medical specialisations from a txt file',
)]
class DoctorImportMedicalSpecialisationsCommand extends Command
{
    private const string LIST_ARGUMENT = 'list';

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            self::LIST_ARGUMENT,
            InputArgument::REQUIRED,
            'List of specialisations to import'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $list = $input->getArgument(self::LIST_ARGUMENT);
        $specializations = $this->getSpecializations($list);
        $specializationCount = count($specializations);
        $io->note(sprintf('Found %d specialization(s)', $specializationCount));
        $io->progressStart($specializationCount);
        foreach ($specializations as $specialization) {
            $this->createSpecialization($specialization);
            $io->progressAdvance();
        }
        $this->entityManager->flush();
        $io->progressFinish();
        $io->success('Specializations imported');

        return Command::SUCCESS;
    }

    private function getSpecializations(string $list): array
    {
        $contents = file_get_contents($list);
        $contents = str_replace(["\r\n", "'", "\n"], '', $contents);

        return explode(', ', $contents);
    }

    private function createSpecialization(string $specialization): void
    {
        $medicalSpecialisation = (new MedicalSpecialisation())
            ->setTitle($specialization);
        $this->entityManager->persist($medicalSpecialisation);
    }
}
