<?php
	class ContactInfo{
		private $id;
		private $name;
		private $phone;
		private $email;
		private $refer;
		
		function __construct($id, $name, $phone, $email, $refer){
			$this->setId($id);
			$this->setName($name);
			$this->setPhone($phone);
			$this->setEmail($email);
			$this->setRefer($refer);
		}
		
		public function getId(){
			return $this->id;
		}
		
		public function setId($id){
			$this->id = $id;
		}
		
		public function getName(){
			return $this->name;
		}
		
		public function setName($name){
			$this->name = $name;
		}
		
		public function getPhone(){
			return $this->phone;
		}
		
		public function setPhone($phone){
			$this->phone = $phone;
		}
		
		public function getEmail(){
			return $this->email;
		}
		
		public function setEmail($email){
			$this->email = $email;
		}
		
		public function getRefer(){
			return $this->refer;
		}
		
		public function setRefer($refer){
			$this->refer = $refer;
		}
	}
?>