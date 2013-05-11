<?php
// 支持中文截取，utf-8 格式
function str_cut($string, $start, $len, $byte=3) {
        $str = "";
        $count = 0;
        $str_len = strlen($string);
        for ($i = 0; $i < $str_len; $i++) {
                if (($count + 1 - $start) > $len) {
                        $str .= "...";
                        break;
                } elseif ((ord(substr($string, $i, 1)) <= 128) && ($count < $start)) {
                        $count++;
                } elseif ((ord(substr($string, $i, 1)) > 128) && ($count < $start)) {
                        $count = $count + 2;
                        $i = $i + $byte - 1;
                } elseif ((ord(substr($string, $i, 1)) <= 128) && ($count >= $start)) {
                        $str .= substr($string, $i, 1);
                        $count++;
                } elseif ((ord(substr($string, $i, 1)) > 128) && ($count >= $start)) {
                        $str .= substr($string, $i, $byte);
                        $count = $count + 2;
                        $i = $i + $byte - 1;
                }
        }
        return $str;
}

/* End of file MY_text_hepler.php */
/* Location: ./application/helpers/MY_text_hepler.php */