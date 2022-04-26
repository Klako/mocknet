<?php

use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit\Framework\TestCase;
use Scouterna\Mocknet\Database\DbGenerator;

class DbGeneratorTest extends TestCase
{
    /** @var \Scouterna\Mocknet\Database\DbGenerator */
    private $generator;

    public function setUp(): void
    {
        $this->generator = new DbGenerator([
            'driver' => 'pdo_sqlite',
            'path' => ':memory:'
        ]);
    }

    public function testGenerator()
    {
        $em = $this->generator->generateDb();
        $metadataFactory = $em->getMetadataFactory();
        $tool = new SchemaTool($em);
        $tool->updateSchema($metadataFactory->getAllMetadata());
        $em->flush();
    }
}
