<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate;

use Omnipay\Common\Message\RequestInterface;

interface GatewayInterface extends \Omnipay\Common\GatewayInterface
{
    /**
     * @param array $options
     *
     * @return RequestInterface
     */
    public function acknowledge(array $options = []): RequestInterface;
}
