<?php

namespace App\Format\Admin;


use App\Services\ToolService;
use Illuminate\Support\Facades\Auth;

class MenuFormat
{












    /**
     * @param $menus
     * @return array
     */
    public function formatMenu($menus)
    {
        $result = array();
        $middle_result = array();
        $lang = Auth::user()->lang;

        foreach ($menus as $menu) {
            if($menu->parentId == 0) {
                $middle_result[$menu->id]['children'] = array();
                $middle_result[$menu->id]['id'] = $menu->id;
                $middle_result[$menu->id]['name'] = $menu->name;
                $title = json_decode($menu->title, true);
                $middle_result[$menu->id]['title'] = $title[$lang];
                $middle_result[$menu->id]['icon'] = $menu->icon;
                $middle_result[$menu->id]['desc'] = $menu->description;
                $middle_result[$menu->id]['url'] = $menu->url;
                $middle_result[$menu->id]['expand'] = true;
            }else{
                $tmp['name'] = $menu->name;
                $tmp['id'] = $menu->id;
                $tmp['pid'] = $menu->parentId;
                $title = json_decode($menu->title, true);
                $tmp['title'] = $title[$lang];
                $tmp['icon'] = $menu->icon;
                $tmp['desc'] = $menu->description;
                $tmp['url'] = $menu->url;
                $middle_result[$menu->parentId]['children'][$menu->id][] = $tmp;
            }
        }

        $middle_result = array_values($middle_result);
        foreach ($middle_result as $item) {
            $item['children'] = array_values($item['children']);
            $tmp = array();
            foreach ($item['children'] as $child)
            {
                foreach ($child as $c){
                    $tmp[] = $c;
                }
            }
            $item['children'] = $tmp;
            $result[] = $item;
        }

        return $result;
    }

    /**
     * 格式话下拉列表框的菜单数据
     * @param $menus
     * @return array
     */
    public function formatSelectMenus($menus)
    {
        $result = array();
        foreach ($menus as $menu) {
            $title = json_decode($menu->title,true);
            $lang = Auth::user()->lang;
            $tmp['id'] = $menu->id;
            $tmp['title'] = $title[$lang];
            $result[] = $tmp;
        }

        return $result;
    }
}