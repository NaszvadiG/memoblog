<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author 幽蓝冰魄
 * @copyright 2011
 */
class Blog extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('M_sidebar');
        $this->load->model('M_blog');
    }

    // 首页
    function index($num = '') {
        $data['last'] = $this->M_sidebar->get_last(5);
        $data['hot'] = $this->M_sidebar->get_hot(5);
        $data['tag'] = $this->M_sidebar->get_tag_hot();
        $data['comment'] = $this->M_sidebar->get_comment_last(5);
        $data['guest'] = $this->M_sidebar->get_guest_last(5);
        $data['archive'] = $this->M_sidebar->get_archive_last(0);
        $data['link'] = $this->M_sidebar->get_link(5);
        $data['sort'] = $this->M_sidebar->get_sort();
        // 加载分页类
        $this->load->library('pagination');
        $config['base_url'] = 'blog/index/';
        $config['total_rows'] = $this->M_blog->count('index');
        $config['per_page'] = 6;
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
        $data['post'] = $this->M_blog->get('index', $config['per_page'], $num);
        // 配置页面标题
        $data['page_title'] = '首页';
        // 加载视图
        $this->load->view('blog_index', $data);
    }

    // 分类页
    function sort($id = '', $num = '') {
        // 判断是否有分类参数
        if ($id === '') {
            redirect("/blog");
        } else {
            $data['last'] = $this->M_sidebar->get_last(5);
            $data['hot'] = $this->M_sidebar->get_hot(5);
            $data['tag'] = $this->M_sidebar->get_tag_hot();
            $data['comment'] = $this->M_sidebar->get_comment_last(5);
            $data['guest'] = $this->M_sidebar->get_guest_last(5);
            $data['archive'] = $this->M_sidebar->get_archive_last(0);
            $data['link'] = $this->M_sidebar->get_link(5);
            $data['sort'] = $this->M_sidebar->get_sort();
            // 加载分页类
            $this->load->library('pagination');
            $config['base_url'] = 'blog/sort/' . $id;
            $config['total_rows'] = $this->M_blog->count_sort('front', $id);
            $config['per_page'] = 6;
            $config['num_links'] = 3;
            $config['uri_segment'] = 4;
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
            $config['first_link'] = '首页';
            $config['last_link'] = '末页';
            $config['next_link'] = '下一页 &gt;';
            $config['prev_link'] = '&lt; 上一页';
            $config['cur_tag_open'] = '&nbsp;<a class="current">';
            $config['cur_tag_close'] = '</a>';
            $this->pagination->initialize($config);
            $data['post'] = $this->M_blog->get_sort('front', $config['per_page'], $num, $id);
            // 配置页面标题
            $this->load->model('M_sort');
            $data['page_title'] = $this->M_sort->get('name', $id, '');
            $data['page_title'] = $data['page_title']['SortName'];
            // 加载视图
            $this->load->view('blog_index', $data);
        }
    }

    // 内容页
    function post($id = '') {
        // 判断是否有文章参数
        if ($id === '') {
            redirect("/blog");
        } else {
            $data['last'] = $this->M_sidebar->get_last(5);
            $data['hot'] = $this->M_sidebar->get_hot(5);
            $data['tag'] = $this->M_sidebar->get_tag_hot();
            $data['comment'] = $this->M_sidebar->get_comment_last(5);
            $data['guest'] = $this->M_sidebar->get_guest_last(5);
            $data['archive'] = $this->M_sidebar->get_archive_last(0);
            $data['link'] = $this->M_sidebar->get_link(5);
            $data['sort'] = $this->M_sidebar->get_sort();
            $this->M_blog->update('front', $id);
            $data['post'] = $this->M_blog->post('front', $id);
            // 配置页面标题
            $data['row'] = $data['post']->row_array(1);
            if ($data['row'] != NULL) {
                $data['page_title'] = $data['row']['PostTitle'];
                if ($this->input->post('Password') === FALSE) {
                    $data['pass'] = ($data['row']['Password'] == '' ) ? TRUE : FALSE;
                } else {
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('Password', '密码不能为空', 'required');
                    $data['pass'] = (trim($this->input->post('Password')) === trim($data['row']['Password'])) ? TRUE : FALSE;
                }
                $this->load->model('M_comment');
                $data['post_comment'] = $this->M_comment->get('front', 0, '', $id);
            }
            // 加载 form 助手
            $this->load->helper('form');
            // 加载视图
            $this->load->view('blog_post', $data);
        }
    }

    // 标签页
    function tag($id = '', $num = '') {
        $data['last'] = $this->M_sidebar->get_last(5);
        $data['hot'] = $this->M_sidebar->get_hot(5);
        $data['tag'] = $this->M_sidebar->get_tag_hot();
        $data['comment'] = $this->M_sidebar->get_comment_last(5);
        $data['guest'] = $this->M_sidebar->get_guest_last(5);
        $data['archive'] = $this->M_sidebar->get_archive_last(0);
        $data['link'] = $this->M_sidebar->get_link(5);
        $data['sort'] = $this->M_sidebar->get_sort();
        // 更新阅读次数
        $this->load->model('M_tag');
        $this->M_tag->update($id);
        if ($id === '') {
            $this->load->model('M_tag');
            $data['list'] = $this->M_tag->get('front', '');
            $data['page_title'] = '标签';
            // 加载视图
            $this->load->view('blog_tag', $data);
        } else {
            // 加载分页类
            $this->load->library('pagination');
            $config['base_url'] = 'blog/tag/' . $id;
            $config['total_rows'] = $this->M_blog->count_tag('front', $id);
            $config['per_page'] = 6;
            $config['num_links'] = 3;
            $config['uri_segment'] = 4;
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
            $config['first_link'] = '首页';
            $config['last_link'] = '末页';
            $config['next_link'] = '下一页 &gt;';
            $config['prev_link'] = '&lt; 上一页';
            $config['cur_tag_open'] = '&nbsp;<a class="current">';
            $config['cur_tag_close'] = '</a>';
            $this->pagination->initialize($config);
            $data['post'] = $this->M_blog->get_tag('front', $config['per_page'], $num, $id);
            // 配置页面标题
            $data['row'] = $this->M_tag->get('name', $id)->row_array(1);
            $data['page_title'] = $data['row']['TagName'] . '_标签';
            // 加载视图
            $this->load->view('blog_index', $data);
        }
    }

    function archive($id = '', $num = '') {
        // 判断是否有归档参数
        if ($id === '') {
            redirect("/blog");
        } else {
            $data['last'] = $this->M_sidebar->get_last(5);
            $data['hot'] = $this->M_sidebar->get_hot(5);
            $data['tag'] = $this->M_sidebar->get_tag_hot();
            $data['comment'] = $this->M_sidebar->get_comment_last(5);
            $data['guest'] = $this->M_sidebar->get_guest_last(5);
            $data['archive'] = $this->M_sidebar->get_archive_last(0);
            $data['link'] = $this->M_sidebar->get_link(5);
            $data['sort'] = $this->M_sidebar->get_sort();
            // 加载分页类
            $this->load->library('pagination');
            $config['base_url'] = 'blog/archive/' . $id;
            $config['total_rows'] = $this->M_blog->count_archive('front', $id);
            $config['per_page'] = 6;
            $config['num_links'] = 3;
            $config['uri_segment'] = 4;
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
            $config['first_link'] = '首页';
            $config['last_link'] = '末页';
            $config['next_link'] = '下一页 &gt;';
            $config['prev_link'] = '&lt; 上一页';
            $config['cur_tag_open'] = '&nbsp;<a class="current">';
            $config['cur_tag_close'] = '</a>';
            $this->pagination->initialize($config);
            $data['post'] = $this->M_blog->get_archive('front', $config['per_page'], $num, $id);
            // 配置页面标题
            $data['page_title'] = $id . '年_日志归档';
            // 加载视图
            $this->load->view('blog_index', $data);
        }
    }

    function search() {
        if (($id = trim($this->input->get('id'))) === '' || ($type = $this->input->get('type')) === '') {
            redirect("/blog");
        } else {
            $data['last'] = $this->M_sidebar->get_last(5);
            $data['hot'] = $this->M_sidebar->get_hot(5);
            $data['tag'] = $this->M_sidebar->get_tag_hot();
            $data['comment'] = $this->M_sidebar->get_comment_last(5);
            $data['guest'] = $this->M_sidebar->get_guest_last(5);
            $data['archive'] = $this->M_sidebar->get_archive_last(0);
            $data['link'] = $this->M_sidebar->get_link(5);
            $data['sort'] = $this->M_sidebar->get_sort();
            // 加载分页类
            $this->load->library('pagination');
            $config['base_url'] = 'blog/search?type=' . $type . '&id=' . $id;
            $config['total_rows'] = $this->M_blog->count_like('front', $type, $id);
            $config['num_links'] = 3;
            $config['per_page'] = 6;
            $config['full_tag_open'] = '<div class="pagination">';
            $config['full_tag_close'] = '</div>';
            $config['first_link'] = '首页';
            $config['last_link'] = '末页';
            $config['next_link'] = '下一页 &gt;';
            $config['prev_link'] = '&lt; 上一页';
            $config['cur_tag_open'] = '&nbsp;<a class="current">';
            $config['cur_tag_close'] = '</a>';
            $config['page_query_string'] = TRUE;
            $this->pagination->initialize($config);
            $data['post'] = $this->M_blog->get_like('front', $config['per_page'], $this->input->get('per_page'), $type, $id);
            // 配置页面标题
            $data['page_title'] = $id . '_搜索';
            // 加载视图
            $this->load->view('blog_index', $data);
        }
    }

    // RSS Feed
    function rss() {
        $this->load->helper('xml');
        $data['encoding'] = 'utf-8';
        $data['feed_name'] = '老龟的沙滩';
        $data['feed_url'] = base_url();
        $data['page_description'] = '';
        $data['page_language'] = 'zh-cn';
        $data['creator_email'] = '';
        $data['posts'] = $this->M_blog->get('rss', 0, 0);
        header("Content-Type: application/rss+xml");
        $this->load->view('blog_rss', $data);
    }

    // 评论
    function comment() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('UserName', '评论者', 'trim|required');
        $this->form_validation->set_rules('UserEmail', '电子邮箱', 'trim|valid_email');
        $this->form_validation->set_rules('CommentBody', '评论内容', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $id = $this->input->post('PostID');
            $this->load->model('M_comment');
            $data = array(
                'PostID' => $id,
                'UserEmail' => $this->input->post('UserEmail'),
                'CommentBody' => $this->input->post('CommentBody'),
                'UserName' => $this->input->post('UserName'),
                'AddTime' => date('Y-m-d H:i:s'),
                'AddIP' => $query = $this->input->ip_address(),
                'IsShowID' => '0',
            );
            if ($this->M_comment->insert($data) > 0) {
                $this->M_blog->update('comment', $id);
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
                echo "<script language=\"javascript\">alert('评论成功,请等待审核!')</script>";
            } else {
                echo "<script language=\"javascript\">alert('评论失败,请重试!')</script>";
            }
        }
        redirect('blog/post/' . $id);
    }

    // ajax 评论
    public function ajaxcomment() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('UserName', '评论者', 'trim|required');
        $this->form_validation->set_rules('UserEmail', '电子邮箱', 'trim|valid_email');
        $this->form_validation->set_rules('CommentBody', '评论内容', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $id = $this->input->post('PostID');
            $this->load->model('M_comment');
            $data = array(
                'PostID' => $id,
                'UserEmail' => $this->input->post('UserEmail'),
                'CommentBody' => $this->input->post('CommentBody'),
                'UserName' => $this->input->post('UserName'),
                'AddTime' => date('Y-m-d H:i:s'),
                'AddIP' => $query = $this->input->ip_address(),
                'IsShowID' => '0',
            );
            if ($this->M_comment->insert($data) > 0) {
                $this->M_blog->update('comment', $id);
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
                echo '评论成功，请等待审核！';
            }
        }
        return FALSE;
    }

}

/* End of file blog.php */
/* Location: ./application/controllers/blog.php */