<?php

namespace Ampeco\OmnipayApcopay;

use Ampeco\OmnipayApcopay\Message\CheckoutPageRequest;
use Ampeco\OmnipayApcopay\Message\Request;
use Ampeco\OmnipayApcopay\Message\ApcopayNotification;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;

class Gateway extends AbstractGateway
{
    public function getName(): string
    {
        return 'Apcopay';
    }

    public function acceptNotification(array $options = array()): ApcopayNotification
    {
        return new ApcopayNotification($options);
    }

    public function createCard(array $options = array()): RequestInterface
    {
        return $this->createRequest(Request::class, $options);
    }

    public function purchase(array $options = array()): RequestInterface
    {
        return $this->createRequest(CheckoutPageRequest::class, $options);
    }

    public function authorize(array $options = array()): RequestInterface
    {
        return $this->createRequest(CheckoutPageRequest::class, $options);
    }

    public function capture(array $options = array()): RequestInterface
    {
        return $this->createRequest(CheckoutPageRequest::class, $options);
    }

    public function void(array $options = array()): RequestInterface
    {
        return $this->createRequest(CheckoutPageRequest::class, $options);
    }

    public function initial(array $options = array()): RequestInterface
    {
        return $this->createRequest(Request::class, $options);
    }

    public function getAvailableCurrencies(): array
    {
        return [
            'AUD', 'CAD', 'CHF', 'CYP', 'DEM', 'EUR', 'FRF', 'GBP', 'ISR', 'ITL', 'JPY', 'MTL', 'USD', 'NOK', 'SEK',
            'RON', 'SKK', 'CZK', 'HUF', 'PLN', 'DKK', 'HKD', 'MDL', 'ILS', 'EEK', 'BRL', 'ZAR', 'SGD', 'LTL', 'LVL',
            'NZD', 'TRY', 'KRW', 'KZT', 'HRK', 'BGN', 'MXN', 'PHP', 'RUB', 'THB', 'CNY', 'MYR', 'INR', 'IDR', 'ISK',
            'ISK', 'ALL', 'TND',
        ];
    }
}
