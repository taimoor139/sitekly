<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Controllers;

class Preview extends BaseController
{
  public $FileManager;
  public $type;
  public $siteData;

  public function local($domain, $page = false, $subpage = false)
  {
    if (!$this->getSite($domain, 'local')) return $this->view404();
    $this->viewPage($page, $subpage);
  }

  public function project($directory, $page = false, $subpage = false)
  {
    if (!$this->getSite($directory, 'project')) return $this->view404();

    $this->viewPage($page, $subpage);
  }

  public function template($directory, $page = false, $subpage = false)
  {
    if (!$this->getSite($directory, 'template')) return $this->view404();
    $auth = newLib('Auth');

    if ($this->request->getVar('hashKey')) {
      $thumbGenerator = newLib('thumbGenerator');
      return $thumbGenerator->saveHeights($directory, $this->request->getVar('hashKey'), $this->request->getVar('heights'));
    }

    if ($this->siteData['status'] == 0  || $this->siteData['type'] == 2) {
      if (!$auth->isAdmin()) return redirect()->to(base_url());
    }



    $this->viewPage($page, $subpage);
  }

  public function builder($page = false, $subpage = false)
  {
    if (!$this->getSite('', 'builder')) return $this->view404();

    $this->viewPage($page, $subpage);
  }

  public function form($formid)
  {
    if (!$this->getSite('', 'builder')) return $this->view404();

    $settings = json_decode($this->FileManager->getFileContent('config/settings.json'), true);
    $formSettings = isset($settings['forms'][$formid]) ? $settings['forms'][$formid] : false;
    if (!$formSettings) return json_encode(['status' => 0, 'message' => $fail]);

    $success = !empty($formSettings['success']) ? $formSettings['success'] : lang('app.mail-form-success');
    $fail = !empty($formSettings['fail']) ? $formSettings['fail'] : lang('app.mail-form-fail');

    if (!isset($formSettings['mail'])) return json_encode(['status' => 0, 'message' => $fail]);

    $message = '';
    foreach ($_POST as $k => $v) {
      $message .= '<p><b>' . htmlspecialchars($k, ENT_QUOTES) . ':</b> ' . htmlspecialchars($v, ENT_QUOTES) . '</p>';
    }

    $mailData = [
      'sendTo' => $formSettings['mail'],
      'subject' => $formSettings['subject'],
      'message' => $message
    ];

    $mails = newLib('Mails');
    if ($mails->send($mailData)) {
      return  json_encode(['status' => 1, 'message' => $success]);
    }

    return  json_encode(['status' => 0, 'message' => $fail]);
  }

  public function localform($domain, $formid)
  {

    if (!$this->getSite($domain, 'local')) return $this->view404();

    $settings = json_decode($this->FileManager->getFileContent('config/settings.json'), true);
    $formSettings = isset($settings['forms'][$formid]) ? $settings['forms'][$formid] : false;
    if (!$formSettings) return json_encode(['status' => 0, 'message' => $fail]);

    $success = !empty($formSettings['success']) ? $formSettings['success'] : lang('app.mail-form-success');
    $fail = !empty($formSettings['fail']) ? $formSettings['fail'] : lang('app.mail-form-fail');

    if (!isset($formSettings['mail'])) return json_encode(['status' => 0, 'message' => $fail]);

    $message = '';
    foreach ($_POST as $k => $v) {
      $message .= '<p><b>' . htmlspecialchars($k, ENT_QUOTES) . ':</b> ' . htmlspecialchars($v, ENT_QUOTES) . '</p>';
    }

    $mailData = [
      'sendTo' => $formSettings['mail'],
      'subject' => $formSettings['subject'],
      'message' => $message
    ];

    $mails = newLib('Mails');
    if ($mails->send($mailData)) {
      return  json_encode(['status' => 1, 'message' => $success]);
    }

    return  json_encode(['status' => 0, 'message' => $fail]);
  }

  protected function viewPage($page = false, $subpage = false)
  {

    $page = ($subpage) ? $page . '/' . $subpage : $page;


    $pageData = $this->FileManager->getPage($page);


    if (!$pageData && $page != '404') return $this->view404();
    if (!$pageData) {
      $this->response->setStatusCode(404);
      echo getView('errors/html/error_404');
      return;
    }

    $data = [
      'key' => $pageData[0],
      'content' => $pageData[1]['content'],
      'fonts' => $this->FileManager->getFonts(),
      'type' => $this->type
    ];
    $meta = ['title', 'description', 'keywords', 'altlang'];
    foreach ($meta as $key) {
      $data['meta'][$key] = isset($pageData[1][$key]) ? $pageData[1][$key] : null;
    }

    $settings = json_decode($this->FileManager->getFileContent('config/settings.json'), true);

    $data['meta']['title'] .= (isset($settings['website']['title-suffix']) && $settings['website']['title-suffix'] == 1) ? ' - ' . $settings['website']['name'] : '';
    $data['meta']['favicon'] = !empty($settings['website']['src']) ? $settings['website']['src'] : null;

    if ($this->type == 'builder') {
      if (isset($pageData[1]['dynamic'])) {
        $data['content'] = $this->addDynamic($pageData[1]['content'], $pageData[1]['dynamic']);
      }
    }

    $data['basehref'] = $this->FileManager->previewUrl;
    $data['baseurl'] = $this->FileManager->baseurl;
    $data['editMode'] = false;

    $data['siteStyle'] = $data['basehref'] . '/style.css?v=' . hash('crc32',  @filemtime($this->FileManager->activePath . $this->siteData['styleFile']));


    echo getView('preview', $data);
  }

  public function getStyle($type, $site)
  {

    if (!$this->getSite($site, $type)) return $this->view404();

    $style = $this->FileManager->getFileContent($this->siteData['styleFile']);
    if (!$style) return $this->view404();


    $this->response->setCache(['max-age'  => 604800, 'private']);
    $this->response->setHeader('Content-type', 'text/css; charset: UTF-8');

    return $style;
  }

  protected function getSite($site, $type)
  {

    if (!in_array($type, ['local', 'project', 'template', 'builder'])) return false;

    $styleFiles = [
      'local' => 'style.css',
      'project' => 'style.css',
      'template' => 'themeconfig/style.css',
      'builder' => 'style.css'
    ];

    if ($type == 'project') {
      $model = newModel('SiteModel');
      $project = $model->where(['directory' => $site])->first();
    } else if ($type == 'local') {
      $model = newModel('SiteModel');
      $project = $model->where(['domain' => $site])->first();
      if ($project && $project['expire'] < time()) {
        die('Expired');
      }
    } else if ($type == 'builder') {
      $model = newModel('TemplateModel');
      $project = $model->where(['type' => '2', 'status' => '1'])->first();
      $project['directory'] = $project['id'];
    } else {
      $model = newModel('TemplateModel');
      $project = $model->where(['id' => $site])->first();
      $project['directory'] = $project['id'];
    }
    if (!$project) return false;
    $project['styleFile'] = $styleFiles[$type];
    $this->type = $type;
    $this->siteData = $project;

    $this->FileManager = newLib('FileManager');
    return $this->FileManager->setPath($type, $project['directory']);
  }


  public function view404()
  {
    $this->response->setStatusCode(404);
    return $this->builder('404');
  }


  protected function addDynamic($content, $config)
  {

    if (isset($config['templates']) && count($config['templates']) != 0) {
      $model = newModel('TemplateModel');
      $SettingsModel = newModel('SettingsModel');
      helper(['form']);

      $auth = newLib('Auth');
      if ($auth->isAdmin()) {
        $templates = $model->orderBy('id', 'DESC')->findAll();
      } else {
        $templates = $model->where(['status' => '1', 'type' => '1'])->orderBy('id', 'DESC')->findAll();
      }

      $bkey = array_search('f930533257d79378', array_column($templates, 'uid'));
      $blank = $templates[$bkey];
      unset($templates[$bkey]);
      array_unshift($templates, $blank);


      $modelData = [];
      $modelData['templates'] = $model->TemplatesData($templates);
      $modelData['categories_all'] = array_merge(['' => lang('app.choose-category')], $SettingsModel->getOption('template_categories_all', true));
      $modelData['categories'] = $SettingsModel->getOption('template_categories', true) ?? [];

      foreach ($config['templates'] as $k => $data) {
        $data = json_decode($data, true);

        if ($filterCat = $this->request->getPost('templatecategoryselect')) {
          foreach ($modelData['categories'] as $cth => $cats) {
            if (in_array($filterCat, $cats)) {
              $bkey = array_search($cth, array_column($modelData['templates'], 'id'));
              $modelData['list'][] = $modelData['templates'][$bkey];
            }
          }
        } else if (isset($data['filter'])) {
          foreach ($data['filter'] as $id) {
            $bkey = array_search($id, array_column($modelData['templates'], 'id'));
            $modelData['list'][] = $modelData['templates'][$bkey];
          }
        } else {
          $modelData['list'] = $modelData['templates'];
        }


        $replace = getView('buildersite/' . $data['view'], $modelData);
        $content = str_replace($k, $replace, $content);
      }
    }

    if (isset($config['pricing']) && count($config['pricing']) != 0) {

      $model = newModel('PricingModel');
      $viewdata = [];
      $viewdata['pricing'] = $model->where('id!=', '1')->findAll();


      foreach ($config['pricing'] as $k => $data) {
        $data = json_decode($data, true);

        $replace = getView('buildersite/' . $data['view'], $viewdata);
        $content = str_replace($k, $replace, $content);
      }
    }

    return $content;
  }


  //--------------------------------------------------------------------

}
