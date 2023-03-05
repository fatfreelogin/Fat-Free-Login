<?php

class ApiController {
	
	protected $f3;
	protected $db;
  protected $log;

  function __construct() {
		$f3=Base::instance();
		$db=new DB\SQL(
			$f3->get('db_dns') . $f3->get('db_name'),
			$f3->get('db_user'),
			$f3->get('db_pass')
		);
    // $log=new Logger;
		$this->f3=$f3;
		$this->db=$db;
    // Do we need this?
    // $this->web = \Web::instance();
	}

  function beforeroute() {
    $tokenSearch = $this->db->exec(
      "SELECT username FROM users WHERE api_token=:apitoken",
      array(
        ":apitoken" => str_replace(
            "Bearer ",
            "",
            $this->f3->get("HEADERS.Authorization")
          )
      )
    );
    if (count($tokenSearch) == 0) {
      $this->f3->error(401);
    }
  }
  
  function printTest($test) {
    foreach ($test->results() as $result) {
      if (is_array($result['text'])) {
        echo print_r($result['text']).PHP_EOL;
      } else {
        echo $result['text'].PHP_EOL;
      }
      
      if ($result['status'])
          echo 'Pass';
      else
          echo 'Fail ('.$result['source'].')';
      echo PHP_EOL;
    }
  }
  function http_parse_query($queryString, $argSeparator = '&', $decType = PHP_QUERY_RFC1738) {
    $result = array();
    $parts = explode($argSeparator, urldecode($queryString));

    foreach ($parts as $part) {
      list($paramName, $paramValue)   = explode('=', $part, 2);

      switch ($decType) {
        case PHP_QUERY_RFC3986:
          $paramName      = rawurldecode($paramName);
          $paramValue     = rawurldecode($paramValue);
          break;

        case PHP_QUERY_RFC1738:
        default:
          $paramName      = urldecode($paramName);
          $paramValue     = urldecode($paramValue);
          break;
      }
      

      if (preg_match_all('/\[([^\]]*)\]/m', $paramName, $matches)) {
        $paramName      = substr($paramName, 0, strpos($paramName, '['));
        $keys           = array_merge(array($paramName), $matches[1]);
      } else {
        $keys           = array($paramName);
      }
      
      $target         = &$result;
      
      foreach ($keys as $index) {
              if ($index === '') {
                      if (isset($target)) {
                              if (is_array($target)) {
                                      $intKeys        = array_filter(array_keys($target), 'is_int');
                                      $index  = count($intKeys) ? max($intKeys)+1 : 0;
                              } else {
                                      $target = array($target);
                                      $index  = 1;
                              }
                      } else {
                              $target         = array();
                              $index          = 0;
                      }
              } elseif (isset($target[$index]) && !is_array($target[$index])) {
                      $target[$index] = array($target[$index]);
              }

              $target         = &$target[$index];
      }

      if (is_array($target)) {
              $target[]   = $paramValue;
      } else {
              $target     = $paramValue;
      }
    }

    return $result;
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

  function toCamelCase($string) {
    $capitalizeFirstCharacter = true;
    $str = str_replace([' ','-'], '', ucwords($string, ' '));
    if (!$capitalizeFirstCharacter) {
        $str = lcfirst($str);
    }
    return $str;
  }

  // function csv2array($filename = "uploads/FU67c491", $delimiter = ",") {
  function csv2array($filename) {
    // $filename = 'uploads/'.$this->f3->get('PARAMS.filename');;
    $delimiter = ',';
    echo $filename;

    if(!file_exists($filename) || !is_readable($filename))
        return FALSE;

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if(!$header)
                $header = array_map([$this, 'toCamelCase'], $row);
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    // print_r($data);
    return $data;
  }
}