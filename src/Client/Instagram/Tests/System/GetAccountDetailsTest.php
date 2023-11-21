<?php

declare(strict_types=1);

namespace App\Client\Instagram\Tests\System;

use App\Client\Instagram\System\Service\SystemService;

include dirname(__DIR__, 5).'/vendor/autoload.php';

$test = new GetAccountDetailsTest();
$test->run();

class GetAccountDetailsTest
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
            $response = $this->systemService->getAccountDetails();

            dump($response, $this->systemService->getRequest(), $this->systemService->getResponse());
        } catch (\Throwable $exception) {
            dump($exception->getMessage());
        }
    }
}
