<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class main extends CI_Controller {

    // 初始化
    function __construct() {
        parent::__construct();
        $this->load->library('session');
        // 判断 session 是否存在
        if (!$this->session->userdata('UserID')) {
            redirect('manage/login');
        }
    }

    // 管理面板页
    function index() {
        $this->load->model('M_user');
        $data['LogTimes'] = $this->M_user->count('login');
        $data['userall'] = $this->M_user->count('back');
        $data['userto'] = $this->M_user->count('backto');
        // 加载文章数量
        $this->load->model('M_blog');
        $data['blogall'] = $this->M_blog->count('back');
        $data['blogto'] = $this->M_blog->count('backto');
        // 加载其他数量
        $this->load->model('M_other');
        $data['otherall'] = $this->M_other->count('back');
        $data['otherto'] = $this->M_other->count('backto');
        // 加载链接数量
        $this->load->model('M_link');
        $data['linkall'] = $this->M_link->count('back');
        $data['linkto'] = $this->M_link->count('backto');
        // 加载留言数量
        $this->load->model('M_guest');
        $data['guestall'] = $this->M_guest->count('back');
        $data['guestto'] = $this->M_guest->count('backto');
        // 加载评论数量
        $this->load->model('M_comment');
        $data['commentall'] = $this->M_comment->count('back');
        $data['commentto'] = $this->M_comment->count('backto');
        // 加载数据库占用
        $this->load->model('M_manage');
        $data['mysql'] = $this->M_manage->mysql_count()->row(1);
        $data['post'] = $this->M_manage->post_count()->row(1);
        // 显示视图
        $this->load->view('manage/main_index', $data);
    }

    // 日志页 TODO
    function log() {
        // 显示视图
        $this->load->view('manage/main_log');
    }

    // 设置页 TODO
    function setting() {
        // 显示视图
        $this->load->view('manage/main_setting');
    }

    // 备份数据库
    function backup() {
        $this->load->model('M_manage');
        $this->M_manage->backup();
    }

    // 清空缓存
    function clear() {
        $this->db->cache_delete_all();
    }

    // 修改密码页
    function password() {
        // 显示视图
        $this->load->helper('form');
        $this->load->view('manage/main_password');
    }

    // 加载 sidebar/header/footer
    function load($type) {
        switch ($type) {
            default :
            case 'sidebar':
                $this->load->view('manage/sidebar');
                break;
            case 'header':
                $this->load->view('manage/header');
                break;
            case 'footer':
                $this->load->view('manage/footer');
                break;
        }
    }

}

/* End of file main.php */
    /* Location: ./application/controllers/manage/main.php */