<?php

namespace Ampeco\OmnipayApcopay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Ampeco\OmnipayApcopay\TransactionStatusService;

class GetTransactionResponse extends AbstractResponse
{
    private const BANK_ACCEPT_YES = 'YES';
    private const RESULT_OK = 'OK';

    private ?string $transactionStatus;
    private ?string $transactionReference;
    private bool $acceptedByBank;

    public function __construct(RequestInterface $request, array $data, private int $code, private string $trnType)
    {
        $this->transactionStatus = null;
        $this->transactionReference = null;
        $this->acceptedByBank = false;

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

    public function isAcceptedByBank(): bool
    {
        return $this->acceptedByBank;
    }

    private function setTransactionData(): void
    {
        if (!isset($this->data['Transactions']) || !is_array($this->data['Transactions'])) {
            return;
        }

        foreach ($this->data['Transactions'] as $transaction) {
            $transactionTypeMatches = isset($transaction['TrnType']) && $transaction['TrnType'] === $this->trnType;
            $bankResponseMatches = isset($transaction['BankResponse'])
                && TransactionStatusService::getExpectedTransactionStatus($this->trnType) === $transaction['BankResponse'];
            if ($transactionTypeMatches || $bankResponseMatches) {
                $this->transactionStatus = $transaction['BankResponse'] ?? null;
                $this->transactionReference = $transaction['PSPID'] ?? null;
                $this->acceptedByBank = isset($transaction['BankAccept']) ? $transaction['BankAccept'] === self::BANK_ACCEPT_YES : false;
            }
        }
    }
}
