<?php

namespace App\Command;

use App\Entity\Clinic;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\TabularDataReader;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

class ImportClinicsCommand extends Command
{
    protected static $defaultName = 'app:import-clinics-from-csv';
    protected static $defaultDescription = 'Imports Clinic entities from CSV file';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly KernelInterface $kernel
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this->addArgument(
            'source',
            InputArgument::REQUIRED,
            'Source CSV file path.'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $source = $input->getArgument('source');
        $path = $this->kernel->getProjectDir() . '/' . $source;
        $this->checkSourceExistence($path);
        foreach ($this->getRows($path) as $row) {
            $this->createClinicFromRow($row);
        }

        $this->entityManager->flush();
        $io->success('Successfully imported clinics');

        return Command::SUCCESS;
    }

    private function checkSourceExistence(string $source): void
    {
        if (!file_exists($source)) {
            throw new RuntimeException('Given file doesn\'t exists!');
        }
    }

    private function getRows(string $source): TabularDataReader
    {
        $csv = (Reader::createFromPath($source))
            ->setDelimiter(';')
            ->setHeaderOffset(0);

        return (Statement::create())->process($csv);
    }

    private function createClinicFromRow(array $row): void
    {
        $clinic = (new Clinic())
            ->setName($row['name'])
            ->setCountry($row['country'])
            ->setCity($row['city'])
            ->setEmail($row['email'])
            ->setZipCode($row['zip_code'])
            ->setStreetAddress($row['street_address']);

        $this->entityManager->persist($clinic);
    }
}
