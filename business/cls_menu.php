<?php
//		cls_menu.php
//		classe de création de menu

class Menu {
	//cette classe gère 'ensemble des elements d'un menu
	private $_menuID;
	private $_currentGroupeOrder = 1;
	private $_mGroupe = array();

	//fonction pour recuperer le nom d'un menu presta et prix
	public static function GetMenuNom($id) {
		$sql = 'CALL get_menunom_presta_parID(:mID)';
		$param = array(':mID' => $id);
		return DatabaseHandler::GetRow($sql, $param);
	}

	//menuID
	public function AddMenuID($id) {
		if ((!is_numeric($id)) || ($id < 1)) {
			return 'Valeur transmise invalide';
		}
		$this -> _menuID = $id;
		return NULL;
	}

	public function AddGroupeMenu($groupe) {
		$grp = new GroupeMenu();
		$result = $grp -> AddGroupe($groupe, $this -> _currentGroupeOrder);
		if (!is_null($result)) {
			return $result;
		}
		$this -> _mGroupe[] = $grp;
		$this -> _currentGroupeOrder++;
		return $result;
	}

	public function AddPlatGroupe($groupe, $plat) {
		$groupe = trim($groupe);
		if ($groupe == '') {
			return 'Valeur transmise invalide';
		}
		$result = 'toto';
		for ($i = 0; $i < count($this -> _mGroupe); $i++) {
			if ($this -> _mGroupe[$i] -> GetGroupe() == $groupe) {
				$result = $this -> _mGroupe[$i] -> AddPlatToGroupe($plat, $this -> _menuID);

			}
		}
		if (!is_null($result)) {
			return $result;
		}
		return null;
	}

	public function SaveMenu() {
		//on loop chaque groupe
		DatabaseHandler::SetBeginTransaction();
		for ($i = 0; $i < count($this -> _mGroupe); $i++) {
			$this -> _mGroupe[$i] -> SaveGroupe();
		}
		DatabaseHandler::CommitTransaction();
	}
	
	//mise à jour du menu
	public function UpdateMenu(){
		//on delete d'abord le menu dans la bd
		DatabaseHandler::SetBeginTransaction();
		$sql='CALL del_plat_menu(:pID)';
		$param=array(':pID'=>$this->_menuID);
		DatabaseHandler::Execute($sql,$param);
		$this->SaveUpdateMenu();
		DatabaseHandler::CommitTransaction();
	}
	private function SaveUpdateMenu(){
		for ($i = 0; $i < count($this -> _mGroupe); $i++) {
			$this -> _mGroupe[$i] -> SaveGroupe();
		}
	}
	
	//retrouve le nom d'un menu
	public static function GetMenuNomParID($id){
		$sql = 'CALL get_menu_nom_parID(:mID)';
		$param=array(':mID'=>$id);
		return DatabaseHandler::GetOne($sql,$param);		
	}
	
	//retrouve les éléments d'un menu
	public static function GetMenuItemParID($id){
		$sql ='CALL get_menu_item_parID(:mID)';
		$param =array(':mID'=>$id);
		return DatabaseHandler::GetAll($sql,$param);
	}
	
	public static function GetMenuGroupe($id){
		$sql='CALL get_groupe_menu_parID(:pID)';
		$param = array(':pID'=>$id);
		return DatabaseHandler::GetAll($sql,$param);
	}
}

class GroupeMenu {
	//cette classe gère les groupes de menu
	private $_mGroupeNom;
	private $_mGroupeOrder;
	private $_menuItem = array();

	//currentGroupe
	public function AddGroupe($groupe, $order) {
		$groupe = stripslashes($groupe);
		if ($groupe == '') {
			return 'Entrez un nom pour ce groupe';
		}
		if (!preg_match('/^[^<>"]{2,45}$/i', trim($groupe))) {
			return 'Des caractères non valides ont été saisis dans ce champ';
		}
		$this -> _mGroupeNom = $groupe;
		$this -> _mGroupeOrder = $order;
		return NULL;
	}

	public function GetGroupe() {
		return stripslashes($this -> _mGroupeNom);
	}

	//menuiten
	public function AddPlatToGroupe($plat, $id) {
		$item = new MenuItem();
		$result = $item -> AddNewPlat($plat, $this -> _mGroupeNom, $this -> _mGroupeOrder, $id);
		if (!is_null($result)) {
			return $result;
		}
		$this -> _menuItem[] = $item;
		return NULL;
	}

	//save menu
	public function SaveGroupe() {
		for ($i = 0; $i < count($this -> _menuItem); $i++) {
			//on loop chaque menu item pour les sauvegarder
			$this -> _menuItem[$i] -> SavePlat();
		}
	}

}

class MenuItem {
	//cette classe gère un élément du menu
	private $_mNom;
	private $_mGroupePlatNom;
	private $_mGroupePlatOrder;
	private $_mMenuID;

	//ajoute le nom d'un plat
	private function AddPlatNom($plat) {
		$plat = stripslashes($plat);
		if ($plat == '') {
			$result = 'Ce champ ne peut pas être vide';
			return $result;
		}
		if (!preg_match('/^[^<>"]{3,120}$/i', $plat)) {
			$result = 'Des caractères non valides ont été saisis dans ce champ';
			return $result;
		}
		$this -> _mNom = $plat;
		return NULL;
	}

	private function GetPlatNom() {
		return stripslashes($this -> _mNom);
	}

	//ajoute le nom du plat
	public function AddNewPlat($plat, $groupeNom, $groupeOrder, $menuID) {
		$result = $this -> AddPlatNom($plat);
		if (!is_null($result)) {
			return $result;
		}
		$this -> _mGroupePlatNom = $groupeNom;
		$this -> _mGroupePlatOrder = $groupeOrder;
		$this -> _mMenuID = $menuID;
		return NULL;
	}

	//fonction pour sauvegarder le plat
	public function SavePlat() {
		try {
			$sql = 'CALL add_plat_menu(:mNom,:mPlatID,:mGroupe,:mOrder)';
			$params = array(':mNom' => $this -> _mNom, ':mPlatID' => $this -> _mMenuID, ':mGroupe' => $this -> _mGroupePlatNom, ':mOrder' => $this -> _mGroupePlatOrder);
			DatabaseHandler::Execute($sql, $params);
		} catch(PDOException $e) {
			DatabaseHandler::RoolbackTransaction();
			DatabaseHandler::Close();
			trigger_error($e -> getMessage(), E_USER_ERROR);
		}
	}

}
