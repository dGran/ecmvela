<?php

declare(strict_types=1);

namespace Instagram\System;

use App\Client\Instagram\System\Service\SystemService;

include dirname(__DIR__, 3).'/vendor/autoload.php';

$test = new ForceUpdateTokenTest();
$test->run();

class ForceUpdateTokenTest
{
    private SystemService $systemService;

    public function __construct()
    {
        $configuration = [
            'access_token' => 'IGQWRNOVBndU1YWXgwZAFJYNzNLcVJ0Tk5KaDJwT1pRcER5YVJDWm1BN0hRUi1CVUlZATVRJZAGlZARTBWQllPZAmFXOUhGVEVnYV9wd1duTmVQazVFZAWJqaW5ub2p6a2FlVExib0lUa2ZAEMkUwbUNpSThDdUdLd2prcmsZD',
            'expires_in' => null,
        ];
        $this->systemService = new SystemService($configuration);
    }

    public function run(): void
    {
        try {
            $token = $this->systemService->forceUpdateToken();

            dump($token, $this->systemService->getRequest(), $this->systemService->getResponse());
        } catch (\Throwable $exception) {
            dump($exception->getMessage());
        }
    }
}
