<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class tag extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        // 判断 session 是否存在
        if (!$this->session->userdata('UserID')) {
            redirect('manage/login');
        }
        $this->load->model('M_tag');
    }

    // 标签首页
    function index($num = '') {
        // 加载分页类
        $this->load->library('pagination');
        $config['base_url'] = '/index.php/manage/tag/index/';
        $config['total_rows'] = $this->M_tag->count('back','');
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
        $data['list'] = $this->M_tag->get('back', $config['per_page'], $num);
        $data['page'] = array(
            'total' => $config['total_rows'],
            'num' => $config['per_page'],
            'page' => (int) (($config['total_rows'] % $config['per_page'] === 0) ? ($config['total_rows'] / $config['per_page']) : ($config['total_rows'] / $config['per_page'] + 1)),
            'c_num' => $num
        );
        // 显示视图
        $this->load->view('manage/tag_index', $data);
    }

}

/* End of file tag.php */
/* Location: ./memo/controllers/manage/tag.php */