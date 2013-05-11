<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class Other extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('M_sidebar');
    }

    function index($num = '') {
        $data['last'] = $this->M_sidebar->get_last(5);
        $data['hot'] = $this->M_sidebar->get_hot(5);
        $data['tag'] = $this->M_sidebar->get_tag_hot();
        $data['comment'] = $this->M_sidebar->get_comment_last(5);
        $data['guest'] = $this->M_sidebar->get_guest_last(5);
        $data['archive'] = $this->M_sidebar->get_archive_last(0);
        $data['link'] = $this->M_sidebar->get_link(5);
        $data['sort'] = $this->M_sidebar->get_sort();
        $this->load->model('M_other');
        // 加载分页类
        $this->load->library('pagination');
        $config['base_url'] = 'other/index/';
        $config['total_rows'] = $this->M_other->count('front');
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
        $data['post'] = $this->M_other->get('front', $config['per_page'], $num);
        // 加载视图
        $this->load->view('other_index', $data);
    }

}

/* End of file other.php */
/* Location: ./application/controllers/other.php */