<?php

namespace Mayijuntuan\Weixin\Request;

//发送客服消息
class MessageCustomSend extends BaseRequest{

    protected $action = '/cgi-bin/message/custom/send';
    protected $method = 'post';

    public function setAccessToken( $access_token ){
        $this->params['access_token'] = $access_token;
    }

    public function setToUser( $touser ){
        $this->data['touser'] = $touser;
    }

    public function setMsgType( $msgtype ){
        $this->data['msgtype'] = $msgtype;
    }

    public function setText( $text ){
        $this->data['text'] = $text;
    }

    public function setImage( $image ){
        $this->data['image'] = $image;
    }

    public function setVoice( $voice ){
        $this->data['voice'] = $voice;
    }

    public function setVideo( $video ){
        $this->data['video'] = $video;
    }

    public function setMusic( $music ){
        $this->data['music'] = $music;
    }

    public function setNews( $news ){
        $this->data['news'] = $news;
    }

    public function setMpNews( $mpnews ){
        $this->data['mpnews'] = $mpnews;
    }

    public function setMsgMenu( $msgmenu ){
        $this->data['msgmenu'] = $msgmenu;
    }

    public function setWxCard( $wxcard ){
        $this->data['wxcard'] = $wxcard;
    }

    public function setMiniProgramPage( $miniprogrampage ){
        $this->data['miniprogrampage'] = $miniprogrampage;
    }

    public function setCustomService( $customservice ){
        $this->data['customservice'] = $customservice;
    }

}
