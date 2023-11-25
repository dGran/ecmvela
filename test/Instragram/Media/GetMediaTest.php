<?php

declare(strict_types=1);

namespace Instagram\Media;

use App\Client\Instagram\Media\Factory\MediaRequestFactory;
use App\Client\Instagram\Media\Service\MediaService;

include dirname(__DIR__, 3).'/vendor/autoload.php';

$test = new GetMediaTest();
$test->run();

class GetMediaTest
{
    private MediaService $mediaService;

    private int $limit = 10;

    public function __construct()
    {
        $configuration = [
            'access_token' => 'IGQWRQUV92dkFrS1BKYWpXQWp6aFV5S1k0X0NtaFFXMnhZAN0Y4SmNLNUdteEVocGROeElQUy1lNFhuQ2NpamxkWFZA5Ti1oN0pIUERRRVNLRHU5S25KODl0ekxaS09RNGhMV3pGZADBlMS1kdwZDZD',
            'expires_in' => null,
        ];
        $this->mediaService = new MediaService($configuration);
    }

    public function run(): void
    {
        $request = MediaRequestFactory::build($this->limit);

        try {
            $response = $this->mediaService->getMedia($request);

            dump($response, $this->mediaService->getRequest(), $this->mediaService->getResponse());
        } catch (\Throwable $exception) {
            dump($exception->getMessage());
        }
    }
}
