<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class M_comment extends CI_Model {

    // 获取评论，$type fornt/back/backto 默认 front，$num 每页数量 为 0 获取全部，$offset 偏移量，$id 文章编号
    function get($type, $num, $offset, $id) {
        $query = '';
        switch ($type) {
            default :
            case 'front':
                $this->db->select('CommentID,CommentBody,AddTime,UserName,ReplyTime,ReplyBody');
                if ($num === 0) {
                    $query = $this->db->get_where('comment', array('IsShowID >' => 0, 'PostID' => $id));
                } else {
                    $query = $this->db->get_where('comment', array('IsShowID >' => 0, 'PostID' => $id), $num, $offset);
                }
                break;
            case 'back':
                $this->db->select('CommentID,PostID,CommentBody,AddTime,UserName,UserEmail,ReplyTime,ReplyBody,IsShowID');
                if ($id === '') {
                    $query = $this->db->get('comment', $num, $offset);
                } else {
                    $query = $this->db->get_where('comment', array('PostID' => $id), $num, $offset);
                }
                break;
            case 'backto':
                $this->db->select('CommentID,PostID,CommentBody,AddTime,UserName,UserEmail,ReplyTime,ReplyBody,IsShowID');
                $query = $this->db->get_where('comment', array('IsShowID' => 0), $num, $offset);
                break;
        }
        return $query;
    }

    // 获取评论数量，$type fornt/back/backto 默认 front
    function count($type) {
        $this->db->select('CommentID');
        $this->db->from('comment');
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

    // 后台获取评论，$id 编号
    function post($id) {
        $this->db->select('CommentID,PostID,AddIP,CommentBody,UserEmail,AddTime,UserName,ReplyTime,ReplyBody,IsShowID');
        return $query = $this->db->get_where('comment', array('CommentID' => $id));
    }

    // 插入评论
    function insert($data) {
        $this->db->insert('comment', $data);
        return $this->db->insert_id();
    }

    // 编辑评论
    function update($id) {
        $data = array(
            'UserEmail' => $this->input->post('UserEmail'),
            'CommentBody' => $this->input->post('CommentBody'),
            'ReplyBody' => $this->input->post('ReplyBody'),
            'ReplyTime' => (trim($this->input->post('ReplyTime')) === '' || trim($this->input->post('ReplyTime')) === NULL || trim($this->input->post('ReplyTime')) === FALSE) ? date('Y-m-d H:m:s') : $this->input->post('ReplyTime'),
            'IsShowID' => $this->input->post('IsShowID'),
        );
        $this->db->update('comment', $data, array('CommentID' => $id));
        return $this->db->affected_rows();
    }

    // 删除评论，$query 待删除编号数组
    function delete($query) {
        $num = 0;
        if ($query === '') {
            return;
        } else if (is_array($query)) {
            foreach ($query as $item) {
                $num = $this->delete($item) + $num;
            }
        } else {
            // todo 对文章评论数量 - 1
            $this->db->where('CommentID', $query);
            $this->db->delete('comment');
            return $this->db->affected_rows();
        }
        return $num;
    }

}

/* End of file m_comment.php */
    /* Location: ./application/models/m_comment.php */