<?php

namespace App\Http\Controllers\Captcha;


use Gregwar\Captcha\CaptchaBuilder;
use Session;

class Gregwar
{

    public function generate(){

        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder();
        //可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);

        $builder->setMaxFrontLines(0);
        $builder->setMaxBehindLines(0);

        //获取验证码的内容
        $phrase = $builder->getPhrase();

        //把内容存入session

        Session::flash('milkcaptcha', $phrase);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();

    }

    public function verify($verify_code)
    {
        if (Session::get('milkcaptcha') != $verify_code){
            return false;
        }
        return true;
    }
}