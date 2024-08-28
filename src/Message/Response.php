<?php

namespace Ampeco\OmnipayApcopay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse implements RedirectResponseInterface
{
    public function __construct(RequestInterface $request, array $data, protected int $code)
    {
        parent::__construct($request, $data);
    }

    public function isSuccessful() : bool
    {
        return $this->code == 200 && isset($this->data['Result']) && $this->data['Result'] == 'OK';
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectUrl()
    {
        return $this->getBaseUrl() . $this->getToken();
    }

    public function getResult(): string
    {
        return $this->data['Result'] ?? '';
    }

    public function getErrorMessage(): ?string
    {
        return $this->data['ErrorMsg'] ?? null;
    }

    public function getBaseUrl(): ?string
    {
        return $this->data['BaseURL'] ?? null;
    }

    public function getToken(): ?string
    {
        return $this->data['Token'] ?? null;
    }
}
