<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\RuntimeException;

trait PaymentDataTrait
{
    /**
     * @return array
     *
     * @throws InvalidRequestException
     */
    public function getPaymentData(): array
    {
        $paymentData = [
            'currency' => $this->getCurrency(),
            'language' => $this->getLanguage(),
            'country' => $this->getCountry(),
            'orderid' => $this->generateOrderId(),
        ];

        if (null !== ($autoactivate = $this->getAutoActivate())) {
            $paymentData['autoactivate'] = $autoactivate;
        }

        if (null !== ($logo = $this->getLogo())) {
            $paymentData['logo'] = $logo;
        }

        if (null !== ($acceptUrl = $this->getAcceptUrl())) {
            $paymentData['accepturl'] = $acceptUrl;
        }

        if (null !== ($cancelUrl = $this->getCancelUrl())) {
            $paymentData['cancelurl'] = $cancelUrl;
        }

        if (null !== ($returnMethod = $this->getReturnMethod())) {
            $paymentData['returnMethod'] = $returnMethod;
        }

        if (null !== ($callbackUrl = $this->getCallbackUrl())) {
            $paymentData['callbackUrl'] = $callbackUrl;
        }

        return $paymentData;
    }

    /**
     * @return string|null
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    /**
     * @return string|null
     */
    public function getCountry()
    {
        return $this->getParameter('country');
    }

    /**
     * @return string|null
     */
    public function getAutoActivate()
    {
        return $this->getParameter('autoActive');
    }

    /**
     * @return string|null
     */
    public function getLogo()
    {
        return $this->getParameter('logo');
    }

    /**
     * @return string|null
     */
    public function getAcceptUrl()
    {
        return $this->getParameter('acceptUrl');
    }

    /**
     * @return string|null
     */
    public function getReturnMethod()
    {
        return $this->getParameter('returnMethod');
    }

    /**
     * @return string|null
     */
    public function getCallbackUrl()
    {
        return $this->getParameter('callbackUrl');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setLanguage(string $value): self
    {
        $this->setParameter('language', $value);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setCountry(string $value): self
    {
        $this->setParameter('country', $value);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setAutoActive(string $value): self
    {
        $this->setParameter('autoActive', $value);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setLogo(string $value): self
    {
        $this->setParameter('logo', $value);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setAcceptUrl(string $value): self
    {
        $this->setParameter('acceptUrl', $value);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setReturnMethod(string $value): self
    {
        $this->setParameter('returnMethod', $value);

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setCallbackUrl(string $value): self
    {
        $this->setParameter('callbackUrl', $value);

        return $this;
    }

    /**
     * @return string - unique order id generated as a reference
     */
    private function generateOrderId()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $orderId = '';

        for ($i = 0; $i < 16; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $orderId .= $characters[$index];
        }

        return $orderId;
    }

    /**
     * @param string $validatable,... a variable length list of required parameters
     *
     * @throws InvalidRequestException
     */
    abstract public function validate();

    /**
     * @param string $key
     *
     * @return mixed
     */
    abstract protected function getParameter($key);

    /**
     * Set a single parameter
     *
     * @param string $key   The parameter key
     * @param mixed  $value The value to set
     *
     * @return AbstractRequest Provides a fluent interface
     *
     * @throws RuntimeException if a request parameter is modified after the request has been sent.
     */
    abstract protected function setParameter($key, $value);
}
