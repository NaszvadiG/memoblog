<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
/**
 * CodeIgniter的关键字过滤函数
 * 用于在字符串中过滤一些敏感关键字
 * 请在控制器或视图中通过 $this-&gt;load-&gt;helper('filter'); 来载入此辅助函数；
 *
 *
 */
if (!function_exists('clean')) {

    function clean($string) {
        $keywords = array(
            'shit' => 's**t',
            'Shit' => 'S**t',
            'twat' => 't**t',
            '他妈的' => 'TMD',
            '狗日的' => '狗X的',
            'X你妈' => '草泥马',
            '躲猫猫' => '朵猫猫',
            '70码' => '欺实马',
            'Yamete' => '雅蔑蝶',
            'fuck you' => '法克鱿',
            '叉腰肌' => '猹妖鸡',
            '90后' => '九岭猴',
            '傻B' => '傻X'
        );
        return strtr($string, $keywords);
    }

}

/* MY_filter_helper.php 文件结束 */
/* 本文件的位置应该是: ./application/helpers/MY_filter_helper.php */