<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ToolService;
use App\Repositories\Admin\{MenuRepository,RoleMenuRepository};
use App\Http\Controllers\Controller;
use App\Format\Admin\RoleMenuFormat;



class RoleMenuController extends Controller
{
    public function __construct( Request $request ,
                                   RoleMenuRepository $roleMenuRepository,
                                   MenuRepository $menuRepository,
                                   RoleMenuFormat $roleMenuFormat)
    {
        $this->request = $request;
        $this->menuRepository = $menuRepository;
        $this->roleMenuRepository = $roleMenuRepository;
        $this->roleMenuFormat = $roleMenuFormat;
    }



    public function menuTreeList()
    {
        $where = array();
        $allMenuObj = $this->menuRepository->getMenuListAllData($where);
        $allMenuData = ToolService::stdClass2array($allMenuObj);

        #生成菜单树
        $menuTree =  $this->roleMenuFormat->generateMenuTree($allMenuData, 0, 'id', 'parent_id');
        $menuTreeList = array();
        $menuTreeList = $this->roleMenuFormat->treeToArrayByRecursion($menuTree,$menuTreeList);

        #获取当前角色下，可以查看的菜单
        $where = array();
        $where[] = ['role_id','=',$this->request->get('role_id')];
        $currentRoleMenuObj = $this->roleMenuRepository->getRoleMenuListAllData($where);
        $currentRoleMenuData = ToolService::stdClass2array($currentRoleMenuObj);
        $currentRoleMenuList = array_column($currentRoleMenuData,'menu_id');

        foreach($menuTreeList as $key => $value){
            $menuTreeList[$key]['is_checked'] = in_array($value['id'],$currentRoleMenuList) ?  "checked='checked'" : "";
        }

        $data['menuTreeData'] = $menuTreeList;
        $data['role_id'] = $this->request->get('role_id');

        return view('backend.role_menu.menu_tree',$data);
    }



    public function updateRoleMenu()
    {
        $menuTreeCheckbox = $this->request->get('menuTreeCheckbox') ?? array();
        $currentRoleId = $this->request->get('role_id');

        $where = array();
        $where[] = ['role_id','=',$currentRoleId];
        $currentRoleMenuObj = $this->roleMenuRepository->getRoleMenuListAllData($where);
        $currentRoleMenuData = ToolService::stdClass2array($currentRoleMenuObj);
        $currentRoleMenuList = array_column($currentRoleMenuData,'menu_id');


        #要添加的菜单id
        $addMenuList = array_diff($menuTreeCheckbox,$currentRoleMenuList);
        $addMenuData = array();
        foreach ($addMenuList as $menuId){
            $temp = array();
            $temp['role_id'] = $currentRoleId;
            $temp['menu_id'] = $menuId;
            $temp['admin_id'] = Auth::user()->id;
            $addMenuData[] = $temp;
        }
        $add = $this->roleMenuRepository->add($addMenuData);
        if($add === false ){
            return $this->jsonError(400, 'add error');
        }


        #要移除的菜单id
        $deleteMenuList = array_diff($currentRoleMenuList,$menuTreeCheckbox);

        $where = array();
        $where[] = ['role_id','=',$currentRoleId];
        $delete = $this->roleMenuRepository->deleteMenuList($where,$deleteMenuList);
        if($delete === false ){
            return $this->jsonError(400, 'delete error');
        }

        return redirect("admin/role/index");
    }
}
