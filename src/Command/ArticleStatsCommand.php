<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ArticleStatsCommand extends Command
{
    protected static $defaultName = 'article:stats';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('slug', InputArgument::OPTIONAL, 'The article\'s slug')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'The output format')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $slug = $input->getArgument('slug');

        $data = [
            'slug' => $slug,
            'hearts' => rand(10, 100),
        ];

        switch ($input->getOption('format')) {
            case 'text':
                $rows = [];
                foreach ($data as $key => $val)
                    $rows[] = [$key, $val];

                $io->table(['Key', 'Value'], $rows);
                break;
            case 'json':
                $io->write(\GuzzleHttp\json_encode($data));
                break;

            default:
                throw new \Exception('What is that?');
                break;
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
