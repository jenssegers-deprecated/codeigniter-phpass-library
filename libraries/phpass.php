<?php
/**
 * @name		CodeIgniter phpass Library
 * @author		Jens Segers
 * @link		http://www.jenssegers.be
 * @license		MIT License Copyright (c) 2012 Jens Segers
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class phpass {
    
    protected $PasswordHash;
    
    // default values if config was not found
    protected $iteration_count_log2 = 8;
    protected $portable_hashes = FALSE;
    
    /**
     * Construct with configuration array
     * 
     * @param array $config
     */
    public function __construct($config = array()) {
        // check if the original phpass file exists
        if (!file_exists($path = dirname(__FILE__) . '/../vendor/PasswordHash.php')) {
            show_error('The phpass class file was not found.');
        }
        
        include ($path);
        
        if (!empty($config)) {
            $this->initialize($config);
        }
        
        // create phpass object
        $this->PasswordHash = new PasswordHash($this->iteration_count_log2, $this->portable_hashes);
    }
    
    /**
     * Initialize with configuration array
     * 
     * @param array $config
     */
    public function initialize($config = array()) {
        foreach ($config as $key => $val) {
            if ($key != 'PasswordHash') {
                $this->{$key} = $val;
            }
        }
    }
    
    /**
     * Alias method for HashPassword
     */
    public function hash($password) {
        return $this->PasswordHash->HashPassword($password);
    }
    
    /**
     * Alias method for CheckPassword
     */
    public function check($password, $stored_hash) {
        return $this->PasswordHash->CheckPassword($password, $stored_hash);
    }
    
    /**
     * Magic call method that passes every call to the phpass object
     * 
     * @return mixed
     */
    public function __call($name, $arguments) {
        return call_user_func_array(array($this->PasswordHash, $name), $arguments);
    }
    
    /**
     * Magic get method that passes every property request to the phpass object
     * 
     * @return mixed
     */
    public function __get($name) {
        return $this->PasswordHash->{$name};
    }

}