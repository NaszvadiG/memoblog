<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class link extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        // 判断 session 是否存在
        if (!$this->session->userdata('UserID')) {
            redirect('manage/login');
        }
        $this->load->model('M_link');
    }

    // 链接首页
    function index($num = '') {
        // 加载分页类
        $this->load->library('pagination');
        $config['base_url'] = '/index.php/manage/link/index/';
        $config['total_rows'] = $this->M_link->count('back');
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
        $data['list'] = $this->M_link->get('back', $config['per_page'], $num);
        $data['page'] = array(
            'total' => $config['total_rows'],
            'num' => $config['per_page'],
            'page' => (int) (($config['total_rows'] % $config['per_page'] === 0) ? ($config['total_rows'] / $config['per_page']) : ($config['total_rows'] / $config['per_page'] + 1)),
            'c_num' => $num
        );
        $this->load->helper('form');
        // 显示视图
        $this->load->view('manage/link_index', $data);
    }

    // 待审链接
    function to($num = '') {
        // 加载分页类
        $this->load->library('pagination');
        $config['base_url'] = '/index.php/manage/link/to/';
        $config['total_rows'] = $this->M_link->count('backto');
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
        // 获取后台全部待审链接
        $data['list'] = $this->M_link->get('backto', $config['per_page'], $num);
        $data['page'] = array(
            'total' => $config['total_rows'],
            'num' => $config['per_page'],
            'page' => (int) (($config['total_rows'] % $config['per_page'] === 0) ? ($config['total_rows'] / $config['per_page']) : ($config['total_rows'] / $config['per_page'] + 1)),
            'c_num' => $num
        );
        $this->load->helper('form');
        // 显示视图
        $this->load->view('manage/link_index', $data);
    }

    // 编辑链接
    function edit($id = '') {
        $data['post'] = '';
        // 判断是否有传值
        if ($id != '') {
            $data['post'] = $this->M_link->post($id)->row_array(1);
        }
        $this->load->helper('form');
        // 显示视图
        $this->load->view('manage/link_edit', $data);
    }

    // 插入链接
    function insert() {
        if ($this->M_link->insert('back') > 0) {
            echo "<script language=\"javascript\">alert('编辑成功!')</script>";
        }
        echo "<script language=\"javascript\">history.go(-1);</script>";
    }

    // 更新链接
    function update() {
        if ($this->M_link->update($this->input->post('LinkID')) > 0) {
            echo "<script language=\"javascript\">alert('编辑成功!')</script>";
        }
        echo "<script language=\"javascript\">history.go(-1);</script>";
    }

    // 删除链接
    function delete($id = '') {
        $id = ($id === '') ? $this->input->post('LinkID') : $id;
        if ($id !== '') {
            if ($this->M_link->delete($id) > 0) {
                echo "<script language=\"javascript\">alert('删除成功!')</script>";
            }
        }
        echo "<script language=\"javascript\">history.go(-1);</script>";
    }

}

/* End of file link.php */
/* Location: ./application/controllers/manage/link.php */