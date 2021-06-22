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
    // var_dump($resourceDemande);

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
/*
    else if($resourceDemande == 'utilisateur'){

        if($methodeRequete == 'GET'){
            $resourceDemande = array_shift($requete); //on prend la resources suivante
            $data = databaseRequest($db, "SELECT * FROM utilisateurs WHERE pseudo =:pseudo;",[":pseudo"=> $resourceDemande]);
            //a modif si besoin recherche partiel
        }
        
        else if($methodeRequete == 'POST'){
            
            $login = $_POST['pseudo'];
            $nom = $_POST['nom'];
            $tel = $_POST['tel'];
            $mdp = $_POST['mdp'];

            // var_dump($_POST);
            
            $data = databaseRequest($db, "INSERT INTO utilisateurs(pseudo,nom_utilisateur,telephone,hash_mdp) VALUES (':pseudo,:nom,:tel,:mdp'); COMMIT;",[
                ":pseudo"=>$login,
                ":nom"=>$nom,
                ":tel"=>$tel,
                ":mdp"=>$mdp
            ]);

        }
        
    }
*/
    else if($resourceDemande == 'trajets'){

        if($methodeRequete == 'GET'){
            $resourceDemande = array_shift($requete); //on prend la resources suivante
            //echo $resourceDemande;
            if($resourceDemande != ''){//si il y à quelque chose (un id) on affiche le trajet en question
                $data = databaseRequest($db, "SELECT * FROM trajets WHERE id_trajet = :id_trajet;",[":id_trajet"=> $resourceDemande]);
                // echo 'test';
            }
            else if(isset($_GET['destination']) && isset($_GET['isen_depart'])){//si l'on ne cherche pas par trajet spécifique, nous recherchons par destination et origine
                $data = databaseRequest($db,

                    "SELECT * FROM trajets t 
                    JOIN ville v ON t.code_insee = v.code_insee 
                    WHERE v.commune LIKE :destination 
                    AND t.depart_isen = 1
                    AND t.site_isen LIKE :isen_depart;",
                    
                    [":destination"=> $_GET['destination'], ":isen_depart"=> $_GET['isen_depart']]
                );
                
            }
            else if(isset($_GET['depart']) && isset($_GET['isen_destinataire'])){ 
                $data = databaseRequest($db, 

                    "SELECT * FROM trajets t 
                    JOIN ville v ON t.code_insee = v.code_insee 
                    WHERE v.commune LIKE :depart 
                    AND t.depart_isen = 0 
                    AND t.site_isen LIKE :isen_destinataire ;",

                    [":depart"=> $_GET['depart'], ":isen_destinataire"=> $_GET['isen_destinataire']]
                );
            }
        }
        else if($methodeRequete == 'POST'){

            $date_heure_depart = $_POST['date_heure_depart'];
            $date_heure_arrivee = $_POST['date_heure_arrivee'];
            $nb_places_max = $_POST['nb_places_max'];
            $nb_places_rest = $_POST['nb_places_rest'];
            $prix = $_POST['prix'];
            $adresse = $_POST['adresse'];
            $depart_isen = $_POST['depart_isen'];
            $code_insee = $_POST['code_insee'];
            $site_isen = $_POST['site_isen'];
            $pseudo_conducteur = $_POST['pseudo_conducteur'];

            $data = databaseRequest($db, "INSERT INTO trajets(date_heure_depart,date_heure_arrivee,nb_places_max,nb_places_restantes,prix,adresse,depart_isen,code_insee,site_isen,pseudo) VALUES (
                :date_heure_depart,
                :date_heure_arrivee,:
                :nb_places_max,
                :nb_places_restantes,
                :prix,
                :adresse,
                :depart_isen,
                :code_insee,
                :site_isen,
                ;pseudo_conducteur); COMMIT;",[
                
                ":date_heure_depart"=> $date_heure_depart,
                ":date_heure_arrivee"=> $date_heure_arrivee,
                ":nb_places_max"=> $nb_places_max,
                ":nb_places_restantes"=> $nb_places_restantes,
                ":prix"=> $prix,
                ":adresse"=> $adresse,
                ":depart_isen"=> $depart_isen,
                ":code_insee"=> $code_insee,
                ":site_isen"=> $site_isen,
                ":pseudo_conducteur"=> $pseudo_conducteur
            ]);
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