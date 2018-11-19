<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\ToolService;
use App\Format\Admin\MenuFormat;
use App\Format\Admin\RoleMenuFormat;
use App\Repositories\Admin\MenuRepository;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    private $menuRepository;
    private $menuFormat;

    public function __construct(Request $request,
                                  MenuRepository $menuRepository,
                                  MenuFormat $menuFormat,
                                  RoleMenuFormat $roleMenuFormat)
    {
        $this->request = $request;
        $this->menuRepository = $menuRepository;
        $this->menuFormat = $menuFormat;
        $this->roleMenuFormat = $roleMenuFormat;
    }



    public function index()
    {
        $where = array();
        $allMenuObj = $this->menuRepository->getMenuListAllData($where);
        $allMenuData = ToolService::stdClass2array($allMenuObj);

        #生成菜单树
        $menuTree =  $this->roleMenuFormat->generateMenuTree($allMenuData, 0, 'id', 'parent_id');
        $menuTreeList = array();
        $menuTreeList = $this->roleMenuFormat->treeToArrayByRecursion($menuTree,$menuTreeList);

        $data['menuTreeList'] = $menuTreeList;
        $data['total'] = count($menuTreeList);
        return view('backend.menus.index',$data);
    }



    public function createMenuInfo()
    {
        return view('backend.menus.create_info');
    }



    public function createMenu()
    {
        $addData = array();
        $addData['name'] = $this->request->get('menu_name');
        $addData['level'] = $this->request->get('level');
        $addData['parent_id'] = $this->request->get('parent_id');
        $addData['link'] = $this->request->get('link') ?? '';
        $addData['description'] = $this->request->get('description') ?? '';
        $addData['create_time'] = time();
        $addData['update_time'] = time();
        $addData['admin_id'] = Auth::user()->id;

        $insert = $this->menuRepository->insertData($addData);

        if($insert === false )
        {
            return $this->jsonError(400, 'delete error');
        }
        else
        {
            return redirect("admin/menu/index");
        }
    }



    public function createSubmenuInfo()
    {
        if( $this->request->get('menu_id') !== false)
        {
            $menuId = $this->request->get('menu_id');

            $menuInfoObj = $this->menuRepository->getMenuInfoById($menuId);
            $menuInfoData = ToolService::stdClass2array($menuInfoObj);

            $param['parent_id'] =$menuId;
            $param['parent_name'] =$menuInfoData['name'];
            $param['level'] =$menuInfoData['level']+1;
            return view('backend.menus.create_sub_info',$param);
        }
        else
        {
            return $this->jsonError(400, 'menu id can not empty');
        }
    }




    public function updateMenuInfo()
    {
        if( $this->request->get('menu_id') !== false)
        {
            $menuId = $this->request->get('menu_id');
            $menuInfoObj = $this->menuRepository->getMenuInfoById($menuId);
            $menuInfoData = ToolService::stdClass2array($menuInfoObj);

            $param['menu_id'] = $menuId;
            $param['menu_name'] = $menuInfoData['name'];
            $param['level'] = $menuInfoData['level'];
            $param['link'] = $menuInfoData['link'];
            $param['description'] = $menuInfoData['description'];
            return view('backend.menus.update_info',$param);
        }
        else
        {
            return $this->jsonError(400, 'menu id can not empty');
        }
    }


    public function updateMenu()
    {
        if( $this->request->get('menu_id') !== false)
        {
            $whereData = array();
            $whereData['id'] = $this->request->get('menu_id');

            $updateData = array();
            $updateData['name'] = $this->request->get('menu_name');
            $updateData['link'] = $this->request->get('link') ?? '';
            $updateData['description'] = $this->request->get('description') ?? '';
            $updateData['update_time'] = time();
            $updateData['admin_id'] = Auth::user()->id;

            $update = $this->menuRepository->updateData($whereData,$updateData);
            if($update === false )
            {
                return $this->jsonError(400, 'update error');
            }
            else
            {
                return redirect("admin/menu/index");
            }

        }
        else
        {
            return $this->jsonError(400, 'menu id can not empty');
        }
    }
}
