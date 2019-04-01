<?php

class PageController extends Controller {
	
	public function homepage()
	{
		$this->f3->set('view','page/homepage.htm');
	}
}