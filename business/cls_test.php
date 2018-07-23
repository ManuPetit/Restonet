<?php
//		cls_test.php
//		pour tester les slashes

class Tester{
	private $_mNom;
	private $_mPrenom;
	private $_mAdresse;
	private $_mDesc;
	private $_mID;
	
	// propriete ID
	public function GetID(){
		return $this->_mID;
	}
	
	//propriéte nom
	public function SetNom($nom){
		$result = NULL;
		$nom = trim(stripslashes($nom));
		if ($nom == '') {
			$result = 'Ce champ ne peut pas être vide';
			return $result;
		}
		if (!preg_match('/^[^<>?$_"]{3,80}$/u', $nom)) {
			$result = 'Des caractères non valides(<,>,_,$,? ou ") ont été saisis dans ce champ';
			return $result;
		}
		$this -> _mNom = $nom;
		return $result;
	}
	
	public function GetNom(){
		return $this->_mNom;
	}
	
	//propriete prenom
	public function SetPrenom($prenom){
		$result = NULL;
		$prenom = trim(stripslashes($prenom));
		if ($prenom == '') {
			$result = 'Ce champ ne peut pas être vide';
			return $result;
		}
		if (!preg_match('/^[^<>?$_"]{3,80}$/u', $prenom)) {
			$result = 'Des caractères non valides(<,>,_,$,? ou ") ont été saisis dans ce champ';
			return $result;
		}
		$this -> _mPrenom = $prenom;
		return $result;		
	}
	
	public function GetPrenom(){
		return $this->_mPrenom;
	}
	
	//Adresse
	public function SetAdresse($adresse){
		$result = NULL;
		$adresse = trim(stripslashes($adresse));
		if ($adresse == '') {
			$result = 'Ce champ ne peut pas être vide';
			return $result;
		}
		if (!preg_match('/^[^<>?$_"]{4,80}$/u', $adresse)) {
			$result = 'Des caractères non valides(<,>,_,$,? ou ") ont été saisis dans ce champ';
			return $result;
		}
		$this -> _mAdresse = $adresse;
		return $result;				
	}
	
	public function GetAdresse(){
		return $this->_mAdresse;
	}
	
	//description
	public function SetDescription($desc){
		$result = NULL;
		$desc = trim(stripslashes($desc));
		if ($desc == '') {
			$result = 'Ce champ ne peut pas être vide';
			return $result;
		}
		if (!preg_match('/^[^<>"]{3,10000}$/u', $desc)) {
			$result = 'Des caractères non valides(<,> ou ") ont été saisis dans ce champ';
			return $result;
		}
		$this -> _mDesc = $desc;
		return $result;				
	}
	
	public function GetDescription(){
		return $this->_mDesc;
	}
	
	public function SaveDetail(){
		DatabaseHandler::SetBeginTransaction();
		echo '<pre>';
print_r($this);
echo('</pre>');
		try{
		$sql = "CALL test_add(:adr,:nNom,:pNom,:mDesc)";
		$params=array(':adr'=>$this->_mAdresse,':nNom'=>$this->_mNom,':pNom'=>$this->_mPrenom,':mDesc'=>$this->_mDesc);
		$this->_mID = DatabaseHandler::GetOne($sql,$params);
		DatabaseHandler::CommitTransaction();
		} catch(PDOException $e) {
			DatabaseHandler::RoolbackTransaction();
			DatabaseHandler::Close();
			trigger_error($e -> getMessage(), E_USER_ERROR);
		}
	}
	
	public function GetDetail($id){
		$sql = "CALL test_get(:iID)";
		$param = array(':iID'=>$id);
		$row = DatabaseHandler::GetRow($sql,$param);
		if (!empty($row)){
			$this->_mID=$id;
			$this->_mAdresse=$row['Adresse'];
			$this->_mNom=$row['Nom'];
			$this->_mPrenom=$row['Prenom'];
			$this->_mDesc=$row['Description'];			
		}
	}
	
	public static function GetNbreDetail(){
		$sql = "SELECT DISTINCT tID FROM table_otest";
		return DatabaseHandler::GetAll($sql);
	}
}
