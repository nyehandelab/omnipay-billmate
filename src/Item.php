<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate;

final class Item extends \Omnipay\Common\Item implements ItemInterface
{
    /**
     * @inheritDoc
     */
    public function getTaxRate()
    {
        return $this->getParameter('tax_rate');
    }

    /**
     * @inheritDoc
     */
    public function getTotalAmount()
    {
        return $this->getParameter('total_amount');
    }

    /**
     * @inheritDoc
     */
    public function getTotalDiscountAmount()
    {
        return $this->getParameter('total_discount_amount');
    }

    /**
     * @inheritDoc
     */
    public function getTotalTaxAmount()
    {
        return $this->getParameter('total_tax_amount');
    }

    /**
     * @param int $taxRate
     */
    public function setTaxRate($taxRate)
    {
        $this->setParameter('tax_rate', $taxRate);
    }

    /**
     * @param int $amount
     */
    public function setTotalAmount($amount)
    {
        $this->setParameter('total_amount', $amount);
    }

    /**
     * @param int $amount
     */
    public function setTotalDiscountAmount($amount)
    {
        $this->setParameter('total_discount_amount', $amount);
    }

    /**
     * @param int $amount
     */
    public function setTotalTaxAmount($amount)
    {
        $this->setParameter('total_tax_amount', $amount);
    }
}
