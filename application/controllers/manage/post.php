<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class post extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        // 判断 session 是否存在
        if (!$this->session->userdata('UserID')) {
            redirect('manage/login');
        }
        $this->load->model('M_blog');
    }

    // 文章首页
    function index($num = '') {
        // 加载分页类
        $this->load->library('pagination');
        $config['base_url'] = '/index.php/manage/post/index/';
        $config['total_rows'] = $this->M_blog->count('back');
        $config['per_page'] = 8;
        $config['num_links'] = 2;
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
        $data['list'] = $this->M_blog->get('back', $config['per_page'], $num);
        $data['page'] = array(
            'total' => $config['total_rows'],
            'num' => $config['per_page'],
            'page' => (int) (($config['total_rows'] % $config['per_page'] === 0) ? ($config['total_rows'] / $config['per_page']) : ($config['total_rows'] / $config['per_page'] + 1)),
            'c_num' => $num
        );
        $this->load->helper('form');
        // 显示视图
        $this->load->view('manage/post_index', $data);
    }

    // 待审文章
    function to($num = '') {
        // 加载分页类
        $this->load->library('pagination');
        $config['base_url'] = '/index.php/manage/post/to';
        $config['total_rows'] = $this->M_blog->count('backto');
        $config['per_page'] = 8;
        $config['num_links'] = 2;
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
        // 获取后台全部待审文章
        $data['list'] = $this->M_blog->get('backto', $config['per_page'], $num);
        $data['page'] = array(
            'total' => $config['total_rows'],
            'num' => $config['per_page'],
            'page' => (int) (($config['total_rows'] % $config['per_page'] === 0) ? ($config['total_rows'] / $config['per_page']) : ($config['total_rows'] / $config['per_page'] + 1)),
            'c_num' => $num
        );
        $this->load->helper('form');
        // 显示视图
        $this->load->view('manage/post_index', $data);
    }

    // 分类文章
    function sort($id = '', $num = '') {
        if ($id === '') {
            redirect('manage/post');
        } else {
            // 加载分页类
            $this->load->library('pagination');
            $config['base_url'] = '/index.php/manage/post/sort/' . $id;
            $config['total_rows'] = $this->M_blog->count_sort('back', $id);
            $config['per_page'] = 8;
            $config['num_links'] = 2;
            $config['uri_segment'] = 5;
            $config['full_tag_open'] = '<p class="pagination ta-right">';
            $config['full_tag_close'] = '</p>';
            $config['first_link'] = '首页';
            $config['last_link'] = '末页';
            $config['next_link'] = '下一页 &gt;';
            $config['prev_link'] = '&lt; 上一页';
            $config['cur_tag_open'] = '&nbsp;<a class="pagination-active">';
            $config['cur_tag_close'] = '</a>';
            $this->pagination->initialize($config);
            $data['list'] = $this->M_blog->get_sort('back', $config['per_page'], $num, $id);
            $data['page'] = array(
                'total' => $config['total_rows'],
                'num' => $config['per_page'],
                'page' => (int) (($config['total_rows'] % $config['per_page'] === 0) ? ($config['total_rows'] / $config['per_page']) : ($config['total_rows'] / $config['per_page'] + 1)),
                'c_num' => $num
            );
            $this->load->helper('form');
            // 显示视图
            $this->load->view('manage/post_index', $data);
        }
    }

    // 搜索文章
    function search() {
        if (($id = trim($this->input->get('id'))) === '') {
            redirect("manage/post");
        } else {
            // 加载分页类
            $this->load->library('pagination');
            $config['base_url'] = '/index.php/manage/post/search?id=' . $id;
            $config['total_rows'] = $this->M_blog->count_like('back', '', $id);
            $config['num_links'] = 2;
            $config['per_page'] = 8;
            $config['full_tag_open'] = '<p class="pagination ta-right">';
            $config['full_tag_close'] = '</p>';
            $config['first_link'] = '首页';
            $config['last_link'] = '末页';
            $config['next_link'] = '下一页 &gt;';
            $config['prev_link'] = '&lt; 上一页';
            $config['cur_tag_open'] = '&nbsp;<a class="pagination-active">';
            $config['cur_tag_close'] = '</a>';
            $config['page_query_string'] = TRUE;
            $this->pagination->initialize($config);
            $data['list'] = $this->M_blog->get_like('back', $config['per_page'], $num = $this->input->get('per_page'), '', $id);
            $data['page'] = array(
                'total' => $config['total_rows'],
                'num' => $config['per_page'],
                'page' => (int) (($config['total_rows'] % $config['per_page'] === 0) ? ($config['total_rows'] / $config['per_page']) : ($config['total_rows'] / $config['per_page'] + 1)),
                'c_num' => $num
            );
            $this->load->helper('form');
            // 加载视图
            $this->load->view('manage/post_index', $data);
        }
    }

    // 编辑文章
    function edit($id = '') {
        $data['post'] = '';
        // 判断是否有传值
        if ($id != FALSE) {
            $data['post'] = $this->M_blog->post('back', $id);
            $data['post'] = $data['post']->row_array(1);
        }
        $this->load->model('M_isshow');
        // 获取显示状态
        $data['isshow'] = $this->M_isshow->get('post', '', '');
        $this->load->model('M_sort');
        // 获取分类
        $data['sort'] = $this->M_sort->get('', '');
        // 加载 form 助手
        $this->load->helper('form');
        // 显示视图
        $this->load->view('manage/post_edit', $data);
    }

    // 插入文章
    function insert() {
        if ($this->M_blog->insert() > 0) {
            echo "<script language=\"javascript\">alert('编辑成功!')</script>";
        }
        redirect('manage/post/edit');
        //echo "<script language=\"javascript\">history.back(-2);</script>";
    }

    // 更新文章
    function update() {
        if ($this->M_blog->update('back', $this->input->post('PostID')) > 0) {
            echo "<script language=\"javascript\">alert('编辑成功!')</script>";
        }
        echo "<script language=\"javascript\">history.go(-1);</script>";
    }

    // 删除文章
    function delete($id = '') {
        $id = ($id === '') ? $this->input->post('PostID') : $id;
        if ($id !== '') {
            if ($this->M_blog->delete($id) > 0) {
                echo "<script language=\"javascript\">alert('删除成功!')</script>";
            } else {
                echo "<script language=\"javascript\">alert('文章被占用,无法删除!')</script>";
            }
        }
        echo "<script language=\"javascript\">history.go(-1);</script>";
    }

}

/* End of file guest.php */
/* Location: ./application/controllers/manage/guest.php */