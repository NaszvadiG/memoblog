<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class M_sort extends CI_Model {

    // 获取文章分类
    function get($type, $num = 0, $offset = 0) {
        switch ($type) {
            case 'front':
            default :
                $this->db->select('SortID,ParentID,SortName');
                $this->db->where('IsShowID', 1);
                break;
            case 'back':
                $this->db->select('SortID,SortName,SortLevel,SortOrder,IsShowID');
                break;
            case 'to':
                $this->db->select('SortID,SortName,SortLevel,SortOrder,IsShowID');
                $this->db->where('IsShowID', 0);
                break;
            case 'option':
                $this->db->select('SortID,SortName,SortLevel');
                $this->db->order_by('Sortlevel');
                break;
            case 'name':
                $this->db->select('SortName');
                $data = $this->db->get_where('sort', array('SortID' => $num));
                return $data->row_array(1);
                break;
        }
        $this->db->order_by('SortOrder', 'desc');
        return $query = $this->db->get('sort', $num, $offset);
    }

    // 获取分类数量
    function count($type) {
        $this->db->select('SortID');
        switch ($type) {
            case 'front':
                $this->db->where('IsShowID', 1);
            default :
                break;
            case 'back':
                break;
            case 'to':
                $this->db->where('IsShowID', 0);
                break;
        }
        $this->db->from('sort');
        return $this->db->count_all_results();
    }

    // 插入分类
    function insert() {
        $data = array(
            'SortName' => $this->input->post('SortName'),
            'ParentID' => $this->input->post('ParentID'),
            'SortOrder' => $this->input->post('SortOrder'),
            'IsShowID' => $this->input->post('IsShowID')
        );
        $this->db->insert('sort', $data);
        $this->update('insert', $this->db->insert_id());
    }

    // 后台获取其他，$id 编号
    function post($id) {
        $this->db->select('SortName,SortOrder,SortLevel,ParentID,IsShowID');
        return $query = $this->db->get_where('sort', array('SortID' => $id));
    }

    // 编辑分类
    function update($type, $id) {
        $data = array();
        switch ($type) {
            case 'sort':
            default :
                if ($this->inusing('sort', $id)) {
                    return;
                } else {
                    $data = array(
                        'SortName' => $this->input->post('SortName'),
                        'ParentID' => ($pid = $this->input->post('ParentID')),
                        'SortOrder' => $this->input->post('SortOrder'),
                        'IsShowID' => $this->input->post('IsShowID'),
                        'SortLevel' => $this->getlevel($id, $pid)
                    );
                }
                break;
            case 'insert':
                $data = array(
                    'SortLevel' => $this->getlevel($id, $this->getid('parentid', $id))
                );
                break;
        }
        $this->db->where('SortID', $id);
        $this->db->update('sort', $data);
        return $this->db->affected_rows();
    }

    // 删除分类，$id 待删除编号
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
            if ($this->inusing('delete', $query)) {
                return;
            }
            $this->db->where('SortID', $query);
            $this->db->delete('sort');
            return $this->db->affected_rows();
        }
        return $num;
    }

    // 检查是否被占用
    private function inusing($type, $id) {
        switch ($type) {
            case 'delete':
            default :
                $this->db->select('PostID');
                $this->db->from('post');
                $this->db->where('SortID', $id);
                break;
            case 'sort':
                $this->db->select('SortID');
                $this->db->from('sort');
                $this->db->like('SortLevel', $id, 'after');
                $this->db->where('SortID <>',$id);
                break;
        }
        return ($this->db->count_all_results() > 0) ? TRUE : FALSE;
    }

    // 获取 ID
    private function getid($type, $id) {
        switch ($type) {
            case 'parentid':
                $this->db->select('ParentID');
                $this->db->where('SortID', $id);
                $data = $this->db->get('sort')->row_array(1);
                return $data['ParentID'];
                break;
            case 'sortname':
            default :
                $this->db->select('SortID');
                $this->db->where('SortName', $id);
                break;
        }
        $data = $this->db->get('sort')->row_array(1);
        return $data['SortID'];
    }

    // 获得分类深度
    private function getlevel($id = '', $pid = '0') {
        if ($pid === '0' || $pid === 0 || $pid === null) {
            return $id;
        }
        $this->db->select('SortLevel');
        $this->db->where('SortID', $pid);
        $data = $this->db->get('sort')->row_array(1);
        return $data['SortLevel'] . '|' . $id;
    }

}

/* End of file m_sort.php */
/* Location: ./application/models/m_sort.php */