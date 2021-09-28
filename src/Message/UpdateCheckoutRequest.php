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
final class UpdateCheckoutRequest extends AbstractOrderRequest
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
            'transactionReference'
        );

        $data = $this->getOrderData();

        $data['function'] = 'updateCheckout';

        return $data;
    }

    /**
     * @return array
     */
    protected function getOrderData(): array
    {
        $data = [
            'Articles' => $this->getItemData($this->getItems() ?? new ItemBag()),
            'Cart' => $this->getCart(),
            'PaymentData' => [
                'number' => $this->getParameter('transactionReference')
            ],
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
        $response = $this->sendRequest('POST', '/', $data);

        if ($response->getStatusCode() >= 400) {
            throw new InvalidResponseException(
                \sprintf('Reason: %s (%s)', $response->getReasonPhrase(), $response->getBody())
            );
        }

        return new UpdateCheckoutResponse($this, $this->getResponseBody($response), $this->getRenderUrl());
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
