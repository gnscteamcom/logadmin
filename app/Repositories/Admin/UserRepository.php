<?php
namespace App\Repositories\Admin;

use App\Constants\AdminStatusConstant;
use App\Constants\CommonConstant;
use App\Repositories\BaseRepository;
use App\Model\User;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class UserRepository extends BaseRepository
{
    private $dbObj;
    private $userTable;

    public function __construct()
    {
        $this->dbObj = DB::connection('mysql_log_admin');
        $this->userTable = 'log_user';
    }



    /**
     * 记录上次用户登录时间
     */
    public function lastLogin($userId, $lang='zh-CN')
    {
        $update['lang'] = $lang;
        $update['last_login_time'] = time();

        return $this->dbObj->table($this->userTable)->where('id', $userId)->update($update);
    }



    /**
     * 获取用户列表
     */
    public function getUsers()
    {
        $where[] = ['log_user.status','!=',AdminStatusConstant::ADMIN_STATUS_DELETE];
        return $this->dbObj->table($this->userTable)
            ->select('log_user.id', 'log_user.user_name', 'log_user.telephone', 'log_user.email', 'log_user.role_id','log_role.role_name',
                $this->dbObj->raw('if(log_user.create_time<>0,from_unixtime(log_user.create_time, "%Y-%m-%d %H:%i:%s"),null ) as create_time'),
                $this->dbObj->raw('if(log_user.last_login_time<>0,from_unixtime(log_user.last_login_time, "%Y-%m-%d %H:%i:%s"),null ) as last_login_time'),
                'log_user.status')
            ->leftJoin('log_role', 'log_user.role_id', '=' ,'log_role.id')
            ->where($where)
            ->orderBy('log_user.id', 'DESC')
            ->paginate(CommonConstant::PAGE_NUMBER);
    }



    /**
     * 获取用户列表
     */
    public function getUserInfoByUserId($uid)
    {
        return $this->dbObj->table($this->userTable)
            ->select('id', 'user_name', 'role_id', 'email', 'telephone', 'lang', 'status','description',
                $this->dbObj->raw("from_unixtime(create_time) as create_time"),
                $this->dbObj->raw("from_unixtime(last_login_time) as last_login_time"))
            ->where('id', $uid)
            ->first();
    }



    /**
     * 添加用户
     */
    public function insert($params)
    {
        $data = array();
        $data['user_name'] = $params['user_name'];
        $data['password'] = bcrypt($params['password']);
        $data['email'] = $params['email'];
        $data['telephone'] = $params['telephone'] ?? 2;
        $data['role_id'] = $params['role_id'] ?? 2;
        $data['status'] = 1;
        $data['lang'] = 'zh-CN';
        $data['description'] = $params['description'] ?? '';
        $data['create_time'] = time();
        $data['update_time'] = time();

        return $this->dbObj->table($this->userTable)->insert($data);
    }



    /**
     * 注册
     */
	public function register($requests){
        $user = new User();
        $user->user_name = $requests['user_name'];
        $user->email = $requests['email'];
        $user->telephone = $requests['telephone'];
        $user->status = isset($requests['status']) ? (int)$requests['status'] : AdminStatusConstant::ADMIN_STATUS_ABLE;
        $user->role_id = isset($requests['rid']) ? (int)$requests['rid'] : AdminStatusConstant::USER_ROLE_OBSERVER;
        $user->create_time = time();
        $user->update_time = time();
        if(isset($requests['password'])){
            $user->password = bcrypt($requests['password']);
        }
        $save =  $user->save();
        if($save){
            return $user->id;
        }
        return $save;
    }
	
	
	
    /**
     * 更改用户信息
     */
    public function updateByUserId($params, $userId)
    {
        if(empty($params)) {
            return true;
        }

        $update = array();
        if(isset($params['user_name']) && !empty($params['user_name'])) {
            $update['user_name'] = $params['user_name'];
        }

        if(isset($params['telephone']) && !empty($params['telephone'])) {
            $update['telephone'] = $params['telephone'];
        }

        if(isset($params['email']) && !empty($params['email'])) {
            $update['email'] = $params['email'];
        }

        if(isset($params['role_id']) && !empty($params['role_id'])) {
            $update['role_id'] = $params['role_id'];
        }

        if(isset($params['status']) && !empty($params['status'])) {
            $update['status'] = $params['status'];
        }

        if(isset($params['description']) && !empty($params['description'])) {
            $update['description'] = $params['description'];
        }

        $update['update_time'] = time();
        return $this->dbObj->table($this->userTable)->where('id', $userId)->update($update);

    }

    public function deleteByUserId($userId)
    {
        return $this->dbObj->table($this->userTable)->where('id', $userId)->update(['status' => 0]);
    }



    public function getUserInfo($uid)
    {
        return $this->dbObj->table($this->userTable)
            ->select('users.id', 'users.username', 'users.role_id', 'roles.name', 'users.email', 'users.tel', 'users.lang',
                'users.status', $this->dbObj->raw("from_unixtime(users.created) as createTime"),
                $this->dbObj->raw("from_unixtime(users.last_login_time) as last_login_time"))
            ->leftJoin('roles', 'roles.id', 'users.role_id')
            ->where('users.id', $uid)
            ->first();
    }
}
