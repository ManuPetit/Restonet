<?php
	//		cls_local.php
	
	//		classe des éléments relatifs aux pays, regions, départements et villes
	class Local
	{
		//retrouve toutes les regions
		public static function GetRegions()
		{
			//requete
			$sql = 'CALL get_regions()';
			//excution et renvoie le resultat
			return DatabaseHandler::GetAll($sql);
		}
		
		public static function GetDepartementParID($id)
		{
			//requete
			$sql = 'Call get_departement_par_id(:dept_id)';
			$params=array(':dept_id' => 39);
			return DatabaseHandler::GetRow($sql,$params);
		}
		
		public static function GetVilleParCodePostal($codepostal)
		{
			//requete
			$sql = 'CALL get_ville_par_cp(:code_postal)';
			$params = array(':code_postal' => $codepostal);
			return DatabaseHandler::GetAll($sql,$params);
		}
			
	}