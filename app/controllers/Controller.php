<?php

class Controller {

	protected $f3;
	protected $db;

    function beforeroute() {
		if($this->f3->get('SESSION.logged_in'))
		{
			if(time() - $this->f3->get('SESSION.timestamp') > $this->f3->get('auto_logout')) 
			{
				$this->f3->clear('SESSION');
				$this->f3->reroute('/login');
			} 
			else {
				$this->f3->set('SESSION.timestamp', time());
			}
		}
		$csrf_page = $this->f3->get('PARAMS.0'); //URL route !with preceding slash!

		if( NULL === $this->f3->get('POST.session_csrf') )
		{
			$this->f3->CSRF = $this->f3->session->csrf();
			$this->f3->copy('CSRF','SESSION.'.$csrf_page.'.csrf');
		}
		if ($this->f3->VERB==='POST')
		{
			if(  $this->f3->get('POST.session_csrf') ==  $this->f3->get('SESSION.'.$csrf_page.'.csrf') ) 
			{	// Things check out! No CSRF attack was detected.
				$this->f3->set('CSRF', $this->f3->session->csrf()); // Reset csrf token for next post request
				$this->f3->copy('CSRF','SESSION.'.$csrf_page.'.csrf');  // copy the token to the variable
			}
			else
			{	// DANGER: CSRF attack!
				$this->f3->error(403); 
			}
		}
		
		$access=Access::instance();
		$access->policy('allow'); // allow access to all routes by default
		$access->deny('/admin*');
		
		// admin routes
		$access->allow('/admin*','100'); //100 = admin ; 10 = superuser ; 1 = user
		$access->deny('/user*');
		// user login routes
		$access->allow('/user*',['100','10','1']);

		$access->authorize($this->f3->exists('SESSION.user_type') ? $this->f3->get('SESSION.user_type') : 0 );
		
    }

	function afterroute() {
		echo Template::instance()->render('layout.htm');
	}

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
}
