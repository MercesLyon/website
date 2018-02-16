<?php

namespace App\Command;

use App\Entity\Admin\User;
use App\Manager\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAdminCommand extends Command
{
    /** @var string */
    public static $defaultName = 'app:admin:create';
    /** @var \Doctrine\ORM\EntityManagerInterface */
    private $entityManager;
    /** @var \App\Manager\UserManager */
    private $userManager;

    /**
     * CreateAdminCommand constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \App\Manager\UserManager             $userManager
     */
    public function __construct(EntityManagerInterface $entityManager, UserManager $userManager)
    {
        $this->entityManager = $entityManager;
        $this->userManager   = $userManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Creates an admin user.')
            ->addArgument('email', InputArgument::REQUIRED)
            ->addArgument('password', InputArgument::REQUIRED);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = new User();
        $user->setEmail($input->getArgument('email'));
        $user->setPlainPassword($input->getArgument('password'));
        $this->userManager->updatePassword($user);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
