<?php

class DAO
{

	public static function add($obj)
	{
		$db = DbConnect::getDb();
		$class = get_class($obj);
		$colonnes = $class::getAttributes();
		$requ = "INSERT INTO " . $class . "(";
		$values = "";
		$bindValue = [];

		for ($i = 1; $i < count($colonnes); $i++) {
			$methode = "get" . ucfirst($colonnes[$i]);
			if ($obj->$methode() != null) {
				$requ .= $colonnes[$i] . ",";
				$values .= ":" . $colonnes[$i] . ",";
			}
		}
		$requ = substr($requ, 0, strlen($requ) - 1);
		$values = substr($values, 0, strlen($values) - 1);
		$requ .= ") VALUES (" . $values . ")";

		$q = $db->prepare($requ);

		for ($i = 1; $i < count($colonnes); $i++) {
			$methode = "get" . ucfirst($colonnes[$i]);
			if ($obj->$methode() != null)
				$q->bindValue(":" . $colonnes[$i], $obj->$methode());
		}
		return $q->execute();
	}

	public static function update($obj)
	{
		$db = DbConnect::getDb();
		$class = get_class($obj);
		$colonnes = $class::getAttributes();
		$requ = "UPDATE " . $class . " SET ";

		for ($i = 1; $i < count($colonnes); $i++) {
			$requ .= $colonnes[$i] . "=:" . $colonnes[$i] . ",";
		}
		$requ = substr($requ, 0, strlen($requ) - 1);
		$requ .= " WHERE " . $colonnes[0] . "=:" . $colonnes[0];

		$q = $db->prepare($requ);

		for ($i = 0; $i < count($colonnes); $i++) {
			$methode = "get" . ucfirst($colonnes[$i]);
			$q->bindValue(":" . $colonnes[$i], $obj->$methode());
		}
		return $q->execute();
	}

	public static function delete($obj)
	{
		$db = DbConnect::getDb();
		$class = get_class($obj);
		$colonnes = $class::getAttributes();
		$methode = "get" . ucfirst($colonnes[0]);
		return $db->query("DELETE FROM " . $class . " WHERE " . $colonnes[0] . " = " . $obj->$methode());
	}

	/**
	 * Perform a SELECT query with JOIN support, using prepared statements for security.
	 * 
	 * @param array  $nomColonnes  Columns to select in the query, e.g. ['t.id', 't.name'].
	 * @param string $table        The primary table to select from, e.g. 'work_technologies'.
	 * @param array  $joins        Associative array of tables to join with, in the format ['table' => 'condition'], 
	 *                             e.g. ['technologies' => 'technologies.id = work_technologies.technology_id'].
	 * @param array  $conditions   Optional. Associative array of conditions for the WHERE clause, 
	 *                             e.g. ['work_technologies.work_id' => $workId].
	 * @param string $orderBy      Optional. Column(s) to order by, e.g. 't.name DESC'.
	 * @param string $limit        Optional. Limit the number of results, e.g. '10'.
	 * @param bool   $api          Optional. If true, return the result as a string; if false, return as objects.
	 * @param bool   $debug        Optional. If true, output the generated SQL query for debugging.
	 * 
	 * @return array|false         Returns an array of associative arrays (if $api is true) or objects, or false on failure.
	 */
	public static function selectWithJoin(array $nomColonnes, string $table, array $joins, array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
		$db = DbConnect::getDb();

		// Reusing the existing elementSelect() function for the SELECT clause
		$cols = self::elementSelect($nomColonnes);
		$t = " FROM " . $table;

		// Building the JOIN clause
		$joinClause = '';
		foreach ($joins as $joinTable => $joinCondition) {
			$joinClause .= " JOIN $joinTable ON $joinCondition";
		}

		// Use existing conditionSelect() to build the WHERE clause
		$whereClause = '';
		if ($conditions != null) {
			$whereClause = self::conditionSelect($conditions); // Reuse existing conditionSelect
		}

		// Optional ORDER BY clause
		if ($orderBy != null) {
			$orderBy = " ORDER BY " . $orderBy;
		}

		// Optional LIMIT clause
		if ($limit != null) {
			$limit = " LIMIT " . $limit;
		}

		// Combine all parts into a single query string
		$query = $cols . $t . $joinClause . $whereClause . $orderBy . $limit;

		if ($debug) {
			var_dump($query); // Show the query if debugging is enabled
		}

		// Prepare the query for execution
		$stmt = $db->prepare($query);

		// Execute the query (no need to bind parameters here since conditionSelect already handles escaping)
		$stmt->execute();

		$liste = [];

		// Fetch the results
		while ($donnees = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$liste[] = $donnees; // Add each row to the result list
		}

		return $liste;
	}


	


	/**
	 *
	 * @param array $nomColonnes => contient le noms des champs désirés dans la requête.
	 * Exemple :  [nomColonne1,nomColonne2] => "SELECT nomColonne1, nomColonne2"
	 *
	 * @param string $table => contient Nom de la table sur laquelle la requête sera effectuée.
	 * Exemple : nomTable => "FROM nomTable"
	 *
	 * @param array $conditions => null par défaut, attendu un tableau associatif 
	 * qui peut prendre plusieurs formes en fonction de la complexité des conditions.
	 *  Exemples : tableau associatif
	 *  [nomColonne => '1'] => "WHERE nomColonne = 1"
	 *  [nomColonne => ['1','3']] => "WHERE nomColonne in (1,3)"
	 *  [nomColonne => '%abcd%'] => "WHERE nomColonne like "abcd" "
	 *  [nomColonne => '1->5'] => "WHERE nomColonne BETWEEN 1 and 5 "
	 *  Si il y a plusieurs conditions alors :
	 *  [nomColonne1 => '1', nomColonne2 => '%abcd%' ] => "WHERE nomColonne1 = 1 AND nomColonne2 LIKE "%abcd%"
	 *
	 * @param string $orderBy => null par défaut, contient un string qui contient les noms de colonnes et le type de tri
	 * Exemple :"nomColonne1 , nomColonne2 DESC" => "Order By nomColonne1 , nomColonne2 DESC"
	 *
	 * @param string $limit  => null par défaut, contient un string pour donner la délimitations des enregistrements de la BDD
	 * Exemples :
	 * "1" => "LIMIT 1"
	 * "1,2"=> "LIMIT 1,2"
	 *
	 * @param boolean $api => false par défaut, mettre true si on souhaite recevoir la réponse sous forme de string sinon sous forme d'objets.
	 *
	 * @param bool $debug => contient faux par défaut mais s'il on le met a vrai, on affiche la requete qui est effectuée.
	 *
	 * @return [array ou object] $liste => résultat de la requête revoie false si la requête s'est mal passé sinon renvoie un tableau.
	 */
	public static function select(array $nomColonnes, string $table, array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
	{
		$db = DbConnect::getDb();

		$string = json_encode($nomColonnes) . $table . json_encode($conditions) . $orderBy . $limit . $api . $debug;
		if (strpos($string, ";")) {
			return false;
		} else if (!empty($nomColonnes)  && ($table != null && $table != "")) {

			$cols = self::elementSelect($nomColonnes);

			$t = " FROM " . $table;

			if ($conditions != null) {
				$conditions = self::conditionSelect($conditions);
			}
			if ($orderBy != null) {
				$orderBy = " ORDER BY " . $orderBy;
			}
			if ($limit != null) {
				$limit = " LIMIT " . $limit;
			}

			// echo($cols . $t . $conditions . $orderBy . $limit);
			$q = $db->query($cols . $t . $conditions . $orderBy . $limit);
			if ($debug) // Si le debug est a true on affiche la requete qui est envoyée en base de données
			{
				var_dump($cols . $t . $conditions . $orderBy . $limit);
			}
			$liste = [];
			// var_dump($q);
			if (!$q) return false;
			while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) { // on récupère les enregistrements de la BDD
				if ($donnees != false) {
					// var_dump($donnees);
					// var_dump($table);
					// var_dump($liste);
					if ($api) { // On vérifie si api est a true, on renvoie un string sinon des objets liés a à la table donnée en paramètres.
						$liste[] = $donnees;
					} else {
						$liste[] = new $table($donnees);
					}
				}
			}

			return $liste;
		}
		return false;
	}

	/**
	 * Méthode privée qui sera appelée par la méthode select
	 *
	 * @param array $tab => Tableau de noms de colonnes ou agrégats de la BDD pour plus de détail allez voir la doc sur select.
	 * @return string => compose la partie SELECT de la méthode select
	 *
	 */
	private static function elementSelect($tab)
	{
		$temp = "SELECT ";
		foreach ($tab as $uneCol) {
			$temp .= $uneCol . ", ";
		}
		return substr($temp, 0, strlen($temp) - 2);
	}

	/**
	 * Méthode privée qui sera appelée par la méthode select
	 *
	 * @param array $conditions => tableaux qui contient les conditions pour plus de détail allez voir la doc sur select.
	 * @return string => compose la partie WHERE de la méthode select
	 *
	 */
	private static function conditionSelect($conditions, $OR = false)
	{
		$req = " WHERE ";
		foreach ($conditions as $nomColonne => $valeur) {
			if (is_array($valeur)) {
				// IN clause
				$req .= $nomColonne . " IN (" . implode(",", $valeur) . ") AND ";
			} else if (!(strpos($valeur, "%") === false)) {
				// LIKE clause
				$req .= $nomColonne . ' LIKE "' . $valeur . '" AND ';
			} else if (strpos($valeur, "->")) {
				// BETWEEN clause
				$tab = explode("->", $valeur);
				$req .= $nomColonne . " BETWEEN " . $tab[0] . " AND " . $tab[1] . " AND ";
			} else if (preg_match('/\(.+\)/', $valeur)) {
				// Subquery, no quotes
				$req .= $nomColonne . " = " . $valeur . " AND ";
			} else {
				// Standard condition, with quotes
				$req .= $nomColonne . " = \"" . $valeur . "\" AND ";
			}
		}
		return substr($req, 0, -4); // Remove the trailing ' AND '
	}

}
