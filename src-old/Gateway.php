<?php

/**
 * Swish Gateway.
 */
namespace Nyehandel\Omnipay\Swish;

use Omnipay\Common\AbstractGateway;

/**
 * Billmate Class.
 *
 * ### Example
 *
 * #### Initialize Gateway
 *
 * <code>
 *   // Create a gateway for the Swish gateway
 *   // (routes to GatewayFactory::create)
 *   $gateway = Omnipay::create('Swish');
 *
 *   // Initialize the gateway
 *   $gateway->initialize(array(
 *   ));
 * </code>
 *
 * #### Payment
 *
 * @link https://billmate.github.io/api-docs/
 */
class Gateway extends AbstractGateway
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Billmate';
    }

    public function getDefaultParameters()
    {
        return [
            'eid' => null,
            'secret' => null,
            'ssl' => null,
            'test' => null,
        ];
    }

    public function getEid()
    {
        return $this->getParameter('eid');
    }

    public function setEid($value)
    {
        return $this->setParameter('eid', $value);
    }

    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    public function getSsl()
    {
        return $this->getParameter('ssl');
    }

    public function setSsl($value)
    {
        return $this->setParameter('ssl', $value);
    }

    public function getTest()
    {
        return $this->getParameter('test');
    }

    public function setTest($value)
    {
        return $this->setParameter('test', $value);
    }

    public function initCheckout()
    {

    }

    public function updateCheckout()
    {

    }
}
