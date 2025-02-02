<?php

namespace App\Command;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'app:add-client',
    description: 'Add a new client via the command line',
)]
class AddClientCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;
    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        $firstnameQuestion = new Question('Prénom du client : ');
        $lastnameQuestion = new Question('Nom du client : ');
        $emailQuestion = new Question('Email du client : ');
        $phoneQuestion = new Question('Numéro de téléphone du client : ');
        $addressQuestion = new Question('Adresse du client : ');
        $roleQuestion = new Question('Rôle du client (ROLE_ADMIN, ROLE_MANAGER, ROLE_USER) : ');

        $firstname = $helper->ask($input, $output, $firstnameQuestion);
        $lastname = $helper->ask($input, $output, $lastnameQuestion);
        $email = $helper->ask($input, $output, $emailQuestion);
        $phone = $helper->ask($input, $output, $phoneQuestion);
        $address = $helper->ask($input, $output, $addressQuestion);
        $role = $helper->ask($input, $output, $roleQuestion);

        $client = new Client();
        $client->setFirstname($firstname);
        $client->setLastname($lastname);
        $client->setEmail($email);
        $client->setPhoneNumber($phone);
        $client->setAddress($address);
        $client->setCreatedAt(new \DateTimeImmutable());

        $errors = $this->validator->validate($client);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $io->error($error->getMessage());
            }
            return Command::FAILURE;
        }

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        $io->success("Le client {$firstname} {$lastname} a été ajouté avec succès !");
        return Command::SUCCESS;
    }
}
