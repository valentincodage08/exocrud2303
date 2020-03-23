<?php
$nom_cinema=$_POST['nomCinema'];
$ville_cinema=$_POST['villeCinema'];
$adresse_cinema=$_POST['adresseCinema'];
$mail_cinema=$_POST['mailCinema'];
$numero_cinema=$_POST['numeroCinema'];
$numero_salle=$_POST['numeroSalle'];
$capacite_salle=$_POST['capaciteSalle'];

echo "$nom_cinema        $ville_cinema      $adresse_cinema       $mail_cinema       $numero_cinema <br>";

     $server = "db5000303630.hosting-data.io";
     $dbname = "dbs296617";
     $user = "dbu526536";
     $pass = "7f,7]WCg";
     $numero_salle=$_POST['numeroSalle'];
     $capacite_salle=$_POST['capaciteSalle'];

     try{
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $bdd = new PDO("mysql:host=$server;dbname=$dbname", $user, $pass, $pdo_options);

         $stmt = $bdd->prepare("INSERT INTO cinema (nom_cinema, ville_cinema, adresse_cinema, mail_cinema, telephone_cinema) VALUES (:nom_cinema, :ville_cinema, :adresse_cinema, :mail_cinema, :telephone_cinema)");
         $stmt->execute(array(
            ':nom_cinema' => $nom_cinema,
            ':ville_cinema'=>$ville_cinema,
            ':adresse_cinema'=>$adresse_cinema,
            ':mail_cinema'=>$mail_cinema,
            ':telephone_cinema'=>$numero_cinema));
         $stmt-> closeCursor();

         $numero_salle=$_POST['numeroSalle'];
         $capacite_salle=$_POST['capaciteSalle'];
         $stmt = $bdd->prepare("INSERT INTO salle (numero_salle, capacite_salle, id_cinema) VALUES ( :numero_salle, :capacite_salle, :id_cinema)");
         $stmt->execute(array(
         ':numero_salle' => $numero_salle,
         ':id_cinema' => 10,
         ':capacite_salle'=>$capacite_salle));
        
         $cinema = $bdd->query("SELECT * FROM cinema");

        while ($donnée = $cinema->fetchObject()){

            echo "      $donnée->nom_cinema/";
            echo "      $donnée->ville_cinema/";
            echo "      $donnée->adresse_cinema/";
            echo "      $donnée->mail_cinema/";
            echo "      $donnée->telephone_cinema<br>";      
        }

         $cinema->closeCursor();

         $cinema = $bdd->query("SELECT * FROM cinema");
        while ($i = $cinema->fetchObject()){
            echo "<br><h1>$i->nom_cinema</h1><br>";
            $salle= $bdd->query('SELECT * FROM salle WHERE id_cinema='.$i->id_cinema);
            while($j = $salle->fetchObject()){
                echo "salle  $j->numero_salle : ";
                echo " $j->capacite_salle places<br>";
            }
        }
        $cinema->closeCursor();

        $equipement=$bdd->query("SELECT id_equipement FROM avoir ");
        $salle=$bdd->query("SELECT id_salle FROM avoir");
        while(($y = $equipement->fetchObject()) && ($z= $salle->fetchObject())) {
            $numero=$bdd->query("SELECT numero_salle FROM salle WHERE id_salle=".$z->id_salle);
            $nomequip=$bdd->query("SELECT nom_equipement FROM equipement WHERE id_equipement=".$y->id_equipement);
            $idcine=$bdd->query("SELECT id_cinema FROM salle WHERE id_salle=".$z->id_salle);
            while(($k=$numero->fetchObject()) && ($l=$nomequip->fetchObject())  && ($p=$idcine->fetchObject())){

                $nomcine=$bdd->query("SELECT nom_cinema FROM cinema where id_cinema=".$p->id_cinema);
                while($q=$nomcine->fetchObject()){
                    echo "<br>dans la salle numero $k->numero_salle du cinema $q->nom_cinema il y a l'equipement $l->nom_equipement <br>";
                }
            }
        }
     }
    catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }
?>