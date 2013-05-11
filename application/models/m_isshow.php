<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class M_isshow extends CI_Model {

    // 获取状态，post/back 默认 post
    function get($type, $num, $offset) {
        switch ($type) {
            default :
            case 'post':
                $this->db->select('IsShowID,IsShowName');
                break;
            case 'back':
                $this->db->select('IsShowID,IsShowName,IsShowOrder');
                break;
        }
        $this->db->order_by("IsShowOrder", "asc");
        return $query = $this->db->get('isshow', $num, $offset);
    }

    // 获取状态数量
    function count() {
        $this->db->from('isshow');
        return $this->db->count_all_results();
    }

    // 后台获取状态，$id 编号
    function post($id) {
        return $query = $this->db->get_where('isshow', array('IsShowID' => $id));
    }

    // 插入状态
    function insert($data) {
        $this->db->insert('isshow', $data);
        return $this->db->insert_id();
    }

    // 编辑状态
    function update($id) {
        $data = array(
            'IsShowName' => $this->input->post('IsShowName'),
            'IsShowOrder' => $this->input->post('IsShowOrder'),
        );
        $this->db->update('isshow', $data, array('IsShowID' => $id));
        return $this->db->affected_rows();
    }

    // 删除状态，$query 待删除编号数组
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
            if ($this->inusing($query) === FALSE) {
                $this->db->where('IsShowID', $query);
                $this->db->delete('isshow');
                return $this->db->affected_rows();
            }
        }
        return $num;
    }

    // 检查是否被占用
    private function inusing($id) {
        $this->db->select('PostID');
        $this->db->from('post');
        $this->db->where('IsShowID', $id);
        $inusing = ($this->db->count_all_results() > 0) ? TRUE : FALSE;
        $this->db->select('OtherID');
        $this->db->from('other');
        $this->db->where('IsShowID', $id);
        return $inusing && ($this->db->count_all_results() > 0) ? TRUE : FALSE;
    }

}

/* End of file m_isshow.php */
/* Location: ./application/models/m_isshow.php */