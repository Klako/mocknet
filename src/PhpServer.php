<?php

namespace Scouterna\Mocknet;

use Symfony\Component\Process\PhpProcess;
use Symfony\Component\Process\Process;

class PhpServer
{
    private $host;

    private $port;

    private $process;

    public function __construct(string $host, int $port, $dbParams = null)
    {
        $this->host = $host;
        $this->port = $port;
        $phpFile = __DIR__ . \DIRECTORY_SEPARATOR . 'server.php';
        $cmd = ['php', '-S', "$host:$port", $phpFile];
        $dbParamsB64 = \base64_encode(\json_encode($dbParams));
        $env = ['MOCKNET_DBPARAMS' => $dbParamsB64];
        $this->process = new Process($cmd, __DIR__, $env);
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
