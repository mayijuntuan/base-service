<?php

namespace Mayijuntuan\Weixin\Request;

//发送客服消息
class MessageCustomSend extends BaseRequest{

    protected $action = '/cgi-bin/message/custom/send';
    protected $method = 'post';
    protected $needAccessToken = true;

    public function setToUser( $touser ){
        $this->params['touser'] = $touser;
    }

    public function setMsgType( $msgtype ){
        $this->params['msgtype'] = $msgtype;
    }

    public function setText( $text ){
        $this->params['text'] = $text;
    }

    public function setImage( $image ){
        $this->params['image'] = $image;
    }

    public function setVoice( $voice ){
        $this->params['voice'] = $voice;
    }

    public function setVideo( $video ){
        $this->params['video'] = $video;
    }

    public function setMusic( $music ){
        $this->params['music'] = $music;
    }

    public function setNews( $news ){
        $this->params['news'] = $news;
    }

    public function setMpNews( $mpnews ){
        $this->params['mpnews'] = $mpnews;
    }

    public function setMsgMenu( $msgmenu ){
        $this->params['msgmenu'] = $msgmenu;
    }

    public function setWxCard( $wxcard ){
        $this->params['wxcard'] = $wxcard;
    }

    public function setMiniProgramPage( $miniprogrampage ){
        $this->params['miniprogrampage'] = $miniprogrampage;
    }

    public function setCustomService( $customservice ){
        $this->params['customservice'] = $customservice;
    }

}
