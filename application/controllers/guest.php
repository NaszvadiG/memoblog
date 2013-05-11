<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class Guest extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('M_sidebar');
    }

    function index($num = '') {
        $data['tag'] = $this->M_sidebar->get_tag_hot();
        $data['last'] = $this->M_sidebar->get_last(5);
        $data['hot'] = $this->M_sidebar->get_hot(5);
        $data['comment'] = $this->M_sidebar->get_comment_last(5);
        $data['guest'] = $this->M_sidebar->get_guest_last(5);
        $data['archive'] = $this->M_sidebar->get_archive_last(0);
        $data['link'] = $this->M_sidebar->get_link(5);
        $data['sort'] = $this->M_sidebar->get_sort();
        $this->load->model('M_guest');
        // 加载分页类
        $this->load->library('pagination');
        $config['base_url'] = 'guest/index';
        $config['total_rows'] = $this->M_guest->count('front');
        $config['per_page'] = 8;
        $config['num_links'] = 3;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['first_link'] = '首页';
        $config['last_link'] = '末页';
        $config['next_link'] = '下一页 &gt;';
        $config['prev_link'] = '&lt; 上一页';
        $config['cur_tag_open'] = '&nbsp;<a class="current">';
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);
        $data['guest'] = $this->M_guest->get('front', $config['per_page'], $num);
        // 加载 form 和 smiley 助手
        $this->load->helper('form');
        $this->load->view('guest_index', $data);
    }

    // 留言
    function insert() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('UserName', '留言者', 'trim|required');
        $this->form_validation->set_rules('UserEmail', '电子邮箱', 'trim|valid_email');
        $this->form_validation->set_rules('GuestBody', '评论内容', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'UserEmail' => $this->input->post('UserEmail'),
                'GuestBody' => $this->input->post('GuestBody'),
                'UserName' => $this->input->post('UserName'),
                'AddTime' => date('Y-m-d H:i:s'),
                'AddIP' => $query = $this->input->ip_address(),
                'IsShowID' => '0',
            );
            $this->load->model('M_guest');
            if ($this->M_guest->insert($data) > 0) {
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
                echo "<script language=\"javascript\">alert('留言成功,请等待审核!')</script>";
            } else {
                echo "<script language=\"javascript\">alert('留言失败,请重试!')</script>";
            }
        }
        redirect('guest');
    }

    // ajax 插入
    public function ajaxinsert() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('UserName', '留言者', 'trim|required');
        $this->form_validation->set_rules('UserEmail', '电子邮箱', 'trim|valid_email');
        $this->form_validation->set_rules('GuestBody', '评论内容', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'UserEmail' => $this->input->post('UserEmail'),
                'GuestBody' => $this->input->post('GuestBody'),
                'UserName' => $this->input->post('UserName'),
                'AddTime' => date('Y-m-d H:i:s'),
                'AddIP' => $query = $this->input->ip_address(),
                'IsShowID' => '0',
            );
            $this->load->model('M_guest');
            if ($this->M_guest->insert($data) > 0) {
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
                echo '留言成功，请等待审核！';
            }
        }
        return FALSE;
    }

}

/* End of file guest.php */
/* Location: ./application/controllers/guest.php */