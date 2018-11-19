<?php

namespace App\Format\Auth;


use App\Repositories\Admin\MenuRepository;
use Illuminate\Support\Facades\Auth;

class AuthorityFormat
{
    public function formatUserAuthority($role_authority, $user_authority)
    {
        $lang = Auth::user()->lang;
        $result = array();

        $middle_result = array();
        $middle_result = $this->formatAuthority($user_authority, $middle_result);
        $middle_result = $this->formatAuthority($role_authority, $middle_result);

        $middle_result = array_values($middle_result);
        foreach ($middle_result as $item)
        {
            $item['children'] = array_values($item['children']);
            for ($index=0; $index <count($item['children']); $index++) {
                unset($item['children'][$index]['checked']);
            }
            if(isset($item['expand'])){
                unset($item['expand']);
            }else{
                $menuRep = new MenuRepository();
                $menu_info = $menuRep->getByMid($item['children'][0]['pid']);
                $item['id'] = $menu_info->id;
                $item['name'] = $menu_info->name;
                $title = json_decode($menu_info->title, true);
                $item['title'] = $title[$lang];
                $item['icon'] = $menu_info->icon;
                $item['desc'] = $menu_info->description;
                $item['url'] = $menu_info->url;
            }
            $result[] = $item;
        }

        return $result;
    }

    public function formatAuthority($authorities, $result=[])
    {
        $lang = Auth::user()->lang;
        foreach ($authorities as $auth)
        {
            if($auth->pid == 0){
                $result[$auth->id]['children'] = array();
                $result[$auth->id]['id'] = $auth->id;
                $result[$auth->id]['name'] = $auth->name;
                $title = json_decode($auth->title, true);
                $result[$auth->id]['title'] = $title[$lang];
                $result[$auth->id]['icon'] = $auth->icon;
                $result[$auth->id]['desc'] = $auth->desc;
                $result[$auth->id]['url'] = $auth->url;
                $result[$auth->id]['expand'] = true;
            }else{
                $tmp['id'] = $auth->id;;
                $tmp['pid'] = $auth->pid;
                $tmp['name'] = $auth->name;
                $title = json_decode($auth->title, true);
                $tmp['title'] = $title[$lang];
                $tmp['icon'] = $auth->icon;
                $tmp['desc'] = $auth->desc;
                $tmp['url'] = $auth->url;
                $tmp['checked'] = false;
                $result[$auth->pid]['children'][$auth->id] = $tmp;
            }
        }

        return $result;
    }
}