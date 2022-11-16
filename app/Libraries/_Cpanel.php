<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries\Panels;

class _Cpanel extends Cpanel
{
    public function listDns($data)
    {
        $args = [
            'domain' =>    $data['domain'],
        ];

        return $this->query('api2_query', ['', 'ZoneEdit', 'fetchzone_records', $args]);
    }
}
