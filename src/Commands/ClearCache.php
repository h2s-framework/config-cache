<?php

namespace Siarko\ConfigCache\Commands;

use Psr\Log\LoggerInterface;
use Siarko\CacheFiles\Manager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCache extends Command
{

    public function __construct(
        protected readonly Manager $cacheManager,
        private readonly LoggerInterface $logger
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('cache:clear')
            ->setDescription("Clear caches");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $types = $this->cacheManager->getTypes();
        foreach ($types as $type) {
            try{
                $this->cacheManager->clear($type);
                $output->writeln("<info>Cleared \"$type\" cache</info>");
            }catch (\Exception $e){
                $this->logger->error("Failed to clear \"$type\" cache", ['exception' => $e]);
                $output->writeln("<error>Failed to clear \"$type\" cache\n".$e->getMessage()."</error>");
            }
        }
        return Command::SUCCESS;
    }


}