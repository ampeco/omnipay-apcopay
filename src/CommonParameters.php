<?php

namespace Ampeco\OmnipayApcopay;

trait CommonParameters
{
    public function setMerchantCode(string $value): void
    {
        $this->setParameter('merchantCode', $value);
    }

    public function getMerchantCode(): string
    {
        return $this->getParameter('merchantCode');
    }

    public function setMerchantPassword(string $value): void
    {
        $this->setParameter('merchantPassword', $value);
    }

    public function getMerchantPassword(): string
    {
        return $this->getParameter('merchantPassword');
    }

    public function setProfileId(string $value): void
    {
        $this->setParameter('profileId', $value);
    }

    public function getProfileId(): string
    {
        return $this->getParameter('profileId');
    }

    public function setSecretWord(string $value): void
    {
        $this->setParameter('secretWord', $value);
    }

    public function getSecretWord(): string
    {
        return $this->getParameter('secretWord');
    }

    public function setLanguage(?string $value): void
    {
        $this->setParameter('language', $value);
    }

    public function getLanguage(): ?string
    {
        return $this->getParameter('language');
    }

    public function setActionType(int $value): void
    {
        $this->setParameter('actionType', $value);
    }

    public function getActionType(): int
    {
        return $this->getParameter('actionType');
    }

    public function setForceBank(?string $value): void
    {
        $this->setParameter('forceBank', $value);
    }

    public function getForceBank(): ?string
    {
        return $this->getParameter('forceBank');
    }

    public function setPspId(?string $value): void
    {
        $this->setParameter('pspId', $value);
    }

    public function getPspId(): ?string
    {
        return $this->getParameter('pspId');
    }

    public function setRedirectionUrl(string $value): void
    {
        $this->setParameter('redirectionUrl', $value);
    }

    public function getRedirectionUrl(): string
    {
        return $this->getParameter('redirectionUrl');
    }

    public function setStatusUrl(string $value): void
    {
        $this->setParameter('statusUrl', $value);
    }

    public function getStatusUrl(): string
    {
        return $this->getParameter('statusUrl');
    }

    public function setFastPay(array $value): void
    {
        $this->setParameter('fastPay', $value);
    }

    public function getFastPay(): string
    {
        return $this->getParameter('fastPay');
    }

    public function setReference(string $value): void
    {
        $this->setParameter('reference', $value);
    }

    public function getReference(): string
    {
        return $this->getParameter('reference');
    }

    public function setBaseUrlParam(string $value): void
    {
        $this->setParameter('baseUrlParam', $value);
    }

    public function getBaseUrlParam(): string
    {
        return $this->getParameter('baseUrlParam');
    }
}
