<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use App\HealthChecker;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

if ($path === '/api/health') {
    echo json_encode((new HealthChecker())->status());
    exit;
}

if ($path === '/api/status') {
	echo json_encode([
		[
			'start' => '2026-01-01',
			'uptime'=> '2 days'
		],
		[
			'start' => '2026-01-03',
			'uptime'=> '2 days'
		],
		[
			'start' => '2026-01-05',
			'uptime'=> '2 days'
		]
	]);
}

http_response_code(404);
echo json_encode(['error' => 'not found']);
