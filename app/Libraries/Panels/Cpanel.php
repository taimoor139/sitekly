<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries\Panels;

class Cpanel
{
  protected $panel;
  protected $config;

  public function connect($config, $port = false)
  {
    $this->config = $config;
    $host = preg_replace("#^[^:/.]*[:/]+#i", "", $config['panel_host']);
    $this->panel = new \App\ThirdParty\xmlapi($host);
    $this->panel->set_output('json');
    $this->panel->set_port($config['port']);
    $this->panel->password_auth($config['login'], $config['password']);

    //  $this->panel->set_debug(1);

  }

  public function addUser($data)
  {
    $args = [
      'username' => $data['username'],
      'password' => $data['password'],
      'domain' => $data['domain'],
      'plan' => $this->config['package'],

    ];
    return $this->query('createacct', [$args]);
  }

  public function deleteUser($data)
  {


    return $this->query('removeacct', [$data['username']]);
  }


  public function changeDomain($old_domain, $new_domain, $login)
  {
    $args = [
      'domain' => $new_domain
    ];

    return $this->query('modifyacct', [$login, $args]);
  }

  public function addEmail($data)
  {
    $args = [
      'domain' =>  $data['domain'],
      'email' =>  $data['name'],
      'password' => $data["pass"],
      'quota' => '0'
    ];

    return $this->query('api2_query', ['', 'Email', 'addpop', $args]);
  }
  public function changeEmail($data)
  {
    $args = [

      'domain' =>      $data['domain'],
      'email' => $data['name'],
      'password' =>  $data['newpassword'],

    ];

    return $this->query('api2_query', ['', 'Email', 'passwdpop', $args]);
  }

  public function deleteEmail($data)
  {
    $args = [

      'email' =>      $data['name'],
      'domain' =>     $data['domain'],

    ];

    return $this->query('api2_query', ['', 'Email', 'delpop', $args]);
  }

  public function getdocroots()
  {
    return json_decode($this->panel->api2_query('', 'DomainLookup', 'getdocroots'), true);
  }

  public function getdocroot($domain)
  {
    return json_decode($this->panel->api2_query('', 'DomainLookup', 'getdocroot', ['domain' => $domain]), true);
  }

  public function testUser()
  {
    $result = $this->getdocroots();
    if (isset($result['cpanelresult']['data'][0]['domain'])) return true;
  }

  public function listDomains()
  {
    $result = $this->getdocroots();
    if (!is_array($result['cpanelresult']['data'])) return false;
    $return = [];
    foreach ($result['cpanelresult']['data'] as $data) {
      $return[] = $data['domain'];
    }
    return $return;
  }


  protected function query($method, $args)
  {

    $result = json_decode(call_user_func_array([$this->panel, $method], $args), true);

    var_dump($result);

    if (isset($result['cpanelresult'])) {

      $status = $result['cpanelresult']['data'][0]['result'];
      $error = $result['cpanelresult']['data'][0]['reason'];
    } else if (isset($result['result'])) {
      $status = $result['result'][0]['status'];
      $error = $result['result'][0]['statusmsg'];
    } else {
    }


    if ($status != '1') {
      return ['error' => $error];
    } else {
      return true;
    }
  }
}
