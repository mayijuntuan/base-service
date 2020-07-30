<?php

namespace Mayijuntuan\Weixin\Request;

//提交审核
class WxaCommitAudit extends BaseRequest{

    protected $action = '/wxa/submit_audit';
    protected $method = 'post';
    protected $needAccessToken = true;

    public function setItemList( $item_list ){
        $this->params['item_list'] = $item_list;
    }

    public function setPreviewInfo( $preview_info ){
        $this->params['preview_info'] = $preview_info;
    }

    public function setVersionDesc( $version_desc ){
        $this->params['version_desc'] = $version_desc;
    }

    public function setFeedbackInfo( $feedback_info ){
        $this->params['feedback_info'] = $feedback_info;
    }

    public function setFeedbackStuff( $feedback_stuff ){
        $this->params['feedback_stuff'] = $feedback_stuff;
    }

    public function setUgcDeclare( $ugc_declare ){
        $this->params['ugc_declare'] = $ugc_declare;
    }

}
