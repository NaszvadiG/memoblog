<?php

if (!defined('BASEPATH'))
        exit('No direct script access allowed');

/*
 *
 * @brief	继承CI_Upload类，支持多文件上传
 *
 */

class MY_Upload extends CI_Upload {

        var $datas = array();

        function MY_Upload($props = array()) {
                parent::CI_Upload($props);
        }

        function do_upload($_FILES = '', $field = 'userfile') {
                if (empty($_FILES[$field])) {
                        $this->set_error('upload_no_file_selected');
                        return FALSE;
                } else {
                        if (count($_FILES[$field]['name']) > 1) {
                                foreach ($_FILES[$field]['name'] as $index => $name) {
                                        if (!empty($name)) {
                                                $this->do_xupload($_FILES, $field, $index);
                                                $temp = parent::data();
                                                $this->set_dataArray($temp, $index);
                                        }
                                }
                                return true;
                        } else {
                                if ($field == 'proimg') {
                                        $this->do_xupload($_FILES, $field);
                                        $temp = parent::data();
                                        $this->set_dataArray($temp, 0);
                                        return true;
                                } else {
                                        parent::do_upload($_FILES, $field);
                                        return parent::data();
                                }
                        }
                }
        }

        function set_dataArray($data, $index) {
                $this->datas[$index] = $data;
        }

        function get_dataArray() {
                return $this->datas;
        }

        /**
         * Perform the file upload
         *
         * @access	public
         * @return	bool
         */
        function do_xupload($_FILES = '', $field = 'userfile', $index=0) {
                // Is $_FILES[$field] set? If not, no reason to continue.
                if (!isset($_FILES[$field])) {
                        $this->set_error('upload_no_file_selected');
                        return FALSE;
                }

                // Is the upload path valid?
                if (!$this->validate_upload_path()) {
                        $this->set_error('upload_no_filepath');
                        return FALSE;
                }

                // Was the file able to be uploaded? If not, determine the reason why.
                if (!is_uploaded_file($_FILES[$field]['tmp_name'][$index])) {
                        $error = (!isset($_FILES[$field]['error'][$index])) ? 4 : $_FILES[$field]['error'][$index];

                        switch ($error) {
                                case 1: // UPLOAD_ERR_INI_SIZE
                                        $this->set_error('upload_file_exceeds_limit');
                                        break;
                                case 2: // UPLOAD_ERR_FORM_SIZE
                                        $this->set_error('upload_file_exceeds_form_limit');
                                        break;
                                case 3: // UPLOAD_ERR_PARTIAL
                                        $this->set_error('upload_file_partial');
                                        break;
                                case 4: // UPLOAD_ERR_NO_FILE
                                        $this->set_error('upload_no_file_selected');
                                        break;
                                case 6: // UPLOAD_ERR_NO_TMP_DIR
                                        $this->set_error('upload_no_temp_directory');
                                        break;
                                case 7: // UPLOAD_ERR_CANT_WRITE
                                        $this->set_error('upload_unable_to_write_file');
                                        break;
                                case 8: // UPLOAD_ERR_EXTENSION
                                        $this->set_error('upload_stopped_by_extension');
                                        break;
                                default : $this->set_error('upload_no_file_selected');
                                        break;
                        }

                        return FALSE;
                }

                // Set the uploaded data as class variables
                $this->file_temp = $_FILES[$field]['tmp_name'][$index];
                $this->file_name = $_FILES[$field]['name'][$index];
                $this->file_size = $_FILES[$field]['size'][$index];
                $this->file_type = preg_replace("/^(.+?);.*$/", "\\1", $_FILES[$field]['type'][$index]);
                $this->file_type = strtolower($this->file_type);
                $this->file_ext = $this->get_extension($_FILES[$field]['name'][$index]);

                // Convert the file size to kilobytes
                if ($this->file_size > 0) {
                        $this->file_size = round($this->file_size / 1024, 2);
                }

                // Is the file type allowed to be uploaded?
                if (!$this->is_allowed_filetype()) {
                        $this->set_error('upload_invalid_filetype');
                        return FALSE;
                }

                // Is the file size within the allowed maximum?
                if (!$this->is_allowed_filesize()) {
                        $this->set_error('upload_invalid_filesize');
                        return FALSE;
                }

                // Are the image dimensions within the allowed size?
                // Note: This can fail if the server has an open_basdir restriction.
                if (!$this->is_allowed_dimensions()) {
                        $this->set_error('upload_invalid_dimensions');
                        return FALSE;
                }

                // Sanitize the file name for security
                $this->file_name = $this->clean_file_name($this->file_name);

                // Remove white spaces in the name
                if ($this->remove_spaces == TRUE) {
                        $this->file_name = preg_replace("/\s+/", "_", $this->file_name);
                }

                /*
                 * Validate the file name
                 * This function appends an number onto the end of
                 * the file if one with the same name already exists.
                 * If it returns false there was a problem.
                 */
                $this->orig_name = $this->file_name;

                if ($this->overwrite == FALSE) {
                        $this->file_name = $this->set_filename($this->upload_path, $this->file_name);

                        if ($this->file_name === FALSE) {
                                return FALSE;
                        }
                }

                /*
                 * Move the file to the final destination
                 * To deal with different server configurations
                 * we'll attempt to use copy() first.  If that fails
                 * we'll use move_uploaded_file().  One of the two should
                 * reliably work in most environments
                 */
                if (!@copy($this->file_temp, $this->upload_path . $this->file_name)) {
                        if (!@move_uploaded_file($this->file_temp, $this->upload_path . $this->file_name)) {
                                $this->set_error('upload_destination_error');
                                return FALSE;
                        }
                }

                /*
                 * Run the file through the XSS hacking filter
                 * This helps prevent malicious code from being
                 * embedded within a file.  Scripts can easily
                 * be disguised as images or other file types.
                 */
                if ($this->xss_clean == TRUE) {
                        $this->do_xss_clean();
                }

                /*
                 * Set the finalized image dimensions
                 * This sets the image width/height (assuming the
                 * file was an image).  We use this information
                 * in the "data" function.
                 */
                $this->set_image_properties($this->upload_path . $this->file_name);

                return TRUE;
        }

        // --------------------------------------------------------------------
}

/* End of file MY_Upload.php */
/* Location: ./application/libraries/MY_Upload.php */