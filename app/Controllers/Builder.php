<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Controllers;

use App\Libraries\Builder\Widgets;

class Builder extends BaseController
{
  private $widgets;
  private $SiteData;
  private $FileManager;
  protected $themeMedia = 'default';

  protected $widgetList = [
    'block', 'slider', 'col', 'container', 'menu', 'title', 'paragraph', 'divider', 'button', 'cform', 'img', 'icon', 'iconlist', 'iconbox', 'imagebox', 'video',
    'gallery', 'carousel', 'map', 'accordion', 'social-buttons', 'custom-code'
  ];

  protected $atts_allowed = ["class", "id", "style", "href", "src", "alt", "action", "method", "name", "required", "type", "placeholder", "value", "allow", "allowfullscreen", "width", "height", "frameborder", "scrolling", "marginheight", "marginwidth"];
  protected $tags_remove = ['script'];

  public function index()
  {
    if (!$this->getSite()) return namedRedirect('dashboard');
    if ($this->request->getPost('site')) return namedRedirect('builder');

    $this->widgets = newLib('Builder/Widgets');

    $data = $this->commonData();
    $data['site'] = $this->SiteData;
    $data['site']['hasDraft'] = $this->FileManager->isFile('/draft/style.css');
    $data['site']['isDraft'] = ($this->request->getPost('draft') && $data['site']['hasDraft']) ? true : false;
    $data['sitedata'] = $this->siteres($data['site']['isDraft']);
    $data['js'] = $this->js();
    $data['css'] = $this->css();
    $data['images'] = $this->siteImages();
    $data['icons'] = $this->icons();
    $data['widgets'] = $this->widgetSelect();
    $data['widgetControl'] = $this->widgetControl();
    $data['context'] = $this->contextMenu();
    $data['exports'] = $this->getExports();

    echo getView('builder', $data);
  }


  public function frame()
  {
    if (!$this->getSite()) return $this->view404();
    $data = [];


    $data['basehref'] = $this->SiteData['siteUrl'];
    $data['baseurl'] = base_url();
    $data['meta'] = array('title' => '', 'description' => '', 'keywords' => '');
    $data['content'] = '';
    $data['editMode'] = true;
    $data['fonts'] = $this->FileManager->getFonts();

    echo getView('preview', $data);
  }
  public function lang()
  {
    $this->response->setContentType('text/javascript');
    $lang = lang('app.js');
    $lang['tour'] = lang('editorTour.js');
    return 'lang=' . json_encode($lang);
  }


  public function import()
  {
    if (!$this->getSite()) return $this->view404();

    $model = newModel('TemplateModel');
    $template = $model->where(['status' => '1', 'id' => $this->request->getPost('id')])->first();
    if (!$template) return 'no_theme';

    $this->FileManager->setPath('template', $template['id']);


    $sid = $this->request->getPost('sectionID');
    $pid = $this->request->getPost('pageID');

    if (isset($sid)) {
      $sid = (int)$_POST['sectionID'];
      $sections = json_decode($this->FileManager->getFileContent('themeconfig/exports/sections.json'), true);

      if ($sections && $sections[$sid]) return $this->importer($template['id'], $sections[$sid]);

      return 'error';
    } else if (isset($pid)) {

      $pid = $_POST['pageID'];
      $pages = json_decode($this->FileManager->getFileContent('themeconfig/exports/pages.json'), true);
      if ($pages && $pages[$pid]) return $this->importer($template['id'], $pages[$pid]);

      return 'error';
    }
  }


  protected function importer($template, $data)
  {
    helper('text');

    $MediaManager = newLib('MediaManager');
    $MediaManager->connect($this->themeMedia);
    if ($MediaManager->space($this->SiteData)['full'] && !$this->SiteData['isBuilderTheme']) return json_encode(['error' => lang('app.disk-full')]);

    $oldBase = $MediaManager->config['base'] . '/' . $template . '/';

    $MediaManager->connect($this->SiteData['media']);
    $newBase = $MediaManager->config['base'] . '/' . $this->SiteData['directory'] . '/';


    $selectors = $data['selectors'];
    unset($data['selectors']);
    foreach ($selectors as $selector) {
      $nsel = "s-" . strtolower(random_string('alnum', 8));
      foreach ($data as &$val) {
        $val = str_replace($selector, $nsel, $val);
      }
    }

    $filenames = [];
    $fontnames = [];
    foreach ($data as $k => &$value) {
      preg_match_all('/' . preg_quote($oldBase, '/') . '(.+)[\'"]/U', $value, $images);
      $filenames = array_merge($filenames, $images[1]);
      preg_match_all('/font-family: (.+);/U', $value, $fonts);
      $fontnames = array_merge($fontnames, $fonts[1]);
      $value = str_replace($oldBase, $newBase, $value);
    }
    $data['images'] = $filenames = array_unique($filenames);
    $data['fonts'] = array_unique($fontnames);
    $data['base'] = $newBase;


    foreach ($data['images'] as $filename) {
      $filenames[] = 'systhumb/' . $filename;
    }

    $list = [
      'files' => $filenames,
      'base' => $oldBase,
      'dirs' => ['systhumb']
    ];

    $MediaManager->copyAllFiles($this->SiteData['directory'], $list);

    return json_encode($data);
  }

  public function upload()
  {


    if (!$this->getSite()) return $this->view404();

    if ($img = $this->request->getFile('file')) {

      $manager = newLib('MediaManager');
      $manager->connect($this->SiteData['media']);


      if ($manager->space($this->SiteData)['full'] && !$this->SiteData['isBuilderTheme']) return json_encode(['error' => lang('app.disk-full')]);


      if ($img->isValid() && !$img->hasMoved()) {
        $rules = [
          'file' => 'uploaded[file]|max_size[file,5000]|ext_in[file,png,jpg,jpeg,gif]|is_image[file]|mime_in[file,image/jpg,image/jpeg,image/gif,image/png]'
        ];
        $errors = [
          'file' => [
            'ext_in' => lang('Validation.is_image', ['field' => 'file']),
            'mime_in' => lang('Validation.is_image', ['field' => 'file'])
          ]
        ];
        if (!$this->validate($rules, $errors)) {
          return json_encode(['error' => $this->validator->getError('file')]);
        }


        helper('text');
        if ($this->request->getPost('update')) {
          $name = $this->request->getPost('update');
        } else {
          $name = $img->getRandomName(false, 20);
        }

        return $manager->moveUploaded($this->SiteData['directory'], $name);
      }
    }
  }


  public function imgedit()
  {

    if (!$this->getSite()) return $this->view404();

    $rules = [
      'action' => 'required',
      'file' => 'required|valid_url',
      'width' => 'required|integer'
    ];

    if (!$this->validate($rules)) {
      return 'validation fail';
    }

    $manager = newLib('MediaManager');
    $manager->connect($this->SiteData['media']);

    if ($manager->space($this->SiteData)['full'] && !$this->SiteData['isBuilderTheme']) return json_encode(['error' => lang('app.disk-full')]);


    $pathinfo = pathinfo($this->request->getPost('file'));
    $filename = $pathinfo['basename'];
    if (empty($filename)) return 'wrong file';

    helper('text');

    $newname = time() . '_' . bin2hex(random_bytes(10)) . '.' . $pathinfo['extension'];

    $replace = $this->request->getPost('action') == 'update' ? true : false;

    return $manager->resize($this->SiteData['directory'], $filename, $newname, $replace, $this->request->getPost('width'), $this->request->getPost('height'), $this->request->getPost('x'), $this->request->getPost('y'));
  }


  public function delete()
  {
    if (!$this->getSite()) return $this->view404();

    $manager = newLib('MediaManager');
    $manager->connect($this->SiteData['media']);

    $pathinfo = pathinfo($this->request->getPost('file'));
    $filename = $pathinfo['basename'];
    if (empty($filename)) return 'wrong file';


    return $manager->delete($this->SiteData['directory'], $filename);
  }
  public function token()
  {
    $data = ['name' => csrf_token(), 'value' => csrf_hash()];
    return $this->response->setJSON($data);
  }
  public function publish()
  {

    function geterateCss($data)
    {
      $own = json_decode($data, true);
      return $own['lg'] . '@media only screen and (max-width: 75em) {' . $own['md'] . '}@media only screen and (max-width: 62em) {' . $own['sm'] . '}@media only screen and (max-width: 48em) {' . $own['xs'] . '}';
    }


    $returnData = [];
    if (!$this->getSite()) return $this->view404();
    $SiteData = $this->SiteData;


    $data = [
      'pages' => ["pages", 'config/', 'json'],
      'settings' => ["settings", 'config/', 'json'],
      'ostyle' => ["styles", 'config/', 'json'],
      'globals' => ["globals", 'config/', 'json'],
      'allmenus' => ["allmenus", 'config/', 'html'],
      'fonts' => ["fonts", 'config/', 'json'],
    ];

    if ($SiteData['isTheme']) {
      $themeData = [
        'ostylefull' => ["styles", 'themeconfig/data/', 'json'],
        'pagesfull' => ["pages", 'themeconfig/data/', 'json'],
        'fontsfull' => ["fonts", 'themeconfig/data/', 'json'],
        'sections' => ["sections", 'themeconfig/exports/', 'json'],
        'epages' => ["pages", 'themeconfig/exports/', 'json']
      ];


      if ($SiteData['isBuilderTheme']) {
        $themeData['dynamicpages'] = ["dynamicpages", 'themeconfig/data/', 'json'];
      }

      $data = array_merge($data, $themeData);
    }

    $draft = $this->request->getPost('draft') == 'true' ? true : false;

    $post = [];
    foreach ($data as $key => $config) {
      if (!$this->request->getPost($key)) return 'inc-data' . $key;
      $post[$key] =  $this->request->getPost($key);
    }

    $data['style']  = ["style", '', 'css'];
    $post['style'] = geterateCss($post['ostyle']);
    if ($SiteData['isTheme']) {
      cache()->delete('exports');
      $data['stylefull']  = ["style", 'themeconfig/', 'css'];
      $post['stylefull'] = geterateCss($post['ostylefull']);

      if (!$SiteData['isBuilderTheme']) {
        $data['dynamicpages'] = ["dynamicpages", 'themeconfig/data/', 'json'];
        $post['dynamicpages'] = $post['pages'];
      }

      $draftDirs = ['draft', 'draft/config', 'draft/themeconfig', 'draft/themeconfig/data', 'draft/themeconfig/exports'];
      foreach ($draftDirs as $dir) {
        if (!is_dir($this->FileManager->activePath . $dir)) {
          mkdir($this->FileManager->activePath . $dir);
        }
      }
    }

    $size =  strlen(serialize((array)$post)) / 1000000;
    if ($size > 10) {
      return ['error' => 'size fail'];
    }

    foreach ($data as $key => $config) {

      $name = $config[0];
      $dir = $draft ? 'draft/' . $config[1] : $config[1];

      $ext = $config[2];

      $content = preg_replace('/\s+/', ' ', $post[$key]);
      $content = preg_replace('/<\\?.*(\\?>|$)/Us', '', $content);

      if ($key == 'pages') {
        $content = json_decode($content, true);

        foreach ($content as $k => $d) {
          $content[$k]['content'] = $this->sanitize_html($d['content']);
        }

        $content = json_encode($content);
      }

      if (!$this->FileManager->setFileContent($dir . $name . "." . $ext, $content)) {

        $returnData['error'][] = 'Unable to save ' . $key;
      }
    }

    $Mediamanager = newLib('MediaManager');
    $Mediamanager->connect($SiteData['media']);
    $Mediamanager->thumbs($SiteData['directory'], $this->request->getPost('thumbs'));

    if (!$draft) {
      $thumbGenerator = newLib('thumbGenerator');
      if ($SiteData['isTheme'] && $this->request->getPost('thumb') != 'false') {
        $tg =  $thumbGenerator->generateThumbs($post['pagesfull'], $post['sections'], $SiteData['directory']);
        if (isset($tg['error'])) {
          $returnData['error'][] = $tg['error'];
        }
      } else if (!$SiteData['isTheme']) {

        if (function_exists('exec')) {
          $tasks = newLib('Tasks');
          $tasks->run('main_thumb', $SiteData['directory']);
        } else {
          $thumbGenerator->generateMain($SiteData['directory']);
        }
      }
    }

    if (!$draft && !empty($SiteData['panel_login'])) {
      $RemoteFileManager = newLib('RemoteFileManager');
      $RemoteFileManager->init($SiteData['id']);
      $RemoteFileManager->updateSite();
    }

    $returnData['status'] = isset($returnData['error']) ? lang('app.update-fail') : lang('app.update-success');

    return $this->response->setJSON($returnData);
  }

  protected function sanitize_html($html)
  {
    if (empty($html)) {
      return "";
    }
    $dom = new \DOMDocument;
    $mock = new \DOMDocument;
    libxml_use_internal_errors(true);
    $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    libxml_use_internal_errors(false);
    $nodes = $dom->getElementsByTagName('*');

    foreach ($nodes as $node) {

      if ($node->hasAttributes()) {
        foreach ($node->attributes as $attr) {
          $name = $attr->nodeName;
          if (substr($name, 0, 5) === "data-") {
          } else {
            if (!in_array($name, $this->atts_allowed)) {

              $node->removeAttribute($name);
            }
          }
        }
      }


      foreach ($this->tags_remove as $tag) {
        if ($node->nodeName == $tag) {
          $node->parentNode->removeChild($node);
        }
      }
    }


    $body = $dom->getElementsByTagName('body')->item(0);
    foreach ($body->childNodes as $child) {
      $mock->appendChild($mock->importNode($child, true));
    }

    return $mock->saveHTML();
  }


  protected function siteres($draft)
  {
    $SiteData = $this->SiteData;
    $draftDir = $draft ? 'draft/' : '';

    $data = ['js' => '', 'html' => ''];
    $json = [
      'globalSettings' => 'config/settings.json',
      'globals' => 'config/globals.json',
    ];
    $html = [
      'menus' => 'config/allmenus.html'
    ];
    $string = [
      'siteId' => $SiteData['siteid'],
      'siteBase' => $SiteData['siteUrl'],
      'mediaDir' => $SiteData['directory'],
      'activeWidgets' => $this->privileges->getGroup('widgets_allowed')
    ];

    $json['opages'] = ($SiteData['isTheme']) ? 'themeconfig/data/pages.json' : 'config/pages.json';


    foreach ($json as $k => $file) {
      $content = $this->FileManager->getFileContent($draftDir . $file);


      if (!$content) return false;
      $data['js'] .= $k . '= JSON.parse(' . json_encode($content) . ');';
    }

    foreach ($html as $k => $file) {
      $content = $this->FileManager->getFileContent($draftDir . $file);

      if (!$content) return false;
      $data['js'] .= $k . '="' . htmlspecialchars($content) . '";';
    }

    foreach ($string as $k => $v) {
      if (is_array($v)) {
        $data['js'] .= $k . '=' . json_encode($v) . ';';
      } else {
        $data['js'] .= $k . '="' . $v . '";';
      }
    }

    $ownCss = ($SiteData['isTheme']) ? 'themeconfig/data/styles.json' : 'config/styles.json';
    $content = $this->FileManager->getFileContent($draftDir . $ownCss);

    if (!$content) return false;
    $ownCss = json_decode($content, true);

    $data['html'] .= '
   <div class="astylec">
      <style class="astyles" id="lg">' . $ownCss['lg'] . '</style>
      <style class="astyles" id="md">' . $ownCss['md'] . '</style>
      <style class="astyles" id="sm">' . $ownCss['sm'] . '</style>
      <style class="astyles" id="xs">' . $ownCss['xs'] . '</style>
    </div>
   ';

    $fonts = $this->gfontList(200);
    $data['html'] .= $fonts['html'];
    $data['js'] .= "gfonts = JSON.parse('" . $fonts['json'] . "');";


    return $data;
  }

  protected function getSite()
  {



    $siteid = $this->request->getPost('site') ? $this->request->getPost('site') : $this->session->get('site');
    if (!$siteid) return false;
    $auth = newLib('Auth');

    if (!$auth->isAdmin()) {
      $this->privileges->extendBySite($siteid);
    }

    if (!$this->privileges->can('site_edit')) return false;

    $adminMode = $this->request->getPost('admin_mode') ? $this->request->getPost('admin_mode') : $this->session->get('adminMode');

    if ($auth->isAdmin() && $adminMode == 'true') {
      if (!$this->privileges->can('admin_sites_manage')) return false;

      $model = newModel('SiteModel');
      $siteRow = $model->where(['id' => $siteid])->first();
      if (!$siteRow) return false;
    } else if ($auth->isAdmin()) {
      $model = newModel('TemplateModel');
      $template = $model->where(['id' => $siteid])->first();
      if (!$template) return false;

      if (!$this->privileges->can('edit', 'admin_templates')) return false;
      if ($template['type'] == 2 && !$this->privileges->can('builder_templates', 'admin_templates')) return false;


      $this->FileManager = newLib('FileManager');
      $this->FileManager->setPath('template', $template['id']);
      $data = $template;
      $data['isTheme'] = true;
      $data['isBuilderTheme'] = ($template['type'] == 2) ? true : false;
      $data['directory'] = $template['id'];
      $data['package'] = 1;
      $data['media'] = $this->themeMedia;
      $data['siteUrl'] = $this->FileManager->previewUrl;
    } else {
      $model = newModel('SiteModel');
      $siteRow = $model->getMySite($siteid);
      if (!$siteRow) return false;
    }

    if (isset($siteRow)) {
      $this->FileManager = newLib('FileManager');
      $this->FileManager->setPath('project', $siteRow['directory']);
      $data = $siteRow;
      $data['isTheme'] = false;
      $data['isBuilderTheme'] = false;
      $data['siteUrl'] = $this->FileManager->previewUrl;
    }


    $data['siteid'] = $siteid;
    $this->session->set('site', $siteid);
    $this->session->set('adminMode', $adminMode);
    $this->SiteData = $data;

    return true;
  }



  protected function siteImages()
  {

    $data = '';
    $manager = newLib('MediaManager');
    $manager->connect($this->SiteData['media']);

    $images = $manager->getAllImages($this->SiteData['directory']);


    if ($images && isset($images['links'])) {
      foreach ($images['links'] as $k => $params) {
        $data .= '<div class="myimages" data-width="' . $params['width'] . '" data-size="' . $params['size'] . '" src="' . $params['file'] . '" style="background-image:url(\'' . $params["thumb"] . '\')"></div>';
      }
    } else if (isset($images['error'])) {
      dlog("media " . $this->SiteData['media'] . " " . $images['error']);
    }

    return $data;
  }

  protected function icons()
  {
    $icons = json_decode(file_get_contents("editor/lineawesome.json"), true);
    $data = '';
    foreach ($icons as $icon) {
      $name = str_replace("-", " ", explode(" la-", $icon)[1]);
      $data .= '<div class="fa-icon"><i class="' . $icon . '"></i><span>' . $name . '</span></div>';
    }
    return $data;
  }


  protected function js()
  {

    $appPath = 'editor/js/app.js';
    //$devMode = (ENVIRONMENT == 'development') ? true : false;
    $devMode = (CI_DEBUG) ? true : false;
    $buildReady = is_file($appPath) ? true : false;
    $data = "";
    if ($devMode || !$buildReady) {

      $all = [
        'template/js' => ['jquery', 'jquery-ui.min', 'jquery.ui.touch-punch.min'],
        'editor/js' => [
          'jquery.form', 'editor', 'helpers', 'functions', 'getstyle', 'setstyle', 'template', 'video', 'global-design', 'publish_cleanup_html', 'filters', 'pages', 'globals',
          'menu', 'slider', 'map', 'accordion', 'imgcrop', 'tour'
        ],
        'editor/vendor' => [
          'jquery.dnd_page_scroll', 'spectrum/spectrum', 'fontselect/fontselect', 'bselect/jquery.bselect', 'dropzone/dist/dropzone', 'rcrop/dist/rcrop.min', 'tinytour/tour.min'
        ],
        'editor/vendor/codemirror' => [
          'lib/codemirror', 'addon/edit/closetag', 'addon/fold/xml-fold', 'mode/xml/xml', 'mode/css/css', 'mode/htmlmixed/htmlmixed',
          'addon/selection/active-line', 'addon/selection/active-line', 'addon/edit/closebrackets',
        ]
      ];

      $app = '';
      foreach ($all as $dir => $files) {
        foreach ($files as $file) {
          if ($devMode) {
            $data .= '<script src="' . base_url_versioned($dir . '/' . $file . '.js') . '"></script>';
          } else {
            $app .= ";\n" . file_get_contents($dir . '/' . $file . '.js');
          }
        }
      }

      if (!$devMode) {
        $app = \App\Libraries\Builder\Minifier::minify($app);
        file_put_contents($appPath, $app);
      }
    }

    if (!$devMode) {
      $data .= '<script src="' . base_url_versioned($appPath) . '"></script>';
    }
    if ($devMode && $buildReady) {
      unlink($appPath);
    }

    if ($this->SiteData['isTheme']) {
      $data .= '<script src="' . base_url_versioned('editor/js/template-dev.js') . '"></script>';
    }
    if ($this->SiteData['isBuilderTheme']) {
      $data .= '<script src="' . base_url_versioned('editor/js/dynamic-widgets.js') . '"></script>';
    }

    $data .= '<script src="' . namedRoute('builder/lang') . '"></script>';

    $data .= '<script src="' . base_url_versioned('editor/vendor/tinymce/tinymce.min.js') . '"></script>';
    $data .= '<script src="' . base_url_versioned('custom/js/editor.js') . '"></script>';

    return $data;
  }


  protected function css()
  {
    $appPath = 'editor/css/app.css';
    // $devMode = (ENVIRONMENT == 'development') ? true : false;
    $devMode = (CI_DEBUG) ? true : false;
    $buildReady = is_file($appPath) ? true : false;

    if ($devMode || !$buildReady) {
      $data = "";
      $all = [
        'editor' => ['css/style'],
        'editor/vendor' => ['spectrum/spectrum', 'fontselect/fontselect', 'bselect/bselect', 'dropzone/dist/dropzone', 'codemirror/lib/codemirror', 'rcrop/dist/rcrop.min', 'tinytour/tour.min'],
      ];
      $app = '';
      foreach ($all as $dir => $files) {
        foreach ($files as $file) {
          if ($devMode) {
            $data .= '<link href="' . base_url_versioned($dir . '/' . $file . '.css') . '" rel="stylesheet" type="text/css" />';
          } else {
            $app .= file_get_contents($dir . '/' . $file . '.css');
          }
        }
      }

      if (!$devMode) {
        file_put_contents($appPath, $app);
      }
    }

    if ($devMode && $buildReady) {
      unlink($appPath);
    }

    if (!$devMode) {
      $data .= '<link href="' . base_url_versioned($appPath) . '" rel="stylesheet" type="text/css" />';
    }
    $data .= '<link href="' . base_url_versioned('template/font-awesome/css/all.min.css') . '" rel="stylesheet" type="text/css" />';
    $data .= '<link href="' . base_url_versioned('template/line-awesome/1.3.0/css/line-awesome.min.css') . '" rel="stylesheet" type="text/css" />';
    $data .= '<link href="' . base_url_versioned('custom/css/editor.css') . '" rel="stylesheet" type="text/css" />';
    return $data;
  }

  protected function gfontList(int $limit)
  {
    $fontsKey = config('MasterConfig')->fontsKey;
    $url = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=' . $fontsKey;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

    $out = json_decode($output, true);
    if (isset($out['error'])) {
      dlog("fonts: " . $out['error']['message']);
      return ["html" => "", "json" => "{}"];
    }
    $i = 0;
    foreach ($out['items'] as $item) {
      if (!in_array('latin-ext', $item['subsets'])) {
        continue;
      }
      if ($i++ == $limit)
        break;

      $variants = array();
      foreach ($item['variants'] as $variant) {
        if (is_numeric($variant)) {
          $variants[$variant] = array();
        } else if ($variant == "regular") {
          $variants['400'] = array();
        } else if ($variant == "italic") {
          $variants['400'][] = 'i';
        } else {
          $re = '/([0-9]+)([a-z]+)/m';
          preg_match_all($re, $variant, $matches, PREG_SET_ORDER, 0);
          if (count($matches[0]) == 3) {

            if ($matches[0][2] == 'italic') {
              $variants[$matches[0][1]][] = 'i';
            }
          }
        }
      }

      $fonts[$item['family']] = array(
        "category" => $item['category'],
        'variants' => $variants
      );
    }


    $gfobj = [];
    $returnData = ['html' => '', 'json' => ''];
    $gflist = '';
    $fonts = array_chunk($fonts, ceil(count($fonts) / 2), true);
    foreach ($fonts as $part => $gfp) {
      $agf = [];
      foreach ($gfp as $name => $data) {

        $agf[] = $name;
        $gflist .= '<li style="font-family:' . $name . '">' . $name . '</li>';

        $gfobj[$name] = implode(",", array_keys($data['variants']));
      }
      $agf = implode("|", $agf);

      $returnData['html'] .= '<link class="gfp" href="https://fonts.googleapis.com/css?family=' . urlencode($agf) . '&display=swap&text=abcdefghijklmnopqrstuvwxyz" rel="stylesheet" type="text/css">';
    }
    $returnData['html'] .= '<ul class="gflist custom-select">' . $gflist . '</div>';
    $returnData['json'] = json_encode($gfobj);


    return $returnData;
  }


  protected function widgetSelect()
  {
    $addels = $this->widgetList;

    $privileges = $this->privileges->getRoleConfig();

    if ($this->SiteData['isBuilderTheme']) {
      $addels[] = 'dynamic-widget';
    }

    $data = '';
    foreach ($addels as $addel) {
      //  if (!in_array($addel, $privileges['widgets_allowed'])) continue;
      $widget = $this->widgets->widgets_config[$addel];
      if ($widget['html']) {
        $widget['html'] = htmlspecialchars($widget['html'], ENT_QUOTES);

        $data .= '<div class="z-elad ' . $widget['name'] . '" data-code="' . $widget['html'] . '">' . $widget['label'] . '</div>';
      }
    }
    return $data;
  }


  protected function widgetControl()
  {
    ob_start();
    $this->widgets->buildAll();
    return ob_get_clean();
  }


  protected function getExports()
  {

    $exportsLib = newLib('Exports');
    $exports = $exportsLib->getExports();
    $themeKeys = array_keys($exports['themes']);
    $return = ['pages' => '', 'sections' => ''];
    foreach ($exports['pages'] as $key => $data) {
      if ($key == 0) continue;
      $tid = array_search($data['themeName2'], $themeKeys);
      $return['pages'] .=
        '<div data-params=\'' . json_encode($data) . '\'  class="con isection">
                 <div class="thumb" style="background-image:url(\'thumbs/' . $data['id'] . '/pages/600/' . $data['pageID'] . '.png\')"></div>
                 <div class="desc">#' . $tid . ' ' . $exports['localized']['themes'][$data['themeName2']] . " - " . $exports['localized']['pageCategories'][$data['pageName']] . '</div></div>';
    }


    foreach ($exports['sections'] as $key => $data) {
      $return['sections'] .=
        '<div data-params=\'' . json_encode($data) . '\' class="con isection">
                 <div class="thumb"><img class="delaysrc" dsrc="thumbs/' . $data['id'] . '/sections/600/' . $data['sectionID'] . '.png"/></div>
                 <div class="desc">' . $exports['localized']['sectionCategories'][$data['sectionCategory']] . '</div></div>';
    }

    $return = array_merge($exports, $return);

    return $return;
  }




  protected function contextMenu()
  {
    $data = '
    <div class="z-tool z-style"><i class="fas fa-pen" aria-hidden="true"></i>' . lang('app.edit') . '</div>
    <div class="z-tool z-handle"><i class="fas fa-arrows-alt" aria-hidden="true"></i>' . lang('app.move') . '</div>
    <div class="z-tool z-clone"><i class="fa fa-clone" aria-hidden="true"></i>' . lang('app.clone') . '</div>
    <div class="z-tool z-copy"><i class="far fa-clone" aria-hidden="true"></i>' . lang('app.copy-style') . '</div>
    <div class="z-tool z-paste"><i class="far fa-clone" aria-hidden="true"></i>' . lang('app.paste-style') . '</div>
    <div class="z-tool z-delete"><i class="fa fa-trash" aria-hidden="true"></i>' . lang('app.delete') . '</div>
    <div class="z-tool gsave"><i class="fas fa-globe" aria-hidden="true"></i><span class="save">' . lang('app.save-as-global') . '</span><span class="unlink">' . lang('app.unlink-from-global') . '</span></div>
    <div class="z-tool z-addc"><i class="fas fa-columns" aria-hidden="true"></i>' . lang('app.add-column') . '</div>
';
    if ($this->privileges->can('section_export')) {
      $data .= '<div class="z-tool z-export-code"><i class="fas fa-download" aria-hidden="true"></i>' . lang('app.export') . '</div>';
    }

    if ($this->SiteData['isTheme']) {
      $data .= '<div class="z-tool z-export"><i class="fa fa-clone" aria-hidden="true"></i>' . lang('app.clone-to-sections') . '</div>';
    }

    return $data;
  }


  protected function view404()
  {
    return '404';
  }
}
