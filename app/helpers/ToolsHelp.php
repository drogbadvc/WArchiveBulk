<?php

namespace App\helpers;

class ToolsHelp {
    /**
     * @param $arr
     * @return float|int
     */
    public function countHits($arr) {
        $arr_sum = [];
        foreach ($arr as $years) {
            $arr_sum[] = array_sum($years);
        }
        return array_sum($arr_sum);
    }

    /**
     * @param $info
     * @param false $capture
     * @return string
     */
    public function getDomain($info, $capture = false): string
    {
        if($capture) {
            $re = '/\?url=+[a-z0-9-]+.[a-z]{2,4}/m';
        }else{
            $re = '/&url=+[a-z0-9-]+.[a-z]{2,4}/m';
        }
        $str = $info;
        preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
        $clean = str_replace(array('&url=', '?url='), '', $matches[0]);
        return current($clean);
    }
}