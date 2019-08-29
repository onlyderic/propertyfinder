<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Map extends CI_Controller {
    
    private $folder = 'map/';
    
    public function _remap($method, $params = array()) {
        //Get properties for the map
        if( $method == 'get-properties' ) {
            $this->_get_properties();
            return true;
        }
        //Set specific location
        elseif( $method == 'location' ) {
            $location = '';
            if(count($params) == 1) {
                $location = $params[0];
            }
            $this->index($location);
            return true;
        }
        if(method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            show_404();
        }
    }
    
    function __construct() {
        parent::__construct();
        
        $this->load->model('Properties_Model', 'prop');
    }

    public function index($location = '') {
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $this->tank_auth->get_user_code();
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = 'Map' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('map' => true);
        
        include('ip2locationlite.class.php');
        $ipLite = new ip2location_lite;
        $ip = $this->input->ip_address();
        $locations = $ipLite->getCity($ip);

        $data['latitude'] = '';
        $data['longitude'] = '';
        if(!empty($locations) && is_array($locations)) {
            $data['latitude'] = $locations['latitude'];
            $data['longitude'] = $locations['longitude'];
        }
        
        //Set specific location instead of the latitude and logitude...
        if(!empty($location)) {
            $location = str_replace('-', ' ', $location);
            $data['location'] = urldecode($location);
        }
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'map', $data);
        $this->load->view('footer', $datafoot);
    }
    
    protected function _get_properties() {
        $listprops = array();
        
        if(isset($_POST['lat']) && isset($_POST['lng'])) {
            $latitude = $_POST['lat'];
            $longitude = $_POST['lng'];
                        
            $this->load->model('Properties_Model', 'prop');
            $result = $this->prop->get_map_properties($latitude, $longitude, 10, LIMIT_MAP);
            foreach($result as $rec) {
                if($rec->proptype == PROPCATEGORY_COMMERCIAL) {
                    $type = 'Commercial';
                    $icon = 'icon-commercial.png';
                } elseif($rec->proptype == PROPCATEGORY_LAND) {
                    $type = 'Land';
                    $icon = 'icon-land.png';
                } elseif($rec->proptype == PROPCATEGORY_HOTEL) {
                    $type = 'Hotel/Resort';
                    $icon = 'icon-hotel.png';
                } else {
                    $type = 'Residential';
                    $icon = 'icon-residential.png';
                }
                $record = array(
                    'propname' => $rec->name,
                    'propurl' => site_url('property/' . url_title($rec->name) . '/' . $rec->code),
                    'proptype' => $type,
                    'propicon' => $icon,
                    'clat' => $rec->clat,
                    'clng' => $rec->clng
                );
                array_push($listprops, $record);
            }
        }
        
        echo json_encode($listprops);
        
    }
}