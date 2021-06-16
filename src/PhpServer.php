<?php

namespace Scouterna\Mocknet;

use Symfony\Component\Process\PhpProcess;
use Symfony\Component\Process\Process;

class PhpServer
{
    private $host;

    private $port;

    private $process;

    /**
     * 
     * @param string $host 
     * @param int $port 
     * @param string[] $dbParams parameters for a doctrine dbal connection.
     * See link.
     * @link https://www.doctrine-project.org/projects/doctrine-dbal/en/2.13/reference/configuration.html#configuration
     * @return void 
     */
    public function __construct(string $host, int $port, array $dbParams)
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
