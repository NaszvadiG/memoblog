<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class M_blog extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // 获取文章，$type fornt/rss/back/backto 默认 front，$num 每页数量，$offset 偏移量
    function get($type, $num, $offset) {
        $query = '';
        switch ($type) {
            default :
            case 'index':
                $this->db->select('PostID,PostTitle,post.AddTime,ReadNum,Comment,post.SortID,PostAbout,SortName,UserName');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->join('user', 'user.UserID = post.UserID');
                $this->db->order_by("post.AddTime", "desc");
                $this->db->order_by("post.IsShowID", "desc");
                $query = $this->db->get_where('post', array('post.IsShowID >' => 4), $num, $offset);
                break;
            case 'rss':
                $this->db->select('PostID,PostTitle,AddTime,PostAbout');
                $this->db->order_by("AddTime", "desc");
                $this->db->order_by("IsShowID", "desc");
                $query = $this->db->get_where('post', array('IsShowID >' => 2));
                break;
            case 'back';
                $this->db->select('PostID,PostTitle,AddTime,ReadNum,Comment,post.SortID,SortName,IsShowName');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->join('isshow', 'isshow.IsShowID = post.IsShowID');
                $this->db->order_by("post.AddTime", "desc");
                $query = $this->db->get('post', $num, $offset);
                break;
            case 'backto':
                $this->db->select('PostID,PostTitle,AddTime,ReadNum,Comment,post.SortID,SortName,IsShowName');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->join('isshow', 'isshow.IsShowID = post.IsShowID');
                $this->db->order_by("post.AddTime", "desc");
                $query = $this->db->get_where('post', array('post.IsShowID <' => 3), $num, $offset);
                break;
        }
        return $query;
    }

    // 获取文章数量，$type fornt/back/backto 默认 front
    function count($type) {
        $this->db->from('post');
        switch ($type) {
            default :
            case 'index':
                $this->db->where(array('IsShowID >' => 4));
                break;
            case 'back':
                break;
            case 'backto':
                $this->db->where(array('IsShowID <' => 3));
                break;
        }
        return $this->db->count_all_results();
    }

    // 获取分类文章，$type front/back/backto 默认 front，$num 每页数量，$offset 偏移量，$id 编号
    function get_sort($type, $num, $offset, $id) {
        $query = '';
        switch ($type) {
            default :
            case 'front':
                $this->db->select('PostID,PostTitle,post.AddTime,ReadNum,Comment,post.SortID,SortName,PostAbout,UserName');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->join('user', 'user.UserID = post.UserID');
                $this->db->order_by("post.AddTime", "desc");
                $this->db->order_by("post.IsShowID", "desc");
                $query = $this->db->get_where('post', array('post.SortID' => $id, 'post.IsShowID >' => 2), $num, $offset);
                break;
            case 'back':
                $this->db->select('PostID,PostTitle,AddTime,ReadNum,Comment,post.SortID,SortName,isshow.IsShowName');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->join('isshow', 'isshow.IsShowID = post.IsShowID');
                $this->db->order_by("post.AddTime", "desc");
                $this->db->order_by("post.IsShowID", "desc");
                $query = $this->db->get_where('post', array('post.SortID' => $id), $num, $offset);
                break;
            case 'backto':
                $this->db->select('PostID,PostTitle,AddTime,ReadNum,Comment,post.SortID,SortName,isshow.IsShowName');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->join('isshow', 'isshow.IsShowID = post.IsShowID');
                $this->db->order_by("post.AddTime", "desc");
                $this->db->order_by("post.IsShowID", "desc");
                $query = $this->db->get_where('post', array('post.SortID' => $id, 'post.IsShowID <' => 3), $num, $offset);
                break;
        }
        return $query;
    }

    // 获取分类文章数量，$type front/back/backto 默认 front，$id 编号
    function count_sort($type, $id) {
        $this->db->from('post');
        switch ($type) {
            default :
            case 'front':
                $this->db->where(array('SortID' => $id, 'IsShowID >' => 2));
                break;
            case 'back':
                $this->db->where(array('SortID' => $id));
                break;
            case 'backto':
                $this->db->where(array('SortID' => $id, 'IsShowID <' => 3));
                break;
        }
        return $this->db->count_all_results();
    }

    // 获取文章内容，$type front/back 默认 front，$id 编号
    function post($type, $id) {
        $query = '';
        switch ($type) {
            default :
            case 'front':
                $this->db->select('PostTitle,post.AddTime,ReadNum,Comment,post.SortID,PostBody,SortName,UserName,post.Password');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->join('user', 'user.UserID = post.UserID');
                $query = $this->db->get_where('post', array('post.IsShowID >' => '2', 'post.PostID' => $id));
                break;
            case 'back':
                $this->db->select('PostTitle,SortID,PostBody,Password,TagName,IsShowID,PostAbout');
                $query = $this->db->get_where('post', array('PostID' => $id));
                break;
        }
        return $query;
    }

    // 获取分类文章，$type front/back/backto 默认 front，$num 每页数量，$offset 偏移量，$id 编号
    function get_archive($type, $num, $offset, $id) {
        $query = '';
        switch ($type) {
            default :
            case 'front':
                $this->db->select('PostID,PostTitle,post.AddTime,ReadNum,Comment,post.SortID,PostAbout,SortName,UserName');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->join('user', 'user.UserID = post.UserID');
                $this->db->order_by("post.AddTime", "desc");
                $this->db->order_by("post.IsShowID", "desc");
                $this->db->like('post.AddTime', $id, 'after');
                $query = $this->db->get_where('post', array('post.IsShowID >' => 2), $num, $offset);
                break;
            case 'back':
                $this->db->select('PostID,PostTitle,AddTime,ReadNum,Comment,post.SortID,SortName,isshow.IsShowName');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->order_by("post.AddTime", "desc");
                $this->db->order_by("post.IsShowID", "desc");
                $this->db->like('post.AddTime', $id, 'after');
                $query = $this->db->get('post', $num, $offset);
                break;
            case 'backto':
                $this->db->select('PostID,PostTitle,AddTime,ReadNum,Comment,post.SortID,SortName,isshow.IsShowName');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->order_by("post.AddTime", "desc");
                $this->db->order_by("post.IsShowID", "desc");
                $this->db->like('post.AddTime', $id, 'after');
                $query = $this->db->get_where('post', array('post.IsShowID <' => 3), $num, $offset);
                break;
        }
        return $query;
    }

    // 获取归档文章数量
    function count_archive($type, $id) {
        $this->db->from('post');
        switch ($type) {
            default :
            case 'front':
                $this->db->like('AddTime', $id, 'after');
                $this->db->where(array('IsShowID >' => 2));
                break;
            case 'back':
                $this->db->like('AddTime', $id, 'after');
                break;
            case 'backto':
                $this->db->like('AddTime', $id, 'after');
                $this->db->where(array('IsShowID <' => 3));
                break;
        }
        return $this->db->count_all_results();
    }

    // 获取相似文章
    function get_like($type, $num, $offset, $type2, $id) {
        $query = '';
        switch ($type2) {
            default :
            case 'title':
                $this->db->like('PostTitle', $id);
                break;
            case 'post':
                $this->db->like(array('PostTitle' => $id, 'PostBody' => $id, 'PostAbout' => $id));
                break;
            case 'blur':
                $this->db->like(array('PostTitle' => $id, 'PostAbout' => $id));
                break;
        }
        switch ($type) {
            default :
            case 'front':
                $this->db->select('PostID,PostTitle,post.AddTime,ReadNum,Comment,post.SortID,PostAbout,SortName,UserName');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->join('user', 'user.UserID = post.UserID');
                $this->db->order_by("post.AddTime", "desc");
                $this->db->order_by("post.IsShowID", "desc");
                $query = $this->db->get_where('post', array('post.IsShowID >' => 2), $num, $offset);
                break;
            case 'back':
                $this->db->select('PostID,PostTitle,AddTime,ReadNum,Comment,post.SortID,SortName,IsShowName');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->join('isshow', 'isshow.IsShowID = post.IsShowID');
                $this->db->order_by("post.AddTime", "desc");
                $this->db->order_by("post.IsShowID", "desc");
                $query = $this->db->get('post', $num, $offset);
                break;
            case 'backto':
                $this->db->select('PostID,PostTitle,AddTime,ReadNum,Comment,post.SortID,SortName,IsShowName');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->join('isshow', 'isshow.IsShowID = post.IsShowID');
                $this->db->order_by("post.AddTime", "desc");
                $this->db->order_by("post.IsShowID", "desc");
                $query = $this->db->get_where('post', array('post.IsShowID <' => 3), $num, $offset);
                break;
        }
        return $query;
    }

    // 获取相似文章数量
    function count_like($type, $type2, $id) {
        $this->db->from('post');
        switch ($type2) {
            default :
            case 'title':
                $this->db->like('PostTitle', $id);
                break;
            case 'post':
                $this->db->like(array('PostTitle' => $id, 'PostBody' => $id, 'PostAbout' => $id));
                break;
            case 'blur':
                $this->db->like(array('PostTitle' => $id, 'PostAbout' => $id));
                break;
        }
        switch ($type) {
            default :
            case 'front':
                $this->db->where(array('IsShowID >' => 2));
            case 'back':
                break;
            case 'backto':
                $this->db->where(array('IsShowID <' => 3));
                break;
        }
        return $this->db->count_all_results();
    }

    // 获取标签文章
    function get_tag($type, $num, $offset, $id) {
        $query = '';
        switch ($type) {
            default :
            case 'front':
                $this->db->select('PostID,PostTitle,post.AddTime,ReadNum,Comment,post.SortID,PostAbout,SortName,UserName');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->join('user', 'user.UserID = post.UserID');
                $this->db->order_by("post.AddTime", "desc");
                $this->db->order_by("post.IsShowID", "desc");
                $this->db->like('TagID', $id);
                $query = $this->db->get_where('post', array('post.IsShowID >' => 2), $num, $offset);
                break;
            case 'back':
                $this->db->select('PostID,PostTitle,AddTime,ReadNum,Comment,post.SortID,SortName,isshow.IsShowName');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->order_by("post.AddTime", "desc");
                $this->db->order_by("post.IsShowID", "desc");
                $this->db->like('TagID', $id);
                $query = $this->db->get('post', $num, $offset);
                break;
            case 'backto':
                $this->db->select('PostID,PostTitle,AddTime,ReadNum,Comment,post.SortID,SortName,isshow.IsShowName');
                $this->db->join('sort', 'sort.SortID = post.SortID');
                $this->db->order_by("post.AddTime", "desc");
                $this->db->order_by("post.IsShowID", "desc");
                $this->db->like('TagID', $id);
                $query = $this->db->get_where('post', array('post.IsShowID <' => 3), $num, $offset);
                break;
        }
        return $query;
    }

    // 获取标签文章数量
    function count_tag($type, $id) {
        $this->db->from('post');
        $this->db->like('TagID', $id);
        switch ($type) {
            default :
            case 'front':
                $this->db->where(array('IsShowID >' => 2));
                break;
            case 'back':
                $this->db->where(array('SortID' => $id));
                break;
            case 'backto':
                $this->db->where(array('IsShowID <' => 3));
                break;
        }
        return $this->db->count_all_results();
    }

    // 插入文章，返回插入后的 ID
    function insert() {
        $data = array(
            'PostTitle' => $this->input->post('PostTitle'),
            'PostAbout' => $this->input->post('PostAbout'),
            'PostBody' => $this->input->post('PostBody'),
            'SortID' => $this->input->post('SortID'),
            'IsShowID' => $this->input->post('IsShowID'),
            'UserID' => $this->session->userdata('UserID'),
            'AddTime' => date('Y-m-d H:m:s'),
            'AddIP' => $this->input->ip_address(),
            'Password' => (($pass = trim($this->input->post('Password'))) == '') ? NULL : $pass,
            'TagName' => ($TagName = $this->input->post('TagName')),
            'TagID' => $this->maketag($TagName)
        );
        $this->db->insert('post', $data);
        return $this->db->insert_id();
    }

    // 编辑文章，返回更新条数
    function update($type, $id) {
        switch ($type) {
            default :
            case 'front':
                $this->db->set('ReadNum', 'ReadNum+1', FALSE);
                break;
            case 'comment':
                $this->db->set('Comment', 'Comment+1', FALSE);
                break;
            case 'back':
                $data = '';
                if (($pass = trim($this->input->post('Password'))) == '' || $pass === 0 || $pass === '0') {
                    $data = array(
                        'PostTitle' => $this->input->post('PostTitle'),
                        'PostAbout' => $this->input->post('PostAbout'),
                        'PostBody' => $this->input->post('PostBody'),
                        'SortID' => $this->input->post('SortID'),
                        'IsShowID' => $this->input->post('IsShowID'),
                        'TagName' => ($TagName = $this->input->post('TagName')),
                        'TagID' => $this->maketag($TagName)
                    );
                } else {
                    $data = array(
                        'PostTitle' => $this->input->post('PostTitle'),
                        'PostAbout' => $this->input->post('PostAbout'),
                        'PostBody' => $this->input->post('PostBody'),
                        'SortID' => $this->input->post('SortID'),
                        'IsShowID' => $this->input->post('IsShowID'),
                        'Password' => $pass,
                        'TagName' => ($TagName = $this->input->post('TagName')),
                        'TagID' => $this->maketag($TagName)
                    );
                }
                $this->db->where('PostID', $id);
                $this->db->update('post', $data);
                return $this->db->affected_rows();
                break;
        }
        $this->db->where('PostID', $id);
        $this->db->update('post');
        return $this->db->affected_rows();
    }

    // 删除文章，$query 待删除编号数组，返回删除条数
    function delete($query) {
        $num = 0;
        if ($query == '') {
            return 0;
        }
        if (is_array($query)) {
            foreach ($query as $item) {
                $num = $this->delete($item) + $num;
            }
        } else {
            if ($this->inusing($query) === FALSE) {
                $this->db->where('PostID', $query);
                $this->db->delete('post');
                return $this->db->affected_rows();
            }
        }
        return $num;
    }

    // 检查是否被占用，返回占用与否
    private function inusing($id) {
        $this->db->select('CommentID');
        $this->db->from('comment');
        $this->db->where('PostID', $id);
        return ($this->db->count_all_results() > 0) ? TRUE : FALSE;
    }

    // 构造标签，返回构造后的 TagID 字符串
    private function maketag($id) {
        $data = explode('|', $id);
        $str = '';
        foreach ($data as $item) {
            if ($str != '') {
                $str = $this->gettagid($item) . '|' . $str;
            }
        }
        return $str;
    }

    // 获取 tag ID，返回 tagID
    private function gettagid($id) {
        $this->db->select('TagID');
        $data = $this->db->get_where('tag', array('TagName' => $id))->row_array(1);
        if ($data['TagID'] == '') {
            $query = array(
                'TagName' => $id
            );
            $this->db->insert('tag', $query);
            $data['TagID'] = $this->db->insert_id();
        }
        return $data['TagID'];
    }

}

/* End of file m_blog.php */
/* Location: ./application/models/m_blog.php */