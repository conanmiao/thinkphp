<?php

namespace app\weixin\controller;

use app\common\controller\Common;

class Index extends common
{
    public function index()
    {
        //1.将timestamp,nonce,token按字典序排序
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $token = 'baixun';
        $signature = $_GET['signature'];
        $echostr=$_GET['echostr'];
        $array = array($timestamp, $nonce, $token);
        sort($array);
        //2，将排序后的3个参数拼接之后 用sha1加密
        $tmpstr = implode('', $array);//join
        $tmpstr = sha1($tmpstr);
        //3将加密后的字符串与signature进行比对，判断该请求是否来自微信
        if (($tmpstr == $signature) && $echostr) {
            //第一次接入微信平台api接口
            echo $echostr;
            exit;
        } else {
            $this->responseMsg();
        }
    }

    //接收事件推送并回复
    public function responseMsg()
    {
        //1 获取微信post过来的推送消息 格式是xml格式例如
//<xml>
//<ToUserName><![CDATA[toUser]]></ToUserName>
//<FromUserName><![CDATA[FromUser]]></FromUserName>
//<CreateTime>123456789</CreateTime>
//<MsgType><![CDATA[event]]></MsgType>
//<Event><![CDATA[subscribe]]></Event>
//</xml>
//        $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
        $postArr=file_get_contents("php://input");
        dump($postArr);
        exit;

        $postObj = simplexml_load_string($postArr);//将xml格式的内容转换成为对象,生成的对象如下
//        $postObj->ToUserName='';
//        $postObj->FromUserName='';
//        $postObj->CreateTime='';
//        $postObj->MsgType='';
//        $postObj->Event='';
        //判断是否是事件推送
        if (strtolower($postObj->MsgType) == 'event') {
            //判断是否是关注subscribe事件
            if (strtolower($postObj->Event) == 'subscribe') {
                //回复用户消息，首先定义接收方和发送方（刚好与微信推送过来的消息相反）
                $toUser = $this->FromUserName;
                $formUser = $this->ToUserName;
                $time = time();
                $msgType = "text";
                $content = "欢迎您关注百讯信息科技！";
                $template = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
                //sprintf()按照第二个参数将第一个参数中的%s进行替换
                $info = sprintf($template, $toUser, $formUser, $time, $msgType, $content);
                return $info;
            }
        }
    }

}