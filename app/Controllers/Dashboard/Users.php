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

class Users extends BaseController
{
    public function index()
    {
        $data = $this->commonData();

        helper(['form']);

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'username' => 'required|min_length[3]|max_length[20]',
                'password' => 'required|min_length[6]|max_length[255]|validateUser[username,password]',
            ];

            $errors = [
                'password' => [
                    'validateUser' => lang('app.login-fail')
                ]
            ];

            if (!$this->validate($rules, $errors)) {

                $config = config('MasterConfig');
                if (isset($config->multiLogin) && $config->multiLogin) {
                    return $this->hostLogin();
                }

                $data['validation'] = $this->validator;

            } else {
                $model = newModel('UserModel');

                $user = $model->where('username', $this->request->getVar('username'))->first();

                $model->save(['id' => $user['id'], 'last_visit' => time()]);

                $this->setUserSession($user);

                return namedRedirect('dashboard');

            }
        }

        $data['langs'] = $this->langs();

        echo getView('dashboard/parts/head', $data);
        echo getView('dashboard/login');
        echo getView('dashboard/parts/footer');
    }

    public function hostLogin()
    {
        $data = $this->commonData();

        helper(['form']);

        if ($this->request->getMethod() == 'post') {

            if ($this->validator) $this->validator->reset();

            $rules = [
                'username' => 'required',
                'password' => 'required',
            ];

            $errors = [
                'password' => [
                    'validateUser' => lang('app.login-fail')
                ]
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {

                $autoHost = newLib('AutoHost');
                $result = $autoHost->login($this->request->getVar('username'), $this->request->getVar('password'));

                if ($result && isset($result['host'])) {
                    $username = $this->request->getVar('username') . '@' . $result['host'];
                    $model = newModel('UserModel');

                    $user = $model->where('username', $username)->first();
                    if ($user) {
                        $save = ['id' => $user['id'], 'last_visit' => time(), 'password' => $result['password'], 'status' => 'autoUser'];
                    } else {
                        $save = [
                            'username' => $username,
                            'password' => $result['password'],
                            'email' => '',
                            'status' => 'autoUser',
                            'role' => 'autoUser'
                        ];
                    }


                    $model->save($save);
                    $user = $model->where('username', $username)->first();

                    $user['display_name'] = $this->request->getVar('username');

                    $this->setUserSession($user);
                    return namedRedirect('dashboard');

                } else {
                    $this->validator->setError('password', lang('app.app.login-fail'));
                    $data['validation'] = $this->validator;
                }

            }
        }

        $data['langs'] = $this->langs();

        echo getView('dashboard/parts/head', $data);
        echo getView('dashboard/login');
        echo getView('dashboard/parts/footer');
    }

    public function demologin()
    {
        if (!$this->privileges->guestCan('demologin')) return namedRedirect('dashboard/login');
        $config = config('MasterConfig');
        if (!isset($config->demoUser['login']) || !isset($config->demoUser['deleteAfter'])) return namedRedirect('dashboard/login');

        $model = newModel('UserModel');
        $user = $model->where('username', $config->demoUser['login'])->first();
        if (!$user) return namedRedirect('dashboard/register');

        $this->setUserSession($user);
        $this->session->set('demoUser', true);
        $this->session->setFlashdata('fail', lang('app.demo-sites-delete-info') . ' ' . lang('Time.hours', [$config->demoUser['deleteAfter']]) . '.');
        return namedRedirect('dashboard');
    }

    protected function setUserSession($user)
    {

        $data = [
            'user_id' => $user['id'],
            'user_username' => $user['username'],
            'user_status' => $user['status'],
            'user_role' => $user['role'],
            'user_email' => $user['email'],
            'user_isLoggedIn' => true,
        ];

        $data['user_display_name'] = isset($user['display_name']) ? $user['display_name'] : $user['username'];

        $this->session->set($data);
        return true;
    }

    protected function langs()
    {
        $config = config('App');
        $locales = $config->LocalesDetails;
        $language = service('language');
        $current = $language->getLocale();
        return ['supported' => $locales, 'current' => $locales[$current][0]];
    }

    public function register()
    {
        helper(['curl']);
        if (!$this->privileges->guestCan('register')) return namedRedirect('dashboard');

        $data = $this->commonData();

        helper(['form']);

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[20]|is_unique[Users.Username]',
                'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[Users.email]',
                'password' => 'required|min_length[6]|max_length[255]',
            ];

            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $model = newModel('UserModel');

                $newData = [
                    'username' => $this->request->getVar('username'),
                    'password' => $this->request->getVar('password'),
                    'email' => $this->request->getVar('email'),
                    'status' => 'user',
                    'role' => 'user'
                ];
                $model->save($newData);

                $post_endpoint = '/api/integration/user/add';

                $request_data = array('username' => $this->request->getVar('username'),
                    'password' => $this->request->getVar('password'),
                    'email' => $this->request->getVar('email'));

                $response = perform_http_request('POST', 'https://storemanager.faddishbuilder.com' . $post_endpoint, $request_data);


                $this->session->setFlashdata('success', lang('app.register-success'));
                return namedRedirect('dashboard/login');

            }
        }

        $data['langs'] = $this->langs();

        echo getView('dashboard/parts/head', $data);
        echo getView('dashboard/register');
        echo getView('dashboard/parts/footer');
    }

    public function reset()
    {
        if (!$this->privileges->guestCan('resetPassword')) return namedRedirect('dashboard');

        $data = $this->commonData();

        helper(['form']);
        $tokens = newLib('Tokens');
        $mails = newLib('Mails');

        if ($this->request->getMethod() == 'get' && $this->request->getVar('t')) {
            $token = $tokens->check($this->request->getVar('t'), 'password-reset');
            if (!$token) {
                $this->validate([]);
                $this->validator->setError('t', lang('app.token-fail'));
                $data['validation'] = $this->validator;
            } else {

                $model = newModel('UserModel');
                $user = $model->where('id', $token->uid)->first();

                helper('text');
                $newData = [
                    'id' => $token->uid,
                    'password' => random_string('alnum', 8),
                ];

                $newData['status'] = $user['status'];
                $model->save($newData);

                $mailData = [
                    'sendTo' => $user['email'],
                    'subject' => lang('app.mail-new-password'),
                    'template' => 'newPassword',
                    'content' => ['buttonUrl' => site_url(), 'password' => $newData['password']]
                ];

                $mails->send($mailData);

                $this->session->setFlashdata('success', lang('app.reset-success'));
                return namedRedirect('dashboard/login');
            }

        }
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'email' => 'required|valid_email|min_length[6]|max_length[50]|userExist'
            ];

            $errors = [
                'email' => [
                    'userExist' => lang('app.reset-init-fail')
                ]
            ];

            if (!$this->validate($rules, $errors)) {
                $data['validation'] = $this->validator;
            } else {
                $model = newModel('UserModel');

                $user = $model->where('email', $this->request->getVar('email'))->first();

                $token = $tokens->add($user['id'], 'password-reset', 86400);


                $mailData = [
                    'sendTo' => $user['email'],
                    'subject' => lang('app.mail-password-reset'),
                    'template' => 'mailReset',
                    'content' => ['buttonUrl' => site_url('dashboard/reset?t=' . $token)]
                ];

                $mails->send($mailData);

                $this->session->setFlashdata('success', lang('app.reset-init-success'));
                return namedRedirect('dashboard/reset');

            }
        }
        $data['langs'] = $this->langs();

        echo getView('dashboard/parts/head', $data);
        echo getView('dashboard/reset');
        echo getView('dashboard/parts/footer');


    }

    public function profile()
    {
        if (!$this->privileges->can('profile_edit')) return namedRedirect('dashboard');
        helper(['form']);
        $model = newModel('UserModel');
        $data['privileges'] = $this->privileges;
        $data['row'] = $model->where('id', $this->session->get('user_id'))->first();

        $data['rules'] = [
            'firstname' => [
                'rules' => 'permit_empty|min_length[3]|max_length[100]',
                'label' => lang('app.firstname'),
                'size' => '6'
            ],
            'lastname' => [
                'rules' => 'permit_empty|min_length[3]|max_length[100]',
                'label' => lang('app.lastname'),
                'size' => '6'
            ],
            'email' => [
                'rules' => 'required|min_length[6]|max_length[50]|valid_email',
                'label' => lang('app.email-addr'),
                'size' => '12'
            ],
        ];


        if ($this->request->getMethod() == 'post') {
            if (!$this->validate($data['rules'])) {
                $data['validation'] = $this->validator;
            } else {

                $inuse = $model->where(['id!=' => $this->session->get('user_id'), 'email' => $this->request->getPost('email')])->first();
                if ($inuse) {
                    $this->validator->setError('email', lang('app.emailtaken'));
                    $data['validation'] = $this->validator;
                } else {

                    $newData = [
                        'id' => $this->session->get('user_id'),
                        'firstname' => $this->request->getPost('firstname'),
                        'lastname' => $this->request->getPost('lastname'),
                        'email' => $this->request->getPost('email'),
                    ];
                    $model->save($newData);

                    $this->session->setFlashdata('success', 'Successfuly Updated');
                    return namedRedirect('dashboard');
                }
            }
        }


        $data['back'] = ['label' => lang('app.back'), 'path' => '/dashboard'];
        $data['title'] = lang('app.profile');

        echo getView('dashboard/parts/header', $data);
        echo getView('dashboard/parts/saveform');
        echo getView('dashboard/parts/footer');
    }

    public function logout()
    {

        if ($this->session->get('admin_mode')) {
            foreach ($this->session->get('admin_mode') as $key => $val) {
                $this->session->set($key, $val);
            }
            $this->session->remove('admin_mode');
            return namedRedirect('admin/users');
        }

        $this->session->destroy();
        return redirect()->to(base_url());
    }

    //--------------------------------------------------------------------

}
