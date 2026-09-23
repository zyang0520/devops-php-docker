<?php

declare(strict_types=1);

namespace App\Tests;

use App\HealthChecker;
use PHPUnit\Framework\TestCase;

final class HealthCheckerTest extends TestCase
{
    public function testStatusReturnsOk(): void
    {
        $checker = new HealthChecker();

        self::assertSame(['status' => 'ok'], $checker->status());
    }
}
