<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Http\Exception\NetworkException;
use Omnipay\Common\Http\Exception\RequestException;

/**
 * Cancels an order
 */
final class CancelPaymentRequest extends AbstractApiRequest
{
    /**
     * @inheritDoc
     *
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate(
            'transactionReference'
        );

        $data = $this->getApiData();

        $data['function'] = 'cancelPayment';

        return $data;
    }

    /**
     * @inheritDoc
     *
     * @throws InvalidResponseException
     * @throws RequestException when the HTTP client is passed a request that is invalid and cannot be sent.
     * @throws NetworkException if there is an error with the network or the remote server cannot be reached.
     */
    public function sendData($data): CancelPaymentResponse
    {
        $response = $this->sendRequest('POST', '/', $data);

        if ($response->getStatusCode() >= 400) {
            throw new InvalidResponseException(
                \sprintf('Reason: %s (%s)', $response->getReasonPhrase(), $response->getBody())
            );
        }

        return new CancelPaymentResponse(
            $this,
            $this->getResponseBody($response),
            $response->getStatusCode()
        );
    }
}
