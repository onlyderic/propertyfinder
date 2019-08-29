<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Property extends CI_Controller {
    
    private $folder = 'properties/';
    
    function __construct() {
        parent::__construct();
        
        $this->load->model('Properties_Model', 'prop');
    }
    
    public function _remap($method, $params = array()) {
        //If the method doesn't exist (because it's the property's name), it means that it's viewing the property profile
        //Format: URL/property/property-name/propertyid
        if( ! method_exists($this, $method) &&  count($params) == 1 ) {
            $this->_profile($params[0]);
            return true;
        }
        //Property profile edit
        //Format: URL/property/post/property-name/propertyid
        elseif( $method == 'post' && count($params) == 2 ) {
            $this->post($params[1]);
            return true;
        }
        //Property form for Map
        //Format: URL/property/form-map
        elseif( $method == 'form-map' && count($params) == 0 ) {
            $this->post_map();
            return true;
        }
        if(method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            show_404();
        }
    }

    public function index() {
        $this->_profile();
    }
    
    protected function _profile($propcode = '') {                
        $usercode = $this->tank_auth->get_user_code();
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $usercode;
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = SITE_NAME;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('properties' => true);
        
        $profilerow = $this->prop->get_property_by_code($propcode);

        $profilerec = array('code' => '',
                      'name' => '',
                      'profilepic' => '',
                      'profilepicwidth' => '',
                      'profilepicheight' => '',
                      'category' => '',
                      'subcategory' => '',
                      'classification' => '',
                      'posting' => '',
                      'price' => '',
                      'price2' => '',
                      'pricedown' => '',
                      'pricereserve' => '',
                      'pricediscount' => '',
                      'rooms' => '',
                      'toilets' => '',
                      'area' => '',
                      'garage' => '',
                      'garagelabel' => '',
                      'address' => '',
                      'location' => '',
                      'tenure' => '',
                      'construction' => '',
                      'completion' => '',
                      'floorsnum' => '',
                      'unitsnum' => '',
                      'foreclosure' => '',
                      'resale' => '',
                      'occupancy' => '',
                      'companycode' => '',
                      'companyname' => '',
                      'companypic' => '',
                      'ownercode' => '',
                      'ownername' => '',
                      'ownerpic' => '',
                      'ownermobilenum' => '',
                      'ownerhomenum' => '',
                      'ownerofficenum' => '',
                      'ownerskype' => '',
                      'owneraccfb' => '',
                      'owneracctwitter' => '',
                      'owneraccgoogle' => '',
                      'owneracclinkedin' => '',
                      'ownerlicense' => '',
                      'ownerlevel' => '',
                      'ownerverifiedagent' => '',
                      'ownerrating' => '',
                      'ownernumrating' => '',
                      'ownertype' => '',
                      'numlikes' => '',
                      'numdislikes' => '',
                      'numviews' => '',
                      'rating' => '',
                      'numrating' => '',
                      'featured' => '',
                      'soldout' => '',
                      'closed' => '',
                      'datepublished' => '',
                      'fdatepublished' => '',
                      'description' => '',
                      'financing' => '',
                      'paymentscheme' => '',
                      'furnished' => '',
                      'furnishings' => '',
                      'features' => '',
                      'facilities' => '',
                      'video' => '',
                      'coordlat' => '',
                      'coordlong' => '',
                      'userrating' => '',
                      'userthumbs' => '',
                      'useragentrating' => '',
                      'recstatus' => '');
        if($profilerow) {
            $datahead['title'] = $profilerow->name . PAGE_TITLE;
            $datahead['profile_title'] = $profilerow->name . PAGE_TITLE;
            $datahead['profile_description'] = strip_quotes($profilerow->description);
            
            $postingarr = str_split($profilerow->posting);
            foreach($postingarr as $k => $v) {
                $postingarr[$k] = strtoupper(get_text_posting($v));
            }
            $posting = implode(' / ', $postingarr);
            
            $price = money_symbol($profilerow->priceunit) . format_money($profilerow->pricemin) . ( !empty($profilerow->pricemax) ? ' <span style="color:#000;font-weight:normal;">to</span> ' . format_money($profilerow->pricemax) : '' );
            $price2 = $price . ( $profilerow->pricenegotiable == YES ? ' <small style="color:#333333;font-weight:normal;">(negotiable)</small>' : ( $profilerow->pricenegotiable == NO ? ' <small style="color:#333333;font-weight:normal;">(not negotiable)</small>' : '' ) );
            $price .= ( $profilerow->pricenegotiable == YES ? '<br/><small style="color:#333333;font-weight:normal;">(negotiable)</small>' : ( $profilerow->pricenegotiable == NO ? '<br/><small style="color:#333333;font-weight:normal;">(not negotiable)</small>' : '' ) );
            $rooms = ( !empty($profilerow->roomsmin) ? get_text_room($profilerow->roomsmin) . ( !empty($profilerow->roomsmax) ? ' to ' . $profilerow->roomsmax . ' rooms' : '' ) : '' );
            $toilets = ( !empty($profilerow->toiletmin) ? $profilerow->toiletmin . ( !empty($profilerow->toiletmax) ? ' to ' . $profilerow->toiletmax : '' ) : '' );
            $area = ( !empty($profilerow->areamin) ? format_number_whole($profilerow->areamin) . ( !empty($profilerow->areamax) ? ' to ' . format_number_whole($profilerow->areamax) : '' ) . ' ' . $profilerow->areaunit : '' );
            $garages = ( !empty($profilerow->garagemin) ? $profilerow->garagemin . ( !empty($profilerow->garagemax) ? ' to ' . $profilerow->garagemax : '' ) : '' );
            $location = $profilerow->city . ( !empty($profilerow->city) && !empty($profilerow->country) ? ', ' : '' ) . ( !empty($profilerow->country) ? get_text_country($profilerow->country) : '' );
            
            $financingarr = str_split($profilerow->financing);
            foreach($financingarr as $k => $v) {
                $financingarr[$k] = get_text_financing($v);
            }
            $financing = implode(', ', $financingarr);
            
            $furnishingsarr = explode(',', $profilerow->furnishings);
            foreach($furnishingsarr as $k => $v) {
                $furnishingsarr[$k] = get_text_furnishing($v);
            }
            $furnishings = implode(', ', $furnishingsarr);
            
            $featuresarr = explode(',', $profilerow->features);
            foreach($featuresarr as $k => $v) {
                $featuresarr[$k] = get_text_feature($v);
            }
            $features = implode(', ', $featuresarr);
            
            $facilitiesarr = explode(',', $profilerow->facilities);
            foreach($facilitiesarr as $k => $v) {
                $facilitiesarr[$k] = get_text_facility($v);
            }
            $facilities = implode(', ', $facilitiesarr);
            
            $months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
            
            if( $profilerow->recstatus == PROPSTATUS_DRAFT && $profilerow->ownercode != $usercode ) {
                $profilerec['code'] = ''; //Remove code so that this record won't show on the page
            } else {
                $profilerec = array('code' => $profilerow->code,
                                    'name' => $profilerow->name,
                                    'profilepic' => $profilerow->profilepic,
                                    'profilepicwidth' => $profilerow->profilepicwidth,
                                    'profilepicheight' => $profilerow->profilepicheight,
                                    'category' => get_text_category($profilerow->category),
                                    'subcategory' => get_text_subcategory($profilerow->subcategory),
                                    'classification' => get_text_classification($profilerow->classification),
                                    'posting' => $posting,
                                    'price' => $price,
                                    'price2' => $price2,
                                    'pricedown' => $profilerow->pricedown,
                                    'pricereserve' => $profilerow->pricereserve,
                                    'pricediscount' => $profilerow->pricediscount,
                                    'rooms' => $rooms,
                                    'toilets' => $toilets,
                                    'area' => $area,
                                    'garage' => $garages,
                                    'garagelabel' => ( $profilerow->category == PROPCATEGORY_COMMERCIAL ? 'Parking' : 'Garage' ),
                                    'address' => $profilerow->address . ( !empty($profilerow->address) && !empty($profilerow->postalcode) ? ' ' . $profilerow->postalcode : '' ),
                                    'location' => $location,
                                    'tenure' => ( $profilerow->tenure == TENURE_FREEHOLD || $profilerow->tenure == TENURE_LEASEHOLD ? $profilerow->tenureyr . '-years ' : '' ) . get_text_tenure($profilerow->tenure),
                                    'construction' => ( empty($profilerow->construction) || $profilerow->construction == -5 ? '' : ( $profilerow->construction == 100 ? 'Complete' : $profilerow->construction . '%' ) ),
                                    'completion' => ( $profilerow->construction != 100 ? ( !empty($profilerow->completionmo) ? $months[$profilerow->completionmo] . ' ' : '' ) . $profilerow->completionyr : '' ),
                                    'floorsnum' => $profilerow->floorsnum . ( !empty($profilerow->floorsnum) ? ( $profilerow->floorsnum == 1 ? ' storey' : ' storeys' ) : '' ),
                                    'unitsnum' => $profilerow->unitsnum . ( !empty($profilerow->unitsnum) ? ( $profilerow->unitsnum == 1 ? ' unit' : ' units' ) : '' ),
                                    'foreclosure' => get_text_foreclosure($profilerow->foreclosure),
                                    'resale' => get_text_resale($profilerow->resale),
                                    'occupancy' => get_text_occupancy($profilerow->occupancy),
                                    'companycode' => $profilerow->companycode,
                                    'companyname' => $profilerow->companyname,
                                    'companypic' => $profilerow->companypic,
                                    'ownercode' => $profilerow->ownercode,
                                    'ownername' => $profilerow->ownername,
                                    'ownerpic' => $profilerow->ownerpic,
                                    'ownermobilenum' => $profilerow->ownermobilenum,
                                    'ownerhomenum' => $profilerow->ownerhomenum,
                                    'ownerofficenum' => $profilerow->ownerofficenum,
                                    'ownerskype' => $profilerow->ownerskype,
                                    'owneraccfb' => $profilerow->owneraccfb,
                                    'owneracctwitter' => $profilerow->owneracctwitter,
                                    'owneraccgoogle' => $profilerow->owneraccgoogle,
                                    'owneracclinkedin' => $profilerow->owneracclinkedin,
                                    'ownerlicense' => $profilerow->ownerlicense,
                                    'ownerlevel' => gettext_profile_level($profilerow->ownerlevel),
                                    'ownerverifiedagent' => ( $profilerow->ownerverifiedagent == YES ? '<span class="badge badge-warning tooltip-propertygusto" data-placement="top" data-title="This is a verified real estate agent!"><i class="icon-ok-sign"></i> Verified</span>' : '' ),
                                    'ownerrating' => $profilerow->ownerrating,
                                    'ownernumrating' => $profilerow->ownernumrating,
                                    'ownertype' => $profilerow->ownertype,
                                    'numlikes' => $profilerow->numlikes,
                                    'numdislikes' => $profilerow->numdislikes,
                                    'numviews' => format_number_whole($profilerow->numviews) . ( $profilerow->numviews == 1 ? ' view' : ' views' ),
                                    'rating' => $profilerow->rating,
                                    'numrating' => $profilerow->numrating,
                                    'featured' => $profilerow->featured,
                                    'soldout' => $profilerow->soldout,
                                    'closed' => $profilerow->closed,
                                    'datepublished' => time_elapsed($profilerow->datepublished),
                                    'fdatepublished' => $profilerow->fdatepublished,
                                    'description' => $profilerow->description,
                                    'financing' => $financing,
                                    'paymentscheme' => $profilerow->paymentscheme,
                                    'furnished' => get_text_furnished($profilerow->furnished),
                                    'furnishings' => $furnishings,
                                    'features' => $features,
                                    'facilities' => $facilities,
                                    'video' => $profilerow->video,
                                    'coordlat' => $profilerow->coordlat,
                                    'coordlong' => $profilerow->coordlong,
                                    'userrating' => $profilerow->userrating,
                                    'userthumbs' => $profilerow->userthumbs,
                                    'useragentrating' => $profilerow->useragentrating,
                                    'recstatus' => $profilerow->recstatus);
            }
            
        }
        $data['usercode'] = $usercode;
        $data['record'] = $profilerec;
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'profile', $data);
        $this->load->view('footer', $datafoot);
    }
    
    public function post($propcode = '') {
        if(!$this->tank_auth->is_logged_in()) {
            $this->session->set_flashdata('call_reference', str_replace('propertygusto/', '', $_SERVER['REQUEST_URI']) );
            redirect('login');
        }
        
        $this->lang->load('success', 'english');
        $this->lang->load('error', 'english');
        
        $usercode = $this->tank_auth->get_user_code();
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $usercode;
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = 'Post property listing' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('user' => true);
        
        //Check the record for existence and ownership
        if(!empty($propcode)) {

            $resultrow = $this->prop->get_property_for_checking($propcode);

            $data = array();
            $error = false;
            if($resultrow) {
                if($resultrow->ownercode != $usercode) {
                    $data['error'] = $this->lang->line('error_property_not_owned');
                    $error = true;
                }
            } else {
                $data['error'] = $this->lang->line('error_property_not_exists');
                $error = true;
            }
            
            if($error) {
                $this->load->view('header', $datahead);
                $this->load->view($this->folder . 'form', $data);
                $this->load->view('footer', $datafoot);
                return true;
            }
        }

        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->load->library('MY_Form_validation');
        $this->form_validation->set_error_delimiters(ERROR_DELIMITER_OPEN, ERROR_DELIMITER_CLOSE);
        $this->form_validation->set_rules('id', '', '');
        $this->form_validation->set_rules('propname', 'Property Name', 'trim|required|min_length[1]|max_length[500]|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('proppost[]', 'Posting', 'required');
        $this->form_validation->set_rules('proptype', 'Type', 'required');
        $this->form_validation->set_rules('propclass', 'Classification', 'required');
        $this->form_validation->set_rules('proppricemin', 'Minimum Price', 'trim|required|min_length[1]|max_length[12]|callback__check_amount');
        $this->form_validation->set_rules('propnegotiable[]', 'Price Negotiable', 'trim');
        $this->form_validation->set_rules('proppriceunit', 'Price Unit', 'required');
        $this->form_validation->set_rules('proppricerange', 'Price Range', '');
        $this->form_validation->set_rules('propscheme', 'Payment Scheme', 'trim|min_length[1]|max_length[10000]|xss_clean');
        $this->form_validation->set_rules('propfinance[]', 'Financing', 'required');
        $this->form_validation->set_rules('propdeveloperid', 'Developer ID', '');
        $this->form_validation->set_rules('propdeveloper', 'Developer', 'trim|max_length[200]');
        $this->form_validation->set_rules('proploccountry', 'Location - Country', 'required');
        $this->form_validation->set_rules('proploccity', 'Location - City', '');
        $this->form_validation->set_rules('propaddress', 'Address', 'trim|max_length[500]');
        $this->form_validation->set_rules('proppostal', 'Postal Code', 'trim|max_length[10]|numeric|xss_clean');
        $this->form_validation->set_rules('propreserve', 'Reservation Fee', 'trim|max_length[1000]|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('propdown', 'Down Payment', 'trim|max_length[1000]|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('propdiscount', 'Discount', 'trim|max_length[1000]|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('proproomrange', 'Room Range', '');
        $this->form_validation->set_rules('proptoiletrange', 'Toilet Range', '');
        $this->form_validation->set_rules('proparearange', 'Area Range', '');
        $this->form_validation->set_rules('propgaragerange', 'Garage Range', '');
        $this->form_validation->set_rules('propdesc', 'Description', 'trim|max_length[65000]|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('proptenure[]', 'Tenure', 'trim');
        $this->form_validation->set_rules('proptenureyears', 'Tenure Years', 'trim|max_length[3]|numeric');
        $this->form_validation->set_rules('propconstruction', 'Construction', 'trim');
        $this->form_validation->set_rules('propcompletionmo', 'Completion Month', 'trim');
        $this->form_validation->set_rules('propfloornum', 'Number of Floors', 'trim|max_length[4]|numeric');
        $this->form_validation->set_rules('propunitnum', 'Number of Units', 'trim|max_length[4]|numeric');
        $this->form_validation->set_rules('propforeclosure[]', 'Foreclosure?', 'trim');
        $this->form_validation->set_rules('propresale[]', 'Resale?', 'trim');
        $this->form_validation->set_rules('propoccupancy[]', 'Ready for Occupancy?', 'trim');
        $this->form_validation->set_rules('propfurnished[]', 'Furnished?', '');
        $this->form_validation->set_rules('propfurnish1[]', 'Furnishings', '');
        $this->form_validation->set_rules('propfurnish2[]', 'Furnishings', '');
        $this->form_validation->set_rules('propfurnish3[]', 'Furnishings', '');
        $this->form_validation->set_rules('propfurnish4[]', 'Furnishings', '');
        $this->form_validation->set_rules('propfeatures1[]', 'Features', '');
        $this->form_validation->set_rules('propfeatures2[]', 'Features', '');
        $this->form_validation->set_rules('propfeatures3[]', 'Features', '');
        $this->form_validation->set_rules('propfeatures4[]', 'Features', '');
        $this->form_validation->set_rules('propfacilities1[]', 'Facilities', '');
        $this->form_validation->set_rules('propfacilities2[]', 'Facilities', '');
        $this->form_validation->set_rules('propfacilities3[]', 'Facilities', '');
        $this->form_validation->set_rules('propfacilities4[]', 'Facilities', '');
        $this->form_validation->set_rules('propvideo', 'Video', 'trim|max_length[150]|prep_url|valid_url_video');
        $this->form_validation->set_rules('profilepic', 'Profile Picture', 'required');
        $this->form_validation->set_rules('propcoordlat', 'Map Location', '');
        $this->form_validation->set_rules('propcoordlng', 'Map Location', '');
        $this->form_validation->set_rules('propcompletion', 'Completion', '');
        
        $tempid = date('YmdHis');
        if(isset($_POST['id'])) { 
            $tempid = $this->input->post('id');
            if($_POST['proppricerange'] == '1') {
                $this->form_validation->set_rules('proppricemax', 'Maximum Price', 'trim|required|min_length[1]|max_length[12]|callback__check_amount|callback__check_prices');
            } else {
                $this->form_validation->set_rules('proppricemax', 'Maximum Price', 'trim|max_length[12]|callback__check_amount');
            }
            $this->form_validation->set_rules('proproommin', 'Minimum Number of Rooms', '');
            $this->form_validation->set_rules('proproommax', 'Maximum Number of Rooms', '');
            if($_POST['proproomrange'] == '1') {
                //Only when there's at least 1 field with value, require both fields
                if( trim($_POST['proproommin']) !== '' || trim($_POST['proproommax']) !== '' ) {
                    $this->form_validation->set_rules('proproommin', 'Minimum Number of Rooms', 'trim|required');
                    $this->form_validation->set_rules('proproommax', 'Maximum Number of Rooms', 'trim|required|max_length[2]|is_natural_no_zero|callback__check_rooms');
                }
            }
            $this->form_validation->set_rules('proptoiletmin', 'Minimum Number of Toilets', '');
            $this->form_validation->set_rules('proptoiletmax', 'Maximum Number of Toilets', '');
            if($_POST['proptoiletrange'] == '1') {
                //Only when there's at least 1 field with value, require both fields
                if( trim($_POST['proptoiletmin']) !== '' || trim($_POST['proptoiletmax']) !== '' ) {
                    $this->form_validation->set_rules('proptoiletmin', 'Minimum Number of Toilets', 'trim|required');
                    $this->form_validation->set_rules('proptoiletmax', 'Maximum Number of Toilets', 'trim|required|max_length[2]|is_natural_no_zero|callback__check_toilets');
                }
            }
            $this->form_validation->set_rules('propareamin', 'Minimum Area', 'trim|max_length[12]|callback__check_amount');
            $this->form_validation->set_rules('propareamax', 'Maximum Area', 'trim|max_length[12]|callback__check_amount');
            $this->form_validation->set_rules('propareaunit', 'Area Unit', '');
            if($_POST['proparearange'] == '1') {
                //Only when there's at least 1 field with value, require both fields
                if( trim($_POST['propareamin']) !== '' || trim($_POST['propareamax']) !== '' ) {
                    $this->form_validation->set_rules('propareamin', 'Minimum Area', 'trim|required|callback__check_amount');
                    $this->form_validation->set_rules('propareamax', 'Maximum Area', 'trim|required|max_length[12]|callback__check_amount|callback__check_areas');
                }
            }
            if( trim($_POST['propareamin']) !== '' xor trim($_POST['propareamax']) !== '' ) {
                $this->form_validation->set_rules('propareaunit', 'Area Unit', 'required');
            }
            $this->form_validation->set_rules('propgaragemin', 'Minimum Number of Garage', '');
            $this->form_validation->set_rules('propgaragemax', 'Maximum Number of Garage', '');
            if($_POST['propgaragerange'] == '1') {
                //Only when there's at least 1 field with value, require both fields
                if( trim($_POST['propgaragemin']) !== '' || trim($_POST['propgaragemax']) !== '' ) {
                    $this->form_validation->set_rules('propgaragemin', 'Minimum Number of Garage', 'trim|required');
                    $this->form_validation->set_rules('propgaragemax', 'Maximum Number of Garage', 'trim|required|max_length[2]|is_natural_no_zero|callback__check_garages');
                }
            }
            //If Completion Month is set, require the Completion Year
            if(!empty($_POST['propcompletionmo'])) {
                $this->form_validation->set_rules('propcompletionyr', 'Completion Year', 'trim|required');
            } else {
                $this->form_validation->set_rules('propcompletionyr', 'Completion Year', 'trim');
            }
            //If Tenure (Freehold/Leasehold) is selected, require the Tenure Years
            $proptenure = ( is_array($this->input->post('proptenure')) ? array_flip($this->input->post('proptenure')) : '' );
            if( isset($proptenure[TENURE_FREEHOLD]) || isset($proptenure[TENURE_LEASEHOLD]) ) {
                $this->form_validation->set_rules('proptenureyears', 'Tenure Years', 'trim|required|max_length[3]|numeric');
            }
        }
        
        if($this->form_validation->run() !== FALSE) {
            $companyname = $this->input->post('propdeveloper');
            $usercode = $this->tank_auth->get_user_code();
            $propname = $this->input->post('propname');
            $profilepic = $this->input->post('profilepic');
            
            $this->load->library('image_lib');
            $img_size = getimagesize( dirname($_SERVER['SCRIPT_FILENAME']) . '/photos/' . $tempid . '/' . $profilepic);
            $orig_width = $img_size[0];
            $orig_height = $img_size[1];
            $newwidth = $orig_width;
            $newheight = $orig_height;

            if($orig_width > PROPPROFILEPIC_MAXWIDTH) {
                $newwidth = PROPPROFILEPIC_MAXWIDTH;
                $newheight = ($orig_height * (PROPPROFILEPIC_MAXWIDTH/$orig_width));
            }

            if($newheight > PROPPROFILEPIC_MAXHEIGHT) {
                $newwidth = ($newwidth * (PROPPROFILEPIC_MAXHEIGHT/$newheight));
                $newheight = PROPPROFILEPIC_MAXHEIGHT;
            }
            
            $category = $this->input->post('proptype');
            $category = substr($category, 0, 1);
            
            $pricemin = convert_amount( $this->input->post('proppricemin') );
            $pricemin = str_replace(',', '', $pricemin);
            $pricemax = $this->input->post('proppricemax');
            $pricemax = ( !empty($pricemax) ? convert_amount($pricemax) : $pricemax );
            $pricemax = str_replace(',', '', $pricemax);
                
            $propareamin = $this->input->post('propareamin');
            $propareamin = ( !empty($propareamin) ? convert_amount($propareamin) : $propareamin );
            $propareamin = str_replace(',', '', $propareamin);
                
            $propareamax = $this->input->post('propareamax');
            $propareamax = ( !empty($propareamax) ? convert_amount($propareamax) : $propareamax );
            $propareamax = str_replace(',', '', $propareamax);
            
            $record_infos = array('name' => $propname,
                          'profilepic' => $profilepic,
                          'profilepicwidth' => $newwidth,
                          'profilepicheight' => $newheight,
                          'posting' => implode('', $this->input->post('proppost')),
                          'category' => $category,
                          'subcategory' => $this->input->post('proptype'),
                          'classification' => $this->input->post('propclass'),
                          'opricemin' => $this->input->post('proppricemin'),
                          'opricemax' => $this->input->post('proppricemax'),
                          'pricemin' => $pricemin,
                          'pricemax' => $pricemax,
                          'priceunit' => $this->input->post('proppriceunit'),
                          'companycode' => $this->input->post('propdeveloperid'),
                          'ownercode' => $usercode,
                          'country' => $this->input->post('proploccountry'),
                          'city' => $this->input->post('proploccity'),
                          'address' => $this->input->post('propaddress'),
                          'roomsmin' => $this->input->post('proproommin'),
                          'roomsmax' => $this->input->post('proproommax'),
                          'toiletmin' => $this->input->post('proptoiletmin'),
                          'toiletmax' => $this->input->post('proptoiletmax'),
                          'garagemin' => $this->input->post('propgaragemin'),
                          'garagemax' => $this->input->post('propgaragemax'),
                          'oareamin' => $this->input->post('propareamin'),
                          'oareamax' => $this->input->post('propareamax'),
                          'areamin' => $propareamin,
                          'areamax' => $propareamax,
                          'areaunit' => $this->input->post('propareaunit'),
                          'coordlat' => $this->input->post('propcoordlat'),
                          'coordlong' => $this->input->post('propcoordlng') );

            switch($category) {
                case PROPCATEGORY_COMMERCIAL: //2
                    $propfurnish = $this->input->post('propfurnish2');
                    $propfeats = $this->input->post('propfeatures2');
                    $propfacilities = $this->input->post('propfacilities2');
                    break;
                case PROPCATEGORY_LAND: //3
                    $propfurnish = $this->input->post('propfurnish3');
                    $propfeats = $this->input->post('propfeatures3');
                    $propfacilities = $this->input->post('propfacilities3');
                    break;
                case PROPCATEGORY_HOTEL: //4
                    $propfurnish = $this->input->post('propfurnish4');
                    $propfeats = $this->input->post('propfeatures4');
                    $propfacilities = $this->input->post('propfacilities4');
                    break;
                default: //1
                    $propfurnish = $this->input->post('propfurnish1');
                    $propfeats = $this->input->post('propfeatures1');
                    $propfacilities = $this->input->post('propfacilities1');
                    break;
            }
            $video = $this->input->post('propvideo');
            if(!empty($video)) {
                $pattern1 = "/(?:(?:http|https):\/\/)?(((?:www\.)?youtube\.com\/watch\?v=(?:[a-zA-Z0-9\-_]{11,11}))|((?:www\.)?youtube\.com\/embed\/?(?:[a-zA-Z0-9\-_]{11,11})))/i";
                $pattern2 = "/(?:(?:http|https):\/\/)?(((?:www\.)?vimeo\.com\/?(?:[0-9]{8,8}))|(?:player\.vimeo\.com\/?(?:video\/(?:[0-9]{8,8}))))/i";
                if( preg_match($pattern1, $video, $matches) === 1 ) {
                    $video = $matches[0];
                    $video = str_replace('watch?v=', 'embed/', $video);
                } elseif( preg_match($pattern2, $video, $matches) === 1 ) {
                    $video = $matches[0];
                    $video = str_replace('http://vimeo.com', 'http://player.vimeo.com', $video);
                    if( substr_count($video, 'video') <= 0 ) {
                        $video = str_replace('http://player.vimeo.com', 'http://player.vimeo.com/video', $video);
                    }
                }
            }
            
            $pricenegotiable = $this->input->post('propnegotiable');
            $pricenegotiable = ( !empty($pricenegotiable) ? implode('', $pricenegotiable) : '' );
            $proptenure = $this->input->post('proptenure');
            $proptenure = ( !empty($proptenure) ? implode('', $proptenure) : '' );
            $propforeclosure = $this->input->post('propforeclosure');
            $propforeclosure = ( !empty($propforeclosure) ? implode('', $propforeclosure) : '' );
            $propresale = $this->input->post('propresale');
            $propresale = ( !empty($propresale) ? implode('', $propresale) : '' );
            $propoccupancy = $this->input->post('propoccupancy');
            $propoccupancy = ( !empty($propoccupancy) ? implode('', $propoccupancy) : '' );
            $propfinance = $this->input->post('propfinance');
            $propfinance = ( !empty($propfinance) ? implode('', $propfinance) : '' );
            $propfurnished = $this->input->post('propfurnished');
            $propfurnished = ( !empty($propfurnished) ? implode('', $propfurnished) : '' );
            $propfurnished = $this->input->post('propfurnished');
            $propfurnished = ( !empty($propfurnished) ? implode('', $propfurnished) : '' );
            $record_descs = array(
                          'pricereserve' => $this->input->post('propreserve'),
                          'pricedown' => $this->input->post('propdown'),
                          'pricediscount' => $this->input->post('propdiscount'),
                          'postalcode' => $this->input->post('proppostal'),
                          'pricenegotiable' => $pricenegotiable,
                          'tenure' => $proptenure,
                          'tenureyr' => $this->input->post('proptenureyears'),
                          'construction' => $this->input->post('propconstruction'),
                          'completionmo' => $this->input->post('propcompletionmo'),
                          'completionyr' => $this->input->post('propcompletionyr'),
                          'floorsnum' => $this->input->post('propfloornum'),
                          'unitsnum' => $this->input->post('propunitnum'),
                          'foreclosure' => $propforeclosure,
                          'resale' => $propresale,
                          'occupancy' => $propoccupancy,
                          'paymentscheme' => $this->input->post('propscheme'),
                          'financing' => $propfinance,
                          'description' => $this->input->post('propdesc'),
                          'furnished' => $propfurnished,
                          'furnishings' => ( is_array($propfurnish) ? implode(',', $propfurnish) : '' ),
                          'features' => ( is_array($propfeats) ? implode(',', $propfeats) : '' ),
                          'facilities' => ( is_array($propfacilities) ? implode(',', $propfacilities) : '' ),
                          'video' => $video,
                          'postcompletion' => $this->input->post('propcompletion'),
                          'datecreated' => date('Y-m-d H:i:s'),
                          'datelastmodified' => date('Y-m-d H:i:s'));
            
            if($_POST['pub'] == '1') {
                $record_infos['recstatus'] = PROPSTATUS_ACTIVE;
                $record_infos['datepublished'] = date('Y-m-d H:i:s');
            }
            
            if(empty($propcode)) {
                $result = $this->prop->create($record_infos, $record_descs, $usercode, $companyname);
            } else {
                $result = $this->prop->update($record_infos, $record_descs, $propcode, $companyname);
            
                $this->load->model('Users_Model', 'user');
                if($_POST['pub'] == '1') {
                    $result2 = $this->user->update_numproperties($usercode);
                }
            }
            
            if($result) {
                $propcode = $result['code'];
                $data['tempid'] = $propcode;
                
                $this->session->set_flashdata('message_property_status', 'success');
                if($_POST['pub'] == '1') {
                    $msg = $this->lang->line('success_property_publish') . '<br/>Check it out <a href="' . site_url('property/' . url_title($propname) . '/' . $propcode) . '">here</a>!';
                    $this->session->set_flashdata('message_property', $msg);
                } else {
                    if($tempid != $propcode) {
                        //Rename the photos folder
                        rename('./photos/' . $tempid, './photos/' . $propcode);

                        $this->session->set_flashdata('message_property', $this->lang->line('success_property_new'));
                    } else {
                        $this->session->set_flashdata('message_property', $this->lang->line('success_property_update'));
                    }   
                }
            } else {
                $this->session->set_flashdata('message_property_status', 'error');
                $this->session->set_flashdata('message_property', $this->lang->line('error_property_update'));
            }
            redirect('property/post/' . url_title($propname) . '/' . url_title($propcode));
        }   

        $developerid = '';
        $developername = '';
        if( $this->tank_auth->get_usertype() == USERTYPE_COMPANY ) {
            $developerid = $usercode;
            $developername = $this->tank_auth->get_userfullname();
        }
        
        include('ip2locationlite.class.php');
        $ipLite = new ip2location_lite;
        $ip = $this->input->ip_address();
        $location = $ipLite->getCountry($ip);
        $country = ( isset($location['countryCode']) ? $location['countryCode'] : '' );
        $locations = $ipLite->getCity($ip);
        
        if(isset($_POST['proploccountry'])) {
            $country = $this->input->post('proploccountry');
        }
        
        $propnegotiable = ( is_array($this->input->post('propnegotiable')) ? array_flip($this->input->post('propnegotiable')) : '' );
        $proppost = ( is_array($this->input->post('proppost')) ? array_flip($this->input->post('proppost')) : '' );
        $propfinance = ( is_array($this->input->post('propfinance')) ? array_flip($this->input->post('propfinance')) : '' );
        $proptenure = ( is_array($this->input->post('proptenure')) ? array_flip($this->input->post('proptenure')) : '' );
        $propforeclosure = ( is_array($this->input->post('propforeclosure')) ? array_flip($this->input->post('propforeclosure')) : '' );
        $propresale = ( is_array($this->input->post('propresale')) ? array_flip($this->input->post('propresale')) : '' );
        $propoccupancy = ( is_array($this->input->post('propoccupancy')) ? array_flip($this->input->post('propoccupancy')) : '' );
        $propfurnished = ( is_array($this->input->post('propfurnished')) ? array_flip($this->input->post('propfurnished')) : '' );
        $propconstruction = $this->input->post('propconstruction');
        
        $propfurnish1 = ( is_array($this->input->post('propfurnish1')) ? array_flip($this->input->post('propfurnish1')) : '' );
        $propfurnish2 = ( is_array($this->input->post('propfurnish2')) ? array_flip($this->input->post('propfurnish2')) : '' );
        $propfurnish3 = ( is_array($this->input->post('propfurnish3')) ? array_flip($this->input->post('propfurnish3')) : '' );
        $propfurnish4 = ( is_array($this->input->post('propfurnish4')) ? array_flip($this->input->post('propfurnish4')) : '' );
        $propfeatures1 = ( is_array($this->input->post('propfeatures1')) ? array_flip($this->input->post('propfeatures1')) : '' );
        $propfeatures2 = ( is_array($this->input->post('propfeatures2')) ? array_flip($this->input->post('propfeatures2')) : '' );
        $propfeatures3 = ( is_array($this->input->post('propfeatures3')) ? array_flip($this->input->post('propfeatures3')) : '' );
        $propfeatures4 = ( is_array($this->input->post('propfeatures4')) ? array_flip($this->input->post('propfeatures4')) : '' );
        $propfacilities1 = ( is_array($this->input->post('propfacilities1')) ? array_flip($this->input->post('propfacilities1')) : '' );
        $propfacilities2 = ( is_array($this->input->post('propfacilities2')) ? array_flip($this->input->post('propfacilities2')) : '' );
        $propfacilities3 = ( is_array($this->input->post('propfacilities3')) ? array_flip($this->input->post('propfacilities3')) : '' );
        $propfacilities4 = ( is_array($this->input->post('propfacilities4')) ? array_flip($this->input->post('propfacilities4')) : '' );
        
        $data = array('tempid' => $tempid,
                      'propname' => '',
                      'proppost' => $proppost,
                      'proptype' => $this->input->post('proptype'),
                      'propclass' => $this->input->post('propclass'),
                      'proppricemin' => '',
                      'proppricemax' => '',
                      'proppriceunit' => '',
                      'proppricerange' => $this->input->post('proppricerange'),
                      'propnegotiable' => $propnegotiable,
                      'propscheme' => '',
                      'propfinance' => $propfinance,
                      'propdeveloperid' => $developerid,
                      'propdeveloper' => $developername,
                      'proploccountry' => $country,
                      'proploccity' => '',
                      'propaddress' => '',
                      'proppostal' => '',
                      'propreserve' => '',
                      'propdown' => '',
                      'propdiscount' => '',
                      'proproommin' => '',
                      'proproommax' => '',
                      'proproomrange' => $this->input->post('proproomrange'),
                      'proptoiletmin' => '',
                      'proptoiletmax' => '',
                      'proptoiletrange' => $this->input->post('proptoiletrange'),
                      'propareamin' => '',
                      'propareamax' => '',
                      'propareaunit' => '',
                      'proparearange' => $this->input->post('proparearange'),
                      'propgaragemin' => '',
                      'propgaragemax' => '',
                      'propgaragerange' => $this->input->post('propgaragerange'),
                      'propdesc' => '',
                      'proptenure' => $proptenure,
                      'proptenureyears' => '',
                      'propconstruction' => ( empty($propconstruction) ? '-5' : $propconstruction ),
                      'propcompletionmo' => $this->input->post('propcompletionmo'),
                      'propcompletionyr' => $this->input->post('propcompletionyr'),
                      'propfloornum' => '',
                      'propunitnum' => '',
                      'propforeclosure' => $propforeclosure,
                      'propresale' => $propresale,
                      'propoccupancy' => $propoccupancy,
                      'propfurnished' => $propfurnished,
                      'propfurnish1' => $propfurnish1,
                      'propfurnish2' => $propfurnish2,
                      'propfurnish3' => $propfurnish3,
                      'propfurnish4' => $propfurnish4,
                      'propfeatures1' => $propfeatures1,
                      'propfeatures2' => $propfeatures2,
                      'propfeatures3' => $propfeatures3,
                      'propfeatures4' => $propfeatures4,
                      'propfacilities1' => $propfacilities1,
                      'propfacilities2' => $propfacilities2,
                      'propfacilities3' => $propfacilities3,
                      'propfacilities4' => $propfacilities4,
                      'propvideo' => '',
                      'profilepic' => $this->input->post('profilepic'),
                      'propcoordlat' => $this->input->post('propcoordlat'),
                      'propcoordlng' => $this->input->post('propcoordlng'),
                      'propcompletion' => $this->input->post('propcompletion'),
                      'proprecstatus' => '');
        $data['propcompletion'] = ( empty($data['propcompletion']) ? 0 : $data['propcompletion'] );
        
        $message_property = $this->session->flashdata('message_property');
        $message_property_status = $this->session->flashdata('message_property_status');
        
        if( ! isset($_POST['id'])) { 
            $proprow = $this->prop->get_property_by_code($propcode);
            
            if($proprow) {
                $posting = str_split($proprow->posting);
                $posting = ( is_array($posting) ? array_flip($posting) : '' );
                $financing = str_split($proprow->financing);
                $financing = ( is_array($financing) ? array_flip($financing) : '' );
                $furnishings = explode(',', $proprow->furnishings);
                $furnishings = ( is_array($furnishings) ? array_flip($furnishings) : '' );
                $features = explode(',', $proprow->features);
                $features = ( is_array($features) ? array_flip($features) : '' );
                $facilities = explode(',', $proprow->facilities);
                $facilities = ( is_array($facilities) ? array_flip($facilities) : '' );
                $propfurnish1 = array();
                $propfurnish2 = array();
                $propfurnish3 = array();
                $propfurnish4 = array();
                $propfeats1 = array();
                $propfeats2 = array();
                $propfeats3 = array();
                $propfeats4 = array();
                $propfacilities1 = array();
                $propfacilities2 = array();
                $propfacilities3 = array();
                $propfacilities4 = array();
                switch($proprow->category) {
                    case PROPCATEGORY_LAND: //3
                        $propfurnish3 = $furnishings;
                        $propfeats3 = $features;
                        $propfacilities3 = $facilities;
                        break;
                    case PROPCATEGORY_COMMERCIAL: //2
                        $propfurnish2 = $furnishings;
                        $propfeats2 = $features;
                        $propfacilities2 = $facilities;
                        break;
                    case PROPCATEGORY_HOTEL: //4
                        $propfurnish4 = $furnishings;
                        $propfeats4 = $features;
                        $propfacilities4 = $facilities;
                        break;
                    default: //1
                        $propfurnish1 = $furnishings;
                        $propfeats1 = $features;
                        $propfacilities1 = $facilities;
                        break;
                }
                $propnegotiable = ( !empty($proprow->pricenegotiable) ? array(0 => $proprow->pricenegotiable) : '' );
                $propnegotiable = ( is_array($propnegotiable) ? array_flip($propnegotiable) : '' );
                $proptenure = ( !empty($proprow->tenure) ? array(0 => $proprow->tenure) : '' );
                $proptenure = ( is_array($proptenure) ? array_flip($proptenure) : '' );
                $propforeclosure = ( !empty($proprow->foreclosure) ? array(0 => $proprow->foreclosure) : '' );
                $propforeclosure = ( is_array($propforeclosure) ? array_flip($propforeclosure) : '' );
                $propresale = ( !empty($proprow->resale) ? array(0 => $proprow->resale) : '' );
                $propresale = ( is_array($propresale) ? array_flip($propresale) : '' );
                $propoccupancy = ( !empty($proprow->occupancy) ? array(0 => $proprow->occupancy) : '' );
                $propoccupancy = ( is_array($propoccupancy) ? array_flip($propoccupancy) : '' );
                $propfurnished = ( !empty($proprow->furnished) ? array(0 => $proprow->furnished) : '' );
                $propfurnished = ( is_array($propfurnished) ? array_flip($propfurnished) : '' );
                $data = array('tempid' => $propcode,
                              'propname' => $proprow->name,
                              'proppost' => $posting,
                              'proptype' => $proprow->subcategory,
                              'propclass' => $proprow->classification,
                              'proppricemin' => $proprow->opricemin,
                              'proppricemax' => $proprow->opricemax,
                              'proppriceunit' => $proprow->priceunit,
                              'proppricerange' => ( !empty($proprow->pricemax) ? '1' : '' ),
                              'propnegotiable' => $propnegotiable,
                              'propscheme' => $proprow->paymentscheme,
                              'propfinance' => $financing,
                              'propdeveloperid' => $proprow->companycode,
                              'propdeveloper' => $proprow->companyname,
                              'proploccountry' => $proprow->country,
                              'proploccity' => $proprow->city,
                              'propaddress' => $proprow->address,
                              'proppostal' => $proprow->postalcode,
                              'propreserve' => $proprow->pricereserve,
                              'propdown' => $proprow->pricedown,
                              'propdiscount' => $proprow->pricediscount,
                              'proproommin' => $proprow->roomsmin,
                              'proproommax' => $proprow->roomsmax,
                              'proproomrange' => ( !empty($proprow->roomsmax) ? '1' : '' ),
                              'proptoiletmin' => $proprow->toiletmin,
                              'proptoiletmax' => $proprow->toiletmax,
                              'proptoiletrange' => ( !empty($proprow->toiletmax) ? '1' : '' ),
                              'propareamin' => $proprow->oareamin,
                              'propareamax' => $proprow->oareamax,
                              'propareaunit' => $proprow->areaunit,
                              'proparearange' => ( !empty($proprow->areamax) ? '1' : '' ),
                              'propgaragemin' => $proprow->garagemin,
                              'propgaragemax' => $proprow->garagemax,
                              'propgaragerange' => ( !empty($proprow->garagemax) ? '1' : '' ),
                              'propdesc' => $proprow->description,
                              'proptenure' => $proptenure,
                              'proptenureyears' => $proprow->tenureyr,
                              'propconstruction' => $proprow->construction,
                              'propcompletionmo' => $proprow->completionmo,
                              'propcompletionyr' => $proprow->completionyr,
                              'propfloornum' => $proprow->floorsnum,
                              'propunitnum' => $proprow->unitsnum,
                              'propforeclosure' => $propforeclosure,
                              'propresale' => $propresale,
                              'propoccupancy' => $propoccupancy,
                              'propfurnished' => $propfurnished,
                              'propfurnish1' => $propfurnish1,
                              'propfurnish2' => $propfurnish2,
                              'propfurnish3' => $propfurnish3,
                              'propfurnish4' => $propfurnish4,
                              'propfeatures1' => $propfeats1,
                              'propfeatures2' => $propfeats2,
                              'propfeatures3' => $propfeats3,
                              'propfeatures4' => $propfeats4,
                              'propfacilities1' => $propfacilities1,
                              'propfacilities2' => $propfacilities2,
                              'propfacilities3' => $propfacilities3,
                              'propfacilities4' => $propfacilities4,
                              'propvideo' => $proprow->video,
                              'profilepic' => $proprow->profilepic,
                              'propcoordlat' => $proprow->coordlat,
                              'propcoordlng' => $proprow->coordlong,
                              'propcompletion' => $proprow->postcompletion,
                              'proprecstatus' => $proprow->recstatus);
                
                if($proprow->recstatus == PROPSTATUS_DRAFT && $message_property_status == 'success') {
                    $message_property .= $this->lang->line('success_property_not_published');
                }
            }
        }
        
        if( ( empty($data['propcoordlat']) || empty($data['propcoordlng']) ) &&
            ( !empty($locations) && is_array($locations) ) ) {
            $data['propcoordlat'] = $locations['latitude'];
            $data['propcoordlng'] = $locations['longitude'];
        }
        
        $display_tenuresale = 'display:block;';
        $display_tenurerent = 'display:none;';
        $display_tenureyears = 'display:block;';
        $display_tenurelabel = '';
        if( !isset($data['proppost'][PROPPOST_SALE]) &&
            ( isset($data['proppost'][PROPPOST_RENT]) || isset($data['proppost'][PROPPOST_OWN]) ) ) {
            $display_tenuresale = 'display:none;';
            $display_tenurerent = 'display:block;';
            $display_tenureyears = 'display:none;';   
        } else {
            if(isset($data['proptenure'][TENURE_FREEHOLD])) {
                $display_tenurelabel = '-Freehold';
            } elseif(isset($data['proptenure'][TENURE_LEASEHOLD])) {
                $display_tenurelabel = '-Leasehold';
            }
        }
        $data['display_tenuresale'] = $display_tenuresale;
        $data['display_tenurerent'] = $display_tenurerent;
        $data['display_tenureyears'] = $display_tenureyears;
        $data['display_tenurelabel'] = $display_tenurelabel;
        
        switch($data['proptype']) {
            case PROPSUBCATEGORY_C_OFFICE:
            case PROPSUBCATEGORY_C_SOHO:
            case PROPSUBCATEGORY_C_RETAIL:
            case PROPSUBCATEGORY_C_INDUSTRIAL:
                $propcategory = PROPCATEGORY_COMMERCIAL;
                $display_furnishingsmenu = 'display:block;';
                $display_featuresmenu = 'display:block;';
                $display_facilitiesmenu = 'display:block;';
                $display_furnishingsall = 'display:block;';
                $display_featuresall = 'display:block;';
                $display_facilitiesall = 'display:block;';
                $display_furnishings1 = 'display:none;';
                $display_furnishings2 = 'display:block;';
                $display_furnishings3 = 'display:none;';
                $display_furnishings4 = 'display:none;';
                $display_features1 = 'display:none;';
                $display_features2 = 'display:block;';
                $display_features3 = 'display:none;';
                $display_features4 = 'display:none;';
                $display_facilities1 = 'display:none;';
                $display_facilities2 = 'display:block;';
                $display_facilities3 = 'display:none;';
                $display_facilities4 = 'display:none;';
                $display_rooms = 'display:block;';
                $display_toilets = 'display:block;';
                $display_garages = 'display:block;';
                $display_garagelabel = 'Parking';
                $display_construction = 'display:block;';
                if($data['propconstruction'] != 100) {
                    $display_completion = 'display:block;';
                } else {
                    $display_completion = 'display:none;';
                }
                $display_floornum = 'display:block;';
                $display_unitnum = 'display:block;';
                $display_occupancy = 'display:block;';
                break;
            case PROPSUBCATEGORY_L_LANDONLY:
            case PROPSUBCATEGORY_L_LANDWITHSTRUCTURE:
            case PROPSUBCATEGORY_L_FARM:
            case PROPSUBCATEGORY_L_BEACH:
                $propcategory = PROPCATEGORY_LAND;
                $display_furnishingsmenu = 'display:none;';
                $display_featuresmenu = 'display:block;';
                $display_facilitiesmenu = 'display:none;';
                $display_furnishingsall = 'display:none;';
                $display_featuresall = 'display:block;';
                $display_facilitiesall = 'display:none;';
                $display_furnishings1 = 'display:none;';
                $display_furnishings2 = 'display:none;';
                $display_furnishings3 = 'display:none;';
                $display_furnishings4 = 'display:none;';
                $display_features1 = 'display:none;';
                $display_features2 = 'display:none;';
                $display_features3 = 'display:block;';
                $display_features4 = 'display:none;';
                $display_facilities1 = 'display:none;';
                $display_facilities2 = 'display:none;';
                $display_facilities3 = 'display:none;';
                $display_facilities4 = 'display:none;';
                $display_rooms = 'display:none;';
                $display_toilets = 'display:none;';
                $display_garages = 'display:none;';
                $display_garagelabel = 'Garage';
                $display_construction = 'display:none;';
                $display_completion = 'display:none;';
                $display_floornum = 'display:none;';
                $display_unitnum = 'display:block;';
                $display_occupancy = 'display:none;';
                break;
            case PROPSUBCATEGORY_H_HOTELRESORT:
            case PROPSUBCATEGORY_H_PENSIONINN:
            case PROPSUBCATEGORY_H_CONVENTIONCENTER:
                $propcategory = PROPCATEGORY_HOTEL;
                $display_furnishingsmenu = 'display:block;';
                $display_featuresmenu = 'display:block;';
                $display_facilitiesmenu = 'display:block;';
                $display_furnishingsall = 'display:block;';
                $display_featuresall = 'display:block;';
                $display_facilitiesall = 'display:block;';
                $display_furnishings1 = 'display:none;';
                $display_furnishings2 = 'display:none;';
                $display_furnishings3 = 'display:none;';
                $display_furnishings4 = 'display:block;';
                $display_features1 = 'display:none;';
                $display_features2 = 'display:none;';
                $display_features3 = 'display:none;';
                $display_features4 = 'display:block;';
                $display_facilities1 = 'display:none;';
                $display_facilities2 = 'display:none;';
                $display_facilities3 = 'display:none;';
                $display_facilities4 = 'display:block;';
                $display_rooms = 'display:block;';
                $display_toilets = 'display:none;';
                $display_garages = 'display:none;';
                $display_garagelabel = 'Garage';
                $display_construction = 'display:block;';
                if($data['propconstruction'] != 100) {
                    $display_completion = 'display:block;';
                } else {
                    $display_completion = 'display:none;';
                }
                $display_floornum = 'display:block;';
                $display_unitnum = 'display:block;';
                $display_occupancy = 'display:block;';
                break;
            default:
                $propcategory = PROPCATEGORY_RESIDENTIAL;
                $display_furnishingsmenu = 'display:block;';
                $display_featuresmenu = 'display:block;';
                $display_facilitiesmenu = 'display:block;';
                $display_furnishingsall = 'display:block;';
                $display_featuresall = 'display:block;';
                $display_facilitiesall = 'display:block;';
                $display_furnishings1 = 'display:block;';
                $display_furnishings2 = 'display:none;';
                $display_furnishings3 = 'display:none;';
                $display_furnishings4 = 'display:none;';
                $display_features1 = 'display:block;';
                $display_features2 = 'display:none;';
                $display_features3 = 'display:none;';
                $display_features4 = 'display:none;';
                $display_facilities1 = 'display:block;';
                $display_facilities2 = 'display:none;';
                $display_facilities3 = 'display:none;';
                $display_facilities4 = 'display:none;';
                $display_rooms = 'display:block;';
                $display_toilets = 'display:block;';
                $display_garages = 'display:block;';
                $display_garagelabel = 'Garage';
                $display_construction = 'display:block;';
                if($data['propconstruction'] != 100) {
                    $display_completion = 'display:block;';
                } else {
                    $display_completion = 'display:none;';
                }
                $display_floornum = 'display:block;';
                $display_unitnum = 'display:block;';
                $display_occupancy = 'display:block;';
        }
        $data['propcategory'] = $propcategory;
        $data['display_furnishingsmenu'] = $display_furnishingsmenu;
        $data['display_featuresmenu'] = $display_featuresmenu;
        $data['display_facilitiesmenu'] = $display_facilitiesmenu;
        $data['display_furnishingsall'] = $display_furnishingsall;
        $data['display_featuresall'] = $display_featuresall;
        $data['display_facilitiesall'] = $display_facilitiesall;
        $data['display_furnishings1'] = $display_furnishings1;
        $data['display_furnishings2'] = $display_furnishings2;
        $data['display_furnishings3'] = $display_furnishings3;
        $data['display_furnishings4'] = $display_furnishings4;
        $data['display_features1'] = $display_features1;
        $data['display_features2'] = $display_features2;
        $data['display_features3'] = $display_features3;
        $data['display_features4'] = $display_features4;
        $data['display_facilities1'] = $display_facilities1;
        $data['display_facilities2'] = $display_facilities2;
        $data['display_facilities3'] = $display_facilities3;
        $data['display_facilities4'] = $display_facilities4;
        $data['display_rooms'] = $display_rooms;
        $data['display_toilets'] = $display_toilets;
        $data['display_garages'] = $display_garages;
        $data['display_garagelabel'] = $display_garagelabel;
        $data['display_construction'] = $display_construction;
        $data['display_completion'] = $display_completion;
        $data['display_floornum'] = $display_floornum;
        $data['display_unitnum'] = $display_unitnum;
        $data['display_occupancy'] = $display_occupancy;
        if( ( isset($proppost['S']) && isset($proppost['R']) ) || isset($proppost['O']) ) {
            $display_pricelabel = 'Price/Rental';
        } elseif(isset($proppost['R'])) {
            $display_pricelabel = 'Rental';
        } else {
            $display_pricelabel = 'Price';
        }
        $data['display_pricelabel'] = $display_pricelabel . REQUIRED_INPUT;
        if($data['propcompletion'] > 80) {
            $color_propcompletion = '#62C462';
        } elseif($data['propcompletion'] > 50 && $data['propcompletion'] <= 80) {
            $color_propcompletion = '#FBB450';
        } else {
            $color_propcompletion = '#EE5F5B';
        }
        $data['color_propcompletion'] = $color_propcompletion;

        $data['classifications'] = $this->_get_property_classifications();
        $data['countries'] = $this->config->item('countries');
        $data['currencies'] = $this->config->item('currencies');
        
        $data['furnishings_residentials'] = $this->config->item('furnishings_residentials');
        $data['furnishings_commercials'] = $this->config->item('furnishings_commercials');
        $data['furnishings_lands'] = $this->config->item('furnishings_lands');
        $data['furnishings_hotels'] = $this->config->item('furnishings_hotels');
        
        $data['features_residentials'] = $this->config->item('features_residentials');
        $data['features_commercials'] = $this->config->item('features_commercials');
        $data['features_lands'] = $this->config->item('features_lands');
        $data['features_hotels'] = $this->config->item('features_hotels');
        
        $data['facilities_residentials'] = $this->config->item('facilities_residentials');
        $data['facilities_commercials'] = $this->config->item('facilities_commercials');
        $data['facilities_lands'] = $this->config->item('facilities_lands');
        $data['facilities_hotels'] = $this->config->item('facilities_hotels');
        
        $data['message_status'] = $message_property_status;
        $data['message'] = $message_property;
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'form', $data);
        $this->load->view('footer', $datafoot);
    }
    
    public function post_map() {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->load->library('MY_Form_validation');
        $this->form_validation->set_error_delimiters(ERROR_DELIMITER_OPEN, ERROR_DELIMITER_CLOSE);
        $this->form_validation->set_rules('propcoordlat', 'Map Location', '');
        $this->form_validation->set_rules('propcoordlng', 'Map Location', '');
        
        $data = array('propcoordlat' => '',
                      'propcoordlng' => '');
        if( isset($_POST['propcoordlat']) && isset($_POST['propcoordlng']) ) {
            $data = array('propcoordlat' => $_POST['propcoordlat'],
                          'propcoordlng' => $_POST['propcoordlng']);
        }
        $this->load->view($this->folder . 'form_map', $data);
    }
    
    private function _get_property_classifications() {
        $rc = array(PROPCLASS_R_CONDOMINIUM => 'Condominium',
                    PROPCLASS_R_CONDOMINIUMHOTEL => 'Condominium-Hotel',
                    PROPCLASS_R_PENTHOUSE => 'Penthouse');
        $rhl = array(PROPCLASS_R_DETACHEDSINGLE => 'Single Storey / Detached',
                    PROPCLASS_R_DETACHEDMULTI => 'Multi-Storey / Detached',
                    PROPCLASS_R_DUPLEX => 'Duplex / Semi-attached',
                    PROPCLASS_R_TOWNHOUSE => 'Townhouse / Attached',
                    PROPCLASS_R_MANSIONETTE => 'Mansionette',
                    PROPCLASS_R_MANSION => 'Mansion');
        $ra = array(PROPCLASS_R_APARTMENT => 'Apartment');
        $rh = array(PROPCLASS_R_HDB => 'HDB');
        $rbh = array(PROPCLASS_R_BACHELORSPAD => 'Bachelor\'s Pad',
                    PROPCLASS_R_ROOM => 'Room',
                    PROPCLASS_R_BED => 'Bed');
        $co = array(PROPCLASS_C_OFFICE => 'Office',
                    PROPCLASS_C_BUSINESSPARK => 'Business Park');
        $csh = array(PROPCLASS_C_SOHO => 'SOHO');
        $cr = array(PROPCLASS_C_MALL => 'Mall',
                    PROPCLASS_C_SHOP => 'Shop',
                    PROPCLASS_C_OTHER => 'Other');
        $ci = array(PROPCLASS_C_FACTORY => 'Factory',
                    PROPCLASS_C_WAREHOUSE => 'Warehouse');
        $llo = array(PROPCLASS_L_LANDONLY => 'Land only');
        $lls = array(PROPCLASS_L_LANDWITHSTRUCTURE => 'Land with structure');
        $lf = array(PROPCLASS_L_FARM => 'Farm');
        $lb = array(PROPCLASS_L_BEACH => 'Beach');
        $hhr = array(PROPCLASS_H_HOTEL => 'Hotel',
                    PROPCLASS_H_HOTELANDRESORT => 'Hotel and Resort',
                    PROPCLASS_H_RESORT => 'Resort');
        $hpi = array(PROPCLASS_H_BACKPACKER => 'Back-packer',
                    PROPCLASS_H_PENSIONINN => 'Pension Inn');
        $hcc = array(PROPCLASS_H_CONVENTIONCENTER => 'Convention Center');
        return  array(
                    PROPSUBCATEGORY_R_CONDOMINIUM => $rc,
                    PROPSUBCATEGORY_R_HOUSEANDLOT => $rhl,
                    PROPSUBCATEGORY_R_APARTMENT => $ra,
                    PROPSUBCATEGORY_R_HDB => $rh,
                    PROPSUBCATEGORY_R_BOARDINGHOUSE => $rbh,
                    PROPSUBCATEGORY_C_OFFICE => $co,
                    PROPSUBCATEGORY_C_SOHO => $csh,
                    PROPSUBCATEGORY_C_RETAIL => $cr,
                    PROPSUBCATEGORY_C_INDUSTRIAL => $ci,
                    PROPSUBCATEGORY_L_LANDONLY => $llo,
                    PROPSUBCATEGORY_L_LANDWITHSTRUCTURE => $lls,
                    PROPSUBCATEGORY_L_FARM => $lf,
                    PROPSUBCATEGORY_L_BEACH => $lb,
                    PROPSUBCATEGORY_H_HOTELRESORT => $hhr,
                    PROPSUBCATEGORY_H_PENSIONINN => $hpi,
                    PROPSUBCATEGORY_H_CONVENTIONCENTER => $hcc
                );
    }
    
    public function _check_prices($max) {
        $max = convert_amount($max);
        $max = str_replace(',', '', $max);
        $min = ( isset($_POST['proppricemin']) ? convert_amount($_POST['proppricemin']) : 0 );
        $min = str_replace(',', '', $min);
        if(is_numeric($max) && is_numeric($min) && $max <= $min ) {
            $this->lang->load('error', 'english');
            $this->form_validation->set_message('_check_prices', $this->lang->line('error_invalid_range') );
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function _check_rooms($str) {
        if(is_numeric($str) && isset($_POST['proproommin']) && 
                $_POST['proproommin'] != '' && $_POST['proproommin'] != 'S' &&
                $str <= $_POST['proproommin'] ) {
            $this->lang->load('error', 'english');
            $this->form_validation->set_message('_check_rooms', $this->lang->line('error_invalid_range') );
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function _check_toilets($str) {
        if(is_numeric($str) && isset($_POST['proptoiletmin']) && 
                $_POST['proptoiletmin'] != '' &&
                $str <= $_POST['proptoiletmin'] ) {
            $this->lang->load('error', 'english');
            $this->form_validation->set_message('_check_toilets', $this->lang->line('error_invalid_range') );
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function _check_areas($max) {
        $max = convert_amount($max);
        $max = str_replace(',', '', $max);
        $min = ( isset($_POST['propareamin']) ? convert_amount($_POST['propareamin']) : 0 );
        $min = str_replace(',', '', $min);
        if(is_numeric($max) && is_numeric($min) && $max <= $min ) {
            $this->lang->load('error', 'english');
            $this->form_validation->set_message('_check_areas', $this->lang->line('error_invalid_range') );
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function _check_garages($str) {
        if(is_numeric($str) && isset($_POST['propgaragemin']) && 
                $_POST['propgaragemin'] != '' &&
                $str <= $_POST['propgaragemin'] ) {
            $this->lang->load('error', 'english');
            $this->form_validation->set_message('_check_garages', $this->lang->line('error_invalid_range') );
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function _check_amount($str) {
        if(!empty($str)) {
            $str = convert_amount($str);
            $str = str_replace(',', '', $str);
            if( ! is_numeric($str)) {
                $this->lang->load('error', 'english');
                $this->form_validation->set_message('_check_amount', $this->lang->line('error_invalid_value') );
                return FALSE;
            } else {
                return TRUE;
            }
        }
        return TRUE;
    }
}