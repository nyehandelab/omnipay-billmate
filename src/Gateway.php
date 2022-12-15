<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate;

use Nyehandel\Omnipay\Billmate\Message\AcknowledgeRequest;
use Nyehandel\Omnipay\Billmate\Message\ActivatePaymentRequest;
use Nyehandel\Omnipay\Billmate\Message\CancelPaymentRequest;
use Nyehandel\Omnipay\Billmate\Message\AuthorizeRequest;
use Nyehandel\Omnipay\Billmate\Message\CaptureRequest;
use Nyehandel\Omnipay\Billmate\Message\GetPaymentinfoRequest;
use Nyehandel\Omnipay\Billmate\Message\InitCheckoutRequest;
use Nyehandel\Omnipay\Billmate\Message\UpdateCheckoutRequest;
use Nyehandel\Omnipay\Billmate\Message\VoidRequest;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;

final class Gateway extends AbstractGateway
{

    const BASE_URL = 'https://api.billmate.se';


    public function initCheckout(array $options = []): RequestInterface
    {
        return $this->createRequest(InitCheckoutRequest::class, $options);
    }

    public function updateCheckout(array $options = []): RequestInterface
    {
        return $this->createRequest(UpdateCheckoutRequest::class, $options);
    }

    public function getPaymentinfo(array $options = []): RequestInterface
    {
        return $this->createRequest(GetPaymentinfoRequest::class, $options);
    }

    public function activatePayment(array $options = []): RequestInterface
    {
        return $this->createRequest(ActivatePaymentRequest::class, $options);
    }

    public function cancelOrder(array $options = []): RequestInterface
    {
        return $this->createRequest(CancelPaymentRequest::class, $options);
    }

    /**
     * @inheritDoc
     */
    public function getDefaultParameters(): array
    {
        return [
            'base_url' => self::BASE_URL,
            'eId' => '',
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
        return $this->getParameter('eId');
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

        //$this->setBaseUrl();

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
     * @param string $eId
     *
     * @return $this
     */
    public function setEId(string $eId): self
    {
        $this->setParameter('eId', $eId);

        return $this;
    }

    public function setTestMode($testMode): self
    {
        parent::setTestMode($testMode);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function void(array $options = [])
    {
        return $this->createRequest(VoidRequest::class, $options);
    }

}
