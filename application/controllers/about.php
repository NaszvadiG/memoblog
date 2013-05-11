<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class About extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('M_sidebar');
    }

    function index() {
        $data['tag'] = $this->M_sidebar->get_tag_hot();
        $data['last'] = $this->M_sidebar->get_last(5);
        $data['hot'] = $this->M_sidebar->get_hot(5);
        $data['comment'] = $this->M_sidebar->get_comment_last(5);
        $data['guest'] = $this->M_sidebar->get_guest_last(5);
        $data['archive'] = $this->M_sidebar->get_archive_last(0);
        $data['link'] = $this->M_sidebar->get_link(5);
        $data['sort'] = $this->M_sidebar->get_sort();
        // 加载 About 模型
        //$this->load->model('M_about');
        $this->load->view('about_index', $data);
    }

}

/* End of file about.php */
/* Location: ./application/controllers/about.php */