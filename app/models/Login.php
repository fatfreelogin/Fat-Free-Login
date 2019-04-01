<?php

class Login extends DB\SQL\Mapper {
	
	public function checklogin() {
		$user->set('username',$f3->get('POST.username'));
		$user->set('password',md5($f3->get('POST.password')));
		$auth=new \Auth($user, array('id'=>'username','pw'=>'password'));
		$auth->login($f3->get('POST.username'),md5($f3->get('POST.password')));
	}
}