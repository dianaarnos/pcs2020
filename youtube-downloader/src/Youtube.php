<?php

declare(strict_types=1);

namespace YouTubeDownloader;

use Smoqadam\Video;

class Youtube
{
    private string $url;
    private string $name;
    private int $defaultFormatOption = 1;
    private $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';

    public function __construct(string $url)
    {
        $this->init($url);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    private function init(string $url): void
    {
        $video = new Video($this->getVideoId($url));
        $formats = $video->getFormats();


        print PHP_EOL . "Video Formats:";

        foreach ($formats as $index => $format) {
            printf(PHP_EOL . "%d: %s - %d mb", $index + 1, $format->getMimeType(), ($format->getSize() / 1024 / 1024));
        }

        printf(PHP_EOL . "Which format do you want to download? (default " . $this->defaultFormatOption . "):");

        $input = readline();
        if (!$input) {
            $input = $this->defaultFormatOption;
        }

        $format = $formats[$input - 1];
        $this->url = $format->getUrl();
        $this->name = $video->getDetails()->getTitle();
    }

    private function getVideoId(string $url): string
    {
        preg_match($this->pattern, $url, $match);

        return $match[1];
    }
}
