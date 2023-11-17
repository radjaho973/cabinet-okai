<?php
namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:create-user',description:"Create a new user")]
class CreateUserCommand extends Command
{
    private UserPasswordHasherInterface $userHashInterface;
    private EntityManagerInterface $entityManager;
    private ParameterBagInterface $parameters;

    public function __construct(UserPasswordHasherInterface $userHashInterface,EntityManagerInterface $entityManager,ParameterBagInterface $parameters)
    {
        parent::__construct('app:create-user');
        $this->userHashInterface= $userHashInterface;
        $this->entityManager = $entityManager;
        $this->parameters = $parameters;
    }

    protected function configure():void
    {
        $this->setHelp("Allow to create a new user using app:create-user <name> <lastname> <email> <password> <roles> <is_verified>");

        $this->addArgument("nom",InputArgument::OPTIONAL,'Nom de l\'utilisateur :');
        $this->addArgument("prénom",InputArgument::OPTIONAL,'Prénom de l\'utilisateur :');
        $this->addArgument("email",InputArgument::OPTIONAL,'Email de l\'utilisateur :');
        $this->addArgument("motDePasse",InputArgument::OPTIONAL,'mot de passe de l\'utilisateur :');
        $this->addArgument("roles",InputArgument::OPTIONAL,'roles de l\'utilisateur :');
        $this->addArgument("verif",InputArgument::OPTIONAL,'l\'utilisateur est il vérifié ?');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //Récupération des roles de l'application
        $rolesHierarchy = $this->parameters->get('security.role_hierarchy.roles');
        
        //Transforme le tableau multidimensionel des roles en tableau simple
        $rolesArray = [];
        array_walk_recursive($rolesHierarchy, function($role) use (&$rolesArray) {
            $rolesArray[] = $role;
        });
        //On supprime la dernière entré du tableau car elle correspond à "ROLE_ALLOWED_TO_SWITCH" qui n'est pas un vrai role
        array_pop($rolesArray);

        $helper = $this->getHelper('question');
        $io = new SymfonyStyle($input, $output);
        
        //code to create the user
        //? >> Interaction, question et recuperation de la reponse 

        $email =$input->getArgument('email');
        if(!$email){
            $question = new Question('Veuillez rentrer un mail pour l\'utilisateur : ','mail'.rand(0,1000).'@mail.fr');
            $email = $helper->ask($input,$output,$question);
            $output->writeln($email);
        }

        $motDePasse =$input->getArgument('motDePasse');
        if(!$motDePasse){
            $question = new Question('Veuillez rentrer un mot de passe pour l\'utilisateur : ' ,'mdp'.rand(0,1000));
            $motDePasse = $helper->ask($input,$output,$question);
            $output->writeln($motDePasse);
        }

        // $roles =$input->getArgument('roles');
        // if(!$roles){
        //     $question = new ChoiceQuestion('Quels sont les roles de l\'utilisateur ?  : ',$rolesArray,'["ROLE_USER"]');
        //     $question->setMultiselect(true);
        //     $question->setErrorMessage("Entrées invalides, les valeurs doivent-être séparé par des virgules");
        //     $roles = $helper->ask($input,$output,$question);
        //     $output->writeln($roles);
        // }
        
        $user = new User;
        $user->setEmail($email);
        $user->setPassword(
            $this->userHashInterface->hashPassword(
                $user,
                $motDePasse
                )
            );
        $user->setRoles(['ROLE_ADMIN']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->title("Utilisateur créer !");
        return Command::SUCCESS;
 
        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}