<?php

namespace App\Command;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Exception;
use League\Csv\UnavailableStream;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use League\Csv\Reader;

#[AsCommand(
    name: 'app:import-products',
    description: 'Importe un fichier CSV de produits dans la base de données',
)]
class ImportProductsCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('filePath', InputArgument::OPTIONAL, 'Chemin du fichier CSV', 'public/products.csv')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('filePath');

        // Vérifie si le fichier existe
        if (!file_exists($filePath)) {
            $output->writeln("<error>Erreur : Le fichier $filePath n'existe pas.</error>");
            return Command::FAILURE;
        }

        // Convertir l'encodage si nécessaire
        $fileContent = file_get_contents($filePath);
        $fileContent = mb_convert_encoding($fileContent, 'UTF-8', 'ISO-8859-1');
        file_put_contents($filePath, $fileContent);

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');

        foreach ($csv as $record) {
            $product = new Product();
            $product->setName(trim($record['Name'], "\""));
            $product->setDescription(trim($record['Description'], "\""));
            $product->setPrice((float) str_replace(',', '.', trim($record['Price'], "\"")));

            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();

        $output->writeln('<info>Produits importés avec succès !</info>');
        return Command::SUCCESS;
    }

}
