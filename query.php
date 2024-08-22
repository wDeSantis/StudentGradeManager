<?php
// fonction qui ouvre la connexion à la base de données
    function openConnexion(){
        require_once 'login.php';
        try{
            $pdo = new PDO($attr,$user,$pass,$opts);
            return $pdo;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
    }
    
    // fonction qui affiche les évaluations de chaque cour complété
    function affichernotesind(){
      // ouverture de connnexion
        $pdo = openConnexion();
        // requête qui sélectionne les évaluations complétées
        $query = "SELECT cours.id,cours.description,evaluations.evaluation,resultats.note FROM cours
                  JOIN evaluations ON cours.id = evaluations.codeCours
                  JOIN resultats ON resultats.id = evaluations.id";
        $result = $pdo->query($query);
        // début du tableau pour afficher les évaluations
            echo "<table border='1' width=1000 style='margin: 0 auto;'>";
            echo "<tr><th>ID</th><th>Description</th><th>Evaluation</th><th>Note</th></tr>";
        // boucle qui affiche chaque évaluation dans le tableau
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            echo "<form method='post'>";
            echo "<tr>";
            echo "<td><label for='id'>".$row["id"]."</label><input type='hidden' name='id' value='".$row["id"]."'></td>";
            echo "<td width='450px'><input type='text' name='description' style='width: 450px;' value='".$row["description"]."'></td>";
            echo "<td width='200px'><input type='text' name='evaluation' style='width: 200px;' value='".$row["evaluation"]."'></td>";
            echo "<td width='100px'><input type='number' min='0' max='100' name='note' style='width: 100px;' value='".$row["note"]."'></td>";
            echo "<td width='60px'><button type='submit' name='modifier' value='yes'>Modifier</button></td>";
            echo "</tr>";
            echo "</form>";

        }
        // fermeture de la table
        echo "</table>";
        $pdo = null;
    }


    
 // fonction qui affiche le tableau avec les moyennes
    function affichermoyenne(){
        $pdo = openConnexion();
        // requête qui affiche les cours qui sont complété avec plus de 3 évaluations
        $query = "SELECT DISTINCT cours.id, cours.description
                FROM cours
                JOIN evaluations ON cours.id = evaluations.codeCours
                JOIN resultats ON resultats.id  = evaluations.id
                WHERE resultats.id = evaluations.id
                GROUP BY cours.id, cours.description
                HAVING COUNT(evaluations.id) >= 3
                ORDER BY FIELD(cours.id, 'PPA', 'DW1', 'ARP', 'DW2', 'AWB', 'PO1', 'PO2', 'BD1', 'BD2', 'TDD', 'DCS', 'PWB', 'DM1', 'DM2', 'INF', 'NTE', 'DGP', 'P11', 'P12', 'PFE')";
        $result = $pdo->query($query);
        // début du tableau
        echo "<table border='1' width=1000 style='margin: 0 auto;'>";
        echo "<tr><th>ID</th><th>Description</th><th>Note</th></tr>";

        // sous-requête qui calcule la moyenne par cours et sélectionne les cours
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            $query = "SELECT cours.id, GROUP_CONCAT(resultats.note) AS notes, SUM((resultats.note * evaluations.ponderation) / 100) AS moyenne FROM cours
                 JOIN evaluations ON cours.id = evaluations.codeCours
                 JOIN resultats ON evaluations.id = resultats.id 
                 WHERE evaluations.codeCours = '".$row["id"]."'
                 GROUP BY cours.id
                 HAVING COUNT(evaluations.id) >= 3
                 ORDER BY FIELD(cours.id, 'PPA', 'DW1', 'ARP', 'DW2', 'AWB', 'PO1', 'PO2', 'BD1', 'BD2', 'TDD', 'DCS', 'PWB', 'DM1', 'DM2', 'INF', 'NTE', 'DGP', 'P11', 'P12', 'PFE')";
                
            $subresult = $pdo->query($query);
            $moyRow = $subresult->fetch(PDO::FETCH_ASSOC);
            //affichage de la moyenne dans le tableau pour chaque cours
            if($moyRow['moyenne'] != null){
                $moyenne = $moyRow['moyenne'];
            echo "<form method='post'>";
            echo "<tr>";
            echo "<td width='40px'><label for='id'>".$row["id"]."</label></td>";
            echo "<td width='350px'><label for='description' style='width: 350px;'>".$row["description"]."</label>"."</td>";
            echo "<td width='40px'><label for='note' id='note'>".($moyenne !== null ? number_format($moyenne, 2) : 'Note')."</label></td>"; // affichage de la moyenne pour chaque cour
            echo "<tr>";
            echo "</form>";
            }
        }
        $pdo = null;

    }
    
    function affichermoygeneral(){
        $cnt = 0;
        $moy = 0;
        $pdo = openConnexion();
        // requête qui affiche les cours qui sont complété avec plus de 3 évaluations
        $query = "SELECT DISTINCT cours.id, cours.description
                FROM cours
                JOIN evaluations ON cours.id = evaluations.codeCours
                JOIN resultats ON resultats.id  = evaluations.id
                WHERE resultats.id = evaluations.id
                GROUP BY cours.id, cours.description
                HAVING COUNT(evaluations.id) >= 3
                ORDER BY FIELD(cours.id, 'PPA', 'DW1', 'ARP', 'DW2', 'AWB', 'PO1', 'PO2', 'BD1', 'BD2', 'TDD', 'DCS', 'PWB', 'DM1', 'DM2', 'INF', 'NTE', 'DGP', 'P11', 'P12', 'PFE')";
        $result = $pdo->query($query);

        // sous-requête qui calcule la moyenne par cours et sélectionne les cours
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            $query = "SELECT cours.id, GROUP_CONCAT(resultats.note) AS notes, SUM((resultats.note * evaluations.ponderation) / 100) AS moyenne FROM cours
                 JOIN evaluations ON cours.id = evaluations.codeCours
                 JOIN resultats ON evaluations.id = resultats.id 
                 WHERE evaluations.codeCours = '".$row["id"]."'
                 GROUP BY cours.id
                 HAVING COUNT(evaluations.id) >= 3
                 ORDER BY FIELD(cours.id, 'PPA', 'DW1', 'ARP', 'DW2', 'AWB', 'PO1', 'PO2', 'BD1', 'BD2', 'TDD', 'DCS', 'PWB', 'DM1', 'DM2', 'INF', 'NTE', 'DGP', 'P11', 'P12', 'PFE')";
                
            $subresult = $pdo->query($query);
            $moyRow = $subresult->fetch(PDO::FETCH_ASSOC);
            //affichage de la moyenne dans le tableau pour chaque cours
            if($moyRow['moyenne'] != null){
                $moyenne = $moyRow['moyenne'];
            $cnt++;
            $moy += $moyenne;
            }
        }
        $moyennegen = $moy / $cnt;
        $pdo = null;
        
    }     


    // fonction qui permet de modifier les informations d'un cours
    function modifierinfo(){
        // ouverture de connexion
        $pdo = openConnexion();
        $codeCours = $_POST["id"];
        $description = $_POST["description"];
        $eval = $_POST["evaluation"];
        $note = $_POST["note"];
        // requete qui permet la modification des notes
        $query = "UPDATE cours
                 JOIN  evaluations ON cours.id = evaluations.codeCours
                 JOIN resultats ON resultats.id = evaluations.id
                 SET cours.description = '$description',
                     note = '$note'
                     WHERE cours.id = '$codeCours' AND evaluations.evaluation = '$eval'";
        $result = $pdo->query($query);
        if ($result){
            echo "Enregistrement réussit!";
        } else {
            echo "Échec de l'enregistrement";
         }
    }


    // fonction qui permet l'ajout de note d'une évaluation
    function ajoutNoteEval(){
        //ouverture de connexion
        $pdo = openConnexion();
        $note = $_POST["txtnote"];
        // si les 2 champs sont remplis avec des données
        if (isset($_POST["lsteval"]) && isset($_POST["lstcours"])){
            $nomeval = $_POST["lsteval"];
            $nomcours = $_POST["lstcours"];
            // requête qui sélectionne le id qui correspond a l'évaluation et au cours
            $query = "SELECT evaluations.id FROM evaluations
                 WHERE evaluations.codeCours = '$nomcours' AND evaluations.evaluation = '$nomeval'
                  AND evaluations.id NOT IN (SELECT id FROM resultats)";
            $result = $pdo->query($query);
            $idcours = $result->fetch(PDO::FETCH_COLUMN);
               //si la note n'est pas vide
                if (!empty($note)) {
                    // si la requête retourne quelque chose 
                    if ($idcours !== false){
                        $query = "INSERT INTO resultats(id,note)
                                  VALUES ($idcours, $note)";
                        $result = $pdo->query($query);   
                        echo "Ajout réussie";       
                    } else { // sinon évaluation déjà attribué
                        echo "La note pour cette évaluation de ce cours est déjà attribuée";  
                    } 
                } else { // sinon note non entrer
                    echo "Vous devez entrer une note avant d'ajouter";
                }  
        } 
    }
   
    // si le bouton affichernotes est appuyé
    if(isset($_POST["affichernotes"])){
        if($_POST["affichernotes"] == "yes"){
            affichernotesind();
        }
    }
    // si le bouton modifier est appuyé
    if(isset($_POST["modifier"])){
        if($_POST["modifier"] == "yes"){
            modifierinfo();
        }
    }
    // si le bouton affichermoyenne est appuyé
    if(isset($_POST["affichermoyenne"])){
        if($_POST["affichermoyenne"] == "yes"){
            affichermoyenne();
        }
    }
    // si le bouton ajoutereval est appuyé
    if(isset($_POST["ajouteval"])){
        if($_POST["ajouteval"] == "yes"){
            ajoutNoteEval();
        }
    }
    

?>