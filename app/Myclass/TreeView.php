<?php

namespace app\Myclass;

class TreeView
{

    public function __construct()
    { }

    /**
     * Build Tree Json View
     * @param Array $data Array or object data
     * @return Array $data
     */
    public static function makeview($array = null)
    {
        if (\sizeof($array) > 0) {
            return self::map_array($array);
        } else {
            return array();
        }
    }


    private static function map_array($array)
    {
        $maped_tree = array();

        if(is_array($array)){
            $array_data = $array;
        }else if(is_object($array)){
            $array_data = $array->toArray()['data'] ?? $array->toArray();
        }
        foreach ($array as &$object) {
            if(in_array($object['parent_id'], array_column($array_data, 'id'))){
                $maped_tree[$object['parent_id'] ?? 0][] = &$object;
            }else{
                $maped_tree[0][] = &$object;
            }
            unset($object);
        }
        return self::array_tree($maped_tree, $array);
    }

    private static function array_tree($elements, $parent)
    {
        $item = array();
        foreach ($parent as $key => &$item) {
            if(isset($elements[$item['id']])){
                $item['child'] = $elements[$item['id']];
            }
        }
        return $elements[0] ?? [];
    }
}
