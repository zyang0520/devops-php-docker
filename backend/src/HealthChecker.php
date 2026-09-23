<?php

declare(strict_types=1);

namespace App;

final class HealthChecker
{
    public function status(): array
    {
        return ['status' => 'ok'];
    }
}
