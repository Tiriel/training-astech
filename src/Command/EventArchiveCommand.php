<?php

namespace App\Command;

use App\Repository\EventRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:event:archive',
    description: 'Add a short description for your command',
)]
class EventArchiveCommand extends Command
{
    public function __construct(protected readonly EventRepository $repository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $events = $this->repository->findLiveEventsBetweenDates(null, new \DateTimeImmutable('yesterday'));

        foreach ($events as $key => $event) {
            $event->setArchived(true);
            $flush = $key === \count($events) -1;

            $this->repository->save($event, $flush);
        }

        $io = new SymfonyStyle($input, $output);
        $io->success(sprintf("%d events archived", \count($events)));

        return Command::SUCCESS;
    }
}
