<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate;

final class Address extends \ArrayObject
{
    /**
     * @param array $data
     *
     * @return Address
     */
    public static function fromArray(array $data): Address
    {
        $defaults = [
            'id' => null,
            'hash' => null,
            'version' => null,
            'client' => null,
            'language' => null,
            'serverdata' => null,
            'time' => null,
            'test' => null,
        ];

        return new self(\array_merge($defaults, \array_intersect_key($data, $defaults)));
    }
}
