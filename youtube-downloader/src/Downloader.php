<?php

declare(strict_types=1);

namespace YouTubeDownloader;

class Downloader
{
    private Youtube $youtube;

    public function __construct(Youtube $youtube)
    {
        $this->youtube = $youtube;
    }

    public function download()
    {
        $context = stream_context_create();
        stream_context_set_params($context, ['notification' => [Downloader::class, 'streamCallback']]);

        $handler = fopen($this->youtube->getUrl(), 'r', false, $context);
        if (!$handler) {
            throw new \InvalidArgumentException("Unable to download from link " . $this->youtube->getUrl());
        }

        file_put_contents($this->youtube->getName(), $handler);
    }

    public function streamCallback($notification_code, $severity, $message, $message_code, $bytes_transfered, $bytes_max)
    {
        static $filesize = null;

        switch ($notification_code) {
            case STREAM_NOTIFY_RESOLVE:
            case STREAM_NOTIFY_AUTH_REQUIRED:
            case STREAM_NOTIFY_COMPLETED:
            case STREAM_NOTIFY_FAILURE:
            case STREAM_NOTIFY_AUTH_RESULT:
                break;
            case STREAM_NOTIFY_REDIRECTED:
                echo "Being redirected to: " . $message . PHP_EOL;
                break;
            case STREAM_NOTIFY_CONNECT:
                echo "Connected!" . PHP_EOL;
            case STREAM_NOTIFY_FILE_SIZE_IS:
                $filesize = $bytes_max;
                echo "Filesize: " . $filesize . PHP_EOL;
            case STREAM_NOTIFY_MIME_TYPE_IS:
                echo "Mime-type: " . $message . PHP_EOL;
            case STREAM_NOTIFY_PROGRESS:
                if ($bytes_transfered > 0) {
                    $length = (int)(($bytes_transfered / $filesize) * 100);
                    printf("\r[%-100s] %d%% (%2d/%2d mb)", str_repeat("=", $length) . ">", $length, ($bytes_transfered / 1024 / 1024), $filesize / 1024 / 1024);
                }
                break;
        }
    }
}
