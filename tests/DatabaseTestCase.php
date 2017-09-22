<?php

namespace Tests;

use PHPUnit\Framework\TestCase as PhpUnitTestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

abstract class DatabaseTestCase extends PhpUnitTestCase
{
    use TestCaseTrait;

    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;

    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;

    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = DB::connection()->getPdo();
                Artisan::call('migrate');
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, ':memory:');
        }
        return $this->conn;
    }

    public function getDataSet()
    {
        return $this->createFlatXmlDataSet(__DIR__.'/dataset.xml');
    }
}