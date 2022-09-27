<?php

namespace Mayijuntuan\Weixin\Request;

//获取隐私接口检测结果
class WxaGetCodePrivacyInfo extends BaseRequest{
    protected $action = '/wxa/security/get_code_privacy_info';
}
