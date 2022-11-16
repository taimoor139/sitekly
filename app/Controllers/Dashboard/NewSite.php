<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class NewSite extends BaseController
{

    protected $data;
    protected $theme;

    public function index()
    {
        $auth = newLib('Auth');

        $this->theme = $this->request->getPost('theme') ? $this->request->getPost('theme') : $this->session->get('newsite');
        if (!$this->theme) return namedRedirect('templates');

        $this->data = [
            'post' => $this->request->getPost(),
            'themeMedia' => 'default',
        ];

        if ($auth->isGuest()) {
            $this->session->set(['newsite' => $this->theme, 'loggedRedirect' => '/dashboard/newsite']);
            return namedRedirect('dashboard');
        }


        if ($auth->isAdmin()) {
            return $this->addTemplateForm();

        } else if ($auth->isLogged()) {
            return $this->addSiteForm();
        }

    }

    protected function addSiteForm()
    {
        if (!$this->privileges->can('site_add')) return namedRedirect('dashboard');

        $MasterConfig = config('MasterConfig');
        $siteMedia = array_rand($MasterConfig->media, 1);

        $trial = isset($MasterConfig->trialConfig[$this->session->get('user_status')]) ? $MasterConfig->trialConfig[$this->session->get('user_status')] : ['package' => '1', 'time' => '14'];

        $this->data = array_merge($this->data,
            ['userId' => session()->get("user_id"),
                'trial' => $trial['time'],
                'packageId' => $trial['package'],
                'siteMedia' => $siteMedia]
        );

        $pricingModel = newModel('PricingModel');
        $trialPackage = $pricingModel->find($this->data['packageId']);
        if ($trialPackage['site_limit'] != '-1' && !$this->session->get('demoUser')) {
            $siteModel = newModel('SiteModel');
            $count = $siteModel->countByPackage($trialPackage['id']);
            if ($count >= $trialPackage['site_limit']) {
                $this->session->setFlashdata('fail', lang('app.site-count-limit', ['limit' => $trialPackage['site_limit']]));
                return namedRedirect('dashboard');
            }
        }


        helper(['form']);

        $data = $this->commonData();

        $data['rules'] = [
            'theme' => [
                'rules' => 'required|integer',
                'type' => 'hidden'
            ],
            'name' => [
                'rules' => 'required|alpha_numeric_space|min_length[3]|max_length[100]',
                'label' => lang('app.name')
            ]
        ];

        if ($this->request->getPost('name')) {
            if (!$this->validate($data['rules'])) {
                $data['validation'] = $this->validator;
            } else {
                return $this->process('si');
            }
        }


        $data['back'] = ['label' => lang('app.back'), 'path' => '/templates'];
        $data['title'] = lang('app.create-website');
        $data['row']['theme'] = $this->theme;

        echo getView('dashboard/parts/header', $data);

        echo getView('dashboard/parts/saveform');
        echo getView('dashboard/parts/footer');
    }

    protected function addTemplateForm()
    {

        if (!$this->privileges->can('add_new', 'admin_templates')) return namedRedirect('dashboard');

        helper(['form']);
        $data = $this->commonData();

        $data['rules'] = [
            'theme' => [
                'rules' => 'required|integer',
                'type' => 'hidden'
            ],
            'type' => [
                'rules' => 'required|integer|max_length[1]',
                'label' => lang('app.type'),
                'type' => 'select',
                'options' => ['1' => lang('app.user'), '2' => lang('app.builder')]
            ]
        ];

        if ($this->request->getPost('type')) {
            if (!$this->validate($data['rules'])) {
                $data['validation'] = $this->validator;
            } else {

                return $this->process('ti');
            }
        }


        $data['back'] = ['label' => lang('app.back'), 'path' => '/templates'];
        $data['title'] = lang('app.add-new-template');
        $data['row']['theme'] = $this->theme;

        echo getView('dashboard/parts/header', $data);
        echo getView('dashboard/parts/saveform');
        echo getView('dashboard/parts/footer');
    }

    protected function process($t)
    {
        $i = new \App\Libraries\SystemIterator($this->data);
        $result = $i->$t();

        if (!$result || $result['status'] == 'fail') {
            $this->session->setFlashdata('fail', lang('app.verfail'));
            return namedRedirect('dashboard');
        } else {
            $this->session->setFlashdata('success', lang('app.update-success'));
            return namedRedirect('dashboard');
        }
    }


    //--------------------------------------------------------------------

}
