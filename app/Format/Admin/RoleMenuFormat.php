<?php
namespace App\Format\Admin;


class RoleMenuFormat
{
    /**
     *  递归方式将树型结构，转成数组
     */
    public function treeToArrayByRecursion($menuTree,$menuTreeList)
    {
        foreach($menuTree as $menu){
            $temp = array();
            $temp['id'] = $menu['id'];
            $temp['level'] = $menu['level'];
            $temp['parent_id'] = $menu['parent_id'];
            $temp['link'] = $menu['link'];
            $temp['name'] = $this->prefixBlankCount($menu['level']).$menu['name'];
            $temp['parent_name'] = $menu['parent_name'];
            $temp['create_time'] = $menu['create_time'];
            $temp['user_name'] = $menu['user_name'];
            $menuTreeList[] = $temp;
            if(!empty($menu['child'])){
                $menuTreeList = $this->treeToArrayByRecursion($menu['child'],$menuTreeList);
            }
        }

        return $menuTreeList;
    }



    public function prefixBlankCount($count)
    {
        $blank = '';
        for($i = 0 ; $i < $count-1 ; $i++){
            $blank .= "&nbsp; &nbsp; &nbsp; &nbsp;";
        }
        return $blank;
    }



    /**
     * 数组根据父id生成树
     * @staticvar int $depth 递归深度
     * @param array $data 数组数据
     * @param integer $pid 父id的值
     * @param string $key id在$data数组中的键值
     * @param string $chrildKey 要生成的子的键值
     * @param string $pKey 父id在$data数组中的键值
     * @param int $maxDepth 最大递归深度，防止无限递归
     * @return array 重组后的数组
     */
    public function generateMenuTree($data, $pid = 0, $key = 'id', $pKey = 'parent_id', $childKey = 'child', $maxDepth = 0)
    {
        static $depth = 0;
        $depth++;
        if (intval($maxDepth) <= 0)
        {
            $maxDepth = count($data) * count($data);
        }
        if ($depth > $maxDepth)
        {
            exit("error recursion:max recursion depth {$maxDepth}");
        }
        $tree = array();
        foreach ($data as $rk => $rv)
        {
            if ($rv[$pKey] == $pid)
            {
                $rv[$childKey] = $this->generateMenuTree($data, $rv[$key], $key, $pKey, $childKey, $maxDepth);
                $tree[] = $rv;
            }
        }
        return $tree;
    }
}