<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Projet</title>
</head>
<body>
    <header class="center">
        <h1 class="center blue italic">William De Santis</h1>
        <h2 class="center blue italic">645371-884 | Programmeur-analyste</h2><br>
        <label for="moyenne">Moyenne :</label>
        <input type="text" id="textmoy" disabled="disabled" style='width: 100px;'><br><br><br>
    </header>
    <form action="index.php" method="post">
 
        <table>
            <tr>
                <td><label for="codeCours" name="lblcodeCours">Code de cours :</label></td>
                <td><select name='lstcours' size="1">
                    <option value="PPA">PPA</option>
                    <option value="DW1">DW1</option>
                    <option value="ARP">ARP</option>
                    <option value="DW2">DW2</option>
                    <option value="AWB">AWB</option>
                    <option value="PO1">PO1</option>
                    <option value="PO2">PO2</option>
                    <option value="BD1">BD1</option>
                    <option value="BD2">BD2</option>
                    <option value="TDD">TDD</option>
                    <option value="DCS">DCS</option>
                    <option value="PWB">PWB</option>
                    <option value="DM1">DM1</option>
                    <option value="DM2">DM2</option>
                    <option value="1NF">1NF</option>
                    <option value="NTE">NTE</option>
                    <option value="P11">P11</option>
                    <option value="P12">P12</option>
                    <option value="PFE">PFE</option>
                </select><br></td>
            </tr>
            <tr>
                <td><label for="evaluation" name="lblevaluation">Évaluation :</label></td>
                <td><select name='lsteval' size="1">
                    <option value="Examen intra">Examen intra</option>
                    <option value="Examen final">Examen final</option>
                    <option value="Projet 1">Projet 1</option>
                </select></td>
            </tr>
            <tr>
                <td><label for="note" name="lblnote">Note :</label></td>
                <td><input type="number" min="0" max="100" name="txtnote"></td>
                <td><button type="submit" name="ajouteval" id="btnAjout" value="yes">Ajouter une note</button></td>
            </tr>        
        </table><br><br>
    <div>
        <hr>
        <button type="submit" name="affichernotes" value="yes">Afficher notes individuelles</button>
        <button type="submit" name="affichermoyenne" value="yes">Afficher moyenne par cours</button>
    </div>
    </form>
    <br>
    <?php
        require_once 'query.php';
    ?>
</body>
</html>