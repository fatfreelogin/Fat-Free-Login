<?php

class FileController { //extends Controller {
	protected $f3;
	protected $db;

  public function upload()
	{
    // Just kill it if they're not even trying
    if(!$this->f3->exists('SERVER.PHP_AUTH_USER') && !$this->f3->exists('SERVER.PHP_AUTH_PW')) {
      die;
    }
    
    // User auth
    $user = new User($this->db);
    $user->getByName( $this->f3->get('SERVER.PHP_AUTH_USER') );
    
    if(password_verify($this->f3->get('SERVER.PHP_AUTH_PW'), $user->password)) {

      $filename = "FU".$this->uniqidReal(6);

      $putdata = fopen("php://input", "r");
      /* Open a file for writing */
      $fp = fopen("uploads/".$filename, "w");

      /* Read the data 1 KB at a time
        and write to the file */
      while ($data = fread($putdata, 1024))
        fwrite($fp, $data);

      /* Close the streams */
      fclose($fp);
      fclose($putdata);

      $this->db->exec(
        "INSERT INTO file_queue (`filename`, `status`, `timestamp`) VALUES(:filename, :status, :timestamp)",
        array(
          ':filename'=>$filename,
          ':status'=>1,
          ':timestamp'=>time()
          )
        );
    } else {
      echo "Permission Denied. >:|";
    }    
	}
  
  function __construct() {
		$f3=Base::instance();
		$db=new DB\SQL(
			$f3->get('db_dns') . $f3->get('db_name'),
			$f3->get('db_user'),
			$f3->get('db_pass')
		);
		$this->f3=$f3;
		$this->db=$db;
    $this->web = \Web::instance();
	}
  
  function uniqidReal($length = 13) {
    // uniqid gives 13 chars, but you could adjust it to your needs.
    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($length / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
    } else {
        throw new Exception("no cryptographically secure random function available");
    }
    return substr(bin2hex($bytes), 0, $length);
  }

  function csv2array($filename = 'uploads/FU67c491', $delimiter=",") {
    // $csv = array_map(function($v){return str_getcsv($v, ';');}, file('uploads/FU67c491'));
    $filename = 'uploads/FU67c491';
    $delimiter = ',';

    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            // print_r($header);
            if(!$header)
            //! Hmm, array map needs research...
                $header = array_map(spacesToCamelCase,$row);
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    // return $data;

    // print_r( $data );
  }
  
  function spacesToCamelCase($string, $capitalizeFirstCharacter = false) 
  {
    $str = str_replace(' ', '', ucwords($string, '-'));
    if (!$capitalizeFirstCharacter) {
        $str = lcfirst($str);
    }
    return $str;
  }
}