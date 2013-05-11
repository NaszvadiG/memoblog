<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 * @package Post/Sort/Tag/Guest/Comment/Link/... => font
 */
class M_sidebar extends CI_Model {

    // 初始化
    function __construct() {
        parent::__construct();
    }

    // 获取最新文章
    function get_last($id) {
        $this->db->select('PostID,CAST(PostTitle AS CHAR(20)) AS PostTitle', FALSE);
        $this->db->order_by("AddTime", "desc");
        return $query = $this->db->get_where('post', array('IsShowID >' => 2), $id);
    }

    // 获取最热文章
    function get_hot($id) {
        $this->db->select('PostID,CAST(PostTitle AS CHAR(20)) AS PostTitle', FALSE);
        $this->db->order_by("ReadNum", "desc");
        return $query = $this->db->get_where('post', array('IsShowID >' => 2), $id);
    }

    // 获取文章分类
    function get_sort() {
        $this->db->select('SortID,SortName,ParentID,SortLevel');
        $this->db->order_by('SortLevel');
        $this->db->order_by('SortOrder', 'desc');
        $this->db->where('IsShowID', 1);
        return $data = $this->db->get('sort');
    }

    //获取文章归档
    function get_archive_last($id) {
        $this->db->select('COUNT(PostID) AS Num, LEFT(AddTime,4) AS Mon', FALSE);
        $this->db->group_by('Mon');
        if ($id === 0) {
            $query = $this->db->get_where('post', array('IsShowID >' => 2));
        } else {
            $query = $this->db->get_where('post', array('IsShowID >' => 2), $id);
        }
        return $query;
    }

    // 获取最新评论
    function get_comment_last($id) {
        $this->db->select('CommentID,PostID,CAST(CommentBody AS CHAR(20)) AS CommentBody', FALSE);
        $this->db->order_by('AddTime', 'desc');
        return $query = $this->db->get_where('comment', array('IsShowID >' => 0), $id);
    }

    // 获取最热标签
    function get_tag_hot($id = '') {
        $this->db->select('TagID,TagName,ReadNum');
        $this->db->where('TagName <>','');
        $this->db->order_by('ReadNum', 'desc');
        return $query = ($id == '')?$this->db->get('tag'):$this->db->get('tag', $id);
    }

    // 获取最新留言
    function get_guest_last($id) {
        $this->db->select('GuestID,CAST(GuestBody AS CHAR(20)) AS GuestBody', FALSE);
        $this->db->order_by('AddTime', 'desc');
        return $query = $this->db->get_where('guest', array('IsShowID >' => 0), $id);
    }

    // 获取最新其他
    function get_other_last($id) {
        $this->db->select('OtherID,OtherName,OtherAbout,HtmlUrl');
        $this->db->order_by("AddTime", "desc");
        return $query = $this->db->get_where('other', array('IsShowID >' => 0), $id);
    }

    // 获取所有链接
    function get_link($id) {
        $this->db->select('LinkUrl,LinkName');
        $this->db->order_by("AddTime", "desc");
        if ($id === 0) {
            $query = $this->db->get_where('link', array('IsShowID >' => 0));
        } else {
            $query = $this->db->get_where('link', array('IsShowID >' => 0), $id);
        }
        return $query;
    }

}

/* End of file m_sidebar.php */
/* Location: ./application/models/m_sidebar.php */