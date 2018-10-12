<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Service\PermutationService;

class PermutationCommand extends Command
{
    const FILE_NAME = 'file.txt';

    protected function configure()
    {
        $this->setName('app:show-permutation')
            ->setDescription('Выводит все варианты перестановок без повторений')
            ->addArgument('fieldsCount', InputArgument::REQUIRED, 'Количество ячеек')
            ->addArgument('chipCount', InputArgument::REQUIRED, 'Количество фишек.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fieldsCount = $input->getArgument('fieldsCount');
        $chipCount = $input->getArgument('chipCount');
        $service = $this->getService();


        $service->saveCount($fieldsCount, $chipCount);

        $service->saveVariants($fieldsCount, $chipCount);
    }

    protected function getService(): PermutationService
    {
        return new PermutationService(self::FILE_NAME);
    }
}
