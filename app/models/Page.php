<?php

class Page extends DB\SQL\Mapper {

    public function __construct(DB\SQL $db) {
        parent::__construct($db,'pages');
    }

    public function all() {
        $this->load();
        return $this->query;
    }
    
	public function getExtras($site) {
        $result = $this->load();
		/*$options=array(
		  'order'=>'menu_order ASC',
		  'group'=>NULL,
		  'limit'=>'',
		  'offset'=>0
		);*/
		$linked_products=$result->find(array('site=? AND is_a_product=? AND linked_product>?',$site ,1,0),array('order'=>'menu_order ASC'));
        return $linked_products;
    }
	
	public function pages($site) {
        $result = $this->load();

		$products=$result->find(array('(site=? OR site=? OR site=? ) AND is_a_product=?',$site , 'nl' ,'fr',0),array('order'=>'menu_order ASC'));
        return $products;
    }

	public function productPages($site) 
	{
        $result = $this->load();
		$products=$result->find(array('site=? AND is_a_product=?',$site,1),array('order'=>'menu_order ASC'));
        return $products;
    }
	public function productList($site) 
	{
		/* random select:
			SELECT * FROM tbl WHERE id IN 
		   (SELECT id FROM (SELECT id FROM tbl ORDER BY RAND() LIMIT 10) t)  //subquery because VERY slow on nonindexed column https://stackoverflow.com/questions/4329396/mysql-select-10-random-rows-from-600k-rows-fast
		*/
        $products = $this->db->exec("SELECT id, page_title, page_name, short_description, price FROM pages WHERE is_a_product=1");
        return $products;
    }
	
	public function productNav($site) {
        $result = $this->load();

		$products=$result->find(array('site=? AND is_a_product=? AND show_in_menu=?',$site,1,1),array('order'=>'menu_order ASC'));
        return $products;
    }
	
	public function getProducts($site) {
        $result = $this->load();

		$products=$result->find(array('site=? AND is_a_product=? AND linked_product=?',$site,1,0),array('order'=>'menu_order ASC'));
        return $products;
    }
	
    public function add() {
		$this->copyFrom('POST');
        $this->save();
    }

    public function getById($id) {
        $this->load(array('id=?',$id));
        $this->copyTo('POST');
    }
    public function getByPagename($site,$lang,$page_name) {
        $this->load(array('page_name=?',$page_name));
        $this->copyTo('POST');
    }

    public function getProductByName($page_name) {
        $this->load(array(' page_name=?',$page_name));
        $this->copyTo('POST');
    }

    public function edit($id) {
        $this->load(array('id=?',$id));
        $this->copyFrom('POST');
        $this->update();
    }

    public function delete($id) {
        $this->load(array('id=?',$id));
        $this->erase();
    }
}
