<?php
/**
 * Format
 */
namespace App\Format\Common;
use App\Format\Common\Format;
use App\Services\OSS;

class  Format
{


    public function __construct(){}



    public function getContentByCurl($url,$method,$post_data = 0)
	{
        $ch = curl_init();
        
		curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
		if ($method == 'post') 
		{
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }
		elseif($method == 'get')
		{
            curl_setopt($ch, CURLOPT_HEADER, 0);
        }
		
        $output = curl_exec($ch);
		
        curl_close($ch);
		
        return $output;
    }

	
	
	/**
	 * 阿里云获取文件内容
	 */
    public function getOssFileContent($ossKey){
        $bucketName = env('AWS_BUCKET');
        $res = OSS::getObject($bucketName,$ossKey);
        
		$str = "";
        if($res){
            $resource = $res->getObjectContent();
            $str = stream_get_contents($resource);
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
			$cardStr = $this->getOssFileContent($cardPath);
            $base64Card = base64_encode($cardStr);

			return $base64Card ?? '';
        }
		else
		{
			return '';
		}
	}
	
	
	
	/**
	 * 根据出生时间戳计算年龄
	 */
	public function calculateAgeByTimestamp($timestamp)
	{
		$birthYear = date('Y',$timestamp);//出生年
		$thisYear = date('Y',time());//今年
		$birthMonthDay = date('m-d',$timestamp);//出生月日
		$thisMonthDay = date('m-d',time());//当年月日
		
		$age = intval($thisYear - $birthYear);
		
		if($thisMonthDay < $birthMonthDay){//今年是否已经过生日
			$age--;
		}
		
		return $age;
	}
	
	
}
