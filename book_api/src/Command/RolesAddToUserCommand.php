<?php

namespace App\Command;

use App\Component\User\UserManager;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'roles:add-to-user',
    description: 'Add a short description for your command',
    aliases: ['r:add']
)]
class RolesAddToUserCommand extends Command
{

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserManager $userManager,
    ) {
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $idQuestion = new Question('Please enter user id: ');
        $questionHelper = $this->getHelper('question');
        $user = null;
        $role = " ";

        while (!$user) {
            $id = $questionHelper->ask($input, $output, $idQuestion);

            $user = $this->userRepository->find($id);
            if (!$user) {
                $io->warning('User id cannot be blank!');
            }
        }

        while (!preg_match('/^ROLE_[A-Z]{4,}$/', $role)) {
            $role = $questionHelper->ask($input, $output, $idQuestion);

            if (!preg_match('/^ROLE_[A-Z]{4,}$/', $role)) {
                $io->warning('Role id cannot be blank!');
            }
        }

        if (!in_array($role, $user->getRoles(), true)) {
            $roles = $user->getRoles();
            $roles[] = $role;
            $user->setRoles($roles);
            $this->userManager->save($user, true);
            $io->success('User roles added!');
        }

        $io->success('The process was successfully carried out!');

        return Command::SUCCESS;
    }
}
