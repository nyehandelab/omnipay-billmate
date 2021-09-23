<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate;

use Nyehandel\Omnipay\Billmate\Message\AcknowledgeRequest;
use Nyehandel\Omnipay\Billmate\Message\AuthorizeRequest;
use Nyehandel\Omnipay\Billmate\Message\CaptureRequest;
use Nyehandel\Omnipay\Billmate\Message\ExtendAuthorizationRequest;
use Nyehandel\Omnipay\Billmate\Message\FetchTransactionRequest;
use Nyehandel\Omnipay\Billmate\Message\RefundRequest;
use Nyehandel\Omnipay\Billmate\Message\UpdateCustomerAddressRequest;
use Nyehandel\Omnipay\Billmate\Message\UpdateMerchantReferencesRequest;
use Nyehandel\Omnipay\Billmate\Message\UpdateTransactionRequest;
use Nyehandel\Omnipay\Billmate\Message\VoidRequest;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;

final class Gateway extends AbstractGateway implements GatewayInterface
{

    const BASE_URL = 'https://api.billmate.se';


    public function initCheckout(array $options = []): RequestInterface
    {
        return $this->createRequest(InitCheckoutRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function acknowledge(array $options = []): RequestInterface
    {
        return $this->createRequest(AcknowledgeRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function authorize(array $options = [])
    {
        return $this->createRequest(AuthorizeRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function capture(array $options = [])
    {
        return $this->createRequest(CaptureRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function extendAuthorization(array $options = []): RequestInterface
    {
        return $this->createRequest(ExtendAuthorizationRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function fetchTransaction(array $options = []): RequestInterface
    {
        return $this->createRequest(FetchTransactionRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function refund(array $options = [])
    {
        return $this->createRequest(RefundRequest::class, $options);
    }

    /**
     * @inheritDoc
     */
    public function getDefaultParameters(): array
    {
        return [
            'base_url' => self::BASE_URL,
            'e_id' => '',
            'secret' => '',
            'testMode' => true,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Billmate';
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->getParameter('secret');
    }

    /**
     * @return string
     */
    public function getEId(): string
    {
        return $this->getParameter('e_id');
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->getParameter('base_url');
    }

    /**
     * @inheritDoc
     */
    public function initialize(array $parameters = [])
    {
        parent::initialize($parameters);

        $this->setBaseUrl();

        return $this;
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
     * @param string $username
     *
     * @return $this
     */
    public function setEId(string $eId): self
    {
        $this->setParameter('e_id', $eId);

        return $this;
    }

    public function setTestMode($testMode): self
    {
        parent::setTestMode($testMode);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function updateCustomerAddress(array $options = []): RequestInterface
    {
        return $this->createRequest(UpdateCustomerAddressRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function updateTransaction(array $options = []): RequestInterface
    {
        return $this->createRequest(UpdateTransactionRequest::class, $options);
    }

    public function updateMerchantReferences(array $options = []): RequestInterface
    {
        return $this->createRequest(UpdateMerchantReferencesRequest::class, $options);
    }

    /**
     * @inheritdoc
     */
    public function void(array $options = [])
    {
        return $this->createRequest(VoidRequest::class, $options);
    }

}
