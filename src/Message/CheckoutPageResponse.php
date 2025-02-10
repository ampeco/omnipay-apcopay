<?php

namespace Ampeco\OmnipayApcopay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

class CheckoutPageResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function __construct(RequestInterface $request, array $data, protected int $code)
    {
        parent::__construct($request, $data);
    }

    public function isSuccessful() : bool
    {
        //transaction status is checked with consecutive request
        return true;
    }

    public function isRedirect(): bool
    {
        return false;
    }
}
