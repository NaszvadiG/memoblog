<?php

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
// 支持中文 get 传值
class MY_Input extends CI_Input {

    function _clean_input_keys($str) {
        $config = &get_config('config');
        if (!preg_match("/^[" . $config['permitted_uri_chars'] . "]+$/i", urlencode($str))) {
            exit('Disallowed Key Characters.');
        }
        return $str;
    }

}

/* End of file MY_Input.php */
/* Location: ./application/libraries/MY_Input.php */