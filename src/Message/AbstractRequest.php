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

    const API_VERSION = '2.1.7';
    const VERSION = '1.0';
    const CLIENT = 'Nyehandel:Billmate:' . self::VERSION;


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

    public function getCredentials(array $data)
    {
        return [
            'id' => $this->getParameter('eId'),
            'hash' => $this->hash(json_encode($data)),
            'version' => self::API_VERSION,
            'client' => self::CLIENT,
            'language' => 'sv',
            'serverdata' => $this->serverData(),
            'time' => microtime(),
            'test' => $this->getParameter('testMode')
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
     * @param string $args - json encoded array of data
     *
     * Generates a hash for the request based on the secret combined with the data for the current request
     *
     * @return string
     */
    private function hash(string $args) {
        return hash_hmac('sha512', $args, $this->getParameter('secret'));
    }

    private function serverData()
    {
        return [
            'ip' => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'],
            'referer' => $_SERVER['HTTP_REFERER'] ?? '',
            'user agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'method' => $_SERVER['REQUEST_METHOD'] ?? '',
            'uri' => $_SERVER['REQUEST_URI'] ?? '',
        ];
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
        if ('GET' === $method) {
            return $this->httpClient->request(
                $method,
                $this->getBaseUrl().$url,
            );
        }

        $data = json_encode($data);

        return $this->httpClient->request(
            $method,
            $this->getBaseUrl().$url,
            [
                'Content-Type' => 'application/json',
                'Content-Length' => strlen($data)
            ],
            $data
        );
    }
}
