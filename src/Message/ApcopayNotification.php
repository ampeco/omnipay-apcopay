<?php

namespace Ampeco\OmnipayApcopay\Message;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\ResponseInterface;

class ApcopayNotification implements NotificationInterface, ResponseInterface
{
    private const STATUS_OK = 'OK';
    private array $data;
    private string $xml;

    public function __construct(array $data)
    {
        $this->xml = $data['params'] ?? '';
        $xmlObject = simplexml_load_string($this->xml);
        $json = json_encode($xmlObject);
        $this->data = json_decode($json, true);
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getXml(): string
    {
        return $this->xml;
    }

    public function getMessage(): string
    {
        return $this->data['ISOResp'] ?? '';
    }

    public function getToken(): ?string
    {
        return $this->data['pspid'] ?? null;
    }

    public function getHash(): ?string
    {
        return $this->data['@attributes']['hash'] ?? null;
    }

    public function getTransactionReference(): ?string
    {
        return $this->data['pspid'] ?? null;
    }

    public function getTransactionStatus(): string
    {
        return $this->isSuccessful() ? self::STATUS_COMPLETED : self::STATUS_FAILED;
    }

    public function isSuccessful(): bool
    {
        return isset($this->data['Result']) && $this->data['Result'] === self::STATUS_OK;
    }

    public function getLastFourDigits(): ?string
    {
        if (isset($this->data['ExtendedData']['CardNum'])) {
            return substr($this->data['ExtendedData']['CardNum'], -4);
        }

        return null;
    }

    public function getCardType(): ?string
    {
        return $this->data['ExtendedData']['CardType'] ?? null;
    }

    public function getExpirationDate(): ?string
    {
        return $this->data['ExtendedData']['CardExpiry'] ?? null;
    }

    public function getExpirationYear(): ?int
    {
        if ($this->getExpirationDate() !== null) {
            return (int)substr($this->getExpirationDate(), 3, 4);
        }

        return null;
    }

    public function getExpirationMonth(): ?int
    {
        if ($this->getExpirationDate() !== null) {
            return (int)substr($this->getExpirationDate(), 0, 2);
        }

        return null;
    }

    public function getRequest()
    {
        return null;
    }

    public function isRedirect(): bool
    {
        return false;
    }

    public function isCancelled(): bool
    {
        return false;
    }

    public function getCode(): ?string
    {
        return null;
    }
}
