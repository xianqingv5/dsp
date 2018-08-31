<?php
return [
    // 权限组
    'GROUP_CONF' => [
        '1' => 'super_admin',
        '2' => 'admin',
        '3' => 'ad_dl', // 广告位代理商
        '4' => 'advs', // 广告主
    ],

    // 权限组名映射id
    'MAPPING_NAME_TO_GROUP_ID' => [
        'super_admin'   => 1,
        'admin'         => 2,
        'ad_dl'         => 3,
        'advs'          => 4,
    ],

    // 区分不同的组的home_url
    'HOME_URL_BY_ROLE'      => [
        '1' => 'user/user-index',
        '2' => 'user/user-index',
        '3' => 'offer/offer-index',
        '4' => '',
    ],

    // 代理广告商群组
    'AGENT_ADVERTISERS' => 3,

    // 无需登录即可访问方法
    'NO_LOGIN_ACTIONS' => require 'params/no_login_actions.php',

    // 需要记录操作的方法
    'LOG_RECORD_METHOD' => require 'params/record_log.php',

    // 群组权限列表
    'GROUP_PREV' => require 'params/group_prev.php',
];
