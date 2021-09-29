<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate\Message;

use Nyehandel\Omnipay\Billmate\Address;
use Nyehandel\Omnipay\Billmate\Customer;
use Nyehandel\Omnipay\Billmate\ItemBag;

abstract class AbstractApiRequest extends AbstractRequest
{
    protected function getApiData(): array
    {
        $apiData = [];

        $apiData['data']['number'] = $this->getParameter('transactionReference');
        $apiData['credentials'] = $this->getCredentials($apiData['data']);

        return $apiData;
    }
}
