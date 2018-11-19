<?php
namespace App\Repositories\Admin;

use App\Constants\CommonConstant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class MenuRepository
{
    private $dbObj;
    private $menuTable;

    public function __construct()
    {
        $this->dbObj = DB::connection('mysql_log_admin');
        $this->menuTable = 'log_menu';
        $this->userTable = 'log_user';
    }



    /**
     * 分页获取菜单列表
     */
    public function getMenuListPage()
    {
        return $this->dbObj->table($this->menuTable." AS a")
            ->select('a.id', 'a.name','a.level','a.link','a.description','a.status',
                $this->dbObj->raw('from_unixtime(a.create_time, "%Y-%m-%d %H:%i:%s") as create_time'),
                'b.name as parent_name','c.user_name as user_name')
            ->leftJoin($this->menuTable." AS b", 'a.parent_id', '=' ,'b.id')
            ->leftJoin($this->userTable." AS c", 'a.admin_id', '=' ,'c.id')
            ->orderBy('a.id', 'DESC')
            ->paginate(CommonConstant::PAGE_NUMBER);
    }



    /**
     * 菜单全部数据
     */
    public function getMenuListAllData($where)
    {
        return $this->dbObj->table($this->menuTable." AS a")
            ->select('a.id', 'a.name','a.level','a.link','a.description','a.status',
                $this->dbObj->raw('if(a.create_time<>0,from_unixtime(a.create_time, "%Y-%m-%d %H:%i:%s"),null ) as create_time'),
                'a.parent_id','b.name as parent_name','c.user_name as user_name')
            ->leftJoin($this->menuTable." AS b", 'a.parent_id', '=' ,'b.id')
            ->leftJoin($this->userTable." AS c", 'a.admin_id', '=' ,'c.id')
            ->where($where)
            ->orderBy('id', 'ASC')
            ->get();
    }



    /**
     * 菜单全部数据
     */
    public function getMenuInfoById($menuId)
    {
        return $this->dbObj->table($this->menuTable)
            ->select('*')
            ->where(['id'=>$menuId])
            ->first();
    }



    /**
     * 添加
     */
    public function insertData($data)
    {
        return $this->dbObj->table($this->menuTable)->insert($data);
    }



    /**
     * 修改
     */
    public function updateData($whereData,$updateData)
    {
        return $this->dbObj->table($this->menuTable)->where($whereData)->update($updateData);
    }



    /**
     * 删除
     */
    public function deleteData($menuId)
    {
        return true;
    }
}