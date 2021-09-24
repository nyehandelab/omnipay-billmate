<?php
declare(strict_types=1);

namespace Nyehandel\Omnipay\Billmate;

use Nyehandel\Omnipay\Billmate\Message\AbstractRequest;

final class AuthenticationRequestHeaderProvider
{
    public function getHeaders(AbstractRequest $request): array
    {
        return [
            'Authorization' => sprintf(
                'Basic %s',
                base64_encode(
                    sprintf(
                        '%s:%s',
                        $request->getUsername(),
                        $request->getSecret()
                    )
                )
            ),
        ];
    }
}
