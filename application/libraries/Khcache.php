<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

define('KH_CACHE', true);
define('KH_CACHE_VERSION', 0.3);

/**
 * Khaos :: KhCache
 * 
 * A basic caching system to store any data you want such as the output
 * of an resource intensive function or small parts of a view.
 * 
 * @author      David Cole <neophyte@sourcetutor.com>
 * @version     0.3
 * @copyright   2008
 */
class Khcache
{
    /**
     * KhCache Container Instance
     *
     * @var object
     * @access private
     */
    var $_Container;
    
    /**
     * CI Super Object
     *
     * @var object
     * @access private
     */
    var $_CI;      
    
    /**
     * Default KhCache Settings
     *
     * @var array
     */
    var $_Config = array('container' => 'File',
                         'ttl'       => 3600);

    /**
     * Cache Hits
     *
     * @var int
     */
    var $_Hits = 0;

    /**
     * Cache Misses
     *
     * @var int
     */
    var $_Misses = 0;   
                         
    /**
     * Constructor
     *
     * @return Khcache
     */
    function Khcache()
    {
        $this->_CI =& get_instance();
        $this->_CI->config->load('khaos', true, true);
        
        /*
         * Grab any user set khcache config options and
         * where applicable override the defaults.
         */
        
        $options = $this->_CI->config->item('cache', 'khaos');
        
        if (isset($options['container']))
            $this->_Config['container'] = $options['container'];
            
        if (isset($options['ttl']))
            $this->_Config['ttl'] = $options['ttl'];
        
        /*
         * Try and instanciate the specified container ready to
         * handle cache requests.
         */    
                
        if (!class_exists($class = 'KH_Cache_'.$this->_Config['container']))
            show_error('Khaos :: Cache :: Container \''.$class.'\' does not appear to exist.');
        else 
        {
            $container_options = array();
            
            if (isset($options[$this->_Config['container']]) && is_array($options[$this->_Config['container']]))
                $container_options = $options[$this->_Config['container']];

            $this->_Container = new $class($container_options);
        }
    }
    
    /**
     * Delete Cache Item
     *
     * @param string $key
     * 
     * @return bool
     */
    function delete($key)
    {
        return $this->_Container->Delete($key);
    }
    
    /**
     * Delete All Cache Items
     *
     * @return bool
     * @access public
     */
    function delete_all()
    {
        return $this->_Container->DeleteAll();
    }
    
    /**
     * Fetch Cache Item
     *
     * @param string $key
     * 
     * @return mixed
     */
    function fetch($key)
    {
        if (($ret = $this->_Container->Fetch($key)) === false)
        {
            $this->_Misses++;
            return false;
        }
        else 
        {
            $this->_Hits++;
            return $ret;
        }      
    }
    
    /**
     * Store Cache Item
     *
     * @param string  $key
     * @param mixed   $data  All data will be serialized by the container
     * @param int     $ttl
     * 
     * @return bool
     */
    function store($key, $data, $ttl = false)
    {
        if (!$ttl) // Use the global TTL if no TTL is specified
            $ttl = $this->_Config['ttl'];
        
        return $this->_Container->Store($key, $data, $ttl);     
    }
    
    /**
     * Cache Function Response
     *
     * @param string $func
     * @param array  $args
     * @param int    $ttl
     * 
     * @return mixed
     * @access public
     */
    function call($func, $args = array(), $ttl = false)
    {
        $key = $this->generatekey($func, $args);
        
        if (($cache = $this->fetch($key)) !== false)
            return $cache;
        else 
        {
            if (!is_callable($func))
                return false;
                
            $data = call_user_func_array($func, $args);
            
            if (!$this->store($key, $data, $ttl))
                return false;
                
            return $data;
        }
    }
    
    /**
     * Generate Key
     *
     * @return string
     */
    function generatekey()
    {
        return md5(serialize($data = func_get_args()));
    }
    
    /**
     * Get Number of Cache Hits
     *
     * @return int
     */
    function get_hits()
    {
        return $this->_Hits;
    }
    
    /**
     * Get Number of Cache Misses
     *
     * @return int
     */
    function get_misses()
    {
        return $this->_Misses;
    }
}

/**
 * Khaos :: KhCache :: APC
 *
 * Wraps the APC extension so it can be used
 * as an KhCache Container.
 * 
 */
class KH_Cache_APC
{
    /**
     * Constructor
     *
     * @param array $options   Container Options
     * 
     * @return KH_Cache_APC
     */
    function KH_Cache_APC($options)
    {        
        // Ensure APC is available
        if (!function_exists('apc_store') || !function_exists('apc_fetch') || !function_exists('apc_delete'))
            show_error('Khaos :: Cache :: APC - One or more of the required APC functions is unavailable.');
    }
    
    /**
     * Store Cache Item
     *
     * @param string $key
     * @param mixed  $data
     * @param int    $ttl
     * 
     * @return bool
     * @access public
     */
    function Store($key, $data, $ttl)
    {
        return apc_store($key, serialize($data), $ttl);
    }
    
    /**
     * Fetch Cache Item
     *
     * @param string $key
     * 
     * @return mixed
     * @access public
     */
    function Fetch($key)
    {
        return (($ret = apc_fetch($key)) !== false)?unserialize($ret):false;
    }
    
    /**
     * Delete Cache Item
     *
     * @param string $key
     * 
     * @return bool
     * @access public
     */
    function Delete($key)
    {
        return apc_delete($key);
    } 
    
    /**
     * Delete All Cache Items
     *
     * @return bool
     * @access public
     */
    function DeleteAll()
    {
        return apc_clear_cache('user');
    }
}

/**
 * Khaos :: KhCache :: File
 * 
 * A file based container for KhCache
 *
 */
class KH_Cache_File
{
    /**
     * File Container Options
     *
     * @var array
     */
    var $_Config = array('store'           => '',
                         'auto_clean'      => 10,
                         'auto_clean_life' => 3600,                         
                         'auto_clean_all'  => false);
    
    /**
     * Constructor
     *
     * @param array $options  Container Options
     * 
     * @return KH_Cache_File
     */
    function KH_Cache_File($options)
    {        
        // Set default cache location if not specified  
        if (!isset($options['store']))
            $this->_Config['store'] = BASEPATH.'cache/';
        
        // Set user config options
        $this->_Config = array_merge($this->_Config, $options);            
        
        // Ensure cache store is writable                    
        if (!is_writable($this->_Config['store']))
            show_error('Khaos :: Cache :: File - Store \''.$this->_Config['store'].'\' is not writable');

        // Perform some house cleaning of the cache directory
        if (($this->_Config['auto_clean'] !== false) && (rand(1, $this->_Config['auto_clean']) === 1))
            $this->_Clean();
    }
    
    /**
     * Store Cache Item
     *
     * @param string $key
     * @param mixed  $data
     * @param int    $ttl
     * 
     * @return bool
     * @access public
     */
    function Store($key, $data, $ttl)
    {
        $file  = $this->_Config['store'].'khcache_'.md5($key);
        $data  = serialize(array('expire' => ($ttl + time()), 'cache' => $data));
        
        if (!($fp = fopen($file, 'a+')))
            show_error('Khaos :: Cache :: File - Error opening file \''.$file.'\'.');
            
        flock($fp, LOCK_EX); // Lock file for writing
        fseek($fp, 0);       // Seek to start of file
        ftruncate($fp, 0);   // Ensure the file is empty
    
        if (fwrite($fp, $data) === false) 
            show_error('Khaos :: Cache :: File - Error writing to file \''.$file.'\'.');
        
        fclose($fp);         
        
        return true;
    }
    
    /**
     * Fetch Cache Item
     *
     * @param string $key
     * 
     * @return mixed
     * @access public
     */
    function Fetch($key)
    {
        $file  = $this->_Config['store'].'khcache_'.md5($key);
        
        // Do we have a cache for this key?
        if (!file_exists($file))
            return false;       
            
        // Try and open the cache file    
        if (!($fp = fopen($file, 'r')))
        {
            show_error('Khaos :: Cache :: File - Error Opening File \''.$file.'\'');
            return false;
        }
            
        // Lock file for reading
        flock($fp, LOCK_SH);

        // Retrieve the cache contents
        $data = unserialize(file_get_contents($file));
        fclose($fp);        
        
        // Has the cache item expired ?
        if (time() < $data['expire'])
        	return $data['cache'];
        else 
            return false; 
    }
    
    /**
     * Delete Cache Item
     *
     * @param string $key
     * 
     * @return bool
     * @access public
     */
    function Delete($key)
    {
        $file = $this->_Config['store'].'khcache_'.md5($key);
        
        if (file_exists($file))
            return @unlink($file);
        else 
            return false;        
    }      
    
    /**
     * Delete All Cache Files
     *
     * @return bool
     * @access public
     */
    function DeleteAll()
    {
        // Ensure we can read the cache directory 
        if (!($dh = opendir($this->_Config['store'])))
        {
            show_error('Khaos :: Cache :: File - Error Opening Store \''.$this->_Config['store'].'\'');
            return false;
        }
  
        // Remove any expired cache items
        while ($file = readdir($dh))
            if (($file != '.') && ($file != '..') && ($file != 'index.html') && is_file($cache_file = $this->_Config['store'].$file))
                if (($this->_Config['auto_clean_all'] == true) || (substr($file, 0, 8) == 'khcache_'))
                    @unlink($cache_file);
                    
        return true;
    }
    
    /**
     * Clean Cache Directory
     *
     * @return void
     * @access private
     */
    function _Clean()
    {     
        // Ensure we can read the cache directory 
        if (!($dh = opendir($this->_Config['store'])))
        {
            show_error('Khaos :: Cache :: File - Error Opening Store \''.$this->_Config['store'].'\'');
            return;
        }
  
        // Remove any expired cache items
        while ($file = readdir($dh))
            if (($file != '.') && ($file != '..') && ($file != 'index.html') && is_file($cache_file = $this->_Config['store'].$file))
                if (($this->_Config['auto_clean_all'] == true) || (substr($file, 0, 8) == 'khcache_'))
                    if ((time() - @filemtime($cache_file)) > $this->_Config['auto_clean_life'])
                        @unlink($cache_file);
    }
}

?>