<?php

namespace Mayijuntuan\Weixin\Request;

//获取模板列表
class WxaGetTemplateList extends BaseRequest{

    protected $action = '/wxa/gettemplatelist';
    protected $method = 'post';

    public function setTemplateType( $template_type ){
        $this->data['template_type'] = $template_type;
    }

}
