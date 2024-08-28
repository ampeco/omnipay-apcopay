<?php

namespace Ampeco\OmnipayApcopay\Message;

use Omnipay\Common\Message\ResponseInterface;

class CheckoutPageRequest extends AbstractRequest
{
    public function getRequestMethod(): string
    {
        return 'GET';
    }

    public function getBaseUrl(): string
    {
        return $this->getBaseUrlParam();
    }

    public function getEndpoint(): string
    {
        return $this->getToken();
    }

    public function getData(): array
    {
        return [
            'token' => $this->getToken(),
        ];
    }

    protected function createResponse(array $data, int $statusCode): CheckoutPageResponse
    {
        return new CheckoutPageResponse($this, $data, $statusCode);
    }

    public function sendData($data): ResponseInterface
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->getBaseUrl() . $this->getEndpoint());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());

        // Do not follow redirects
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $this->createResponse(['message' => $response], $httpCode);
    }
}
