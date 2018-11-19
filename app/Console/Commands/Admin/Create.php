<?php

namespace App\Console\Commands\Admin;

use App\Repositories\Admin\UserRepository;
use Illuminate\Console\Command;

class Create extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建管理员 昵称  邮箱  密码';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(UserRepository $userRepository)
    {
        $requests['user_name'] = $this->ask('请输入管理员名称?');
        $requests['email'] = $this->ask('请输入管理员邮箱?');
        $requests['password'] = $this->ask('请输入管理员密码?');
        $requests['telephone'] = $this->ask('请输入管理员手机号?');
        $admin_information = " 昵称:".$requests['user_name']."\n 邮箱".$requests['email']."\n 密码".$requests['password']."\n 手机号".$requests['telephone'];
        $this->info($admin_information);

        if ($this->confirm('确认管理员信息?')) {
            $requests['type'] = 1;
            $res = $userRepository->register($requests);
            if ($res) {
                $this->info('创建管理员成功');
            }else{
                $this->info('创建管理员失败');
            }
        }
    }
}
