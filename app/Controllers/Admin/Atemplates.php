<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Atemplates extends BaseController
{
    protected $FileManager;
    protected $themeMedia = 'default';

    public function index($type = 1)
    {
        if (!$this->privileges->can('view', 'admin_templates')) return redirect()->back();



        $model = newModel('TemplateModel');

        $data = [
            'templates' => $model->where('type', $type)->orderBy('id', 'asc')->paginate(20),
            'pager' => $model->pager,
            'type' => $type
        ];
        $data = $this->dataCommon($data);

        $data['templates'] = $model->TemplatesData($data['templates'], true);

        $data['modal'] = ['id' => 'delete', 'body' => lang('app.sure-del-template')];

        echo getView('admin/parts/header', $data);
        echo getView('admin/templates');
        echo getView('dashboard/parts/modalConfirm');
        echo getView('dashboard/parts/footer');
    }

    public function builder()
    {
        if (!$this->privileges->can('builder_templates', 'admin_templates')) return redirect()->back();
        return $this->index(2);
    }
    public function translate()
    {
        if (!$this->privileges->can('translate', 'admin_templates')) return redirect()->back();
        $exportsLib = newLib('Exports');
        $exports = $exportsLib->getExports();
        $config = config('App');
        $langs = join(';', $config->supportedLocales);

        cache()->delete('exports');

        helper(['form']);
        $data = $this->dataCommon();

        $data['rules'] = [
            'sectionCategories' => [
                'rules' => 'required',
                'label' => lang('app.sectionCategories') . ': ' . $langs,
                'type' => 'textarea'
            ],
            'pageCategories' => [
                'rules' => 'required',
                'label' => lang('app.pageCategories') . ': ' . $langs,
                'type' => 'textarea'
            ],
            'themes' => [
                'rules' => 'required',
                'label' => lang('app.themeNames') . ': ' . $langs,
                'type' => 'textarea'
            ]

        ];


        foreach ($data['rules'] as $key => $options) {
            array_walk($exports[$key], function (&$a, $b) {
                array_unshift($a, $b);
                $a = join(';', $a);
            });
            $data['row'][$key] = join("\n", $exports[$key]);
        }

        if ($this->request->getMethod() == 'post') {
            if (!$this->validate($data['rules'])) {
                $data['validation'] = $this->validator;
            } else {

                $post = $this->request->getPost();

                foreach ($data['rules'] as $key => $options) {
                    $fieldData = [];
                    $field = explode("\r\n", $post[$key]);
                    foreach ($field as $row) {
                        $row = explode(';', $row);
                        $rkey = array_shift($row);
                        $fieldData[$rkey] = $row;
                    }
                    $newData[$key] = $fieldData;
                }

                $SettingsModel = newModel('SettingsModel');
                $SettingsModel->setOption('exports_lang', $newData);
                $this->session->setFlashdata('success', 'Successfuly Updated');
                return namedRedirect('admin/templates');
            }
        }



        $data['back'] = ['label' => lang('app.back'), 'path' => '/admin/templates'];
        $data['title'] = lang('app.translations');


        echo getView('admin/parts/header', $data);
        echo getView('dashboard/parts/saveform');
        echo getView('dashboard/parts/footer');
    }

    public function settings(int $themeID)
    {
        if (!$this->privileges->can('edit', 'admin_templates')) return redirect()->back();
        helper(['form']);
        $data = $this->dataCommon();
        $data['back'] = ['label' => lang('app.back'), 'path' => '/admin/templates'];
        $data['title'] = lang('app.settings');

        $SettingsModel = newModel('SettingsModel');

        $newData = $SettingsModel->getOption('template_categories', true) ?? [];
        $data['row']['categories'] = $newData[$themeID] ?? [];

        $categories = $SettingsModel->getOption('template_categories_all', true);

        $data['rules'] = [
            'categories' => [
                'rules' => 'required',
                'label' => lang('app.category'),
                'type' => 'multiselect',
                'options' => $categories
            ],

        ];

        if ($this->request->getMethod() == 'post') {
            if (!$this->validate($data['rules'])) {
                $data['validation'] = $this->validator;
            } else {

                $post = $this->request->getPost();
                $newData[$themeID] = $post['categories'];

                $categories = [];
                foreach ($newData as $theme => $cats) {
                    $categories = array_merge($categories, $cats);
                }
                $categories = array_unique($categories);
                $categories = array_combine($categories, $categories);

                $SettingsModel->setOption('template_categories_all', $categories);
                $SettingsModel->setOption('template_categories', $newData);
                $this->session->setFlashdata('success', 'Successfuly Updated');
                return namedRedirect('admin/templates');
            }
        }

        echo getView('admin/parts/header', $data);
        echo getView('dashboard/parts/saveform');
        echo getView('dashboard/parts/footer');
    }

    public function delete()
    {
        if (!$this->privileges->can('delete', 'admin_templates')) return redirect()->back();

        if ($this->request->getMethod() == 'post') {
            $id = $this->request->getPost('id');

            $model = newModel('TemplateModel');
            $model->delete($id);

            $FileManager = newLib('FileManager');
            $FileManager->deleteDirectory($FileManager->templatesRoot . $id);
            $FileManager->deleteDirectory($FileManager->thumbsRoot . $id);

            $MediaManager = newLib('MediaManager');
            $MediaManager->connect($this->themeMedia);
            $MediaManager->deleteDirectory($id);
        }
        return redirect()->back();
    }

    public function status()
    {
        if (!$this->privileges->can('status', 'admin_templates')) return redirect()->back();
        if ($this->request->getMethod() == 'post') {
            $id = $this->request->getPost('id');
            $val = $this->request->getPost('val');
            $model = newModel('TemplateModel');
            $row = $model->where('id', $id)->first();
            if ($row['type'] == 2) {
                $model->where('type', '2')->set(['status' => 0])->update();
            }

            $model->update($id, ['status' => $val]);
        }
        return redirect()->back();
    }

    protected function dataCommon($data = [])
    {
        return array_merge(['privileges' => $this->privileges], $data);
    }

    //--------------------------------------------------------------------

}
