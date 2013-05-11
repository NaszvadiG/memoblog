<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

	// 登录页
    function index() {
		// 判断 session 是否存在
        if (!$this->session->userdata('UserID')) {
            $this->load->helper('form');
            $this->load->view('manage/login_index');
        } else {
            redirect('manage/main');
        }
    }

	// 验证登录
    function check() {
        $this->load->model('M_user');
        $this->load->helper('security');
		// 获取用户信息
        $data = $this->M_user->get('login', $this->input->post('UserName'), strtoupper(do_hash($this->input->post('Password'), 'md5')));
		// 判断用户是否存在
        if ($data->num_rows() > 0) {
            $data = $data->row_array(1);
            $this->M_user->update('login',$data['UserID'],'');
			// 设置 session
            $User = array(
                'UserID' => $data['UserID'],
                'UserName' => $data['UserName'],
                'UserEmail' => $data['UserEmail'],
            );
            $this->session->set_userdata($User);
			// 设置 cookie
            $this->load->helper('cookie');
            $cookie = array(
                'name' => 'UserName',
                'value' => $data['UserName'],
                'expire' => '86500',
                'path' => '/',
            );
            $this->input->set_cookie($cookie);
            $cookie = array(
                'name' => 'UserEmail',
                'value' => $data['UserEmail'],
                'expire' => '86500',
                'path' => '/',
            );
            $this->input->set_cookie($cookie);
            redirect('manage/main');
        } else {
            redirect('manage/login');
        }
    }

	// 退出
    function logout() {
		// 销毁 session
        $this->session->sess_destroy();
        redirect('manage/login');
    }

}

/* End of file login.php */
/* Location: ./application/controllers/manage/login.php */