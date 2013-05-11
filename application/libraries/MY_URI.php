<?php

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
// 支持中文 get 传值
class MY_URI extends CI_URI {

    function _filter_uri($str) {
        if ($str != '' AND $this->config->item('permitted_uri_chars') != '') {
            if (!preg_match("|^[" . preg_quote($this->config->item('permitted_uri_chars')) . "]+$|i", urlencode($str))) {
                exit('The URI you submitted has disallowed characters.');
            }
        }
        return $str;
    }

}

/* End of file MY_URI.php */
/* Location: ./application/libraries/MY_URI.php */