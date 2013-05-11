<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class user extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        // 判断 session 是否存在
        if (!$this->session->userdata('UserID')) {
            redirect('manage/login');
        }
        $this->load->model('M_user');
    }

    // 用户首页
    function index($num = '') {
        // 加载分页类
        $this->load->library('pagination');
        $config['base_url'] = '/index.php/manage/user/index/';
        $config['total_rows'] = $this->M_user->count('back');
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
        $data['list'] = $this->M_user->get('back', $config['per_page'], $num);
        $data['page'] = array(
            'total' => $config['total_rows'],
            'num' => $config['per_page'],
            'page' => (int) (($config['total_rows'] % $config['per_page'] === 0) ? ($config['total_rows'] / $config['per_page']) : ($config['total_rows'] / $config['per_page'] + 1)),
            'c_num' => $num
        );
        $this->load->helper('form');
        // 显示视图
        $this->load->view('manage/user_index', $data);
    }

    // 待审用户
    function to($num = '') {
        // 加载分页类
        $this->load->library('pagination');
        $config['base_url'] = '/index.php/manage/user/to/';
        $config['total_rows'] = $this->M_user->count('backto');
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
        // 获取后台全部待审用户
        $data['list'] = $this->M_user->get('backto', $config['per_page'], $num);
        $data['page'] = array(
            'total' => $config['total_rows'],
            'num' => $config['per_page'],
            'page' => (int) (($config['total_rows'] % $config['per_page'] === 0) ? ($config['total_rows'] / $config['per_page']) : ($config['total_rows'] / $config['per_page'] + 1)),
            'c_num' => $num
        );
        $this->load->helper('form');
        // 显示视图
        $this->load->view('manage/user_index', $data);
    }

    // 编辑用户
    function edit($id = '') {
        $data['post'] = '';
        // 判断是否有传值
        if ($id != '') {
            $data['post'] = $this->M_user->post($id);
            $data['post'] = $data['post']->row_array(1);
        }
        $this->load->helper('form');
        // 显示视图
        $this->load->view('manage/user_edit', $data);
    }

    // 修改或重置密码 back/email
    function repass($id = '') {
        if ($id === '') {
            echo "<script language=\"javascript\">history.go(-1);</script>";
        } else {
            if ($this->update('email') > 0) {
                echo "<script language=\"javascript\">alert('编辑成功!')</script>";
            }
        }
        echo "<script language=\"javascript\">history.go(-1);</script>";
    }

    // 插入用户
    function insert() {
        if ($this->M_user->insert() > 0) {
            echo "<script language=\"javascript\">alert('编辑成功!')</script>";
        }
        echo "<script language=\"javascript\">history.go(-1);</script>";
    }

    // 更新链接 back/email/edit 默认 edit
    function update($id) {
        $email = $name = $pass = '';
        $this->load->helper('security');
        switch ($id) {
            case 'back':
                if ($this->M_user->get('password', strtoupper(do_hash($this->input->post('OldPass'), 'md5')), $this->session->sess_read('UserID')) > 0) {
                    $data = array(
                        'Password' => strtoupper(do_hash(($pass = $this->input->post('NewPass')), 'md5')),
                    );
                    $this->emailtouser($this->session->sess_read('UseEmail'), $this->session->sess_read('UserName'), $pass);
                    if ($this->M_user->update('password', $this->session->sess_read('UseID'), $data) > 0) {
                        echo "<script language=\"javascript\">alert('您的密码已发送到指定邮箱,请查收!')</script>";
                    } else {
                        echo "<script language=\"javascript\">alert('系统错误,请重试!')</script>";
                    }
                } else {
                    echo "<script language=\"javascript\">alert('原始密码错误,请重试!')</script>";
                }
                break;
            case 'email':
                $data['post'] = $this->M_user->get('email', $email = $this->input->post('UserEmail', ''));
                if ($data['post']->row_num > 0) {
                    $data['post'] = $data['post']->row_array(1);
                    $data = array(
                        'Password' => ($pass = strtoupper(do_hash(($pass = mt_rand(6, 8)), 'md5'))),
                    );
                    $this->emailtouser($email, $data['post']->UserName, $pass);
                    if ($this->M_user->update('email', $data['post']->UserID, $data) > 0) {
                        echo "<script language=\"javascript\">alert('您的密码已发送到指定邮箱,请查收!')</script>";
                    } else {
                        echo "<script language=\"javascript\">alert('系统错误,请重试!')</script>";
                    }
                } else {
                    echo "<script language=\"javascript\">alert('邮箱错误,请重试!')</script>";
                }
                break;
            default :
            case 'edit':
                $data = '';
                if (($pass = $this->input->post('Password')) === '') {
                    $data = array(
                        'UserName' => $this->input->post('UserName'),
                        'WebSite' => $this->input->post('WebSite'),
                        'IsShowID' => $this->input->post('IsShowID'),
                        'UserEmail' => $this->input->post('UserEmail')
                    );
                } else {
                    $data = array(
                        'UserName' => ($name = $this->input->post('UserName')),
                        'WebSite' => $this->input->post('WebSite'),
                        'Password' => strtoupper(do_hash(($pass = $this->input->post('Password')), 'md5')),
                        'IsShowID' => $this->input->post('IsShowID'),
                        'UserEmail' => ($email = $this->input->post('UserEmail'))
                    );
                    $this->emailtouser($email, $name, $pass);
                }
                if ($this->M_user->update('edit', $this->input->post('UserID'), $data) > 0) {
                    echo "<script language=\"javascript\">alert('编辑成功!')</script>";
                } else {
                    echo "<script language=\"javascript\">alert('编辑失败,请重试!')</script>";
                }
                break;
        }
        echo "<script language=\"javascript\">history.go(-1);</script>";
    }

    // 删除用户
    function delete($id = '') {
        $id = ($id === '') ? $this->input->post('UserID') : $id;
        if ($id !== '') {
            if ($this->M_user->delete($id) > 0) {
                echo "<script language=\"javascript\">alert('删除成功!')</script>";
            } else {
                echo "<script language=\"javascript\">alert('用户被占用,无法删除!')</script>";
            }
        }
        echo "<script language=\"javascript\">history.go(-1);</script>";
    }

    // 电子邮件通知
    private function emailtouser($email, $name, $pass, $config = array()) {
        $this->load->library('email', $config);
        $this->email->from('admin@justfree.org.cn', 'MeMo Blog 系统邮件');
        $this->email->to($email, $name);
        $this->email->subject('MeMo Blog 密码重置邮件通知');
        $this->email->message('尊敬的' . $name . '根据您的需求，您的密码被重置为' . $pass);
        if ($this->email->send()) {
            echo '发送邮件成功' . anchor('manage/user', '返回上一页');
            $this->email->clear();
        } else {
            //echo $this->email->print_debugger();
            $this->email->clear();
        }
    }

}

/* End of file link.php */
/* Location: ./application/controllers/manage/user.php */