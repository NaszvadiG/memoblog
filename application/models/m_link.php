<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class M_link extends CI_Model {

    // 获取链接，$type fornt/back/backto 默认 front，$num 每页数量 为 0 获取全部，$offset 偏移量
    function get($type, $num, $offset) {
        $query = '';
        switch ($type) {
            default :
            case 'front':
                $this->db->select('linkUrl,LinkName');
                $this->db->order_by("AddTime", "desc");
                if ($num === 0) {
                    $query = $this->db->get_where('link', array('IsShowID >' => 0));
                } else {
                    $query = $this->db->get_where('link', array('IsShowID >' => 0), $num, $offset);
                }
                break;
            case 'back';
                $query = $this->db->get('link', $num, $offset);
                break;
            case 'backto':
                $query = $this->db->get_where('link', array('IsShowID' => 0), $num, $offset);
                break;
        }

        return $query;
    }

    // 获取所有链接数量，$type fornt/back/backto 默认 front
    function count($type) {
        $this->db->from('link');
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
        return $query = $this->db->get_where('link', array('LinkID' => $id));
    }

    // 插入链接
    function insert($type) {
        $linkurl = $this->input->post('LinkUrl');
        preg_match("/^(http:\/\/)/i", $linkurl) ? $linkurl : 'http://' . $linkurl;
        $data = array(
            'LinkName' => $this->input->post('LinkName'),
            'LinkUrl' => $linkurl,
            'UserName' => $this->input->post('UserName'),
            'UserEmail' => $this->input->post('UserEmail'),
            // TODO 图片上传或链接
            'AddTime' => date('Y-m-d H:m:s'),
            'AddIP' => $this->input->ip_address(),
            'LinkOrder' => ($type === 'back') ? $this->input->post('LinkOrder') : '',
            'IsShowID' => ($type === 'back') ? $this->input->post('IsShowID') : '0'
        );
        $this->db->insert('link', $data);
        return $this->db->insert_id();
    }

    // 编辑链接
    function update($id) {
        $data = array(
            'LinkName' => $this->input->post('LinkName'),
            'LinkUrl' => $this->input->post('LinkUrl'),
            'UserName' => $this->input->post('UserName'),
            'UserEmail' => $this->input->post('UserEmail'),
            // TODO 图片上传或链接
            'LinkOrder' => $this->input->post('LinkOrder'),
            'IsShowID' => $this->input->post('IsShowID'),
        );
        $this->db->update('link', $data, array('LinkID' => $id));
        return $this->db->affected_rows();
    }

    // 删除链接，$query 待删除编号数组
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
            $this->db->where('LinkID', $query);
            $this->db->delete('link');
            return $this->db->affected_rows();
        }
        return $num;
    }

}

/* End of file m_link.php */
    /* Location: ./application/models/m_link.php */