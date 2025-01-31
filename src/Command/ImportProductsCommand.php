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
    description: 'Add a short description for your command',
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
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $csv = Reader::createFromPath('public/products.csv', 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            $product = new Product();
            $product->setName($record['name']);
            $product->setDescription($record['description']);
            $product->setPrice((float) $record['price']);

            $this->entityManager->persist($product);
        }

        $this->entityManager->flush();

        $output->writeln('Produits importés avec succès !');
        return Command::SUCCESS;
    }
}
