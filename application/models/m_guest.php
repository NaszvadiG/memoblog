<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class M_guest extends CI_Model {

    // 获取留言，$type fornt/back/backto 默认 front，$num 每页数量 为 0 获取全部，$offset 偏移量
    function get($type, $num, $offset) {
        $query = '';
        switch ($type) {
            default :
            case 'front':
                $this->db->select('GuestID,GuestBody,AddTime,UserName,ReplyTime,ReplyBody');
                if ($num === 0) {
                    $query = $this->db->get_where('guest', array('IsShowID >' => 0));
                } else {
                    $query = $this->db->get_where('guest', array('IsShowID >' => 0), $num, $offset);
                }
                break;
            case 'back':
                $this->db->select('GuestID,GuestBody,AddTime,UserEmail,UserName,ReplyTime,ReplyBody,IsShowID');
                $query = $this->db->get('guest', $num, $offset);
                break;
            case 'backto':
                $this->db->select('GuestID,GuestBody,AddTime,UserEmail,UserName,ReplyTime,ReplyBody,IsShowID');
                $query = $this->db->get_where('guest', array('IsShowID' => 0), $num, $offset);
                break;
        }
        return $query;
    }

    // 获取留言数量，$type fornt/back/backto 默认 front
    function count($type) {
        $this->db->select('GuestID');
        $this->db->from('guest');
        switch ($type) {
            default :
            case 'front':
                $this->db->where(array('IsShowID >' => 0));
                break;
            case 'back':
                break;
            case 'backto':
                $this->db->where(array('IsShowID' => 0));
                break;
        }
        return $this->db->count_all_results();
    }

    // 后台获取留言，$id 编号
    function post($id) {
        $this->db->select('GuestID,AddIP,GuestBody,AddTime,UserEmail,UserName,ReplyTime,ReplyBody,IsShowID');
        return $query = $this->db->get_where('guest', array('GuestID' => $id));
    }

    // 插入留言
    function insert($data) {
        $this->db->insert('guest', $data);
        return $this->db->insert_id();
    }

    // 编辑留言
    function update($id) {
        $data = array(
            'UserEmail' => $this->input->post('UserEmail'),
            'GuestBody' => $this->input->post('GuestBody'),
            'ReplyBody' => $this->input->post('ReplyBody'),
            'ReplyTime' => (trim($this->input->post('ReplyTime')) === '' || trim($this->input->post('ReplyTime')) === NULL || trim($this->input->post('ReplyTime')) === FALSE) ? date('Y-m-d H:m:s') : $this->input->post('ReplyTime'),
            'IsShowID' => $this->input->post('IsShowID'),
        );
        $this->db->update('guest', $data, array('GuestID' => $id));
        return $this->db->affected_rows();
    }

    // 删除留言，$query 待删除编号数组
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
            $this->db->where('GuestID', $query);
            $this->db->delete('guest');
            return $this->db->affected_rows();
        }
        return $num;
    }

}

/* End of file m_guest.php */
/* Location: ./application/models/m_guest.php */