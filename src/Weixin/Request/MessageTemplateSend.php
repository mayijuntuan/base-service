<?php

namespace Mayijuntuan\Weixin\Request;

//发送模板消息
class MessageTemplateSend extends BaseRequest{

    protected $action = '/cgi-bin/message/template/send';
    protected $method = 'post';

    public function setToUser( $touser ){
        $this->data['touser'] = $touser;
    }

    public function setTemplateId( $template_id ){
        $this->data['template_id'] = $template_id;
    }

    public function setUrl( $url ){
        $this->data['url'] = $url;
    }

    public function setMiniprogram( $miniprogram ){
        $this->data['miniprogram'] = $miniprogram;
    }

}
