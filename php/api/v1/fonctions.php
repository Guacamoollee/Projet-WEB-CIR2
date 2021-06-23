<?php
    //Cette fonction crée et retourne l'objet PDO de connection à la database.
    function databaseConnect($DB_SERVER, $DB_NAME, $DB_USER, $DB_PASSWORD) {
        try {
            $databaseObject = new PDO("mysql:host=".$DB_SERVER.";dbname=".$DB_NAME.";charset=utf8", $DB_USER, $DB_PASSWORD);
            $databaseObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            error_log("ERROR: ".$exception->getMessage());
            return false;
        }
        return $databaseObject;
    }

    //Cette fonction prépare et transmet la requête à la database et retourne la réponse
	function databaseRequest($databaseObject, $request, $params=[]) {
		try {
			$statement = $databaseObject->prepare($request);
			$statement->execute($params);
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $exception) {
			error_log("ERROR: ".$exception->getMessage());
			return false;
		}
		return $result;
	}
?>