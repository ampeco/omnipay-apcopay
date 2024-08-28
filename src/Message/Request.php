<?php

namespace Ampeco\OmnipayApcopay\Message;

class Request extends AbstractRequest
{
    protected function createResponse(array $data, int $statusCode): Response
    {
        return new Response($this, $data, $statusCode);
    }
}
