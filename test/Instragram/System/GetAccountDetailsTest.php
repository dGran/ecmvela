<?php

declare(strict_types=1);

namespace Instagram\System;

use App\Client\Instagram\System\Service\SystemService;

include dirname(__DIR__, 3).'/vendor/autoload.php';

$test = new GetAccountDetailsTest();
$test->run();

class GetAccountDetailsTest
{
    private SystemService $systemService;

    public function __construct()
    {
        $configuration = [
            'access_token' => 'IGQWRQbEd2d3BSVDRpR0lLVTMyNU1JX1pjZA0pQaUlBcm85aEdFbFNBRmVNemdGRm5ROEFlRzVPM2Q4a2c3YmhKbGdlOWFnNjJnS0gxU1U2MFZAHVV9MejRuYl9wYmZAGbGlzR3BUVEJCWDI2QQZDZD',
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
