<?php

namespace Mayijuntuan\Weixin\Request;

//查询最新一次提交的审核状态
class WxaGetLatestAuditStatus extends BaseRequest{

    protected $action = '/wxa/get_latest_auditstatus';

}
