<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter的人民币金额辅助函数
 * 其中num2rmb函数的作用是用于将阿拉伯数字金额转换为中文大写金额，如将120.50转换为“壹佰贰拾元伍角零分”
 * 请在控制器或视图中通过 $this-&gt;load-&gt;helper('rmb'); 来载入此辅助函数；
 */
if (!function_exists('num2rmb')) {

    function num2rmb($Arabic_numbers) {
        $Chinese_numbers = array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖'); //中文大写数字
        //$oldval=$Arabic_numbers;<span id="more-63"></span>
        $Arabic_numbers = str_replace(",", "", $Arabic_numbers);
        $Arabic_numbers = number_format($Arabic_numbers, 2); //将数字$Arabic_numbers格式化，精度为小数点后2位
        $Arabic_numbers = str_replace(".", "", $Arabic_numbers);
        $Arabic_numbers = str_replace(",", "", $Arabic_numbers);
        $original_num = $Arabic_numbers;
        $Arabic_numbers = abs($Arabic_numbers); //取绝对值
        if ($original_num != $Arabic_numbers) { //如果原始值与绝对值不相等，说明$Arabic_numbers为负数
            $m = "负";
        } else {
            $m = '';
        }
        for ($i = 1; $i <= strlen($Arabic_numbers); $i++) {
            $mynum = substr($Arabic_numbers, $i - 1, 1);
            switch (strlen($Arabic_numbers) + 1 - $i) {
                case 1:
                    $k = $mynum . "分";
                    break;
                case 2:
                    $k = $mynum . "角";
                    break;
                case 3:
                    $k = $mynum . "元";
                    break;
                case 4:
                    $k = $mynum . "拾";
                    break;
                case 5:
                    $k = $mynum . "佰";
                    break;
                case 6:
                    $k = $mynum . "仟";
                    break;
                case 7:
                    $k = $mynum . "万";
                    break;
                case 8:
                    $k = $mynum . "拾";
                    break;
                case 9:
                    $k = $mynum . "佰";
                    break;
                case 10:
                    $k = $mynum . "仟";
                    break;
                case 11 :
                    $k = $mynum . "亿";
                    break;
                case 12 :
                    $k = $mynum . "拾";
                    break;
                case 13:
                    $k = $mynum . "佰";
                    break;
                case 14:
                    $k = $mynum . "仟";
                    break;
            }
            $m = $m . $k;
        }
        foreach ($Chinese_numbers as $key => $Arabic_numbers) {
            $m = str_replace($key, $Arabic_numbers, $m); //字符替换，将阿拉伯数字0123456789对应的替换成"零壹贰叁肆伍陆柒捌玖"
        }
        return $m; //返回结果
    }

}

/* rmb_helper.php 文件结束 */
/* 本文件的位置应该是: ./application/helpers/rmb_helper.php */