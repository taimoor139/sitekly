<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class MasterConfig extends BaseConfig
{

    public $siteName = 'Faddishbuilder';
    public $licenseKey = 'YQQO-NDNJ-FCWQ-VSDV-QAVM';
    public $customFront = false; //true to enable custom front pages (controller Front.php)

    public $media = [
        //keys (default and future ones) should not be changed, all keys should be unique
        'default' => ['base' => 'https://storage.faddishbuilder.com', 'secret' => 'QphnJbV6q5u3cjfxYFlekIdtTagKCRm1'],
        //you can add more here 
    ];
    public $previewDomain = 'https://preview.faddishbuilder.com';
    public $resellers = [
        //keys (rs1 and future ones) should not be changed, all keys should be unique
        'rs1' => [
            'label' => 'default',
            'type' => 'Cpanel',
            'ip' => '3.224.163.137',
            'login' => 'faddishbuilder',
            'password' => 'Jasonweb@1',
            'publicPath' => '/public_html',
            'webmail' => 'https://webmail.faddishbuilder.com/cpsess8126893697/3rdparty/roundcube/?_task=mail&_mbox=INBOX',
            'domains' => 'faddishbuilder.com',
            'nameServers' => 'ns1.faddishbuilder.com,ns2.faddishbuilder.com',
            'port_user' => '2083',
            'port_reseller' => '2087',
            'package' => 'faddishbuilder_package',
            'panel_host' => 'https://www.faddishbuilder.com', // use domain or ip for control panel with http or https
            'secret' => 'gx6AwjbiKmhWSVY5ynOHNkZPUMLTdsEt',
        ],
        //you can add more here 
    ];

    public $fontsKey = 'AIzaSyBk1hxaTdrYpQdosQ6qQZGZvkx77SEEnq0';

    public $captureApi = [
        'keys' => [
            'techulus'  => ['key' => '599adb44-5422-475e-a212-ba8eefd18d55', 'secret' => '70db010a-498d-489b-8e75-76d348ac33ad'],
            'screenly' => 'Md4pmeIXE9wV7e6fxoFcnvsMfZUCHpa0KAlQ2oedgiKNnunO3S',
        ],
        'provider' => ['template' => 'screenly', 'site' => 'screenly']
    ];

    public $trialConfig = [
        'user' => [ //usertype
            'time' => '14', //time in days
            'package' => '1' //default package
        ],
        'autoUser' => [ //hosting provider auto login
            'time' => '36500', //time in days
            'package' => '3' //time in days
        ],
        'settings' => ['hiddenPackages' => [1]] //trial or some special packages, users can't select them

    ];
    public $demoUser = [
        'login' => 'testdemo', //need to be an existing user
        'deleteAfter' => '4' //delete site after x hours
    ];
    public $multiLogin = false; //option for hosting provider mode

    public $paymentConfig = [
        'amount_format' => ['decimal-points' => 0, 'decimal-separator' => '.', 'thousands-
separator' => '', 'before' => '$', 'after' => ''], //set your currency symbol, before or after
        'currency' => 'USD', //your currency
        'testMode' => false //true to enable test mode

    ];

    public $paymentMethods = [
        //'dp'=>['label'=>'Dotpay','id'=>'','pin'=>''],
        //'pp'=>['active'=>true,'label'=>'PayPal','id'=>'njason213@gmail.com'],
        'pd' => [
            'active' => true,
            'label' => 'Credit/Debit',
            'vendor' => 137156, // vendor id
            'packages' => [
                '3' => [ //package id
                    '1' => '742170', //period in months=>product id
                    '12' => '746684'
                ],
                '4' => [
                    '1' => '746685',
                    '12' => '746687'
                ],
                '5' => [
                    '1' => '746688',
                    '12' => '746691'
                ]

            ],
            'publicKey' => '-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAlmMhyJrTQKKpCJw1AavW
6SR4/oWDuIaM9Q5WK3j1TAiuOAUHogQTbNPZOVKyn9mL+s1k/tSbyRc7YdDu//KA
YCi/Qov923mqYYkZuCxOWyCPXP8tHF5gMmOfWLF6zHx79JM7LdvnJ9MyHO2Yz1+8
C6qr1HwZwc6TmDkxoFnDP0rvMEjiqJ6gjGbQ2+dzaU7LDuWRUgr4m8dToqYO1rsC
ITQ3lqNMbrz1zClvi7L8x+k3H/4nGjIxT2aM0Mp3+5glC01IY/qAfSOV6fd/8US4
lh1RXQyMAxiXJgZbxGdbEKpqdZUo3RH1wZz1HJJBRh0ADU9kI6i2acKHKur6OHca
ga+tC/4gVthOuZ5sb1XZPm43g0UUqba/Q9c9hPbvplG6WaYwBL7j3jb3cl4yOmFm
6XAyJvul493jZCxOUDZx18zJMOF96FThbNi9OjTLeVk9FRvGd1fHeYVJew2dnMH3
0lb6fy8Pj2rbYu9i+MOw/WYK8+eQFRu4p+SOR5A4skTRev/jTcBUzxE8n66BuZPS
A9cE1uhje92aQl+DFJPd+096kpDPF9kAwweFNMOPkcehctHBCudf2drWgox48cZW
CiAxNaVzvirQxc1vyi6KHBzHsVRWH/YrX7lnpy2zoYJGPX/p9ag1Zj8QWj+MHZSL
nWFFni4dys0mu7B1iXskkAkCAwEAAQ==
-----END PUBLIC KEY-----', //https://vendors.paddle.com/public-key
            'apiKey' => '626e263d438308729f1a391632a191d80f8ba9b06a5bc6bf9e' //https://sandbox-vendors.paddle.com/authentication required if cancel button should work automatically
        ]
    ];

    public $paymentTestMethods = [
        //'dp'=>['label'=>'Dotpay','id'=>'','pin'=>''], 
        //'pp'=>['label'=>'PayPal','id'=>'']
        'pd' => [
            'active' => true,
            'label' => 'Paddle',
            'vendor' => 4091, // vendor id
            'packages' => [
                '3' => [ //package id
                    '1' => '21079', //period in months=>product id
                    '6' => '21081', //
                    '12' => 'pid'
                ],
                '4' => [
                    '1' => 'pid',
                    '6' => 'pid',
                    '12' => 'pid'
                ],
                '5' => [
                    '1' => 'pid',
                    '6' => 'pid',
                    '12' => 'pid'
                ]

            ],
            'publicKey' => '-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAkpEhlWumIRLmlWZYxDYq
SraPSRMuuwFVQuK1Nx6Fsv6Bi965P5A+pAgJ1qeXrdzoLTa+DnUeMCDsKDenw1jN
tNmQbF7FOCn4iON8N2pwrR0N586xp+V9K4fOAh0Po9n2T9DuVm0iVsJdKCEPkOWX
RMEbIdTuT6QEYw+O1vTCxQtXv8UeykhnEJMn06uPqnVBFqINHHjkj2p94LO0mq8u
e+m/dunMeqU/hKPv3DH6ikK7N9q2vhP0lacy4PAwYEuok2CjXDJ1/G50UgJpSGJA
isBBzTBv7ah9GlN7pYI3UkHyna/m2DwYm7YrywD9WoEHuMdS6pHb+Xc1fgpJ1f30
fvd6mW5pNWIGB74A/qkdP/rvwxBhbUbu9BEjfKlCKynoYC8EF/yjFOjZ3l06BKv3
VQeg5SAwjEL1RnOL7YhgNZaC5FZ3J1a1C+CbxhDRXe4vwe3zwgI7R2nAb8yRJ/fm
b7erc3NZo14zpTeyGAWnrNNKXulzT4m50xtQL2eig5w3Tx3IcB8WXqNqa3FSHxbW
P2nABBilGn6C9FN20fKxV69+/DyNS0+Sg78BrBjnYffnupO3EWM/CzN3+HORILjn
9G/ZEFcaLkT4X6qPzNzYHLmBsu3oDPCh4YY/xH6qzbfVad11Wwp2R2g9V5oUAG/u
FxlUVci3eASIetywuXW9gQUCAwEAAQ==
-----END PUBLIC KEY-----', //https://vendors.paddle.com/public-key
            'apiKey' => '6b89bf8e6322d1a7dcf4c6ae3b3a8a875c0b459ed0eb574aca' //https://sandbox-vendors.paddle.com/authentication required if cancel button should work automatically
        ]
    ];

    public $mail = array(
        'protocol' => 'smtp',
        'display' => 'Website Builder mailer',
        'SMTPHost' => 'mail.faddishbuilder.com',
        'SMTPUser' => 'builder@faddishbuilder.com',
        'SMTPPass' => 'Sh8XcIVivm',
        'SMTPPort' => '587',
        'SMTPCrypto' => 'SSL/TLS',
        'newline' => "\r\n",
        'mailType' => 'html',
        'userAgent' => ''
    );

    public $notify = [
        //notify email
        'email' => 'njason213@gmail.com',
        //notify when only x more sites can be published
        'siteLimit' => [0, 1, 5],
        //notify when license verification failed
        'licenseError' => 1,
        'contact_email' => 'support@faddishbuilder.com', //dashboard contact form email
    ];
}
