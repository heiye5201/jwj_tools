<?php
/**
 * autor      : jiweijian
 * createTime : 2020/12/8 5:56 下午
 * description:
 */
namespace jwj_tools\tools;

class Common {


    public function getMenu($items, $id='id', $pid='pid', $son = 'children')
    {
        $tree = array();
        $tmpMap = array();

        foreach ($items as $item) {
            $tmpMap[$item[$id]] = $item;
        }

        foreach ($items as $item) {
            if (isset($tmpMap[$item[$pid]])) {
                $tmpMap[$item[$pid]][$son][] = &$tmpMap[$item[$id]];
            } else {
                $tree[] = &$tmpMap[$item[$id]];
            }
        }
        return $tree;
    }



    /**
     * 数字转换为中文
     * @param  integer  $num  目标数字
     */
    public function number2chinese($num)
    {
        if (is_int($num) && $num < 100) {
            $char = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
            $unit = ['', '十', '百', '千', '万'];
            $return = '';
            if ($num < 10) {
                $return = $char[$num];
            } elseif ($num%10 == 0) {
                $firstNum = substr($num, 0, 1);
                if ($num != 10) $return .= $char[$firstNum];
                $return .= $unit[strlen($num) - 1];
            } elseif ($num < 20) {
                $return = $unit[substr($num, 0, -1)]. $char[substr($num, -1)];
            } else {
                $numData = str_split($num);
                $numLength = count($numData) - 1;
                foreach ($numData as $k => $v) {
                    if ($k == $numLength) continue;
                    $return .= $char[$v];
                    if ($v != 0) $return .= $unit[$numLength - $k];
                }
                $return .= $char[substr($num, -1)];
            }
            return $return;
        }
        return '' ;
    }


    public function sec2time($sec){

        $sec = round($sec/60);
        if ($sec >= 60){
            $hour = floor($sec/60);
            $min = $sec%60;
            $res = $hour.'h';
            $min != 0&&$res .= $min.'m';
        }else{
            $res = $sec.'m';
        }
        return $res;
    }


    /**
     * tree封装
     * @param $tree
     * @param int $rootId
     * @return array
     */
    public function arr2tree($tree, $rootId = 0) {
        $return = array();
        foreach ($tree as &$item){
            $item['pid'] = $item['parent_id'] ;
        }
        foreach($tree as $leaf) {
            if($leaf['parent_id'] == $rootId) {
                foreach($tree as $subleaf) {
                    if($subleaf['parent_id'] == $leaf['id']) {
                        $leaf['children'] = arr2tree($tree, $leaf['id']);
                        break;
                    }
                }
                $return[] = $leaf;
            }
        }
        return $return;
    }



    public function getChar(){
        return [
            "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","X","Y","Z"
        ] ;
    }




    public function getDirFileName($dir) {
        $array = array();
        //1、先打开要操作的目录，并用一个变量指向它
        //打开当前目录下的目录pic下的子目录common。
        $handler = opendir($dir);
        //2、循环的读取目录下的所有文件
        /* 其中$filename = readdir($handler)是每次循环的时候将读取的文件名赋值给$filename，为了不陷于死循环，所以还要让$filename !== false。一定要用!==，因为如果某个文件名如果叫’0′，或者某些被系统认为是代表false，用!=就会停止循环 */
        while (($filename = readdir($handler)) !== false) {
            // 3、目录下都会有两个文件，名字为’.'和‘..’，不要对他们进行操作
            if ($filename != '.' && $filename != '..') {
                // 4、进行处理
                array_push($array, $filename);
            }
        }
        //5、关闭目录
        closedir($handler);
        return $array;
    }


}
