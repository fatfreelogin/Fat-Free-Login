<?php

class UtilController {
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

  function createTable()  {
    $this->db->exec(
      "CREATE TABLE `trash` (`id` INTEGER, `data` VARCHAR(1024));"
    );
    $this->db->exec(
      "ALTER TABLE `trash` ADD PRIMARY KEY (`id`);"
    );
  }
}