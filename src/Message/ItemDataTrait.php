<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate\Message;

use Money\Money;
use Nyehandel\Omnipay\Billmate\ItemBag;

trait ItemDataTrait
{
    /**
     * @param ItemBag $items
     *
     * @return array[]
     */
    public function getItemData(ItemBag $items): array
    {
        $orderLines = [];

        foreach ($items as $item) {

            $totalAmount = ($item->getQuantity() * $item->getPrice()) - $item->getTotalDiscountAmount();
            $orderLines[] = [
                'artnr' => $item->getName(),
                'title' => $item->getDescription(),
                'quantity' => $item->getQuantity(),
                'aprice' => $item->getPrice(),
                'discount' => $item->getDiscount(),
                'withouttax' => $totalAmount,
                'taxrate' => (int) $item->getTaxRate(),
            ];
        }

        return $orderLines;
    }

    abstract protected function convertToMoney($amount): Money;
}
