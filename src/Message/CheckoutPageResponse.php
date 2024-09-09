<?php

namespace Ampeco\OmnipayApcopay\Message;

use Exception;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

class CheckoutPageResponse extends AbstractResponse implements RedirectResponseInterface
{
    private const STATUS_OK = 'OK';

    public function __construct(RequestInterface $request, array $data, protected int $code)
    {
        try {
            $pattern = '/params=([^&"]*)/';
            $params = preg_match($pattern, $data['message'] ?? '', $matches) ? urldecode($matches[1] ?? '') : null;
            $response = $params ? json_decode(json_encode(simplexml_load_string($params)), true) : $data;
        } catch (Exception $e) {
            $response = $data;
        }

        parent::__construct($request, $response);
    }

    public function isSuccessful() : bool
    {
        return $this->code == 302 && (($this->data['Result'] ?? '') === self::STATUS_OK);
    }

    public function isRedirect(): bool
    {
        return false;
    }
}
