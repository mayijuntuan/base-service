<?php

namespace Mayijuntuan\Weixin\Request;

//获取校验文件名称及内容
class WxOpenQrcodeJumpDownload extends BaseRequest{

    protected $action = '/cgi-bin/wxopen/qrcodejumpdownload';
    protected $method = 'post';

}
