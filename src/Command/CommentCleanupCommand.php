<?php

namespace App\Command;

use App\Repository\CommentRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CommentCleanupCommand extends Command
{
    protected static $defaultName = 'app:comment:cleanup';
    protected static string $defaultDescription = 'Find and remove all old spam and rejected comments.';

    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('days', InputArgument::OPTIONAL, 'Days pass from comment creation')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run');
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $days = $input->getArgument('days');
        if ($input->getOption('dry-run')) {
            $io->note('Dry run mode enabled');

            $count = $this->commentRepository->countSpamAndRejected($days);
        } else {
            $count = $this->commentRepository->deleteSpamAndRejected($days);
        }

        $io->success(\sprintf('Delete %d spam and rejected comments.', $count));

        return Command::SUCCESS;
    }
}
