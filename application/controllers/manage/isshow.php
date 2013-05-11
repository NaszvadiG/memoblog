<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class isshow extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        // 判断 session 是否存在
        if (!$this->session->userdata('UserID')) {
            redirect('manage/login');
        }
        $this->load->model('M_isshow');
    }

    // 显示状态首页
    function index($num = '') {
        // 加载分页类
        $this->load->library('pagination');
        $config['base_url'] = '/index.php/manage/isshow/index/';
        $config['total_rows'] = $this->M_isshow->count();
        $config['per_page'] = 8;
        $config['num_links'] = 3;
        $config['uri_segment'] = 4;
        $config['full_tag_open'] = '<p class="pagination ta-right">';
        $config['full_tag_close'] = '</p>';
        $config['first_link'] = '首页';
        $config['last_link'] = '末页';
        $config['next_link'] = '下一页 &gt;';
        $config['prev_link'] = '&lt; 上一页';
        $config['cur_tag_open'] = '&nbsp;<a class="pagination-active">';
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);
        $data['list'] = $this->M_isshow->get('back', $config['per_page'], $num);
        $data['page'] = array(
            'total' => $config['total_rows'],
            'num' => $config['per_page'],
            'page' => (int) (($config['total_rows'] % $config['per_page'] === 0) ? ($config['total_rows'] / $config['per_page']) : ($config['total_rows'] / $config['per_page'] + 1)),
            'c_num' => $num
        );
        $this->load->helper('form');
        // 显示视图
        $this->load->view('manage/isshow_index', $data);
    }

    // 编辑显示状态
    function edit($id = '') {
        $data['post'] = '';
        // 判断是否有传值
        if ($id != '') {
            $data['post'] = $this->M_isshow->post($id);
            $data['post'] = $data['post']->row_array(1);
        }
        $this->load->helper('form');
        $this->load->view('manage/isshow_edit', $data);
    }

    // 插入显示状态
    function insert() {
        $data = array(
            'IsShowName' => $this->input->post('IsShowName'),
            'IsShowOrder' => $this->input->post('IsShowOrder'),
        );
        $this->M_isshow->insert($data);
        redirect('manage/isshow/edit');
    }

    // 更新显示状态
    function update() {
        if ($this->M_isshow->update($this->input->post('IsShowID')) > 0) {
            echo "<script language=\"javascript\">alert('编辑成功!')</script>";
        }
        echo "<script language=\"javascript\">history.go(-1);</script>";
    }

    // 删除显示状态
    function delete($id = '') {
        $id = ($id === '') ? $this->input->post('IsShow') : $id;
        if ($id !== '') {
            if ($this->M_isshow->delete($id) > 0) {
                echo "<script language=\"javascript\">alert('删除成功!')</script>";
            } else {
                echo "<script language=\"javascript\">alert('显示状态被占用,无法删除!')</script>";
            }
        }
        echo "<script language=\"javascript\">history.go(-1);</script>";
    }

}

/* End of file isshow.php */
/* Location: ./application/controllers/manage/isshow.php */