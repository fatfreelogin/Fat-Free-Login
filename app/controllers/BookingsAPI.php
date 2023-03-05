<?php

class BookingsAPI extends ApiController {
  function test() {
    // print_r($this->f3->get("HEADERS.Authorization")).PHP_EOL;
    
    var_dump(
      $this->db->exec(
        "SELECT COUNT(BookingID) FROM `booking_data`"
      )
    );
  }

  function get() {
    $queryArray = $this->http_parse_query($this->f3->get("QUERY"));
    
    print_r($queryArray).PHP_EOL;

    $queryKeys=array_keys($queryArray);

    
    
    // Replace with url query params.  Obvs.
    $pageSize = $this->f3->get("PARAMS.pageSize");
    $pageOffset = $this->f3->get("PARAMS.pageOffset");
    
    $rowCount = $this->db->exec(
        "SELECT COUNT(BookingID) FROM `booking_data`"
      );

    //Replace with string built from query params.  Natch. 
    $where = "WHERE ";
    $whereArray = [];

    foreach($queryArray as $key => $val) {
      // Replace this with a more betterer, more comprehensive version
      // to handle all possible SQL operators - like Directus
      array_push($whereArray, str_replace("EQUALS", "=", "(".$key." ".strtoupper(array_keys($val)[0])." '".str_replace(">", "' AND '", array_values($val)[0])."') "));
    }
    print_r($whereArray).PHP_EOL;

    $where = "WHERE ".implode(" AND ", $whereArray);
    
    $select = "SELECT BookingID, RequestedPickupTime FROM `booking_data` ".$where." LIMIT :limit OFFSET :offset";
    echo $select.PHP_EOL;

    // $select = "SELECT BookingID, RequestedPickupTime FROM `booking_data` WHERE (RequestedPickupTime BETWEEN '01/01/2023 00:00' AND '03/01/2023 23:59') LIMIT 2 OFFSET 1";
    
    // echo $select.PHP_EOL;
    
    print_r(
      $this->db->exec(
        $select,
        array(
          ":limit" => $pageSize,
          ":offset" => $pageOffset
        )
      )
    );
  }
  function test2() {
    print_r($this->http_parse_query($this->f3->get("QUERY")));
  }
}