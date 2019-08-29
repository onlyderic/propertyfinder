<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Agent
 * 
 * Functions for Individual Agent
 * 
 * @author      Eric Domingo
 * @version     0.1
 * @copyright   2013
 */
class Agent extends CI_Controller {
    
    /**
     * Folder name of view for agents
     *
     * @var string
     * @access private
     */
    private $folder = 'agents/';
    
    /**
     * Folder name of view for properties
     *
     * @var string
     * @access private
     */
    private $folder_props = 'properties/';
    
    /**
     * Class construct
     */
    function __construct() {                
        parent::__construct();
        
        $this->load->model('Users_Model', 'user');
    }
    
    /**
     * Re-map URL to class functions
     * 
     * @param string $method    Name of function
     * @param array $params     Array of parameters
     * 
     * @return bool
     */
    public function _remap($method, $params = array()) {
        //If the method doesn't exist (because it's the agent's name), it means that it's viewing the agent profile
        //Format: URL/agent/agent-name/agentid
        if( ! method_exists($this, $method) && count($params) == 1 ) {
            $profileid = $params[0];
            $notifications = false;
            //Check if instead of Agent's ID, "notifications" is the value
            //If so, this is called from Notifications button
            if( $profileid == 'notifications' ) {
                if(!$this->tank_auth->is_logged_in()) {
                    $this->tank_auth->logout(true);
                    $this->session->set_flashdata('call_reference', 'agent/' . $method . '/' . $profileid );
                    redirect('login');
                }
                $profileid = $this->tank_auth->get_user_code();
                $notifications = true;
            }
            $this->_profile($profileid, $notifications);
            return true;
        }
        //Agent profile edit
        //Agent's ID and current user's ID must be the same
        //Format: URL/agent/edit/agent-name/agentid
        elseif( $method == 'edit' && count($params) == 2 ) {
            //If not logged in or editing a different profile, redirect to profile view only
            $usercode = $this->tank_auth->get_user_code();
            if(!$this->tank_auth->is_logged_in() || $params[1] != $usercode) {
                redirect('agent/' . $params[0] . '/' . $params[1]);
            }
            $this->_edit($params[1]);
            return true;
        }
        //Agent password edit
        //Agent's ID and current user's ID must be the same
        //Format: URL/agent/password/agent-name/agentid
        elseif( $method == 'password' && count($params) == 2 ) {
            //If not logged in or editing a different profile, logout and redirect to login page
            $usercode = $this->tank_auth->get_user_code();
            if(!$this->tank_auth->is_logged_in() || $params[1] != $usercode) {
                $this->tank_auth->logout(true);
                $this->session->set_flashdata('call_reference', 'agent/password/' . $params[0] . '/' . $params[1] );
                redirect('login');
            }
            $this->_password($params[1]);
            return true;
        }
        //Agent's Properties
        //Format: URL/agent/my-properties
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

    /**
     * Landing page
     * 
     * By default, displays the profile of the selected agent
     * If the selected agent doesn't exist, the page displays a agent not found message
     * In this case, it has no agent selected
     * 
     * @access public
     */
    public function index() {
        $this->_profile();
    }
    
    /**
     * Profile page
     * 
     * Displays the profile of the selected agent's ID
     * If the selected agent doesn't exist, the page displays a agent not found message
     * 
     * @access protected
     * 
     * @param string $profileid   Agent ID
     * @param bool $notifications    Show Notifications tab or not. This is set when the Notifications button is clicked
     * 
     * @return null
     */
    protected function _profile($profileid = '', $notifications = false) {
        $usercode = $this->tank_auth->get_user_code();
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $usercode;
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = SITE_NAME;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = ( $notifications ? array('notifications' => true) : array('agents' => true) );
        
        //Get the agent's record
        $profilerow = $this->user->get_user_by_code($profileid);
        
        //Set an empty agent record, but when the agent record's exists, fill it up
        $profilerec = array('code' => '',
                      'pic' => '',
                      'fname' => '',
                      'lname' => '',
                      'companycode' => '',
                      'company' => '',
                      'licensenum' => '',
                      'position' => '',
                      'city' => '',
                      'country' => '',
                      'level' => '',
                      'profile' => '',
                      'rating' => '',
                      'numrating' => '',
                      'mobilenum' => '',
                      'homenum' => '',
                      'officenum' => '',
                      'skype' => '',
                      'accfb' => '',
                      'acctwitter' => '',
                      'accgoogle' => '',
                      'acclinkedin' => '',
                      'dateregistered' => '',
                      'useragentrating' => '',
                      'numproperties' => '',
                      'verifiedagent' => '',
                      'featured' => '');
        if($profilerow) {
            $datahead['title'] = $profilerow->fname . ' ' . $profilerow->lname . PAGE_TITLE;
            $profilerec = array('code' => $profilerow->code,
                          'pic' => $profilerow->profilepic,
                          'fname' => $profilerow->fname,
                          'lname' => $profilerow->lname,
                          'companycode' => $profilerow->companycode,
                          'company' => $profilerow->companyname,
                          'licensenum' => $profilerow->licensenum,
                          'position' => $profilerow->position,
                          'city' => $profilerow->city,
                          'country' => get_text_country($profilerow->country),
                          'level' => gettext_profile_level($profilerow->level, true),
                          'profile' => $profilerow->profile,
                          'rating' => $profilerow->rating,
                          'numrating' => $profilerow->numrating,
                          'mobilenum' => $profilerow->mobilenum,
                          'homenum' => $profilerow->homenum,
                          'officenum' => $profilerow->officenum,
                          'skype' => $profilerow->skype,
                          'accfb' => $profilerow->accfb,
                          'acctwitter' => $profilerow->acctwitter,
                          'accgoogle' => $profilerow->accgoogle,
                          'acclinkedin' => $profilerow->acclinkedin,
                          'dateregistered' => $profilerow->fdatecreated,
                          'useragentrating' => $profilerow->useragentrating,
                          'numproperties' => $profilerow->numproperties,
                          'verifiedagent' => ( $profilerow->verifiedagent == YES ? '<span class="badge badge-warning tooltip-propertygusto" data-placement="top" data-title="This is a verified real estate agent!"><i class="icon-ok-sign"></i> Verified</span>' : '' ),
                          'featured' => $profilerow->featured );
        }
        $data['usercode'] = $usercode;
        $data['record'] = $profilerec;
        
        //Notifications...
        
        //Only if the user accessing this profile is the owner
        $isloggedin = $this->tank_auth->is_logged_in();
        $data['notifications'] = false;
        $data['ownprofile'] = false;
        if( $isloggedin && $usercode == $profileid ) {
            $data['ownprofile'] = true;
            if($notifications) {
                $data['notifications'] = $notifications;

                //Set notification records to "viewed"
                $this->load->model('Notifications_Model', 'notify');
                $this->notify->viewed($usercode);
            }
        }
        
        //Display page...
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'profile', $data);
        $this->load->view('footer', $datafoot);
    }
    
    /**
     * Edit Profile page
     * 
     * Displays the agent profile form
     * The agent to be edited must be the user's own profile
     * Otherwise, the page displays an error message
     * The user must be logged in. This is taken cared of by remap
     * 
     * @access protected
     * 
     * @return null
     */
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
        $this->form_validation->set_rules('ufname', 'First Name', 'trim|required|min_length[1]|max_length[250]|alpha_dash_space');
        $this->form_validation->set_rules('ulname', 'Last Name', 'trim|required|min_length[1]|max_length[250]|alpha_dash_space');
        $this->form_validation->set_rules('uaddress', 'Address', 'trim|max_length[500]|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('ucity', 'City', 'trim|max_length[50]|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('ucountry', 'Country', 'trim');
        $this->form_validation->set_rules('umobilenum', 'Mobile Number', 'trim|min_length[1]|max_length[100]|alpha_dash_space');
        $this->form_validation->set_rules('uofficenum', 'Office Number', 'trim|min_length[1]|max_length[25]|alpha_dash_space');
        $this->form_validation->set_rules('uhomenum', 'Home Number', 'trim|min_length[1]|max_length[25]|alpha_dash_space');
        $this->form_validation->set_rules('uskype', 'Skype', 'trim|min_length[1]|max_length[50]|alpha_dash');
        $this->form_validation->set_rules('udescription', 'Profile Description', 'trim]|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('ucompany', 'Company', 'trim|min_length[1]|max_length[200]');
        $this->form_validation->set_rules('ucompanyid', 'Company ID', 'trim');
        $this->form_validation->set_rules('ulicensenum', 'License Number', 'trim|min_length[1]|max_length[50]|alpha_dash');
        $this->form_validation->set_rules('uposition', 'Position', 'trim|min_length[1]|max_length[50]');
        $this->form_validation->set_rules('uemail', 'Email Address', 'trim|required|max_length[300]|valid_email|callback__check_email');
        $this->form_validation->set_rules('uaccfb', 'Facebook Profile', 'trim|max_length[200]|prep_url|valid_url_fb');
        $this->form_validation->set_rules('uacctwitter', 'Twitter Profile', 'trim|max_length[200]|prep_url|valid_url_twitter');
        $this->form_validation->set_rules('uaccgoogle', 'Google+ Profile', 'trim|max_length[200]|prep_url|valid_url_googleplus');
        $this->form_validation->set_rules('uacclinkedin', 'LinkedIn Profile', 'trim|max_length[200]|prep_url|valid_url_linkedin');
   
        //When submitted...
        
        if($this->form_validation->run() !== FALSE) {
            //First, update the PropInfos table
            $record = array(
                        'fname' => $this->input->post('ufname'),
                        'lname' => $this->input->post('ulname'),
                        'mobilenum' => $this->input->post('umobilenum'),
                        'officenum' => $this->input->post('uofficenum'),
                        'homenum' => $this->input->post('uhomenum'),
                        'skype' => $this->input->post('uskype'),
                        'companyname' => $this->input->post('ucompany'),
                        'companycode' => $this->input->post('ucompanyid'),
                        'companypic' => $this->input->post('ucompanypicfile'),
                        'licensenum' => $this->input->post('ulicensenum'),
                        'email' => $this->input->post('uemail'),
                        'datemodified' => date('Y-m-d H:i:s') );
            $result = $this->user->update($record, $usercode);
            
            //Then, the PropDescs table
            $record = array('position' => $this->input->post('uposition'),
                        'profile' => $this->input->post('udescription'),
                        'address' => $this->input->post('uaddress'),
                        'city' => $this->input->post('ucity'),
                        'country' => $this->input->post('ucountry'),
                        'accfb' => $this->input->post('uaccfb'),
                        'acctwitter' => $this->input->post('uacctwitter'),
                        'accgoogle' => $this->input->post('uaccgoogle'),
                        'acclinkedin' => $this->input->post('uacclinkedin'));
            $result2 = $this->user->update_desc($record, $usercode);
            
            //And, inform user
            if($result) {
                //After successful save, change session, change cached user profile pages
                $this->session->set_userdata('userfname', $this->input->post('ufname'));
                $this->session->set_userdata('userlname', $this->input->post('ulname'));
                
                $this->lang->load('success', 'english');
                $this->session->set_flashdata('message_user_update_status', 'success');
                $this->session->set_flashdata('message_user_update', $this->lang->line('success_user_update'));
            } else {
                $this->lang->load('error', 'english');
                $this->session->set_flashdata('message_user_update_status', 'error');
                $this->session->set_flashdata('message_user_update', $this->lang->line('error_user_update'));
            }
            redirect('agent/edit/' . url_title($datahead['userfullname']) . '/' . url_title($usercode));
        }   
        
        //Display page...
        
        //Get the user's record to display on the form
        $userrow = $this->user->get_user_by_code($usercode);
        
        //If the user has not yet selected his country, set the field to default to user's current location
        include('ip2locationlite.class.php');
        $ipLite = new ip2location_lite;
        $ip = $this->input->ip_address();
        $location = $ipLite->getCountry($ip);
        $country = ( isset($location['countryCode']) ? $location['countryCode'] : '' );
        
        //Set an empty agent record, but when the agent record's exists, fill it up
        $data = array('upic' => '',
                      'ufname' => '',
                      'ulname' => '',
                      'uaddress' => '',
                      'ucity' => '',
                      'ucountry' => $country,
                      'umobilenum' => '',
                      'uofficenum' => '',
                      'uhomenum' => '',
                      'uskype' => '',
                      'udescription' => '',
                      'ucompany' => '',
                      'ucompanyid' => '',
                      'ucompanypicfile' => '',
                      'ulicensenum' => '',
                      'uposition' => '',
                      'uemail' => '',
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
                          'ufname' => $userrow->fname,
                          'ulname' => $userrow->lname,
                          'uaddress' => $userrow->address,
                          'ucity' => $userrow->city,
                          'ucountry' => ( empty($userrow->country) ? $country : $userrow->country ),
                          'umobilenum' => $userrow->mobilenum,
                          'uofficenum' => $userrow->officenum,
                          'uhomenum' => $userrow->homenum,
                          'uskype' => $userrow->skype,
                          'udescription' => $userrow->profile,
                          'ucompany' => $userrow->companyname,
                          'ucompanyid' => $userrow->companycode,
                          'ucompanypicfile' => $userrow->companypic,
                          'ulicensenum' => $userrow->licensenum,
                          'uposition' => $userrow->position,
                          'uemail' => $userrow->email,
                          'uaccfb' => $accfb,
                          'uacctwitter' => $acctwitter,
                          'uaccgoogle' => $accgoogle,
                          'uacclinkedin' => $acclinkedin
                    );
        }
        
        //Get list of countries for the country field
        $data['countries'] = $this->config->item('countries');
        
        //Display a message, if any
        $data['message_status'] = $this->session->flashdata('message_user_update_status');
        $data['message'] = $this->session->flashdata('message_user_update');
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'form', $data);
        $this->load->view('footer', $datafoot);
    }
    
    /**
     * Change Password page
     * 
     * Displays the change password form
     * The user must be logged in. This is taken cared of by remap
     * 
     * @access protected
     * 
     * @return null
     */
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
   
        //When submitted...
        
        if($this->form_validation->run() !== FALSE) {
            //Update user's password
            $password = $this->tank_auth->create_password($this->input->post('upass'));
            $record = array('password' => $password);
            $result = $this->user->update_password($record, $usercode);
            
            //And, inform user
            if($result) {
                $this->lang->load('success', 'english');
                $this->session->set_flashdata('message_user_update_status', 'success');
                $this->session->set_flashdata('message_user_update', $this->lang->line('success_user_password_update'));
            } else {
                $this->lang->load('error', 'english');
                $this->session->set_flashdata('message_user_update_status', 'error');
                $this->session->set_flashdata('message_user_update', $this->lang->line('error_user_password_update'));
            }
            redirect('agent/password/' . url_title($datahead['userfullname']) . '/' . url_title($usercode));
        }   
        
        //Display page...
        
        //Display a message, if any
        $data['message_status'] = $this->session->flashdata('message_user_update_status');
        $data['message'] = $this->session->flashdata('message_user_update');
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'password_form', $data);
        $this->load->view('footer', $datafoot);
    }
    
    /**
     * Agent's Own Properties page
     * 
     * Displays the user's list of properties page
     * The user must be logged in
     * 
     * @access protected
     * 
     * @return null
     */
    protected function _properties() {
        if(!$this->tank_auth->is_logged_in()) {
            $this->session->set_flashdata('call_reference', 'agent/my-properties');
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
        
        //These are for the search form
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
        
        //Get list of agent's properties
        //If this is the first-time access, display a default list
        //Otherwise, display the result of the search
        
        //For every call of this function, start a new list
        $off = 0; //Start new
        $lmt = LIMIT_MYPROPERTIES;
        //By default, retrieve both Active and Drafted records
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
        
        //Get list of countries for the country field
        $data['countries'] = $this->config->item('countries');
        //And, set the country field with the previously selected country
        $data['country'] = $this->input->post('searchcountry');
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder_props . 'my_properties', $data);
        $this->load->view('footer', $datafoot);
    }
    
    /**
     * Search More
     * 
     * Function to be called when the agent's property list is scrolled
     * 
     * @access public
     * 
     * @return json
     */
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
            $vw = $this->load->view($this->folder_props . 'item_myproperties', array('record' => $rec, 'usercode' => $usercode, 'appended' => true, 'userlogin' => $userlogin), true);
            array_push($listprops, $vw);   
        }        
        
        echo json_encode($listprops);
    }
    
    /**
     * Search Live My Properties
     * 
     * Function that processes and retrieve the list of properties based on given parameters
     * 
     * @access private
     * 
     * @param int $off              Offset
     * @param int $lmt              Limit
     * @param array $propstate      Property record's state (Active or Drafted or both)
     * 
     * @return objects
     */
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
        $filters = array('searchownercode' => $usercode,
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
    
    /**
     * Profile Picture
     * 
     * Function that processes the upload and resizing of the agent's profile picture
     * 
     * @access public
     * 
     * @return json
     */
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
	} elseif(empty($_FILES['upic']['tmp_name']) || $_FILES['upic']['tmp_name'] == 'none') {
            $error = 'No file was uploaded..';
	} else {
            $path_parts = pathinfo($_FILES['upic']['name']);
            $ext = $path_parts['extension'];
            
            $upload_path = dirname($_SERVER['SCRIPT_FILENAME']) . '/profiles/';

            // Specify configuration for File
            $config['upload_path'] = $upload_path;
            $msg .= "basepath: " . $upload_path;
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['file_name'] = $path_parts['filename'];
            $config['max_size']	= '1000';

            $this->load->library('upload');
            $this->upload->initialize($config);

            if($this->upload->do_upload('upic')) {
                $usercode = $this->tank_auth->get_user_code();
                
                $pic = md5( date('YmdHis') . '_' . $this->upload->file_name ) . '.' . $ext;
                rename($upload_path . $this->upload->file_name, $upload_path . $pic);
                
                //Save to table
                $this->load->model('Users_Model', 'user');
                $result = $this->user->update_pic($usercode, 'profilepic', $pic);
                
                if($result) {
                    //Change picture on session
                    $this->session->set_userdata(array('userpic' => $pic));
                
                    //Update properties of this user
                    $this->load->model('Properties_Model', 'prop');
                    $result = $this->prop->update_user_pic($usercode, $pic);
                    
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
	}		
	echo "{";
	echo "error: '" . $error . "',\n";
	echo "pic: '" . $pic . "'\n";
	echo "}";
    }
    
    /**
     * Company Picture
     * 
     * Function that processes the upload and resizing of the agent's company logo
     * 
     * @access public
     * 
     * @return json
     */
    public function company_picture() {
        $error = "";
	$msg = "";
	$fileElementName = 'ucompanypic';
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
	} elseif(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none') {
            $error = 'No file was uploaded..';
	} else {
            $path_parts = pathinfo($_FILES[$fileElementName]['name']);
            $ext = $path_parts['extension'];
            
            $upload_path = dirname($_SERVER['SCRIPT_FILENAME']) . '/companies/';

            // Specify configuration for File
            $config['upload_path'] = $upload_path;
            $msg .= "basepath: " . $upload_path;
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['file_name'] = $path_parts['filename'];
            $config['max_size']	= '1000';

            $this->load->library('upload');
            $this->upload->initialize($config);

            if($this->upload->do_upload($fileElementName)) {
                $pic = md5( date('YmdHis') . '_' . $this->upload->file_name ) . '.' . $ext;
                rename($upload_path . $this->upload->file_name, $upload_path . $pic);
                
                //Save to table
                $usercode = $this->tank_auth->get_user_code();
                $this->load->model('Users_Model', 'user');
                $result = $this->user->update_pic($usercode, 'companypic', $pic);
                
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
    
    /**
     * Check Email
     * 
     * Callback function for Form Validation to check validity and existence of email address
     * 
     * @access public
     * 
     * @return json
     */
    public function _check_email($str) {
        $usercode = $this->tank_auth->get_user_code();
        $this->load->model('Users_Model', 'user');
        $result = $this->user->check_email($str, $usercode);
        if(!$result) {
            $this->lang->load('error', 'english');
            $this->form_validation->set_message('_check_email', $this->lang->line('error_email_used') );
            return FALSE;
        } else {
            return TRUE;
        }
    }
}