<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate\Message;

use Nyehandel\Omnipay\Billmate\ItemBag;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Http\Exception\NetworkException;
use Omnipay\Common\Http\Exception\RequestException;

/**
 * Creates a Klarna Checkout order if it does not exist
 */
final class InitCheckoutRequest extends AbstractOrderRequest
{
    /**
     * @inheritDoc
     *
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate(
            'items',
            'checkout_data',
            'payment_data',
        );

        $data = $this->getOrderData();
        $data['function'] = 'initCheckout';

        return $data;
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

    /**
     * @return string|null
     */
    public function getRenderUrl()
    {
        return $this->getParameter('render_url');
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidResponseException
     * @throws RequestException when the HTTP client is passed a request that is invalid and cannot be sent.
     * @throws NetworkException if there is an error with the network or the remote server cannot be reached.
     */
    public function sendData($data)
    {
        $response = $this->getTransactionReference() ?
            $this->sendRequest('GET', '/'.$this->getTransactionReference(), $data) :
            $this->sendRequest('POST', '/', $data);

        $responseBody = $this->getResponseBody($response);
        if(isset($responseBody['code'])){
            throw new InvalidResponseException(
                \sprintf('Error: %s', $responseBody['message'])
            );
        }

        return new InitCheckoutResponse($this, $responseBody, $this->getRenderUrl());
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setRenderUrl(string $url): self
    {
        $this->setParameter('render_url', $url);

        return $this;
    }
}
