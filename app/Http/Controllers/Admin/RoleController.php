<?php

namespace App\Http\Controllers\Admin;
use App\Services\ToolService;
use App\Constants\ReturnStatusConstant;
use App\Format\Admin\RoleFormat;
use App\Http\Controllers\Controller;
use App\Http\Validator\Admin\AddRoleValidator;
use App\Repositories\Admin\RoleRepository;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    private $roleRepository;
    private $roleFormat;

    public function __construct(Request $request, RoleRepository $roleRepository, RoleFormat $roleFormat)
    {
        $this->roleRepository = $roleRepository;
        $this->roleFormat = $roleFormat;
        $this->request = $request;
    }



    /**
     * 角色列表
     */
    public function index()
    {
        $dataObj = $this->roleRepository->getDataListPage();

        $roleData = ToolService::stdClass2array($dataObj);

        return view('backend.roles.index',$roleData);
    }



    /**
     * 创建角色页面
     */
    public function createRoleInfo()
    {
        return view('backend.roles.create_info');
    }



    /**
     * 创建角色
     */
    public function createRole(Request $request)
    {
        $insert = $this->roleRepository->insert($request->all());

        if($insert !== false)
        {
            return redirect("admin/role/index");
        }
        else
        {
            return 'Add Error';
        }
    }



    /**
     * 角色删除
     */
    public function deleteRoleData()
    {
        if($this->request->get('role_id') !== false)
        {
            $delete = $this->roleRepository->deleteByRoleId($this->request->get('role_id'));
            if($delete !== false)
            {
                return redirect("admin/role/index");
            }
            else
            {
                return $this->jsonError(ReturnStatusConstant::STATUS_SERVER_ERROR, 'delete error!');
            }
        }
        else
        {
            return $this->jsonError(ReturnStatusConstant::STATUS_PARAMS, 'role id can not be empty!');
        }
    }



    /**
     * 角色下拉列表
     */
    public function selectRoleList()
    {
        $roleObj = $this->roleRepository->getDataListAll();

        $roleArray = ToolService::stdClass2array($roleObj);

        return array_column($roleArray,'role_name','id');

    }
}
