<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class M_user extends CI_Model {

    // 获取用户 $type login/list/id/email 默认 login，$id 用户编号
    function get($type, $num, $offset) {
        $data = '';
        switch ($type) {
            default:
            case 'login':
                $this->db->select('UserName,UserID,UserEmail');
                $data = array(
                    'UserName' => $num,
                    'Password' => $offset,
					'IsShowID' => 1
                );
                $data = $this->db->get_where('user', $data);
                break;
            case 'back':
                $this->db->select('UserName,UserID,UserEmail,AddTime,LogTimes,LastLogTime,IsShowID');
                $data = $this->db->get('user', $num, $offset);
                break;
            case 'backto':
                $this->db->select('UserName,UserID,UserEmail,AddTime,LogTimes,LastLogTime,IsShowID');
                $data = $this->db->get_where('user', array('IsShowID' => 0), $num, $offset);
                break;
            case 'email':
                $this->db->select('UserID,UserName');
                $this->db->where('UserEmail', $num);
                $data = $this->db->get_where('user', array('IsShowID >' => 0));
                break;
            case 'password':
                $this->db->where(array('IsShowID >' => 0, 'Password' => $num, 'UserID' => $offset));
                $data = $this->db->count_all_results('user');
                break;
        }
        return $data;
    }

    // 统计用户数量
    function count($type) {
        $data = '';
        switch ($type) {
            default:
            case 'back':
                $data = $this->db->count_all_results('user');
                break;
            case 'backto':
                $this->db->where('IsShowID', 0);
                $data = $this->db->count_all_results('user');
                break;
            case 'login':
                $this->db->select('LogTimes');
                $data = $this->db->get_where('user', array('UserID' => $this->session->userdata('UserID')))->row_array(1);
                break;
        }
        return $data;
    }

    // 后台获取用户，$id 编号
    function post($id) {
        return $query = $this->db->get_where('user', array('UserID' => $id));
    }

    // 插入用户
    function insert() {
        $this->load->helper('security');
        $data = array(
            'AddTime' => date('Y/m/d H:m:s'),
            'AddIP' => $this->input->ip_address(),
            'UserName' => $this->input->post('UserName'),
            'WebSite' => $this->input->post('WebSite'),
            'Password' => strtoupper(do_hash(($pass = $this->input->post('Password')), 'md5')),
            'IsShowID' => $this->input->post('IsShowID'),
            'LastLogTime' => '',
            'LastLogIP' => '',
            'LogTimes' => 0,
        );
        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }

    // 更新用户，$type login/password/edit 默认 login，$id 用户编号
    function update($type, $id, $data) {
        switch ($type) {
            default :
            case 'login':
                $this->db->set('LogTimes', 'LogTimes+1', FALSE);
                $this->db->set('LastLogTime', date('Y-m-d H:i:s'));
                $this->db->set('LastLogIP', $this->input->ip_address());
                $this->db->where('UserID', $id);
                $this->db->update('user');
                break;
            case 'password':
            case 'email':
            case 'edit':
                $this->db->update('user', $data, array('UserID' => $id));
                break;
        }
        return $this->db->affected_rows();
    }

    // 删除用户，$query 待删除编号数组
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
            if ($this->inusing($query) === FALSE && $query !== '1') {
                $this->db->where('UserID', $query);
                $this->db->delete('user');
                return $this->db->affected_rows();
            }
        }
        return $num;
    }

    // 检查是否被占用
    private function inusing($id) {
        $this->db->select('PostID');
        $this->db->from('post');
        $this->db->where('UserID', $id);
        return ($this->db->count_all_results() > 0) ? TRUE : FALSE;
    }

}

/* End of file m_user.php */
/* Location: ./application/models/m_user.php */