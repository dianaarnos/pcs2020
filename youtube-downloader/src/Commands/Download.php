<?php /** @noinspection PhpMissingFieldTypeInspection */

declare(strict_types=1);

namespace YouTubeDownloader\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use YouTubeDownloader\Downloader;
use YouTubeDownloader\Youtube;

class Download extends Command
{
    protected static $defaultName = "download";

    private $arg = "url";

    protected function configure()
    {
        $this
            ->setDescription("Download a YouTube video")
            ->addArgument($this->arg, InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>Starting command...</info>");

        $startTime = microtime(true);

        $url = $input->getArgument($this->arg);
        $downloader = new Downloader(new Youtube($url));
        $downloader->download();

        $output->writeln(PHP_EOL . "<info>Finished!</info>");

        $endTime = microtime(true);
        $elapsedTime = $endTime - $startTime;
        $output->writeln("<comment>Elapsed time: " . number_format($elapsedTime, 2) . "sec</comment>");

        return 0;
    }
}
