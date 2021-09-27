<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\RuntimeException;

trait PaymentInfoTrait
{
    /**
     * @return array
     *
     * @throws InvalidRequestException
     */
    public function getPaymentInfo(): array
    {
        $paymentInfo = [];

        if (null !== ($autoactivate = $this->getAutoActivate())) {
            $paymentInfo['autoactivate'] = $autoactivate;
        }

        if (null !== ($logo = $this->getLogo())) {
            $paymentInfo['logo'] = $logo;
        }

        if (null !== ($acceptUrl = $this->getAcceptUrl())) {
            $paymentInfo['accepturl'] = $acceptUrl;
        }

        if (null !== ($cancelUrl = $this->getCancelUrl())) {
            $paymentInfo['cancelurl'] = $cancelUrl;
        }

        if (null !== ($returnMethod = $this->getReturnMethod())) {
            $paymentInfo['returnMethod'] = $returnMethod;
        }

        if (null !== ($callbackUrl = $this->getCallbackUrl())) {
            $paymentInfo['callbackUrl'] = $callbackUrl;
        }

        return $paymentInfo;
    }

    /**
     * @return string|null
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
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
