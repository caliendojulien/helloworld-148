<?php

namespace App\Command;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import_sql',
    description: 'Import SQL des series et saisons',
)]
class ImportSqlCommand extends Command
{

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $fichiers = scandir('./public/img/series');
        foreach ($fichiers as $fichier) {
            if ($fichier == '.' || $fichier == '..') {
                continue;
            }
            $serie = (new Serie())
                ->setTitre($fichier)
                ->setImage($fichier);
            $this->entityManager->persist($serie);
            $io->note('IMPORT SQL : ' . $fichier);
        }
        $this->entityManager->flush();
        $io->success('IMPORT SQL OK');

        return Command::SUCCESS;
    }
}
