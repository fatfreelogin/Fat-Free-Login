<?php

class User extends DB\SQL\Mapper {

/* only these db fields are allowed to be changed */
	protected $allowed_fields = array(
		"username",
		"password",
		"email",
		"activated",
		"hash",
		"type"
	);
	
	private function sanitizeInput(array $data, array $fieldNames) 
	{ //sanitize input - with thanks to richgoldmd
	   return array_intersect_key($data, array_flip($fieldNames));
	}
	
	private function getCurrentdate()
	{
		return date("Y-m-d H:i:s");
	}
	
	public function __construct(DB\SQL $db) 
	{
		parent::__construct($db,'users');
	}

	public function all() 
	{ //get all users, admin only!
		$this->load();
		return $this->query;
	}

	public function add( $unsanitizeddata )
	{
		$data=$this->sanitizeInput($unsanitizeddata, $this->allowed_fields);
		//check if username already exists in db
		$this->load(array('username=?',$data['username']));		
		if(!$this->dry())
		{
			return 10;
		}
		//check if email already exists in db
		$this->load(array('email=?',$data['email']));
		if(!$this->dry())
		{
			return 11;
		}
		$data['created_at']=$this->getCurrentdate();
		$data['updated_at']=$this->getCurrentdate();
		$this->copyFrom($data);
		$this->save();
		return 1;
	}

	public function getByName($name)
	{
		$this->load(array('username=?', $name));
	}
	
	public function getByEmail($email)
	{
		$this->load(array('email=?', $email));
		$this->copyTo('POST');
	}
	
	public function getById($id) 
	{
		$this->load(array('id=?',$id));
		$this->copyTo('POST');
	}
	
	public function login($id) 
	{
		$this->load(array('id=?',$id));
		$this->copyTo('SESSION');
	}
	
	public function getByHash($hash) 
	{
		$this->load(array('hash=? AND activated=0',$hash));
		$this->copyTo('POST');
	}
	
	public function checkActivatedHash($hash) 
	{
		$this->load(array('hash=? AND activated=1',$hash));
		$this->copyTo('POST');
	}
	
	public function edit($id, $unsanitizeddata)
	{
		$data=$this->sanitizeInput($unsanitizeddata, $this->allowed_fields);
		$data['updated_at']=$this->getCurrentdate();
		$this->load(array('id=?',$id));
		$this->copyFrom($data);
		$this->update();
	}

	public function activate($id)
	{
		$data['updated_at']=$this->getCurrentdate();
		$this->load(array('id=?',$id));
		$this->updated_at=$this->getCurrentdate();
		$this->activated=1;
		$this->update();
	}

	public function delete($id) 
	{
		$this->load(array('id=?',$id));
		$this->erase();
	}
}
