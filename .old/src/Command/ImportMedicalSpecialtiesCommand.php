<?php

namespace App\Command;

use App\Entity\MedicalSpecialty;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

class ImportMedicalSpecialtiesCommand extends Command
{
    protected static $defaultName = 'app:import-medical-specialties';
    protected static $defaultDescription = 'Imports list of medical specialties into database';

    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly EntityManagerInterface $entityManager
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this->addArgument(
            'list',
            InputArgument::REQUIRED,
            'List path. Path begins at the root of project'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $list = $input->getArgument('list');

        foreach ($this->getSpecialties($list) as $specialty) {
            $this->createNewMedicalSpecialty($specialty);
        }

        $this->entityManager->flush();

        $io->success('Medical specialties have been imported to database');

        return Command::SUCCESS;
    }

    private function getPath(string $list): string
    {
        return sprintf('%s/%s', $this->kernel->getProjectDir(), $list);
    }

    private function getSpecialties(string $list): array
    {
        $contents = file_get_contents($this->getPath($list));
        $contents = str_replace(["\r\n", "'"], '', $contents);

        return explode(', ', $contents);
    }

    private function createNewMedicalSpecialty(string $specialty): void
    {
        $spec = new MedicalSpecialty();
        $spec->setTitle($specialty);
        $this->entityManager->persist($spec);
    }
}
