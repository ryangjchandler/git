<?php

namespace RyanChandler\Git\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use TitasGailius\Terminal\Terminal;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Terminal::fake();
    }
}