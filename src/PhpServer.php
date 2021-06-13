<?php

namespace Scouterna\Mocknet;

use Symfony\Component\Process\PhpProcess;
use Symfony\Component\Process\Process;

class PhpServer
{
    private $host;

    private $port;

    private $process;

    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
        $this->process = new Process([
            "php",
            "-S",
            $host . ':' . $port,
            __DIR__ . \DIRECTORY_SEPARATOR . "server.php"
        ]);
    }

    public function __destruct()
    {
        $this->stop();
    }

    public function start()
    {
        $this->process->start();
        \usleep(100000);
    }

    public function stop()
    {
        $this->process->stop();
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }
}
