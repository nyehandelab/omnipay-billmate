<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\RuntimeException;

trait CheckoutDataTrait
{
    /**
     * @return array
     *
     * @throws InvalidRequestException
     */
    public function getCheckoutData(): array
    {
        $checkoutData = [];

        if (null !== ($termsUrl = $this->getTermsUrl())) {
            $checkoutData['terms'] = $termsUrl;
        }

        if (null !== ($privacyPolicyUrl = $this->getPrivacyPolicyUrl())) {
            $checkoutData['privacyPolicy'] = $privacyPolicyUrl;
        }

        if (null !== ($companyView = $this->getCompanyView())) {
            $checkoutData['companyView'] = $companyView;
        }

        if (null !== ($showPhoneOnDelivery = $this->getShowPhoneOnDelivery())) {
            $checkoutData['showPhoneOnDelivery'] = $showPhoneOnDelivery;
        }

        if (null !== ($redirectOnSuccess = $this->getRedirectOnSuccess())) {
            $checkoutData['redirectOnSuccess'] = $redirectOnSuccess;
        }

        return $checkoutData;
    }

    /**
     * @return string|null
     */
    public function getTermsUrl()
    {
        return $this->getParameter('termsUrl');
    }

    /**
     * @return string|null
     */
    public function getCompanyView()
    {
        return $this->getParameter('companyView');
    }

    /**
     * @return string|null
     */
    public function getShowPhoneOnDelivery()
    {
        return $this->getParameter('showPhoneOnDelivery');
    }

    /**
     * @return string|null
     */
    public function getRedirectOnSuccess()
    {
        return $this->getParameter('redirectOnSuccess');
    }

    /**
     * @return string|null
     */
    public function getPrivacyPolicyUrl()
    {
        return $this->getParameter('privacyPolicyUrl');
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setTermsUrl(string $url): self
    {
        $this->setParameter('termsUrl', $url);

        return $this;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setPrivacyPolicyUrl(string $url): self
    {
        $this->setParameter('privacyPolicyUrl', $url);

        return $this;
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setCompanyView(bool $value): self
    {
        $this->setParameter('companyView', $value);

        return $this;
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setShowPhoneOnDelivery(bool $value): self
    {
        $this->setParameter('showPhoneOnDelivery', $value);

        return $this;
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setRedirectOnSuccess(bool $value): self
    {
        $this->setParameter('redirectOnSuccess', $value);

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
