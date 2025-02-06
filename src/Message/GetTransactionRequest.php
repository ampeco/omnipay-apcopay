<?php

namespace Ampeco\OmnipayApcopay\Message;

use Omnipay\Common\Message\ResponseInterface;

class GetTransactionRequest extends AbstractRequest
{
    private const API_GET_TRANSACTION_ENDPOINT = '/MerchantTools/MerchantTools.svc/getTransactionsByORef';

    public function getEndpoint(): string
    {
        return self::API_GET_TRANSACTION_ENDPOINT;
    }

    protected function createResponse(array $data, int $statusCode): ResponseInterface
    {
        return new GetTransactionResponse($this, $data, $statusCode, $this->getTrnType());
    }

    public function getData(): array
    {
        return [
            'MerchID' => $this->getMerchantCode(),
            'MerchPass' => $this->getMerchantPassword(),
            'Oref' => $this->getReference(),
        ];
    }
}
