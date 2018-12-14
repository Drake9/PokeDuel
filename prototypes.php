<?php

class attackdex{
	
	public $attackdex = array("cardID", "attackName", "attackType", "attackCategory", "attackPower", "attackCost", "attackKeywords", "attackDescription", "attackSignature");
	
	function __construct(){
		$data = getAttackdex();
		$size = count($data);
		
		for($index=1; $index<=$size; $index++){
			$this->attackdex[$index]['cardID'] = $data[$index]['id'];
			$this->attackdex[$index]['attackName'] = $data[$index]['attackname'];
			$this->attackdex[$index]['attackType'] = $data[$index]['type'];
			$this->attackdex[$index]['attackCategory'] = $data[$index]['category'];
			$this->attackdex[$index]['attackPower'] = $data[$index]['power'];
			$this->attackdex[$index]['attackCost'] = $data[$index]['cost'];
			$this->attackdex[$index]['attackKeywords'] = $data[$index]['keywords'];
			$this->attackdex[$index]['attackDescription'] = $data[$index]['description'];
			$this->attackdex[$index]['attackSignature'] = $data[$index]['signature'];
		}
	}
}

?>