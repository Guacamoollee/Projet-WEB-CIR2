<?php
    require_once('fonctions.php');

    $db = databaseConnect("localhost", "user4", "root", "");

	//En cas de problème de connection à la database, on retourne directement une erreur 503.
	if(!$db){
		header("HTTP/1.1 503");
		exit;
	}

    $methodeRequete = $_SERVER['REQUEST_METHOD']; //recup la méthode (GET POST PUT ou DELETE)
    $requete = substr($_SERVER['PATH_INFO'], 1); // recupère le chemin
    $requete = explode('/', $requete); //découpe la requete
    $resourceDemande = array_shift($requete);

    $data = false;

    if($resourceDemande == 'isen'){
        if($methodeRequete == 'GET'){
            $data = databaseRequest($db, "SELECT * FROM isen;");
            // var_dump($data);
            // echo $resourceDemande;
            // echo $methodeRequete;
        }
    }

    else if($resourceDemande == 'communes'){
        if($methodeRequete == 'GET'){

            $resourceDemande = array_shift($requete); //on prend la resources suivante
            if($resourceDemande != ''){//si il y à quelque chose (un code insee) on demande les info de cette ville
                $data = databaseRequest($db, "SELECT * FROM ville WHERE code_insee =:code_insee;",[":code_insee"=> $resourceDemande]);
            }
            //sinon on recherche par code postal
            else if(isset($_GET['CodePostal'])){
                $data = databaseRequest($db, "SELECT * FROM ville WHERE code_postal = :code_postal;",[":code_postal"=> $_GET['CodePostal']]);
            }
            //sinon on recherche par nom de ville
            else if(isset($_GET['commune'])){
                $data = databaseRequest($db, "SELECT * FROM ville WHERE commune LIKE :commune;",[":commune"=> $_GET['commune'] ]);
                //un % doit être ajouté dans la requete pour rendre cette dernière possible sans le nom exacte de la commune (ex: Bres -> Brest)
            }
        }        
    }

    else if($resourceDemande == 'utilisateur'){

        if($methodeRequete == 'GET'){
            $resourceDemande = array_shift($requete); //on prend la resources suivante
            $data = databaseRequest($db, "SELECT * FROM utilisateurs WHERE pseudo =:pseudo;",[":pseudo"=> $resourceDemande]);
            //a modif si besoin recherche partiel
        }
        /*
        else if($methodeRequete == 'POST'){ //pas réussi à tester
            
            $login = $_POST['login'];
            $nom = $_POST['nom'];
            $tel = $_POST['tel'];
            $mdp = $_POST['mdp'];

            echo '<pre>';
            var_dump($_POST);
            echo '</pre>',

            $data = databaseRequest($db, "INSERT INTO utilisateurs(pseudo,nom_utilisateur,telephone,hash_mdp) VALUES (':pseudo,:nom,:tel,:mdp'); COMMIT;",[
                ":pseudo"=>$login,
                ":nom"=>$nom,
                ":tel"=>$tel,
                ":mdp"=>$mdp
            ]);

        }
        */
    }

    else if($resourceDemande == 'trajets'){

        if($methodeRequete == 'GET'){
            $resourceDemande = array_shift($requete); //on prend la resources suivante
            //echo $resourceDemande;
            if($resourceDemande != ''){//si il y à quelque chose (un id) on affiche le trajet en question
                $data = databaseRequest($db, "SELECT * FROM trajets WHERE id_trajet = :id_trajet;",[":id_trajet"=> $resourceDemande]);
            }
            else if(){
                
            }
        }
    }



    //envoie des données
    
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-control: no-store, no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('HTTP/1.1 200 OK');
    echo json_encode($data);
    
    exit;

?>