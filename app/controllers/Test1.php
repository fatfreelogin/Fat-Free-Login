<?php

class Test1 {
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
  }
  
  function get() {
    // echo "Test1: GET - ".$this->f3->get("PARAMS.BookingID").PHP_EOL;
    
    $data = $this->db->exec("SELECT * FROM 'booking_data' WHERE BookingID=?", $this->f3->get("PARAMS.BookingID"));
    
    echo json_encode($data);
  }
  function post() {
    echo "Test1: POST ".$this->f3->get("PARAMS.BookingID").PHP_EOL;
    try {
      //! Going to have to read in column data and map data to array from input
      var_dump($this->db->exec("INSERT INTO `booking_data` (BookingID, CustomerID, RequestedPickupTime) VALUES(?,?,?)", array(
        1=>$this->f3->get("PARAMS.BookingID"),
        2=>"999999",
        3=>"23/03/1971 00:00:01"
      )));
      // throw new Exception("Gaargh!!");
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }
  function put() {
    echo "Test1: PUT".PHP_EOL;
  }
  function delete() {
    echo "Test1: DELETE".PHP_EOL;
  }
}