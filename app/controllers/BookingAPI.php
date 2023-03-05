<?php

class BookingAPI extends ApiController {
    
  function get() {
    // I think we're done here 
    try {
      
      $BookingID = $this->f3->get("PARAMS.BookingID");
      
      $this->f3->logger->write("BookingAPI: GET ".$BookingID);    
      
      $data = $this->db->exec("SELECT * FROM 'booking_data' WHERE BookingID=?", $BookingID);    
      
      if (count($data)==0)
        throw new Exception("Booking (ID: ".$BookingID.") not found", 1);
      
      $this->f3->logger->write("Booking (ID: ".$BookingID.") found");     
      
      echo json_encode($data);
      
    } catch (Exception $e) {
      
      $this->f3->logger->write("BookingAPI: GET - error: ".$e->getMessage());
      $this->f3->error(404);
          
    }   
  }
  
  function post() {
    //Logging to be added
    $BookingID = $this->f3->get("PARAMS.BookingID");
    $query=$this->f3->get('QUERY');
    
    $this->f3->logger->write("BookingAPI: POST ".$BookingID);
    try {
      //! Going to have to read in column data and map data to array from input
      
      if (!is_numeric($BookingID))
        throw new Exception("Invalid BookingID, integer expected", 1);

      // stripslashes probably not needed
      $queryArray = array_map('stripslashes',$this->http_parse_query($query));
      
      $queryArray['BookingID'] = $BookingID;

      ksort($queryArray);

      $columnList = array_keys($queryArray);

      var_dump(
        $this->db->exec(
          "INSERT INTO `booking_data` (".implode(', ',$columnList).") VALUES(".implode(',', array_fill(0, count($columnList), '?')).")",
          array_values($queryArray)
        )
      );
    } catch (Exception $e) {
      echo 'Err: '.$e->getCode().' : '.$e->getMessage().PHP_EOL;
      switch($e->getCode()) {
        case 1:
          $this->f3->error(500);
          break;
        default:
          $this->f3->error(501);
          break;
      }
    } finally {
      echo json_encode($this->db->exec("SELECT * FROM 'booking_data' WHERE BookingID=?", $BookingID));
    }    
  }
  function put() {
    //Logging to be added
    $BookingID = $this->f3->get("PARAMS.BookingID");

    try {
      //! Going to have to read in column data and map data to array from input
      
      if (!is_numeric($BookingID))
        throw new Exception("Invalid BookingID, integer expected", 1);

      // stripslashes probably not needed
      $queryArray = array_map('stripslashes',$this->http_parse_query($this->f3->get('QUERY')));
      
      // $queryArray['BookingID'] = $BookingID;

      ksort($queryArray);

      $columnList = array_keys($queryArray);

      $sql_values = '';
      $sep = '';
      foreach ($queryArray as $key => $val) {
          $sql_values .= $sep . '`' . $key . '`="' . $val . '"';
          $sep = ', ';
      }
      echo "UPDATE booking_data SET ".$sql_values." WHERE BookingID=".$BookingID.PHP_EOL;
      var_dump(
        $this->db->exec(
          // "INSERT INTO `booking_data` (".implode(', ',$columnList).") VALUES(".implode(',', array_fill(0, count($columnList), '?')).")",
          "UPDATE booking_data SET ".$sql_values." WHERE BookingID=".$BookingID
          // array_values($queryArray)
        )
      );
      // throw new Exception("Gaargh!!");
    } catch (Exception $e) {
      echo 'Err: '.$e->getCode().' : '.$e->getMessage().PHP_EOL;
      switch($e->getCode()) {
        case 1:
          $this->f3->error(500);
          break;
        default:
          $this->f3->error(501);
          break;
      }
    } finally {
      echo json_encode($this->db->exec("SELECT * FROM 'booking_data' WHERE BookingID=?", $BookingID));
    }
  }
  function delete() {
    //Copy to trash table
    //Logging to be added
    try {
      echo $this->db->exec("DELETE FROM 'booking_data' WHERE BookingID=?", $this->f3->get("PARAMS.BookingID")).PHP_EOL;
    } catch (Exception $e) {
      var_dump($e);
    }
  }
  


  //========================
  // Tests
  //
  function testHttpParseQuery () {
    $query = $this->f3->get("QUERY");
    $test = new Test;
    //! Something wrong with call internal function like this
    // $test->expect(
    //   is_callable($this->http_parse_query($query)), 'Is http_parse_query a function'
    // );
    $test->expect(
      is_string($query),
      'Is query is a string'
    );
    $test->expect(
      is_array($this->http_parse_query($query)),
      'Is result an array'
    );
    $test->message($this->http_parse_query($query));
    $this->printTest($test);
  }
}