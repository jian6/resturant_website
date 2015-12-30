<?php

	class Menuitem
	{
		private $itemName, $description, $price;
		
		public function __construct ( $name, $des, $pri) {
			$this->itemName = $name;
			$this->description = $des;
			$this->price = $pri;
		}
		
		public function get_itemName(){
			return $this->itemName;
		}
		
		public function get_description(){
			return $this->description;
		}
		
		public function get_price(){
			return $this->price;
		}

		
	}

?>