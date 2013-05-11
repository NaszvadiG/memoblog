<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class M_manage extends CI_Model {

    function mysql_count() {
        $data = "select concat(truncate(sum(data_length)/1024/1024,2),'MB') as data_size, concat(truncate(sum(max_data_length)/1024/1024,2),'MB') as max_data_size, concat(truncate(sum(data_free)/1024/1024,2),'MB') as data_free, concat(truncate(sum(index_length)/1024/1024,2),'MB') as index_size from information_schema.tables where TABLE_SCHEMA = 'justfree'";
        return $data = $this->db->query($data);
    }

    function post_count() {
        $data = "select concat(truncate(sum(data_length)/1024/1024,2),'MB') as data_size, concat(truncate(sum(max_data_length)/1024/1024,2),'MB') as max_data_size, concat(truncate(sum(data_free)/1024/1024,2),'MB') as data_free, concat(truncate(sum(index_length)/1024/1024,2),'MB') as index_size from information_schema.tables where TABLE_NAME = 'jf_post'";
        return $data = $this->db->query($data);
    }

    function backup() {
        $this->load->dbutil();
        $backup = & $this->dbutil->backup();
        $this->load->helper('file');
        $bkpath = 'backup_' . date('Ymd') . '.gz';
        write_file($bkname, $backup);
        $this->load->helper('download');
        force_download($bkpath, $backup);
    }

}

/* End of file m_manage.php */
/* Location: ./application/models/m_manage.php */