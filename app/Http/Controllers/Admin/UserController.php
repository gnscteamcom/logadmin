<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Format\Admin\UserFormat;
use App\Constants\ReturnStatusConstant;
use App\Constants\AdminStatusConstant;
use App\Repositories\Admin\RoleRepository;
use App\Repositories\Admin\UserRepository;
use App\Services\ToolService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $userRepository;
    private $userFormat;

    public function __construct(Request $request,
                                 UserFormat $format,
                                 AdminStatusConstant $adminStatusConstant,
                                 RoleController $roleController,
                                 UserRepository $userRepository,
                                 RoleRepository $roleRepository)
    {
        $this->request = $request;
        $this->userFormat = $format;
        $this->adminStatusConstant = $adminStatusConstant;
        $this->roleController = $roleController;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }



    /**
     * 用户列表
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $userObj = $this->userRepository->getUsers($params);

        $userData = ToolService::stdClass2array($userObj);

        $userData['stausList'] = $this->adminStatusConstant :: ADMIN_STATUS_LIST;

        return view('backend.users.index',$userData);
    }



    /**
     * 添加用户页面
     */
    public function createUserInfo()
    {
        $roleList = $this->roleController->selectRoleList();

        $param['role_list'] = $roleList;

        return view('backend.users.create_info',$param);
    }



    /**
     * 添加用户
     */
    public function createUser()
    {
        $insert = $this->userRepository->insert($this->request->all());

        if($insert !== false)
        {
            return redirect("admin/user/index");
        }
        else
        {
            return 'Add Error';
        }
    }



    /**
     * 更新用户信息页面
     */
    public function updateUserInfo()
    {
        if($this->request->get('user_id') !== false)
        {
            $userId = $this->request->get('user_id');
            $userInfoObj = $this->userRepository->getUserInfoByUserId($userId);
            $userInfoData = ToolService::stdClass2array($userInfoObj);

            $param['user_info'] =$userInfoData;
            $param['role_list'] = $this->roleController->selectRoleList();;

            return view('backend.users.update_info',$param);
        }
        else
        {
            return 'user id 不可为空';
        }
    }



    /**
     * 更新用户信息
     */
    public function updateUser()
    {
        if($this->request->get('user_id') !== false)
        {
            $update = $this->userRepository->updateByUserId($this->request->all(),$this->request->get('user_id'));
            if($update !== false)
            {
                return redirect("admin/user/index");
            }
            else
            {
                return 'Add Error';
            }
        }
        else
        {
            return 'user id 不可为空';
        }
    }



    /**
     * 用户信息
     */
    public function UserInfo()
    {
       echo $this->request->get('user_id');
    }



    /**
     * 删除用户
     */
    public function deleteUserData()
    {
        if($this->request->get('user_id') !== false)
        {
            $delete = $this->userRepository->deleteByUserId($this->request->get('user_id'));
            if($delete !== false)
            {
                return redirect("admin/user/index");
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

}
