<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class sort extends CI_Controller {

    // 初始化
    function __construct() {
        parent::__construct();
        $this->load->library('session');
        // 判断 session 是否存在
        if (!$this->session->userdata('UserID')) {
            redirect('manage/login');
        }
        // 加载 sort 模型
        $this->load->model('M_sort');
    }

    // 分类首页
    function index($num = '') {
        // 加载分页类
        $this->load->library('pagination');
        $config['base_url'] = '/index.php/manage/sort/index/';
        $config['total_rows'] = $this->M_sort->count('back');
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
        $data['list'] = $this->M_sort->get('back', $config['per_page'], $num);
        $data['page'] = array(
            'total' => $config['total_rows'],
            'num' => $config['per_page'],
            'page' => (int) (($config['total_rows'] % $config['per_page'] === 0) ? ($config['total_rows'] / $config['per_page']) : ($config['total_rows'] / $config['per_page'] + 1)),
            'c_num' => $num
        );
        $this->load->helper('form');
        // 显示视图
        $this->load->view('manage/sort_index', $data);
    }

    // 获取待审
    function to($num = '') {
        // 加载分页类
        $this->load->library('pagination');
        $config['base_url'] = '/index.php/manage/sort/to/';
        $config['total_rows'] = $this->M_sort->count('to');
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
        $data['list'] = $this->M_sort->get('to', $config['per_page'], $num);
        $data['page'] = array(
            'total' => $config['total_rows'],
            'num' => $config['per_page'],
            'page' => (int) (($config['total_rows'] % $config['per_page'] === 0) ? ($config['total_rows'] / $config['per_page']) : ($config['total_rows'] / $config['per_page'] + 1)),
            'c_num' => $num
        );
        $this->load->helper('form');
        // 显示视图
        $this->load->view('manage/sort_index', $data);
    }

    // 编辑分类
    function edit($id = '') {
        $data['post'] = '';
        // 判断是否有传值
        if ($id != '') {
            $data['post'] = $this->M_sort->post($id);
            $data['post'] = $data['post']->row_array(1);
        }
        $data['parent'] = $this->M_sort->get('option', '', '');
        $this->load->helper('form');
        // 显示视图
        $this->load->view('manage/sort_edit', $data);
    }

    // 插入分类
    function insert() {
        if ($this->M_sort->insert() > 0) {
            echo "<script language=\"javascript\">alert('编辑成功!')</script>";
        }
        echo "<script language=\"javascript\">history.go(-1);</script>";
    }

    // 更新分类
    function update() {
        if ($this->M_sort->update('sort', $this->input->post('SortID')) > 0) {
            echo "<script language=\"javascript\">alert('编辑成功!')</script>";
        }
        echo "<script language=\"javascript\">history.go(-1);</script>";
    }

    // 删除分类
    function delete($id = '') {
        $id = ($id === '') ? $this->input->post('SortID') : $id;
        if ($id !== '') {
            if ($this->M_sort->delete($id) > 0) {
                echo "<script language=\"javascript\">alert('删除成功!')</script>";
            } else {
                echo "<script language=\"javascript\">alert('文章分类被占用,无法删除!')</script>";
            }
        }
        echo "<script language=\"javascript\">history.go(-1);</script>";
    }

}

/* End of file sort.php */
/* Location: ./application/controllers/manage/sort.php */