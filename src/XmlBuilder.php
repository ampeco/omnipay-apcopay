<?php

namespace Ampeco\OmnipayApcopay;

use DOMDocument;
use DOMElement;
use DOMException;

class XmlBuilder
{
    private DOMDocument $domDocument;
    private DOMElement $transactionElement;

    private array $keyMapping = [
        'profileId' => 'ProfileID',
        'amount' => 'Value',
        'currency' => 'Curr',
        'language' => 'Lang',
        'reference' => 'ORef',
        'clientAcc' => 'ClientAcc',
        'mobileNo' => 'MobileNo',
        'email' => 'Email',
        'redirectionUrl' => 'RedirectionURL',
        'udf1' => 'UDF1',
        'udf2' => 'UDF2',
        'udf3' => 'UDF3',
        'fastPay' => 'FastPay',
        'cardRestrict' => 'CardRestrict',
        'listAllCards' => 'ListAllCards',
        'newCard1Try' => 'NewCard1Try',
        'newCardOnFail' => 'NewCardOnFail',
        'promptCVV' => 'PromptCVV',
        'promptExpiry' => 'PromptExpiry',
        'extendedErr' => 'ExtendedErr',
        'actionType' => 'ActionType',
        'testMode' => 'TEST',
        'statusUrl' => 'status_url',
        'regName' => 'RegName',
        'forceBank' => 'ForceBank',
        'pspId' => 'PspID',
    ];

    private array $emptyElements = [
        'reference', 'udf1', 'udf2', 'udf3',
    ];

    private array $attributes = [
        'statusUrl' => ['urlEncode' => 'true'],
    ];

    public function __construct(private readonly array $data)
    {
        $this->domDocument = new DOMDocument('1.0', 'utf-8');
        $this->transactionElement = $this->domDocument->createElement('Transaction');
        $this->transactionElement->setAttribute('hash', $this->data['secretWord'] ?? '');
    }

    public function buildRequestXml(): ?string
    {
        foreach ($this->keyMapping as $camelCaseKey => $xmlElementName) {
            if ($camelCaseKey === 'fastPay' && isset($this->data[$camelCaseKey])) {
                $fastPay = $this->domDocument->createElement($xmlElementName);
                foreach ($this->data[$camelCaseKey] as $fastPayKey => $fastPayValue) {
                    $this->appendElementIfExists($fastPayKey, $fastPay, $this->data[$camelCaseKey]);
                }
                $this->transactionElement->appendChild($fastPay);
            } elseif ($camelCaseKey === 'testMode') {
                if (!($this->data[$camelCaseKey] ?? false)) {
                   continue;
                }
                $this->appendEmptyElement($xmlElementName);
            } elseif (in_array($camelCaseKey, $this->emptyElements, true) && !isset($this->data[$camelCaseKey])) {
                $this->appendEmptyElement($xmlElementName);
            }
            else {
                $this->appendElementIfExists($camelCaseKey, attributes: $this->attributes[$camelCaseKey] ?? []);
            }
        }

        $this->domDocument->appendChild($this->transactionElement);
        $xml = $this->domDocument->saveXML($this->transactionElement);

        return $xml !== false ? $xml : null;
    }

    /**
     * @throws DOMException
     */
    private function appendElementIfExists(
        string $camelCaseKey,
        ?DOMElement $parent = null,
        ?array $data = null,
        ?array $attributes = []
    ): void {
        $data = $data ?? $this->data;
        if (isset($data[$camelCaseKey])) {
            $xmlElementName = $this->keyMapping[$camelCaseKey];
            $element = $this->domDocument->createElement($xmlElementName, (string)$data[$camelCaseKey]);

            foreach ($attributes as $attrName => $attrValue) {
                $element->setAttribute($attrName, $attrValue);
            }

            if ($parent) {
                $parent->appendChild($element);
            } else {
                $this->transactionElement->appendChild($element);
            }
        }
    }

    private function appendEmptyElement(string $name): void
    {
        $element = $this->domDocument->createElement($name);
        $this->transactionElement->appendChild($element);
    }
}
