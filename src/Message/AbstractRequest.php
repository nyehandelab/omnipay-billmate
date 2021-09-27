<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate\Message;

use Money\Money;
use Nyehandel\Omnipay\Billmate\AuthenticationRequestHeaderProvider;
use Nyehandel\Omnipay\Billmate\CurrencyAwareTrait;
use Nyehandel\Omnipay\Billmate\ItemBag;
use Omnipay\Common\Http\Exception\NetworkException;
use Omnipay\Common\Http\Exception\RequestException;
use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Psr\Http\Message\ResponseInterface;

/**
 * @method ItemBag|null getItems()
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    use CurrencyAwareTrait;

    /**
     * @return Money|null
     */
    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    /**
     * @return string|null
     */
    public function getBaseUrl()
    {
        return $this->getParameter('base_url');
    }

    /**
     * ISO 639-1 customer's language. Currently supported: sv, en
     *
     * @return string|null
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    /**
     * @return string|null
     */
    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    /**
     * The total tax amount of the order
     *
     * @return Money|null
     */
    public function getTaxAmount()
    {
        return $this->getParameter('tax_amount');
    }

    /**
     * @param string $baseUrl
     *
     * @return $this
     */
    public function setBaseUrl(string $baseUrl): self
    {
        $this->setParameter('base_url', $baseUrl);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setItems($items)
    {
        if ($items && !$items instanceof ItemBag) {
            $items = new ItemBag($items);
        }

        return $this->setParameter('items', $items);
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language)
    {
        $this->setParameter('language', $language);
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
     * @param mixed $value
     */
    public function setTaxAmount($value)
    {
        $this->setParameter('tax_amount', $value);
    }

    public function getCredentials()
    {
        return [
            'id' => $this->getParameter('eId'),
        ];
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    protected function getResponseBody(ResponseInterface $response): array
    {
        try {
            return \json_decode($response->getBody()->getContents(), true);
        } catch (\TypeError $exception) {
            return [];
        }
    }

    /**
     * @param mixed $args
     *
     * Generates a hash for the request based on the secret combined with the data for the current request
     *
     * @return string
     */
    private function hash($args) {
        return hash_hmac('sha512', $args, $this->secret);
    }

    /**
     * @param string $method
     * @param string $url
     * @param mixed  $data
     *
     * @return ResponseInterface
     *
     * @throws RequestException when the HTTP client is passed a request that is invalid and cannot be sent.
     * @throws NetworkException if there is an error with the network or the remote server cannot be reached.
     */
    protected function sendRequest(string $method, string $url, $data): ResponseInterface
    {
        $headers = (new AuthenticationRequestHeaderProvider())->getHeaders($this);

        if ('GET' === $method) {
            return $this->httpClient->request(
                $method,
                $this->getBaseUrl().$url,
                $headers
            );
        }

        return $this->httpClient->request(
            $method,
            $this->getBaseUrl().$url,
            array_merge(
                ['Content-Type' => 'application/json'],
                $headers
            ),
            \json_encode($data)
        );
    }
}
