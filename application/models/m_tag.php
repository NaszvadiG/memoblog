<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class M_tag extends CI_Model {

    // 获取标签
    function get($type, $id) {
        switch ($type) {
            case 'front':
                $this->db->select('TagID,TagName,ReadNum');
                $this->db->where('TagName <>','');
                break;
            case 'name':
                $this->db->select('TagName');
                $this->db->where('TagID',$id);
                break;
            default :
                break;
        }
        return $data = $this->db->get('tag');
    }

    // 获取标签数量
    function count($type, $id) {
        $this->db->from('tag');
        switch ($type) {
            default:
            case 'back':
            case 'front':
                break;
            case 'insert':
                $this->db->where(array('TagName' => $id));
                break;
        }
        return $this->db->count_all_results();
    }

    // 插入标签
    function insert($id) {
        if ($this->count('insert', $id) > 0) {
            $data = array(
                'TagName' => $this->input->post('TagName'),
            );
            $this->db->insert('tag', $data);
            return $this->db->insert_id();
        }
        // TODO 返回 存在的 TagID
    }

    // 更新标签
    function update($id) {
        $this->db->set('ReadNum','ReadNum + 1',FALSE);
        $this->db->where('TagID',$id);
        $this->db->update('tag');
        return $this->db->affected_rows();
    }

}

/* End of file m_tag.php */
/* Location: ./application/models/m_tag.php */