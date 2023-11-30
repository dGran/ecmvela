<?php

declare(strict_types=1);

namespace App\Client\Instagram\System\Service;

use App\Client\Base\Model\AccountInfo;
use App\Client\Base\Model\Token;
use App\Client\Instagram\Base\Exceptions\InvalidCredentialsException;
use App\Client\Instagram\Base\Service\BaseService;
use App\Client\Instagram\Enums\GrantTypes;
use App\Client\Instagram\System\Factory\TokenFactory;
use App\Client\Instagram\System\Model\UpdateTokenResponse;
use App\Utils\Logger;
use App\Utils\Serializer;

class SystemService extends BaseService
{
    private const ENDPOINT_ME = '/me';

    private const ENDPOINT_REFRESH_TOKEN = "/refresh_access_token";

    private const MARGIN_HOURS_TO_REFRESH_TOKEN = 24;

    /**
     * @throws \Exception
     */
    public function forceUpdateToken(): Token
    {
        return $this->doUpdateToken();
    }

    /**
     * @throws \Exception
     */
    public function getAccountDetails(): AccountInfo
    {
        $accountInfo = $this->getAccountInfo();

        try {
            $currentAccessToken = $this->getAccessToken();
            $newToken = $this->updateToken($accountInfo);

            if ($currentAccessToken !== $newToken->token) {
                $accountInfo = $this->getAccountInfo();
                $accountInfo->token = $newToken;
            }
        } catch (\Throwable $exception) {
            $this->logger->error(
                __METHOD__.' Token not updated',
                [
                    'exception_message' => $exception->getMessage(),
                    'exception_code' => $exception->getCode(),
                    'exception_class' => \get_class($exception),
                ]
            );
        }

        return $accountInfo;
    }

    private function getAccountInfo(): AccountInfo
    {
        $accountInfo = new AccountInfo();

        try {
            $this->get(self::ENDPOINT_ME);
            $accountInfo->valid = true;

            return $accountInfo;
        } catch (\Throwable $exception) {
            $this->logger->error(
                __METHOD__.' Exception',
                [
                    'exception_message' => $exception->getMessage(),
                    'exception_code' => $exception->getCode(),
                    'exception_class' => \get_class($exception),
                ]
            );
        }

        return $accountInfo;
    }

    /**
     * @throws \Exception
     * @throws \Throwable
     */
    private function updateToken(AccountInfo $accountInfo): Token
    {
        if ($this->getExpiresIn()) {
            $dateExpirationToken = new \DateTime($this->getExpiresIn());
            $dateMaxToUpdateToken = (new \DateTime())->modify('+'.self::MARGIN_HOURS_TO_REFRESH_TOKEN.' hours');

            if ($dateMaxToUpdateToken < $dateExpirationToken && $accountInfo->valid === true) {
                return TokenFactory::build($this->getAccessToken(), $dateExpirationToken);
            }
        }

        if ($accountInfo->valid === false) {
            $newToken = $this->doUpdateToken();
            $this->accessToken = $newToken->token;

            return $newToken;
        }

        try {
            $newToken = $this->doUpdateToken();
            $this->accessToken = $newToken->token;

            return $newToken;
        } catch (InvalidCredentialsException $exception) {
            Logger::getInstance()->critical(
                __METHOD__.' UPDATE InvalidCredentialsException',
                [
                    'exception_message' => $exception->getMessage(),
                    'exception_code' => $exception->getCode(),
                    'exception_class' => \get_class($exception),
                ]
            );

            throw $exception;
        } catch (\Throwable $exception) {
            Logger::getInstance()->critical(
                __METHOD__.' UPDATE Throwable',
                [
                    'exception_message' => $exception->getMessage(),
                    'exception_code' => $exception->getCode(),
                    'exception_class' => \get_class($exception),
                ]
            );

            throw $exception;
        }
    }

    /**
     * @throws \Exception
     */
    private function doUpdateToken(): Token
    {
        try {
            $response = $this->get(self::ENDPOINT_REFRESH_TOKEN, '', [
                self::GRANT_TYPE => GrantTypes::GRANT_TYPE_REFRESH_TOKEN,
                self::ACCESS_TOKEN => $this->accessToken,
            ]);
            $rawResponse = $response->getRawResponse();
            $this->response->addResponse($rawResponse);
            $updateTokenResponse = Serializer::deserialize($rawResponse, UpdateTokenResponse::class, Serializer::FORMAT_JSON);

            return TokenFactory::buildFromUpdateTokenResponse($updateTokenResponse);
        } catch (\Exception $exception) {
            $this->logger->error(
                __METHOD__.' Exception',
                [
                    'exception_message' => $exception->getMessage(),
                    'exception_code' => $exception->getCode(),
                    'exception_class' => \get_class($exception),
                ]
            );

            throw $exception;
        }
    }
}
