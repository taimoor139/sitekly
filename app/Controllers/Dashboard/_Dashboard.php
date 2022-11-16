<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Controllers\Dashboard;

class _Dashboard extends Dashboard
{
    public function dns()
    {
        $siteId = $this->request->getPost('site');
        $data = $this->commonData();

        $siteModel = newModel('SiteModel');
        $data['site'] = $siteModel->getMySite($siteId);
        if (!$data['site']) return namedRedirect('dashboard');

        if (empty($data['site']['domain'])) {
            $this->session->setFlashdata('fail', lang('app.add-domain-first'));
            return namedRedirect('dashboard');
        }

        $this->privileges->extendByPackage($data['site']['package']);
        if (!$this->privileges->can('domain_manage')) return redirect()->back();
        //$tempD = 'sdcvczxczxcz.com';
        //$data['site']['domain'] = $tempD;

        $controlPanel = newLib('Controlpanel');
        $controlPanel->connectUser($data['site']);
        $data['rtypes'] = ['A', 'MX', 'CNAME', 'AAAA', 'TXT', 'CAA'];

        $data['rules'] = [
            'line' => [
                'rules' => 'required|integer',
            ],
            'name' => [
                'rules' => 'required|string',
            ],
            'type' => [
                'rules' => 'required|string|in_list[' . implode(',', $data['rtypes']) . ']',
            ],

        ];

        if ($this->request->getPost('type')) {
            if ($this->request->getPost('delete')) {
                unset($data['rules']['type'], $data['rules']['name']);
            } else if ($this->request->getPost('type') == 'A' || $this->request->getPost('type') == 'AAAA') {
                $data['rules']['address'] = ['rules' => 'required|valid_ip'];
            } else if ($this->request->getPost('type') == 'CNAME') {
                $data['rules']['cname'] = ['rules' => 'required|string'];
            } else if ($this->request->getPost('type') == 'MX') {
                $data['rules']['exchange'] = ['rules' => 'required|string'];
                $data['rules']['preference'] = ['rules' => 'required|integer'];
            } else if ($this->request->getPost('type') == 'SRV') {
                $data['rules']['target'] = ['rules' => 'required|string'];
            } else if ($this->request->getPost('type') == 'TXT') {
                $data['rules']['txtdata'] = ['rules' => 'required|string'];
            } else if ($this->request->getPost('type') == 'CAA') {
                $data['rules']['flag'] = ['rules' => 'required|string'];
                $data['rules']['tag'] = ['rules' => 'required|string'];
                $data['rules']['value'] = ['rules' => 'required|string'];
            }

            if (!$this->validate($data['rules'])) {
                $data['validation'] = $this->validator;
            } else {
                $args = [];
                foreach ($data['rules'] as $rule => $array) {
                    $args[$rule] = $this->request->getPost($rule);
                }
                $args['domain'] = $data['site']['domain'];
                //$args['domain'] = $tempD;

                if ($this->request->getPost('delete')) {
                    $result = $controlPanel->panel->removedns($args);
                } else if ($this->request->getPost('add')) {
                    unset($args['line']);
                    $result = $controlPanel->panel->adddns($args);
                } else {
                    $result = $controlPanel->panel->editdns($args);
                }
                if (isset($result["cpanelresult"]['data'][0]['result']['status']) && $result["cpanelresult"]['data'][0]['result']['status'] != '1') {
                    $error = $result["cpanelresult"]['data'][0]['result']['statusmsg'] ?? 'Error';
                    $this->validator->setError('name', $error);
                    $data['validation'] = $this->validator;
                }
            }
        }


        $args = ['domain' => $data['site']['domain']];
        $listdns = $controlPanel->panel->listDns($args);
        $data['zones'] = [];
        $data['zones'][] = ['type' => 'A', 'line' => '9999'];
        foreach ($listdns as $record) {
            if (!in_array($record['type'], $data['rtypes'])) continue;
            $hideNames = ['ftp', 'whm', 'cpcalendars', 'cpcontacts', 'webmail', 'cpanel', 'webdisk'];
            $partName = explode('.', $record['name'])[0];
            if (in_array($partName, $hideNames)) continue;
            $data['zones'][] = $record;
        }

        helper(['form']);

        $data['back'] = ['label' => lang('app.back'), 'path' => '/dashboard'];
        $data['title'] = lang('_app.zone-settings');

        echo getView('dashboard/parts/header', $data);
        echo getView('dashboard/parts/dns');
        echo getView('dashboard/parts/footer');
    }
}
