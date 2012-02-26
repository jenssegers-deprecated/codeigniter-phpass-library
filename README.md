CodeIgniter Password Hash Library
=================================

phpass is a portable password hashing framework for use in PHP applications. The preferred (most secure) hashing method supported by phpass is the OpenBSD-style bcrypt (known in PHP as CRYPT_BLOWFISH), with a fallback to BSDI-style extended DES-based hashes (known in PHP as CRYPT_EXT_DES), and a last resort fallback to an MD5-based variable iteration count password hashing method implemented in phpass itself.

Installation
------------

Place the files from the repository in their respective folders (or use spark). Edit the config/phpass.php configuration file if needed.

Example
-------

    $this->load->library('phpass'); // or use spark
    
    // example 1: hashing a password
    $password = $this->input->post('password');
    $hashed = $this->phpass->hash($password);
    
    // example 2: checking a password
    $user = $this->user_model->get(123);
    $hashed = $user->password;
    $password = $this->input->post('password');
    
    if ($this->phpass->check($password, $hashed))
        echo 'logged in';
    else
        echo 'wrong password';
		
*NOTE:* the `hash` and `check` methods are merely alias methods for the original `HashPassword` and `CheckPassword` that are also available.