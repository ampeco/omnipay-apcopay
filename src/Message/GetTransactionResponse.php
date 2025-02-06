<?php

namespace Ampeco\OmnipayApcopay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class GetTransactionResponse extends AbstractResponse
{
    private const BANK_ACCEPT_YES = 'YES';
    private const RESULT_OK = 'OK';

    private ?string $transactionStatus;
    private ?string $transactionReference;

    public function __construct(RequestInterface $request, array $data, private int $code, private string $trnType)
    {
        $this->transactionStatus = null;
        $this->transactionReference = null;

        parent::__construct($request, $data);
        $this->setTransactionData();
    }

    public function isSuccessful() : bool
    {
        return $this->code == 200 && isset($this->data['Result']) && $this->data['Result'] == self::RESULT_OK;
    }

    public function getTransactionStatus(): ?string
    {
        return $this->transactionStatus;
    }

    public function getTransactionReference(): ?string
    {
        return $this->transactionReference;
    }

    private function setTransactionData(): void
    {
        if (!isset($this->data['Transactions']) || !is_array($this->data['Transactions'])) {
            return;
        }

        foreach ($this->data['Transactions'] as $transaction) {
            if (isset($transaction['TrnType']) && $transaction['TrnType'] === $this->trnType
                && isset($transaction['BankAccept']) && $transaction['BankAccept'] === self::BANK_ACCEPT_YES
            ) {
                $this->transactionStatus = $transaction['BankResponse'] ?? null;
                $this->transactionReference = $transaction['PSPID'] ?? null;
            }
        }
    }
}
