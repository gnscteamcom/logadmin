<?php

namespace App\Http\Controllers;

use App\Http\Validator\ApiValidator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    /**
     *  引导页
     */
    public function guide()
    {
        if (!Auth::check())
        {
            return redirect("login");
        }
        else
        {
            return redirect("dashboard");
        }
    }



    /**
     *  dashboard页
     */
	public function dashboard()
	{
		return view("backend.dashboard");
	}
	
	
	
	public function jsonSuccess($data=[], $msg='ok')
    {
        $data = array(
            'code' => 200,
            'data' => $data,
            'msg' => $msg
        );

        return response()->json($data);
    }

    public function jsonError($code, $msg)
    {
        $data = array(
            'code' => $code,
            'data' => [],
            'msg' => $msg
        );

        return response()->json($data);
    }

    /**
     * @param Request $requet
     * @param $validatorRules  验证规则 参考 laravel 自带验证
     * @param $errorsMsg  错误信息 参考 laravel 验证错误信息格式
     * @param bool $sourceJson 数据key来源 json 或者 全部
     * @return mixed
     */
    public function validator(Request $requet,$validatorRules,$errorsMsg,$sourceJson = true){
        if ($sourceJson === true) {
            $data = $requet->json()->all();
        } else {
            $data = $requet->all();
        }

        $validator =  app('validator')->make($data,$validatorRules,$errorsMsg);

        return $validator;
    }

    public function validatorPolymorphism(array $data, ApiValidator $validator)
    {
        return app('validator')->make($data,$validator->rules(), $validator->messages());
    }

    protected function format($data, $formatter)
    {
        return $formatter($data);
    }
}
