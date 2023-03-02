<?php

class ApiController {
	
	protected $f3;
	protected $db;

  function __construct() {
		$f3=Base::instance();
		$db=new DB\SQL(
			$f3->get('db_dns') . $f3->get('db_name'),
			$f3->get('db_user'),
			$f3->get('db_pass')
		);
		$this->f3=$f3;
		$this->db=$db;
    // Do we need this?
    // $this->web = \Web::instance();
	}

  public function test1_get () {
    echo "API Test 1".PHP_EOL;
		echo "-========-".PHP_EOL.PHP_EOL;
		print_r($this->db->exec("SELECT * FROM 'booking_data' WHERE BookingID=3861795"));
  }

  public function test1_post() {
    echo "API Test Create".PHP_EOL;
    echo "-=============-".PHP_EOL.PHP_EOL;
    try {
      //Insert random data with booking id from url
      //throw new Execption("test");
      echo "Foo foo";
    } catch (Exception $e) {
      echo "test1_post error: ".$e->getMessage();
    }
  }
}