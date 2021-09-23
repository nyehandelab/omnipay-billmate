<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate;

final class WidgetOptions extends \ArrayObject
{
    /**
     * @param array $data
     *
     * @return WidgetOptions
     */
    public static function fromArray(array $data): WidgetOptions
    {
        $defaults = [
            'logo' => null,
        ];

        return new self(array_merge($defaults, array_intersect_key($data, $defaults)));
    }
}
