<?php

namespace App\Http\Middleware;

use App\Services\ToolService;
use App\Exceptions\ApiStatusException;
use App\Facades\Permission\Facade\Permission;
use App\Repositories\Admin\RoleMenuRepository;
use Illuminate\Support\Facades\Auth;
use Closure;

class HasPermission
{
    public function __construct(RoleMenuRepository $roleMenuRepository)
    {
        $this->roleMenuRepository = $roleMenuRepository;
    }



    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws ApiStatusException
     */
    public function handle($request, Closure $next)
    {
        $myRoleId = Auth::user()->role_id;

        $requestUrl = $_SERVER["REQUEST_URI"];
        $requestUrl =  strstr($requestUrl,'?') ? explode('?',$requestUrl)[0] : $requestUrl;//去除get参数

        $dataObj = $this->roleMenuRepository->getMemuDataByRoleId($myRoleId,$requestUrl);

        $data = ToolService::stdClass2array($dataObj);

        if($myRoleId != 1 && empty($data) ){
            return  response('无权查看'.$requestUrl , 403);
        }

        return $next($request);
    }





}
