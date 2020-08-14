<?php

namespace Mayijuntuan\Weixin\Request;

//提交审核
class WxaCommitAudit extends BaseRequest{

    protected $action = '/wxa/submit_audit';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setItemList( $item_list ){
        $this->data['item_list'] = $item_list;
    }

    public function setPreviewInfo( $preview_info ){
        $this->data['preview_info'] = $preview_info;
    }

    public function setVersionDesc( $version_desc ){
        $this->data['version_desc'] = $version_desc;
    }

    public function setFeedbackInfo( $feedback_info ){
        $this->data['feedback_info'] = $feedback_info;
    }

    public function setFeedbackStuff( $feedback_stuff ){
        $this->data['feedback_stuff'] = $feedback_stuff;
    }

    public function setUgcDeclare( $ugc_declare ){
        $this->data['ugc_declare'] = $ugc_declare;
    }

}
