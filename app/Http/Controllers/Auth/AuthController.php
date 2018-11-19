<?php

namespace App\Http\Controllers\Auth;

use App\Constants\AdminStatusConstant;
use App\Constants\ReturnStatusConstant;
use App\Format\Auth\AuthorityFormat;
use App\Http\Controllers\Captcha\Gregwar;
use App\Repositories\Admin\RoleMenuRepository;
use App\Repositories\Admin\UserMenuRepository;
use App\Repositories\Admin\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    use ThrottlesLogins;

    protected $redirectPath = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }



    /**
     * 后台登录接口 页面
     */
    public function index()
    {
        return view('auth.login');
    }



    /**
     * 后台登录接口
     * @param Request $request
     * @param UserRepository $userRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, UserRepository $userRepository, Gregwar $gregwar)
    {
        $params = $request->all();
        // 验证码验证
        if(!isset($params['captcha'])  || (isset($params['captcha']) && !$gregwar->verify($params['captcha']))) {
                return $this->jsonError(ReturnStatusConstant::STATUS_PARAMS,'Login failed! VerifyCode error.');
        }

        // 用户名密码验证
        if(Auth::attempt(['user_name'=>$params['user_name'], 'password'=>$params['password'], 'status'=>AdminStatusConstant::ADMIN_STATUS_ABLE], true))
        {
            $userRepository->lastLogin(Auth::user()->id);
        }
        else
        {
            return $this->jsonError(ReturnStatusConstant::STATUS_PARAMS, 'Login failed! user name or password error');
        }

        return redirect("dashboard");
    }



    /**
     * 退出登录接口
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        if(Auth::check()) {
            Auth::logout();
        }

        return redirect("login");
    }



    /**
     * 获取登录用户的菜单
     */
    public function getUserAuthority( AuthorityFormat $authorityFormat,
                                        RoleMenuRepository $roleMenuRepository,
                                        UserMenuRepository $userMenuRepository)
    {
        $uid = Auth::user()->id;
        $rid = Auth::user()->role_id;

        $role_authority = $roleMenuRepository->getRoleAuthorityByRid($rid);
        $user_authority = $userMenuRepository->getUserAuthorityByUid($uid);

        $authority = $authorityFormat->formatUserAuthority($role_authority, $user_authority);

        return $this->jsonSuccess($authority);
    }
}