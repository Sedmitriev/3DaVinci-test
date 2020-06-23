<?php
namespace Sedmit\DaVinci;

require __DIR__ . '/../vendor/autoload.php';

use Sedmit\DaVinci\Models\UserModel;
use Symfony\Component\Console\Command\Command; 
use Symfony\Component\Console\Input\InputInterface; 
use Symfony\Component\Console\Output\OutputInterface; 
use Symfony\Component\Console\Input\InputArgument;  

class StartCommand extends Command {
     private $userModel;
     private $users;

     public function __construct($users, $config)
     {
          parent::__construct();
          $this->userModel = new UserModel($config);
          $this->users = $users;
     }

     protected function configure() { 
          $this 
               ->setName('start') 
               ->setDescription('start application') 
               ->setHelp('This command adds or updates users'); 
     }

     protected function execute(InputInterface $input, OutputInterface $output) {
          $newUsers = [];
          $users = $this->users;
          for ($i = 0; $i < count($users); $i++) {
               $newUsers[$i] = [
                    'id' => $users[$i]['id'],
                    'login' => $users[$i]['login']
               ];
          }
          $this->userModel->addUsers($newUsers); 
          $output->writeln('Users are added');
          return Command::SUCCESS;
     }
}