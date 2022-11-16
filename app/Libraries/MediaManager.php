<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries;

class MediaManager
{
  public $config;
  public $limit;
  protected $client;

  public function connect($mid)
  {
    $this->config = config('MasterConfig')->media[$mid];
    $this->client = \Config\Services::curlrequest();
  }



  public function moveUploaded($directory, $name)
  {

    $file = file_get_contents($_FILES['file']['tmp_name']);

    $post = [
      'action' => 'upload',
      'file' => $file,
      'filename' => $name,
      'directory' => $directory
    ];



    return $this->request($post);
  }

  public function resize($directory, $filename, $newname, $replace, $width, $height, $x, $y)
  {

    $post = [
      'action' => 'resize',
      'directory' => $directory,
      'filename' => $filename,
      'newname' => $newname,
      'replace' => $replace,
      'width' => $width,
      'height' => $height,
      'x' => $x,
      'y' => $y
    ];
    return $this->request($post);
  }

  public function thumbs($directory, $files)
  {
    $post = [
      'action' => 'thumbs',
      'directory' => $directory,
      'files' => $files,
    ];
    return $this->request($post);
  }

  public function delete($directory, $filename)
  {
    $post = [
      'action' => 'deleteFile',
      'directory' => $directory,
      'filename' => $filename
    ];
    return $this->request($post);
  }

  public function deleteDirectory($directory)
  {
    $post = [
      'action' => 'deleteDirectory',
      'directory' => $directory,
    ];
    return $this->request($post);
  }

  public function getAllImages($directory)
  {
    $post = [
      'action' => 'listImages',
      'directory' => $directory
    ];


    return json_decode($this->request($post), true);
  }

  public function listAllFiles($directory)
  {
    $post = [
      'action' => 'listAll',
      'directory' => $directory
    ];

    return json_decode($this->request($post), true);
  }

  public function copyAllFiles($directory, $list)
  {
    $post = [
      'action' => 'copyRemote',
      'directory' => $directory,
      'list' => json_encode($list)
    ];

    return json_decode($this->request($post), true);
  }

  public function space($site)
  {

    $pricingModel = newModel('PricingModel');

    if (isset($site['type']) && $site['type'] == 2) {
      $limit = 1000;
    } else {
      $package = $pricingModel->where('id', $site['package'])->first();
      $limit = $package['space'];
    }

    $post = [
      'action' => 'space',
      'directory' => $site['directory']
    ];

    $result = json_decode($this->request($post), true);
    $used = !isset($result['used']) ? 0 : $result['used'];
    $full = isset($result['used']) && $result['used'] >= $limit ? true : false;
    $usedp = round($used / $limit * 100, 0);
    $usedp = $usedp > 100 ? 100 : $usedp;
    $used = round($used, 1);
    return ['allowed' => $limit, 'used' => $used, 'usedp' => $usedp, 'full' => $full];
  }

  public function setStatus($directory, $expire, $status)
  {
    $post = [
      'action' => 'setStatus',
      'directory' => $directory,
      'expire' => $expire,
      'status' => $status
    ];

    return json_decode($this->request($post), true);
  }

  public function setRequest($post)
  {
    return json_decode($this->request($post), true);
  }

  private function request($post)
  {
    $post['secret'] = $this->config['secret'];

    try {
      $request = $this->client->request('POST', $this->config['base'] . '/manager.php', ['form_params' => $post, 'http_errors' => false]);
    } catch (\Exception $e) {
      dlog($e->getMessage());
      return false;
    }

    return $request->getBody();
  }
}
