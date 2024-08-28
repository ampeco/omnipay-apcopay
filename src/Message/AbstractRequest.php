<?php

namespace Ampeco\OmnipayApcopay\Message;

use Ampeco\OmnipayApcopay\CommonParameters;
use Ampeco\OmnipayApcopay\Gateway;
use Ampeco\OmnipayApcopay\XmlBuilder;
use Omnipay\Common\Message\AbstractRequest as OmniPayAbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

abstract class AbstractRequest extends OmniPayAbstractRequest
{
    use CommonParameters;

    protected const API_URL = 'https://www.apsp.biz';
    protected const API_BUILD_XML_TOKEN_ENDPOINT = '/MerchantTools/MerchantTools.svc/BuildXMLToken';

    protected ?Gateway $gateway;

    public function getEndpoint(): string
    {
        return self::API_BUILD_XML_TOKEN_ENDPOINT;
    }

    abstract protected function createResponse(array $data, int $statusCode): ResponseInterface;

    public function setGateway(Gateway $gateway): self
    {
        $this->gateway = $gateway;
        return $this;
    }

    public function getRequestMethod(): string
    {
        return 'POST';
    }

    public function getBaseUrl(): string
    {
        return self::API_URL;
    }

    public function getData(): array
    {
        return [
            'MerchID' => $this->getMerchantCode(),
            'MerchPass' => $this->getMerchantPassword(),
            'XMLParam' => (new XmlBuilder($this->getParameters()))->buildRequestXml(),
        ];
    }

    public function sendData($data): ResponseInterface
    {
        $endpoint = $this->getEndpoint();

        $response = $this->httpClient->request(
            $this->getRequestMethod(),
            $this->getBaseUrl() . $endpoint,
            $this->getHeaders(),
            $this->getRequestMethod() !== 'GET' ? json_encode($data) : null,
        );

        return $this->createResponse(
            json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR),
            $response->getStatusCode(),
        );
    }

    protected function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }
}
