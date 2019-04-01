<?php

class AdminController extends Controller {
	protected $f3;
	protected $db;
		
	public function users()
	{	
        $users = new User($this->db);
		$this->f3->set('users',$users->all());
		$this->f3->set('view','admin/users.htm');
	}
	
	private function check_password($pw, $confirm)
	{
		if(strlen($pw) < 8)
		{
			return $this->f3->get('i18n_password_too_short');
		}
		else if($pw != $confirm)
		{
			return $this->f3->get('i18n_user_wrong_confirm');
		}
		else 
		{
			return "";
		}		
	}
	
	public function show_user() 
	{
		$id = $this->f3->get('PARAMS.id'); 
		if($this->f3->exists('POST.edit'))
        {
			$users = new User($this->db);
			$pw = $this->f3->get('POST.password');
			if(strlen($pw)===0)
			{ //do not change password, reset to hash in database
				$this->f3->set('POST.password',$this->f3->get('POST.pw'));
			}
			else
			{
				$pwcheck = $this->check_password( $pw , $this->f3->get('POST.confirm'));
				if (strlen($pwcheck) > 0)
				{
					$this->f3->set('message', $pwcheck);
				}
				else
				{
					$crypt = \Bcrypt::instance();
					$password = $crypt->hash($this->f3->get('POST.password'));
					
					$this->f3->set('message', "Password changed");
					$this->f3->set('POST.password', $password);
				}
			}
			$users->edit($id, $this->f3->get('POST'));
		}
		else
		{
			$users = new User($this->db);
			$users->getById($id);

			if($users->dry()) { //throw a 404, order does not exist
				$this->f3->error(404);
			}
		}

		$this->f3->set('view','admin/userdetails.htm');
	}
}