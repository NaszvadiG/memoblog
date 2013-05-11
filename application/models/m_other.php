<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class M_other extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // 获取其他，$type fornt/back/backto 默认 front，$num 每页数量 为 0 获取全部，$offset 偏移量
    function get($type, $num, $offset) {
        $query = '';
        switch ($type) {
            default :
            case 'front':
                $this->db->select('OtherName,OtherAbout,HtmlUrl,AddTime');
                $this->db->order_by("AddTime", "desc");
                return $query = $this->db->get_where('other', array('IsShowID >' => 2), $num, $offset);
                break;
            case 'back':
                $this->db->select('OtherID,OtherName,AddTime,HtmlUrl,IsShowName');
                $this->db->join('isshow', 'isshow.IsShowID = other.IsShowID');
                $this->db->order_by("AddTime", "desc");
                return $query = $this->db->get('other', $num, $offset);
                break;
            case 'backto':
                $this->db->select('OtherID,OtherName,AddTime,HtmlUrl,IsShowName');
                $this->db->join('isshow', 'isshow.IsShowID = other.IsShowID');
                $this->db->order_by("AddTime", "desc");
                return $query = $this->db->get_where('other', array('other.IsShowID <' => 3), $num, $offset);
                break;
        }
    }

    // 获取其他数量，$type fornt/back/backto 默认 front
    function count($type) {
        $this->db->select('OtherID');
        $this->db->from('other');
        switch ($type) {
            default :
            case 'front':
                $this->db->where(array('IsShowID >' => 2));
                break;
            case 'back':
                break;
            case 'backto':
                $this->db->where(array('IsShowID <' => 3));
                break;
        }
        return $this->db->count_all_results();
    }

    // 后台获取其他，$id 编号
    function post($id) {
        return $query = $this->db->get_where('other', array('OtherID' => $id));
    }

    // 插入其他
    function insert() {
        $data = array(
            'OtherName' => $this->input->post('OtherName'),
            'OtherAbout' => $this->input->post('OtherAbout'),
            'HtmlUrl' => $this->input->post('HtmlUrl'),
            'IsShowID' => $this->input->post('IsShowID'),
            'AddTime' => date('Y-m-d h:m:s'),
            'AddIP' => $this->input->ip_address(),
        );
        $this->db->insert('other', $data);
        return $this->db->insert_id();
    }

    // 编辑其他
    function update($id) {
        $data = array(
            'OtherName' => $this->input->post('OtherName'),
            'OtherAbout' => $this->input->post('OtherAbout'),
            'HtmlUrl' => $this->input->post('HtmlUrl'),
            'IsShowID' => $this->input->post('IsShowID'),
        );
        $this->db->update('other', $data, array('OtherID' => $id));
        return $this->db->affected_rows();
    }

    // 删除其他，$query 待删除编号数组
    function delete($query) {
        $num = 0;
        if ($query === '') {
            return;
        }
        if (is_array($query)) {
            foreach ($query as $item) {
                $num = $this->delete($item) + $num;
            }
        } else {
            $this->db->where('OtherID', $query);
            $this->db->delete('other');
            return $this->db->affected_rows();
        }
        return $num;
    }

}

/* End of file m_other.php */
/* Location: ./application/models/m_other.php */