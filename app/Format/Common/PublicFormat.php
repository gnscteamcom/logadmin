<?php
/**
 * Created by PhpStorm.
 * User: zengfanxin
 * Date: 2018/5/4
 * Time: 下午5:47
 */


namespace App\Format\pub;
use Illuminate\Support\Facades\Auth;
use App\Services\OSS;
use Illuminate\Support\Facades\Log;
use Mail;

class  Format{


    public function ParamError()
    {
        $data['code']='400';
        $data['msg']="params error";
        $data['data']=[];
        return $this->RetrunJson($data);
    }

    public function RetrunJson($data){
        return json_encode($data);
    }

    public function AgainLogin()
    {

        $data['code']='401';
        $data['msg']=" Please login ";
        $data['data']=[];
        return $this->RetrunJson($data);
    }

    public function CurlHeadRequest($url,$method,$post_data = "",$head = array("Content-Type: text/html;charset=UTF-8")){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        if ($method == 'post') {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
            curl_setopt($ch, CURLOPT_POST, 1);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }elseif($method == 'get'){
            curl_setopt($ch, CURLOPT_HEADER, 0);
        }
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    function gen_sign_v2($sk, $method, $path, $date, $params = array(), $body = '')
    {
        $p = $params;
        $params_str = array();
        ksort($p, SORT_STRING );
        foreach ($p as $k => $v) {
            if('' === $v) {
                continue;
            }
            $params_str[] = $k.'='.$v;
        }
        $params_str = join('&', $params_str);
        $body_md5 = '';

        if(strlen($body) > 0) {
            $body_md5 = md5($body);
        }

        $sign = array(strtoupper($method), $path, $body_md5, $date,
            $params_str);
        $sign = implode("\n", $sign);
        return hash_hmac('sha1', $sign, $sk);
    }

    // 阿里云获取文件内容
    public function GetOssFileContent($ossKey){
        $bucketName = env('AWS_BUCKET');
        $res = OSS::getObject($bucketName,$ossKey);
        $str = "";
        if($res){
            $resource = $res->getObjectContent();
            $str =  stream_get_contents($resource);
        }
        return $str;
    }

    /**
     * 根据路径返回图片的base64码
     */
    function getPhotoBase64ByPath($photoPath)
    {
        if(isset($photoPath) && !empty($photoPath))
        {
            $cardPath = env('AWS_FILE_PATH').'/'.env('AWS_S3_PRO').$photoPath;
            $cardStr = $this->GetOssFileContent($cardPath);
            $base64Card = base64_encode($cardStr);

            return $base64Card ?? '';
        }
        else
        {
            return '';
        }
    }



    public function FormatPhone($number){
        $number =  str_replace(' ','', $number);
        $patterns='/^((\+620)|(\+062)|(\+62)|(062)|(620)|(0)|(62))/';
        $replacements = '';
        try{
            $fmNumber = preg_replace($patterns, $replacements, $number);
        }
        catch (\Exception $e)
        {
            Log::error('FormatPhone:'.$e);
            $fmNumber = $number;
        }
        return $fmNumber;
    }

    public  function array_msort($array, $cols){
        $colarr = array();
        foreach ($cols as $col => $order) {
            $colarr[$col] = array();
            foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
        }
        $eval = 'array_multisort(';
        foreach ($cols as $col => $order) {
            $eval .= '$colarr[\''.$col.'\'],'.$order.',';
        }
        $eval = substr($eval,0,-1).');';
        eval($eval);
        $ret = array();
        foreach ($colarr as $col => $arr) {
            foreach ($arr as $k => $v) {
                $k = substr($k,1);
                if (!isset($ret[$k])) $ret[$k] = $array[$k];
                $ret[$k][$col] = $array[$k][$col];
            }
        }
        return $ret;
    }

//发短信函数
    public function SendMsg($mobile='13426335082',$_sk='ed68d119fd85ba6422f9f87150d79cb8',$content="",$source_id='cm_guangong'){
        $smsUrl = env('SMS_URL');
        $smsArr = array();
        $smsTime = time();
        $smsArr['server_type'] = 0;
        $smsArr['mobiles'] = $mobile;//"13426335082,18613166226,18911471295,13724362890,18600986606,18611855645";
//        $signStr = 'ed68d119fd85ba6422f9f87150d79cb8'.'本次复审人数已达上限，请及时调整复审策略，谢谢。'.$smsTime;
        $signStr = $_sk.$content.$smsTime;
        $smsArr['sign'] = md5($signStr);
        $smsArr['content'] = $content;
        $smsArr['ctime'] = $smsTime;
        $smsArr['source_id'] = $source_id;
        $smsStatus = $this->curlGet($smsUrl,'post',$smsArr);

        return $smsStatus;
    }

//发送邮件函数

    public function SendEmail($name="",$title="",$to=array(),$file_path="",$filename=""){


        $flag = Mail::send('emails.collect',['name'=>$name],function($message){
            $to = array('zengfanxin@cmcm.com');
            $message->from(env('MAIL_REPORT_SENDER'));
            $title = "";//'抽查审核数据_'.date("Y/m/d",strtotime("-1 day"));
            $message ->to($to)->subject($title);
            if(!empty($file_path) && !empty($filename)) {
                $attachment = storage_path('collect.csv');

                $filename = '抽查审核数据_' . date("Y-m-d", strtotime("-1 day")) . '.csv';
                $message->attach($attachment, ['as' => $filename]);
            }
        });
        var_dump($flag);die;
    }


}

