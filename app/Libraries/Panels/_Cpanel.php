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

        $result = $this->query2('api2_query', ['', 'ZoneEdit', 'fetchzone_records', $args]);
        return isset($result['cpanelresult']['data']) ? $result['cpanelresult']['data'] : false;
    }
    public function adddns($args)
    {

        return $this->query2('api2_query', ['', 'ZoneEdit', 'add_zone_record', $args]);
    }
    public function editdns($args)
    {

        return $this->query2('api2_query', ['', 'ZoneEdit', 'edit_zone_record', $args]);
    }

    public function removedns($args)
    {
        return $this->query2('api2_query', ['', 'ZoneEdit', 'remove_zone_record', $args]);
    }

    protected function query2($method, $args)
    {

        return json_decode(call_user_func_array([$this->panel, $method], $args), true);
    }
}
