<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends CI_Controller {
    
    private $folder = 'companies/';
    private $folder_props = 'properties/';
    
    function __construct() {                
        parent::__construct();
        
        $this->load->model('Companies_Model', 'comp');
    }
    
    public function _remap($method, $params = array()) {
        //If the method doesn't exist (because it's the company's name), it means that it's viewing the company profile
        //Format: URL/company/company-name/companyid
        if( ! method_exists($this, $method) && count($params) == 1 ) {
            $profileid = $params[0];
            $notifications = false;
            if( $profileid == 'notifications' ) {
                if(!$this->tank_auth->is_logged_in()) {
                    $this->tank_auth->logout(true);
                    $this->session->set_flashdata('call_reference', 'company/' . $method . '/' . $profileid );
                    redirect('login');
                }
                $profileid = $this->tank_auth->get_user_code();
                $notifications = true;
            }
            $this->_profile($profileid, $notifications);
            return true;
        }
        //Company profile edit
        //Company's ID and current user's ID must be the same
        //Format: URL/company/edit/company-name/companyid
        elseif( $method == 'edit' && count($params) == 2 ) {
            //If not logged in or editing a different profile, redirect to profile view only
            $usercode = $this->tank_auth->get_user_code();
            if(!$this->tank_auth->is_logged_in() || $params[1] != $usercode) {
                redirect('company/' . $params[0] . '/' . $params[1]);
            }
            $this->_edit($params[1]);
            return true;
        }
        //Company password edit
        //Company's ID and current user's ID must be the same
        //Format: URL/company/password/company-name/companyid
        elseif( $method == 'password' && count($params) == 2 ) {
            //If not logged in or editing a different profile, logout and redirect to login page
            $usercode = $this->tank_auth->get_user_code();
            if(!$this->tank_auth->is_logged_in() || $params[1] != $usercode) {
                $this->tank_auth->logout(true);
                $this->session->set_flashdata('call_reference', 'company/password/' . $params[0] . '/' . $params[1] );
                redirect('login');
            }
            $this->_password($params[1]);
            return true;
        }
        elseif( $method == 'my-properties' ) {
            $this->_properties();
            return true;
        }
        if(method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            show_404();
        }
    }

    public function index() {
        $this->profile();
    }
    
    protected function _profile($companyid = '', $notifications = false) {
        $usercode = $this->tank_auth->get_user_code();
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $usercode;
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = SITE_NAME;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('companies' => true);
        
        $profilerow = $this->comp->get_company_by_code($companyid);

        $profilerec = array('code' => '',
                      'pic' => '',
                      'companyname' => '',
                      'officenum' => '',
                      'faxnum' => '',
                      'othercontact' => '',
                      'skype' => '',
                      'address' => '',
                      'country' => '',
                      'city' => '',
                      'profile' => '',
                      'accfb' => '',
                      'acctwitter' => '',
                      'accgoogle' => '',
                      'acclinkedin' => '',
                      'rating' => '',
                      'numrating' => '',
                      'useragentrating' => '',
                      'featured' => '');
        if($profilerow) {
            $datahead['title'] = $profilerow->companyname . PAGE_TITLE;
            $profilerec = array('code' => $profilerow->code,
                          'pic' => $profilerow->profilepic,
                          'companyname' => $profilerow->companyname,
                          'officenum' => $profilerow->officenum,
                          'faxnum' => $profilerow->faxnum,
                          'othercontact' => $profilerow->othercontact,
                          'skype' => $profilerow->skype,
                          'address' => $profilerow->address,
                          'city' => $profilerow->city,
                          'country' => get_text_country($profilerow->country),
                          'profile' => $profilerow->profile,
                          'accfb' => $profilerow->accfb,
                          'acctwitter' => $profilerow->acctwitter,
                          'accgoogle' => $profilerow->accgoogle,
                          'acclinkedin' => $profilerow->acclinkedin,
                          'rating' => $profilerow->comprating,
                          'numrating' => $profilerow->numrating,
                          'useragentrating' => $profilerow->useragentrating,
                          'featured' => $profilerow->featured);
        }
        $data['record'] = $profilerec;
        
        //Notifications
        //Only if the user accessing this profile is the owner
        $isloggedin = $this->tank_auth->is_logged_in();
        $data['notifications'] = false;
        $data['ownprofile'] = false;
        if( $isloggedin && $usercode == $companyid ) {
            $data['ownprofile'] = true;
            if($notifications) {
                $data['notifications'] = $notifications;

                //Set notifications to viewed
                $this->load->model('Notifications_Model', 'notify');
                $this->notify->viewed($usercode);
            }
        }
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'profile', $data);
        $this->load->view('footer', $datafoot);
    }
    
    protected function _edit() {
        $usercode = $this->tank_auth->get_user_code();
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $usercode;
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = $datahead['userfullname'] . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('user' => true);

        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->load->library('MY_Form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('ucompanyname', 'Name', 'trim|required|min_length[1]|max_length[200]');
        $this->form_validation->set_rules('uemail', 'Email Address', 'trim|required|max_length[300]|valid_email|callback__check_email');
        $this->form_validation->set_rules('uofficenum', 'Office Number', 'trim|min_length[1]|max_length[25]|alpha_dash_space');
        $this->form_validation->set_rules('ufaxnum', 'Fax Number', 'trim|min_length[1]|max_length[25]|alpha_dash_space');
        $this->form_validation->set_rules('uothernum', 'Other Contact', 'trim|min_length[1]|max_length[200]|alpha_dash_space');
        $this->form_validation->set_rules('uskype', 'Skype', 'trim|min_length[1]|max_length[50]|alpha_dash');
        $this->form_validation->set_rules('uaddress', 'Address', 'trim|max_length[500]|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('ucountry', 'Country', 'trim');
        $this->form_validation->set_rules('ucity', 'City', 'trim|max_length[50]|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('udescription', 'Profile Description', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('uaccfb', 'Facebook Profile', 'trim|max_length[200]|prep_url|valid_url_fb');
        $this->form_validation->set_rules('uacctwitter', 'Twitter Profile', 'trim|max_length[200]|prep_url|valid_url_twitter');
        $this->form_validation->set_rules('uaccgoogle', 'Google+ Profile', 'trim|max_length[200]|prep_url|valid_url_googleplus');
        $this->form_validation->set_rules('uacclinkedin', 'LinkedIn Profile', 'trim|max_length[200]|prep_url|valid_url_linkedin');
   
        if($this->form_validation->run() !== FALSE) {
            $companyname = $this->input->post('ucompanyname');
            $companyrecord = array(
                        'companyname' => $companyname,
                        'email' => $this->input->post('uemail'),
                        'officenum' => $this->input->post('uofficenum'),
                        'faxnum' => $this->input->post('ufaxnum'),
                        'othercontact' => $this->input->post('uothernum'),
                        'skype' => $this->input->post('uskype'),
                        'address' => $this->input->post('uaddress'),
                        'country' => $this->input->post('ucountry'),
                        'city' => $this->input->post('ucity'),
                        'profile' => $this->input->post('udescription'),
                        'accfb' => $this->input->post('uaccfb'),
                        'acctwitter' => $this->input->post('uacctwitter'),
                        'accgoogle' => $this->input->post('uaccgoogle'),
                        'acclinkedin' => $this->input->post('uacclinkedin') );
            $userrecord = array(
                        'fname' => $companyname,
                        'email' => $this->input->post('uemail'),
                        'officenum' => $this->input->post('uofficenum'),
                        'skype' => $this->input->post('uskype') );
            $userdescrecord = array(
                        'address' => $this->input->post('uaddress'),
                        'country' => $this->input->post('ucountry'),
                        'city' => $this->input->post('ucity'),
                        'profile' => $this->input->post('udescription'),
                        'accfb' => $this->input->post('uaccfb'),
                        'acctwitter' => $this->input->post('uacctwitter'),
                        'accgoogle' => $this->input->post('uaccgoogle'),
                        'acclinkedin' => $this->input->post('uacclinkedin') );
            $result = $this->comp->update($companyrecord, $userrecord, $userdescrecord, $usercode);
            
            if($result) {
                //After successful save, change session, change cached user profile pages
                $this->session->set_userdata('userfname', $companyname);
                $this->session->set_userdata('username', $companyname);
                
                $this->lang->load('success', 'english');
                $this->session->set_flashdata('message_company_update_status', 'success');
                $this->session->set_flashdata('message_company_update', $this->lang->line('success_company_update'));
            } else {
                $this->lang->load('error', 'english');
                $this->session->set_flashdata('message_company_update_status', 'error');
                $this->session->set_flashdata('message_company_update', $this->lang->line('error_company_update'));
            }
            redirect('company/edit/' . url_title($companyname) . '/' . url_title($usercode));
        }   
        
        $userrow = $this->comp->get_company_by_code($usercode);
        
        include('ip2locationlite.class.php');
        $ipLite = new ip2location_lite;
        $ip = $this->input->ip_address();
        $location = $ipLite->getCountry($ip);
        $country = ( isset($location['countryCode']) ? $location['countryCode'] : '' );
        
        $data = array('upic' => '',
                      'ucompanyname' => '',
                      'uemail' => '',
                      'uofficenum' => '',
                      'ufaxnum' => '',
                      'uothernum' => '',
                      'uskype' => '',
                      'uaddress' => '',
                      'ucountry' => $country,
                      'ucity' => '',
                      'udescription' => '',
                      'uaccfb' => '',
                      'uacctwitter' => '',
                      'uaccgoogle' => '',
                      'uacclinkedin' => '');
        if($userrow) {
            $accfb = $userrow->accfb;
            $acctwitter = $userrow->acctwitter;
            $accgoogle = $userrow->accgoogle;
            $acclinkedin = $userrow->acclinkedin;
            if(!empty($accfb)) {
                $pattern = "/(?:(?:http|https):\/\/)?(?:www\.)?facebook\.com\/?((?:profile\.php\?id=[0-9]*)|(?:(?!(profile|pages))[a-zA-Z0-9\.]{5,})|(?:pages\/[a-zA-Z0-9\.\-]+\/[0-9]+))/i";
                if( preg_match($pattern, $accfb, $matches) === 1 ) {
                    $accfb = $matches[0];
                }
            }
            if(!empty($acctwitter)) {
                $pattern = "/(?:(?:http|https):\/\/)?twitter\.com\/(#!\/)?[a-zA-Z0-9_]+/i";
                if( preg_match($pattern, $acctwitter, $matches) === 1 ) {
                    $acctwitter = $matches[0];
                }
            }
            if(!empty($accgoogle)) {
                $pattern = "/(?:(?:http|https):\/\/)?plus\.google\.com\/u\/?[0]+\/?[0-9]+/i";
                if( preg_match($pattern, $accgoogle, $matches) === 1 ) {
                    $accgoogle = $matches[0];
                }
            }
            if(!empty($acclinkedin)) {
                $pattern = "/(?:(?:http|https):\/\/)?(?:www\.|[a-zA-Z]{,2}\.)?linkedin\.com\/?((?:in\/[a-zA-Z0-9]{5,30})|(?:profile\/view\?id=(?=\d.*)))/i";
                if( preg_match($pattern, $acclinkedin, $matches) === 1 ) {
                    $acclinkedin = $matches[0];
                }
            }
            $data = array('upic' => $userrow->profilepic,
                          'ucompanyname' => $userrow->companyname,
                          'uemail' => $userrow->email,
                          'uofficenum' => $userrow->officenum,
                          'ufaxnum' => $userrow->faxnum,
                          'uothernum' => $userrow->othercontact,
                          'uskype' => $userrow->skype,
                          'uaddress' => $userrow->address,
                          'ucountry' => $userrow->country,
                          'ucity' => $userrow->city,
                          'udescription' => $userrow->profile,
                          'uaccfb' => $accfb,
                          'uacctwitter' => $acctwitter,
                          'uaccgoogle' => $accgoogle,
                          'uacclinkedin' => $acclinkedin
                    );
        }
        
        $data['countries'] = $this->config->item('countries');
        
        $data['message_status'] = $this->session->flashdata('message_company_update_status');
        $data['message'] = $this->session->flashdata('message_company_update');
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'form', $data);
        $this->load->view('footer', $datafoot);
    }
    
    protected function _password() {
        $usercode = $this->tank_auth->get_user_code();
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $usercode;
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = $datahead['userfullname'] . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('user' => true);

        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('upass', 'New Password', 'required|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('ucpass', 'Confirm New Password', 'required|matches[upass]');
   
        if($this->form_validation->run() !== FALSE) {
            $password = $this->tank_auth->create_password($this->input->post('upass'));
            $this->load->model('Users_Model', 'user');
            $record = array('password' => $password);
            $result = $this->user->update_password($record, $usercode);
            
            if($result) {
                $this->lang->load('success', 'english');
                $this->session->set_flashdata('message_company_update_status', 'success');
                $this->session->set_flashdata('message_company_update', $this->lang->line('success_company_password_update'));
            } else {
                $this->lang->load('error', 'english');
                $this->session->set_flashdata('message_company_update_status', 'error');
                $this->session->set_flashdata('message_company_update', $this->lang->line('error_company_password_update'));
            }
            redirect('company/password/' . url_title($datahead['userfullname']) . '/' . url_title($usercode));
        }   
        
        $data['message_status'] = $this->session->flashdata('message_company_update_status');
        $data['message'] = $this->session->flashdata('message_company_update');
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'password_form', $data);
        $this->load->view('footer', $datafoot);
    }
    
    public function profile_picture() {
        $error = "";
	$msg = "";
	$fileElementName = 'upic';
	if(!empty($_FILES[$fileElementName]['error'])) {
            switch($_FILES[$fileElementName]['error']) {
                case '1': $error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini'; break;
                case '2': $error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form'; break;
                case '3': $error = 'The uploaded file was only partially uploaded'; break;
                case '4': $error = 'No file was uploaded.'; break;
                case '6': $error = 'Missing a temporary folder'; break;
                case '7': $error = 'Failed to write file to disk'; break;
                case '8': $error = 'File upload stopped by extension'; break;
                case '999':
                default: $error = 'No error code avaiable';
            }
	} elseif(empty($_FILES['cpic']['tmp_name']) || $_FILES['cpic']['tmp_name'] == 'none') {
            $error = 'No file was uploaded..';
	} else {
            $path_parts = pathinfo($_FILES['cpic']['name']);
            $ext = $path_parts['extension'];
            
            $upload_path = dirname($_SERVER['SCRIPT_FILENAME']) . '/realties/';

            // Specify configuration for File
            $config['upload_path'] = $upload_path;
            $msg .= "basepath: " . $upload_path;
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['file_name'] = $path_parts['filename'];
            $config['max_size']	= '1000';

            $this->load->library('upload');
            $this->upload->initialize($config);

            if($this->upload->do_upload('cpic')) {
                $usercode = $this->tank_auth->get_user_code();
                
                $pic = md5( date('YmdHis') . '_' . $this->upload->file_name ) . '.' . $ext;
                rename($upload_path . $this->upload->file_name, $upload_path . $pic);
                
                //Save to table
                $result = $this->comp->update_pic($usercode, 'profilepic', $pic);
                
                //Change picture on session
                $this->session->set_userdata(array('userpic' => $pic));
                
                if($result) {
                    //Update agents of this company
                    $this->load->model('Users_Model', 'user');
                    $result = $this->user->update_company_pic($usercode, $pic);
                }
                
                //Image Resizing
                //Max size: 150px x 150px
                $this->load->library('image_lib');
                $img_size = getimagesize($upload_path . $pic);
                $orig_width = $img_size[0];
                $orig_height = $img_size[1];
                $newwidth = $orig_width;
                $newheight = $orig_height;

                if($orig_width > 150) {
                    $newwidth = 150;
                    $newheight = ($orig_height * (150/$orig_width));
                }

                if($newheight > 150) {
                    $newwidth = ($newwidth * (150/$newheight));
                    $newheight = 150;
                }

                $resize = array(
                    'image_library' => 'gd2',
                    'source_image' => $upload_path . $pic,
                    'new_image' => $upload_path . $pic,
                    'maintain_ratio'=> TRUE,
                    'width' => $newwidth,
                    'height' => $newheight
                );

                $this->image_lib->initialize($resize);
                if( ! $this->image_lib->resize()) {
                    $this->image_lib->clear();
                }
            }
	}		
	echo "{";
	echo "error: '" . $error . "',\n";
	echo "pic: '" . $pic . "'\n";
	echo "}";
    }
    
    public function auto_list() {        
        $term = $_GET['term'];
        $result = $this->comp->get_autocomplete($term);
        echo json_encode($result);
    }
    
    protected function _properties() {
        if(!$this->tank_auth->is_logged_in()) {
            $this->session->set_flashdata('call_reference', 'company/my-properties');
            redirect('login');
        }
        
        $usercode = $this->tank_auth->get_user_code();
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $usercode;
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = 'My Properties' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('user' => true);
        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters(ERROR_DELIMITER_OPEN, ERROR_DELIMITER_CLOSE);
        $this->form_validation->set_rules('searchkeywords', 'Keywords', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchlocation', 'Location', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchcountry', 'Country', '');
        $this->form_validation->set_rules('searchpropstate[]', 'Posting State', '');
        $this->form_validation->set_rules('searchproppost[]', 'Property Posting', '');
        $this->form_validation->set_rules('searchproptype[]', 'Property Type', '');
        $this->form_validation->set_rules('searchpropavail[]', 'Availability', '');
        $this->form_validation->set_rules('off', 'Offset', '');
        $this->form_validation->set_rules('lmt', 'Limit', '');
        $this->form_validation->set_rules('sort', 'Sort', '');
        $this->form_validation->set_rules('ord', 'Order', '');
        
        $off = 0; //Start new
        $lmt = LIMIT_MYPROPERTIES;
        $propstate = array();
        $data['propstate'] = '';
        $result = $this->_search_live_myproperty($off, $lmt, $propstate);
        $off += $lmt;
        
        $this->form_validation->run();
        
        $arrproppost = ( isset($_POST['searchproppost']) && is_array($_POST['searchproppost']) ? array_flip($_POST['searchproppost']) : array() );
        $arrproptype = ( isset($_POST['searchproptype']) && is_array($_POST['searchproptype']) ? array_flip($_POST['searchproptype']) : array() );
        $arrpropstate = ( isset($_POST['searchpropstate']) && is_array($_POST['searchpropstate']) ? array_flip($_POST['searchpropstate']) : array() );
        $arrpropavail = ( isset($_POST['searchpropavail']) && is_array($_POST['searchpropavail']) ? array_flip($_POST['searchpropavail']) : array() );
        
        $data['insearch'] = ( isset($_POST['searchkeywords']) ? true : false );
        $data['proppost'] = $arrproppost;
        $data['proptype'] = $arrproptype;
        $data['propstate'] = $arrpropstate;
        $data['propavail'] = $arrpropavail;
        $data['off'] = $off;
        $data['lmt'] = $lmt;
        $data['sort'] = $this->input->post('sort');
        $data['ord'] = $this->input->post('ord');
        $data['list'] = $result;
        
        $data['countries'] = $this->config->item('countries');
        $data['country'] = $this->input->post('searchcountry');
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder_props . 'my_properties_company', $data);
        $this->load->view('footer', $datafoot);
    }
    
    public function search_more() {
        $result = array();
        if(isset($_POST['searchkeywords'])) {
            $off = $this->input->post('off');
            $lmt = $this->input->post('lmt');
            $result = $this->_search_live_myproperty($off, $lmt);
        }
        
        $userlogin = $this->tank_auth->is_logged_in();
        $usercode = $this->tank_auth->get_user_code();
        
        $listprops = array();
        foreach($result as $rec) {
            $vw = $this->load->view($this->folder_props . 'item_myproperties_company', array('record' => $rec, 'usercode' => $usercode, 'appended' => true, 'userlogin' => $userlogin), true);
            array_push($listprops, $vw);   
        }        
        
        echo json_encode($listprops);
    }
    
    private function _search_live_myproperty($off = 0, $lmt = LIMIT_MYPROPERTIES, $propstate = array()) {
        $this->load->model('Properties_Model', 'prop');
        
        $usercode = $this->tank_auth->get_user_code();
        
        $searchkeywords = str_replace(',', ' ', $this->input->post('searchkeywords'));
        $searchlocation = strtolower($this->input->post('searchlocation'));
        $searchlocation = str_replace('city', '', $searchlocation);
        $searchlocation = str_replace(',', ' ', $searchlocation);
        if(!empty($propstate)) {
            $searchpropstate = $propstate;
        } else {
            $searchpropstate = ( is_array($this->input->post('searchpropstate')) ? $this->input->post('searchpropstate') : array() );
        }
        $searchproppost = ( is_array($this->input->post('searchproppost')) ? $this->input->post('searchproppost') : array() );
        $searchproptype = ( is_array($this->input->post('searchproptype')) ? $this->input->post('searchproptype') : array() );
        $searchpropavail = ( is_array($this->input->post('searchpropavail')) ? $this->input->post('searchpropavail') : array() );
        $filters = array('searchcompanycode' => $usercode,
                         'searchkeywords' => explode(' ', $searchkeywords),
                         'searchlocation' => explode(' ', $searchlocation),
                         'searchcountry' => $this->input->post('searchcountry'),
                         'searchpropstate' => $searchpropstate,
                         'searchproppost' => $searchproppost,
                         'searchproptype' => $searchproptype,
                         'searchpropavail' => $searchpropavail,
                         'sort' => $this->input->post('sort'),
                         'ord' => $this->input->post('ord') );
        return $this->prop->get_search_result($filters, 'list', $off, $lmt);
    }
    
    public function agents($companycode = '') {
        $offset = '0';
        $limit = LIMIT_COMPANYAGENTS;
        $sort = '';
        $ord = '';
        if(isset($_POST['off']) && isset($_POST['lmt'])) {
            $offset = $this->input->post('off');
            $limit = $this->input->post('lmt');
            $sort = $this->input->post('sort');
            $ord = $this->input->post('ord');
        }
        $filters = array('searchkeywords' => array(),
                         'searchlocation' => array(),
                         'searchcountry' => '',
                         'searchverified' => '',
                         'searchrating' => '',
                         'searchlevel' => array(),
                         'searchcompany' => $companycode,
                         'sort' => $sort,
                         'ord' => $ord );
        $this->load->model('Users_Model', 'user');
        $result = $this->user->get_search_result($filters, 'list', $offset, $limit);
        
        $userlogin = $this->tank_auth->is_logged_in();
        
        $listagents = array();
        foreach($result as $rec) {
            $vw = $this->load->view('agents/item', array('record' => $rec, 'appended' => true, 'userlogin' => $userlogin), true);
            array_push($listagents, $vw);   
        }        
        
        echo json_encode($listagents);
    }
}