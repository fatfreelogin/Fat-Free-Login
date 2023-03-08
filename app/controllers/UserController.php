<?php

class UserController extends Controller {

	public function confirm_registration()
	{
		$user = new User($this->db);
		$user->getByHash($this->f3->get('GET.h'));
		if(strcmp($this->f3->get('POST.hash'),$this->f3->get('GET.h'))===0)
		{
			$user->activate($user->id);
			$this->f3->set('POST.registration_ok',true);
			$this->f3->set('view','user/confirm_registration.htm');
		}
		else 
		{ //check if account is already activated
			$user->checkActivatedHash($this->f3->get('GET.h'));
			if(strcmp($this->f3->get('POST.hash'),$this->f3->get('GET.h'))===0)
			{
				$this->f3->set('message',$this->f3->get('i18n_alreadyactivated') );
				$this->f3->set('page_head',$this->f3->get('i18n_registration'));
				$this->f3->set('view','page/message.htm');
			}
			else
			{
				$this->f3->set('message',$this->f3->get('i18n_reg_conf_failed') );
				$this->f3->set('page_head',$this->f3->get('i18n_registration'));
				$this->f3->set('view','page/message.htm');
			}
		}
	}
	
	public function update_registration()
	{
		// first activation posted
		$user = new User($this->db);
		$sessionlogin = false;
		
		$this->f3->set('POST.activated',1); 
		
		$user->edit($this->f3->get('POST.user_id'));

		$this->f3->copy('POST','SESSION');
		$this->f3->set('SESSION.login_message',$this->f3->get('i18n_reg_update_success') );
		$this->f3->reroute('/login');		
	}
	
	public function pw_reset()
	{
		$user = new User($this->db);
		$user->checkActivatedHash($this->f3->get('GET.h'));
		$this->f3->set('SESSION.user_id',$user->id);

		if($this->f3->exists('POST.reset_pw')){
			$pwcheck = $this->check_password( $this->f3->get('POST.new_password') , $this->f3->get('POST.confirm'));
			if (strlen($pwcheck) > 0) //pwcheck error message returned
			{
				$this->f3->set('message', $pwcheck);
				$this->f3->set('view','user/change-pw.htm');
			} else {
				if($this->setpw( $this->f3->get('POST.new_password'), $user->id))
				{
					$this->f3->reroute('/login');
				} else {
					$this->f3->error(403);
				}
			}
		}
		else if(strcmp($this->f3->get('POST.hash'),$this->f3->get('GET.h'))===0)
		{
			$this->f3->set('view','user/change-pw.htm');
		} else {
			$this->f3->set('page_head',$this->f3->get('i18n_error'));
			$this->f3->set('message',$this->f3->get('i18n_register_oops') );
			$this->f3->set('view','page/message.htm');
		}
	}
	
	private function setpw( $newpw, $user_id )
	{
		$user = new User($this->db);
		$user->getById($user_id);
		
		$password = password_hash($newpw, PASSWORD_BCRYPT);
		
		//check if user id = session id for security
		if($user_id == $this->f3->get('SESSION.user_id'))
		{				
			$this->f3->set('POST.password', $password);
			$user->edit($user_id, $this->f3->get('POST'));
			return true;
		}
		else { 
			return false;
		}
	}
	
	public function edit_registration()
	{
		if($this->f3->VERB==="POST")
		{
			$user_id=$this->f3->get('SESSION.user_id');
			if($this->f3->get('POST.user_id') == $user_id)
			{
				if(null!==$this->f3->get('POST.password'))
				{
					$passwordcheck = $this->check_password($this->f3->get('POST.password'), $this->f3->get('POST.confirm'));
					if( $passwordcheck==="" && $this->setpw( $this->f3->get('POST.password'), $this->f3->get('POST.user_id')) )
					{
						$this->f3->set('alert_type',"success");
						$this->f3->set('message',$this->f3->get('i18n_password_changed'));
					}
					else
					{
						$this->f3->set('alert_type',"danger");
						$this->f3->set('message',$passwordcheck);
					}
				}
				
				$user = new User($this->db);
				$user->getById($user_id);
				$user->edit($user_id, $this->f3->get('POST'));
				$this->f3->set('SESSION.logged_in', 1);
				$user->login($user->id);
			}
			else { 
				$this->f3->error(403);
			}
		}
		$this->f3->copy('SESSION','POST');
		
		$this->f3->set('view','user/editregistration.htm');	
	}
	
	public function success()
	{
		$this->f3->set('view','user/success.htm');
	}
	
	public function sendactmail($email, $hash)
	{
		$confirmation_link = $this->f3->get('SCHEME')."://".$this->f3->get('HOST')."/confirm_registration?h=".$hash;
		$mail = new Mail();
		$mail->send( // sender, recipient, subject, msg
			$this->f3->get('from_email') , 
			$email, 
			$this->f3->get('i18n_confirmation_mail_subject') . " " . $this->f3->get('HOST'),
			$this->f3->get('i18n_confirmation_mail_message')."<a href=\"".$confirmation_link."\">".$confirmation_link . "</a>"
		);
		
	}

	private function pw_reset_mail($email, $hash)
	{
		$confirmation_link = $this->f3->get('SCHEME')."://".$this->f3->get('HOST')."/pw_reset?h=".$hash;
		$mail = new Mail();
		$mail->send( // sender, recipient, subject, msg
			$this->f3->get('from_email') , 
			$email, 
			$this->f3->get('i18n_confirmation_mail_subject') . " " . $this->f3->get('HOST'),
			$this->f3->get('i18n_reset_pw_mail_message')."<a href=\"".$confirmation_link."\">".$confirmation_link . "</a>"
		);
		
	}
	
	public function sendactivationmail()
	{
		if($this->f3->exists('POST.sendmail'))
		{
			$hash=$this->createHash();
			$user = new User($this->db);
			$user->getByEmail($this->f3->get('POST.email'));
			$this->f3->set('POST.hash', $hash);
			$user->edit($user->id);
			$this->sendactmail($this->f3->get('POST.email'), $hash);
			$this->f3->set('page_head',$this->f3->get('i18n_registration'));
			$this->f3->set('message', $this->f3->get('i18n_conf_mail_sent'));
			$this->f3->set('view','page/message.htm');
		}
		else
		{
			$this->f3->set('view','user/send_activation_mail.htm');
		}
	}
	
	private function check_password($pw, $confirm)
	{
		if(strlen($pw) < 8)
		{
			return $this->f3->get('i18n_password_too_short');
		}
		else if($pw !== $confirm)
		{
			return $this->f3->get('i18n_user_wrong_confirm');
		}
		else 
		{
			return "";
		}		
	}

	public function create()
	{
		if($this->f3->exists('POST.create'))
		{
			$pwcheck = $this->check_password( $this->f3->get('POST.password'), $this->f3->get('POST.confirm'));
			if (strlen($pwcheck) > 0)
			{ 
				$this->f3->set('message', $pwcheck);
				$this->f3->set('view','user/create.htm');
			}
			else{
				$password = password_hash($this->f3->get('POST.password'), PASSWORD_BCRYPT);
				$this->f3->set('POST.password', $password);
				
				$hash = $this->createHash();
				$this->f3->set('POST.hash', $hash);
				$user = new User($this->db);
				$user_added=$user->add($this->f3->get('POST'));
				
				if($user_added==1)
				{
					$this->sendactmail($this->f3->get('POST.email'), $hash);

					$this->f3->set('page_head',$this->f3->get('i18n_registration'));
					$this->f3->set('message', $this->f3->get('i18n_conf_mail_sent'));
					$this->f3->set('view','page/message.htm');
				}
				else if($user_added==10) //user taken
				{
					$this->f3->set('message', $this->f3->get('i18n_username_taken'));
					$this->f3->set('view','user/create.htm');
				}
				else if($user_added==11) //email taken
				{
					if($user->activated==0)
					{
						$this->f3->set('message', $this->f3->get('i18n_not_activated'));	
					}
					else
					{
						$this->f3->set('message', $this->f3->get('i18n_email_taken'));						
					}
					$this->f3->set('view','user/create.htm');
				}
			}
		} 
		else
		{
			$this->f3->set('view','user/create.htm');
		}
	}

	public function login()
	{
		if( $this->f3->get('SESSION.logged_in'))
		{
			$this->f3->reroute('https://BTAXFF3PetiteVue.spurblickale.repl.co/');
		}
		else if($this->f3->exists('POST.login')) // OR $this->f3->VERB=='POST'
		{
			$ip = $_SERVER['REMOTE_ADDR'];
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			$user_id="not logged in";

			$user = new User($this->db);
			$user->getByName( $this->f3->get('POST.username') );

			if($user->dry() || ! password_verify($this->f3->get('POST.password'), $user->password))
			{
				$this->f3->logger->write( "1LOG IN: ".$this->f3->get('POST.username')." login failed (ip: " .$ip .")",'r'  );
				sleep(2);
				$this->f3->set('message', $this->f3->get('i18n_wrong_login'));
				$this->f3->set('page_head','Login');
				$this->f3->set('view','user/login.htm');
			}
			else if ($user->activated===0)
			{
				$this->f3->logger->write( "2LOG IN: ".$this->f3->get('POST.username')." not activated (ip: " .$ip .")",'r'  );
				$this->f3->set('message',  $this->f3->get('i18n_not_activated'));
				$this->f3->set('page_head','Login');
				$this->f3->set('view','user/login.htm');
			}
			else 
			{
				$this->f3->set('SESSION.user_id', $user->id);
				$user->login($user->id);
				$this->f3->logger->write( "3LOG IN: ".$this->f3->get('POST.username')." login success (ip: " .$ip .")",'r'  );
				$this->f3->set('SESSION.logged_in', 'true');
				$this->f3->set('SESSION.timestamp', time());
				$this->f3->reroute('https://BTAXFF3PetiteVue.spurblickale.repl.co/');
			}
		} 
		else
		{
			$this->f3->set('page_head','Login');
			$this->f3->set('view','user/login.htm');
		}
	}
	
	public function logout()
	{
		$this->f3->clear('SESSION');
		$this->f3->set('page_head','Logout');
		$this->f3->reroute($this->f3->get("BASE").'/');
	}

	public function update()
	{
		$user = new User($this->db);

		if($this->f3->exists('POST.update'))
		{
			$user->edit($this->f3->get('POST.id'));
			$this->f3->reroute('/success/User Updated');
		} 
		else
		{
			$user->getById($this->f3->get('PARAMS.id'));
			$this->f3->set('user',$user);
			$this->f3->set('page_head',$this->f3->get('i18n_changepassword'));
			$this->f3->set('view','admin/update.htm');
		}
	}

	public function lostpassword()
	{
		if($this->f3->exists('POST.reset_pw'))
		{
			$hash=$this->createHash();
			$user = new User($this->db);
			$user->getByEmail($this->f3->get('POST.email'));
			if(! $user->dry()){
				$this->f3->set('POST.hash', $hash);
				$user->edit($user->id, $this->f3->get('POST'));
				$this->pw_reset_mail($this->f3->get('POST.email'), $hash);
			}
			$this->f3->set('page_head', $this->f3->get('i18n_new_password_request_header'));
			$this->f3->set('message', $this->f3->get('i18n_new_password_request'));
			$this->f3->set('view','page/message.htm');
		} 
		else
		{
			$this->f3->set('view','user/reset-pw.htm');
		}
	}

	private function createHash()
	{ //this should be somewhat unpredictible 
		return md5( str_shuffle(time(). $this->f3->get('POST.username') . $this->f3->get('POST.email') ) );
	}

	public function delete()
	{
		if($this->f3->exists('PARAMS.id'))
		{
			$user = new User($this->db);
			$user->delete($this->f3->get('PARAMS.id'));
		}
		$this->f3->reroute('/success/User Deleted');
	}
}