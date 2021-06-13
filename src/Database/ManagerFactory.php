<?php

namespace Scouterna\Mocknet\Database;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class ManagerFactory
{
    private const defaultConnection = [
        'driver' => 'pdo_sqlite',
        'path' => ':memory:'
    ];

    private $connection;

    public function __construct()
    {
        $this->connection = self::defaultConnection;
    }

    /**
     * Sets the connection with params or an existing connection.
     * @see \Doctrine\ORM\EntityManager::create()
     * @param array<string,mixed>|\Doctrine\DBAL\Connection $connection 
     * @return void 
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * Makes the EntityManager object
     * @return \Doctrine\ORM\EntityManager 
     * @throws \InvalidArgumentException 
     * @throws \Doctrine\ORM\ORMException 
     */
    public function makeManager()
    {
        $paths = [__DIR__ . \DIRECTORY_SEPARATOR . 'Model'];
        $config = Setup::createAnnotationMetadataConfiguration($paths);
        return EntityManager::create($this->connection, $config);
    }
}
