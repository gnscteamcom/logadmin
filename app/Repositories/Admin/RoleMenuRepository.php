<?php


namespace App\Repositories\Admin;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleMenuRepository
{
    private $dbObj;
    private $roleMenuTable;

    public function __construct()
    {
        $this->dbObj = DB::connection('mysql_log_admin');
        $this->menuTable = 'log_menu';
        $this->roleMenuTable = 'log_role_menu';
    }



    /**
     * 按照role_id与链接，查找菜单
     */
    public function getMemuDataByRoleId($roleId,$link)
    {
        $where = array();
        $where[] = ['b.role_id','=',$roleId];
        $where[] = ['a.link','=',$link];

        return $this->dbObj->table($this->menuTable .' AS a')
                ->select('a.id','a.link' )
                ->leftJoin( $this->roleMenuTable ." AS b", 'a.id', '=', 'b.menu_id')
                ->where($where)
                ->get();
    }



    /**
     * 菜单全部数据
     */
    public function getRoleMenuListAllData($where)
    {
        return $this->dbObj->table($this->roleMenuTable)
            ->select('*')
            ->where($where)
            ->orderBy('id', 'ASC')
            ->get();
    }



    public function add($data)
    {
        return $this->dbObj->table($this->roleMenuTable)->insert($data);
    }



    public function deleteMenuList($where,$menuList)
    {
        return $this->dbObj->table($this->roleMenuTable)->where($where)->whereIn('menu_id',$menuList)->delete();
    }



    /**
     * 当前登录的用户所有的权限
     */
    public function getRoleAuthorityByRid($rid)
    {
        return $this->dbObj->table($this->roleMenuTable)
            ->select('menu.id', 'menu.parentId as pid', 'menu.name', 'menu.title', 'menu.icon',
                'menu.description as desc', 'menu.url')
            ->leftJoin('menu', 'menu.id', '=', 'role_menu.mid')
            ->where('role_menu.rid', $rid)
            ->get();
    }
}