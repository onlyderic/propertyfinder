<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Services extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    public function _remap($method, $params = array()) {
        //Property Profiler:
        //Format: URL/services/property-profile/property-name/propertyid
        if( $method == 'property-profile' &&  count($params) == 2 ) {
            $this->_property_profiler($params[1]);
            return true;
        }
        //Property Rating:
        //Format: URL/services/rate-property/property-name/propertyid
        elseif( $method == 'rate-property' &&  count($params) == 2 ) {
            $this->_property_rater($params[1]);
            return true;
        }
        //Agent Rating:
        //Format: URL/services/rate-agent/agent-name/agentid
        elseif( $method == 'rate-agent' &&  count($params) == 2 ) {
            $this->_agent_rater($params[1]);
            return true;
        }
        //Company Rating:
        //Format: URL/services/rate-company/company-name/agentid
        elseif( $method == 'rate-company' &&  count($params) == 2 ) {
            $this->_company_rater($params[1]);
            return true;
        }
        //Property Like:
        //Format: URL/services/like-property/property-name/propertyid
        elseif( $method == 'like-property' &&  count($params) == 2 ) {
            $this->_property_thumbs($params[1], 'U');
            return true;
        }
        //Property Dislike:
        //Format: URL/services/dislike-property/property-name/propertyid
        elseif( $method == 'dislike-property' &&  count($params) == 2 ) {
            $this->_property_thumbs($params[1], 'D');
            return true;
        }
        //Property Sold-Out:
        //Format: URL/services/property-sold-out/property-name/propertyid
        elseif( $method == 'property-sold-out' &&  count($params) == 2 ) {
            $this->_property_sold_out($params[1]);
            return true;
        }
        //Property Closed:
        //Format: URL/services/property-closed/property-name/propertyid
        elseif( $method == 'property-closed' &&  count($params) == 2 ) {
            $this->_property_closed($params[1]);
            return true;
        }
        //Notifications List:
        //Format: URL/services/notifications-list
        elseif( $method == 'notifications-list' ) {
            $this->_notifications_list();
            return true;
        }
        if(method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            show_404();
        }
    }

    public function index() {
        return true;
    }
    
    protected function _property_profiler($propcode = '') {
        $result = array('cmp' => '', 'sl' => '');
        if( isset($_POST['profile']) && $_POST['profile'] == 'true' && $propcode != '' ) {
            
            $usercode = $this->tank_auth->get_user_code();
        
            //Check if compared
            $this->load->model('Compares_Model', 'compare');
            if($this->compare->get($propcode, $usercode)) {
                $result['cmp'] = 'true';
            }
        
            //Check if shortlisted
            $this->load->model('Shortlists_Model', 'short');
            if($this->short->get($propcode, $usercode)) {
                $result['sl'] = 'true';
            }
            
            //Add to recent views...
            $this->load->model('RecentViews_Model', 'views');
            $this->views->create($propcode, $usercode);
            
        }
        echo json_encode($result);
    }
    
    protected function _property_rater($propcode = '') {
        $result = array('status' => 'failed', 'message' => 'Unable to process', 'newrate' => 0, 'newnumrating' => '', 'mode' => 'property');
        $isloggedin = $this->tank_auth->is_logged_in();
        if( isset($_POST['rate']) && isset($_POST['r']) && 
                is_numeric($_POST['r']) &&
                $_POST['rate'] == 'true' && 
                $propcode != '' && 
                $isloggedin ) {
            
            $usercode = $this->tank_auth->get_user_code();
            
            //Check if user exists...
            $this->load->model('Users_Model', 'user');
            if( $this->user->check_user_by_code($usercode) ) {
                //And, has not rated the property yet.    
                
                $this->load->model('PropertyRates_Model', 'rate');
                if( $this->rate->create($propcode, $usercode, $_POST['r']) ) {
                    $rating = '';
                    $numrating = '';
                    if( $row = $this->rate->get_rate($propcode) ) {
                        $rating = $row->rating;
                        $numrating = $row->numrating;
                    }
                    $result['newrate'] = $rating;
                    $result['newnumrating'] = $numrating;
                    $result['status'] = 'success';
                    $result['message'] = 'Successfully submitted your rating!';
                } else {
                    $result['status'] = 'failed';
                    $result['message'] = 'Failed to record your rating.';
                }
            } else {
                $result['status'] = 'failed';
                $result['message'] = 'Unable to find the user.';
            }
        }
        echo json_encode($result);
    }
    
    protected function _agent_rater($agentcode = '') {
        $result = array('status' => 'failed', 'message' => 'Unable to process', 'newrate' => 0, 'newnumrating' => '', 'mode' => 'agent');
        $isloggedin = $this->tank_auth->is_logged_in();
        if( isset($_POST['rate']) && isset($_POST['r']) && 
                is_numeric($_POST['r']) &&
                $_POST['rate'] == 'true' && 
                $agentcode != '' && 
                $isloggedin ) {
            
            $usercode = $this->tank_auth->get_user_code();
            
            //Check if user exists...
            $this->load->model('Users_Model', 'user');
            if( $this->user->check_user_by_code($usercode) ) {
                //And, has not rated the agent yet.    
                
                $this->load->model('UserRates_Model', 'rate');
                if( $this->rate->create($agentcode, $usercode, $_POST['r']) ) {
                    $rating = '';
                    $numrating = '';
                    if( $row = $this->rate->get_rate($agentcode) ) {
                        $rating = $row->rating;
                        $numrating = $row->numrating;
                    }
                    $result['newrate'] = $rating;
                    $result['newnumrating'] = $numrating;
                    $result['status'] = 'success';
                    $result['message'] = 'Successfully submitted your rating!';
                } else {
                    $result['status'] = 'failed';
                    $result['message'] = 'Failed to record your rating.';
                }
            } else {
                $result['status'] = 'failed';
                $result['message'] = 'Unable to find the user.';
            }
        }
        echo json_encode($result);
    }
    
    protected function _company_rater($companycode = '') {
        $result = array('status' => 'failed', 'message' => 'Unable to process', 'newrate' => 0, 'newnumrating' => '', 'mode' => 'company');
        $isloggedin = $this->tank_auth->is_logged_in();
        if( isset($_POST['rate']) && isset($_POST['r']) && 
                is_numeric($_POST['r']) &&
                $_POST['rate'] == 'true' && 
                $companycode != '' && 
                $isloggedin ) {
            
            $usercode = $this->tank_auth->get_user_code();
            
            //Check if user exists...
            $this->load->model('Users_Model', 'user');
            if( $this->user->check_user_by_code($usercode) ) {
                //And, has not rated the company yet.    
                
                $this->load->model('CompanyRates_Model', 'rate');
                if( $this->rate->create($companycode, $usercode, $_POST['r']) ) {
                    $rating = '';
                    $numrating = '';
                    if( $row = $this->rate->get_rate($companycode) ) {
                        $rating = $row->rating;
                        $numrating = $row->numrating;
                    }
                    $result['newrate'] = $rating;
                    $result['newnumrating'] = $numrating;
                    $result['status'] = 'success';
                    $result['message'] = 'Successfully submitted your rating!';
                } else {
                    $result['status'] = 'failed';
                    $result['message'] = 'Failed to record your rating.';
                }
            } else {
                $result['status'] = 'failed';
                $result['message'] = 'Unable to find the user.';
            }
        }
        echo json_encode($result);
    }
    
    protected function _property_thumbs($propcode = '', $thumbs = '') {
        $result = array('status' => 'failed', 'message' => 'Unable to process', 'thumbs' => 'up', 'likecount' => '', 'dislikecount' => '');
        $isloggedin = $this->tank_auth->is_logged_in();
        if( isset($_POST['thumbs']) && $_POST['thumbs'] == 'true' && 
                $propcode != '' && $isloggedin ) {
            
            $usercode = $this->tank_auth->get_user_code();
            
            //Check if user exists...
            $this->load->model('Users_Model', 'user');
            if( $this->user->check_user_by_code($usercode) ) {
                //And, has not liked/disliked the property yet. If so, reverse the action.    
                
                $this->load->model('PropertyLikes_Model', 'like');
                if( $this->like->create($propcode, $usercode, $thumbs) ) {
                    if( $row = $this->like->get_thumbs_count($propcode) ) {
                        $result['likecount'] = $row->numlikes;
                        $result['dislikecount'] = $row->numdislikes;
                    }
                    $result['status'] = 'success';
                    $result['message'] = 'Successfully submitted your like/dislike!';
                } else {
                    $result['status'] = 'failed';
                    $result['message'] = 'Failed to record your like/dislike.';
                }
            } else {
                $result['status'] = 'failed';
                $result['message'] = 'Unable to find the user.';
            }
        }
        echo json_encode($result);
    }
    
    protected function _property_sold_out($propcode = '') {
        $result = array('status' => 'failed', 'message' => 'Unable to process');
        $isloggedin = $this->tank_auth->is_logged_in();
        if( isset($_POST['process']) && $isloggedin && !empty($propcode) ) {
            
            //Check if property exists and user is the owner...
            $this->load->model('Properties_Model', 'prop');
            if( $proprec = $this->prop->get_property_only($propcode) ) {
            
                $usercode = $this->tank_auth->get_user_code();
            
                //And the user is the owner...
                if($proprec->ownercode == $usercode && $proprec->soldout != YES) {
                    $this->prop->update_field($propcode, 'soldout', YES);
                    $result['status'] = 'success';
                    $result['message'] = 'Property has been set to sold-out.';
                } else {
                    $result['status'] = 'failed';
                    $result['message'] = 'Property is not valid.';
                }
            } else {
                $result['status'] = 'failed';
                $result['message'] = 'Unable to find the property.';
            }
        }
        echo json_encode($result);
    }
    
    protected function _property_closed($propcode = '') {
        $result = array('status' => 'failed', 'message' => 'Unable to process');
        $isloggedin = $this->tank_auth->is_logged_in();
        if( isset($_POST['process']) && $isloggedin && !empty($propcode) ) {
            
            //Check if property exists and user is the owner...
            $this->load->model('Properties_Model', 'prop');
            if( $proprec = $this->prop->get_property_only($propcode) ) {
            
                $usercode = $this->tank_auth->get_user_code();
            
                //And the user is the owner...
                if($proprec->ownercode == $usercode && $proprec->closed != YES) {
                    $this->prop->update_field($propcode, 'closed', YES);
                    $result['status'] = 'success';
                    $result['message'] = 'Property has been set to closed.';
                } else {
                    $result['status'] = 'failed';
                    $result['message'] = 'Property is not valid.';
                }
            } else {
                $result['status'] = 'failed';
                $result['message'] = 'Unable to find the property.';
            }
        }
        echo json_encode($result);
    }
    
    public function comments() {
        if(isset($_POST['code'])) {
            $data = array(
                'code' => $this->input->post('code'),
                'title' => $this->input->post('title'),
                'url' => $this->input->post('url')
            );
            $this->load->view('disqus', $data);
        }
        echo '';
    }
    
    public function videos() {
        if(isset($_POST['src'])) {
            $propcode = $this->input->post('src');
            $this->load->model('Properties_Model', 'prop');
            if( $proprec = $this->prop->get_propertydesc_only($propcode) ) {
                if(!empty($proprec->video)) {
                    $data = array('video' => $proprec->video);
                    $this->load->view('properties/videos', $data);
                }
            }
        }
        echo '';
    }
    
    public function notifications() {
        $result = array('notifications' => '', 'loggedin' => $this->tank_auth->is_logged_in());
        $this->load->model('Notifications_Model', 'notify');
        $usercode = $this->tank_auth->get_user_code();
        if( $notifyrec = $this->notify->get_count_by_user($usercode) ) {
            $result['notifications'] = ( !empty($notifyrec->count) ? $notifyrec->count : '' );
        }
        echo json_encode($result);
    }
    
    protected function _notifications_list() {
        $this->load->model('Notifications_Model', 'notify');
        $usercode = $this->tank_auth->get_user_code();
        $result = $this->notify->get_notifications_list($usercode);
        
        $listnotifications = array();
        foreach($result as $rec) {
            $vw = $this->load->view('notifications/item', array('record' => $rec, 'usercode' => $usercode), true);
            array_push($listnotifications, $vw);   
        }        
        
        echo json_encode($listnotifications);
    }
}