<?php
namespace App\Repositories\Admin;

use App\Constants\CommonConstant;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;


class RoleRepository extends BaseRepository
{
    private $dbObj;
    private $roleTable;

    public function __construct()
    {
        $this->dbObj = DB::connection('mysql_log_admin');
        $this->roleTable = 'log_role';
    }

    public function getDataListAll()
    {
        $where[] = ['status','!=',0];
        return $this->dbObj->table($this->roleTable)
                ->select('id', 'role_name','description',
                $this->dbObj->raw('from_unixtime(create_time, "%Y-%m-%d %H:%i:%s") as createTime'))
                ->where($where)
                ->get();
    }


    public function getDataListPage()
    {
        $where[] = ['status','!=',0];
        return  $this->dbObj->table($this->roleTable)
                ->select('id', 'role_name','description',
                    $this->dbObj->raw('if(create_time<>0,from_unixtime(create_time, "%Y-%m-%d %H:%i:%s"),null ) as create_time'))
                ->where($where)
                ->paginate(CommonConstant::PAGE_NUMBER);
    }



    public function insert($params)
    {
        $data = array();
        $data['role_name'] = $params['role_name'] ?? '';
        $data['parent_id'] = 0;
        $data['status'] = 1;
        $data['level'] = $params['level'] ?? 99;
        $data['description'] = $params['description'] ?? 99;
        $data['create_time'] = time();
        $data['update_time'] = time();

        return $this->dbObj->table($this->roleTable)->insert($data);
    }



    public function deleteByRoleId($roleId)
    {
        return $this->dbObj->table($this->roleTable)->where('id', $roleId)->update(['status' => 0]);
    }
}
