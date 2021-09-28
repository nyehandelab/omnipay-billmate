<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate\Message;

use Nyehandel\Omnipay\Billmate\Address;
use Nyehandel\Omnipay\Billmate\Customer;
use Nyehandel\Omnipay\Billmate\ItemBag;

abstract class AbstractOrderRequest extends AbstractRequest
{
    use ItemDataTrait;

    /**
     * @return string
     */
    public function getEId(): string
    {
        return $this->getParameter('eId');
    }

    /**
     * @param string $eId
     *
     * @return $this
     */
    public function setEId(string $eId): self
    {
        $this->setParameter('eId', $eId);

        return $this;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->getParameter('secret');
    }

    /**
     * @param string $secret
     *
     * @return $this
     */
    public function setSecret(string $secret): self
    {
        $this->setParameter('secret', $secret);

        return $this;
    }

    /**
     * @return Address|null
     */
    public function getBillingAddress()
    {
        return $this->getParameter('billing_address');
    }

    /**
     * @return Customer|null
     */
    public function getCustomer()
    {
        return $this->getParameter('customer');
    }

    /**
     * @return string|null
     */
    public function getPurchaseCountry()
    {
        return $this->getParameter('purchase_country');
    }

    /**
     * @return Address|null
     */
    public function getShippingAddress()
    {
        return $this->getParameter('shipping_address');
    }

    /**
     * @return string[]|null ISO 3166 alpha-2 codes of shipping countries, or null if none are specified
     */
    public function getShippingCountries()
    {
        return $this->getParameter('shipping_countries');
    }

    /**
     * @param array $billingAddress
     *
     * @return $this
     */
    public function setBillingAddress($billingAddress): self
    {
        $this->setParameter('billing_address', Address::fromArray($billingAddress));

        return $this;
    }

    /**
     * @param array $customer
     *
     * @return $this
     */
    public function setCustomer(array $customer): self
    {
        $this->setParameter('customer', Customer::fromArray($customer));

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setPurchaseCountry(string $value): self
    {
        $this->setParameter('purchase_country', $value);

        return $this;
    }

    /**
     * @param array $shippingAddress
     *
     * @return $this
     */
    public function setShippingAddress(array $shippingAddress): self
    {
        $this->setParameter('shipping_address', Address::fromArray($shippingAddress));

        return $this;
    }

    /**
     * @param string[] $countries ISO 3166 alpha-2 codes of shipping countries
     *
     * @return $this
     */
    public function setShippingCountries(array $countries): self
    {
        $this->setParameter('shipping_countries', $countries);

        return $this;
    }

    public function setCheckoutData(array $data)
    {
        $this->setParameter('checkout_data', $data);

        return $this;
    }

    public function getCheckoutData()
    {
        return $this->getParameter('checkout_data');
    }

    public function setPaymentData(array $data)
    {
        $this->setParameter('payment_data', $data);

        return $this;
    }

    public function getPaymentData()
    {
        return $this->getParameter('payment_data');
    }

    public function setPaymentInfo(array $data)
    {
        $this->setParameter('payment_info', $data);

        return $this;
    }

    public function getPaymentInfo()
    {
        return $this->getParameter('payment_info');
    }

    public function setCart(array $data)
    {
        $this->setParameter('cart', $data);

        return $this;
    }

    public function getCart()
    {
        return $this->getParameter('cart');
    }

    /**
     * @return array
     */
    protected function getOrderData(): array
    {
        $data = [
            'CheckoutData' => $this->getCheckoutData(),
            'PaymentData' => $this->getPaymentData(),
            'PaymentInfo' => $this->getPaymentInfo(),
            'Articles' => $this->getItemData($this->getItems() ?? new ItemBag()),
            'Cart' => $this->getCart(),
        ];

        $orderData = [
            'credentials' => $this->getCredentials($data),
            'data' => $data,
        ];

        return $orderData;
    }
}
