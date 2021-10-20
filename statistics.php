<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control</title>
</head>
<h1> Estadisticas del juego:</h1>
<form method="post">
    <label>Juego: </label>
    <input type="text" name="juego">
    <br><label>Nombre del equipo: </label>
    <input type="text" name="nombreEquipo">
    <br><label>Niembros del equipo: </label>
    <input type="number" name="niembrosEquipo">
    <br><label>Puntuacion: </label>
    <input type="number" name="puntuacion">
    <br><label>Ganada: </label>
    <input type="text" name="ganada">
    <br><label>Fecha: </label>
    <input type="date" name="fecha">
    <br><input type="submit" value="enviar">

</form>
<?php
    class Statistics {

        private $game, $teamName, $teamMembers, $score, $won, $date;
        
        public function __construct ($game, $teamName, $teamMembers, $score, $won, $date){
            $this->game = $game;
            $this->teamName = $teamName;
            if($teamMembers<3 || $teamMembers>5){
                echo "El campo numero de niembros se ha rellenado mal";
            }
            $this->teamMembers = $teamMembers;
            $this->score = $score;
            $this->won = $won;
            $this->date = $date;
        }

        public function getGame(){
            return $this->game;
        }

        public function getTeamName(){
            return $this->teamName;
        }

        public function getTeamMembers(){
            return $this->teamMembers;
        }

        public function getScore(){
            return $this->score;
        }

        public function getWon(){
            return $this->won;
        }

        public function getDate(){
            return $this->date;
        }   

        public function __toString(){
            return $this->getGame() . ", " .$this->getTeamName() . ", " . $this->getTeamMembers() . ", " .  $this->getScore() . ", " . $this->getWon() . ", " . $this->getDate() ;
        }
        public function juego_bien($juego){
            if($juego == "LoL" || $juego == "WoW" || $juego == "Valorant" || $juego == "Fornite" || $juego == "Minecraft"){
                return true;
            }
            return false;
        }

        public function niembros_bien($niembros){
            if($niembros>3 || $niembros<5){
                return true;
            }
            return false;
        }

        public function puntuacion_bien($puntuacion){
            if($puntuacion>0){
                return true;
            }
            return false;
        }

        public function pganada_bien($ganada){
            if($ganada=="si" || $ganada=="no"){
                return true;
            }
            return false;
        }

    }

    
    class DBManager {

        ////////////////////////////////
        // CAMBIAR ESTOS 3 PARÁMETROS //
        ////////////////////////////////

        private $servername = "10.14.0.179";
        private $username = "Erick";
        private $schema = 'Erick';

        //////////////////////////////
        //////////////////////////////

        private $password = "DW32.Password";
        private $conn;

        function __construct(){
            // Create connection
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->schema);

            // Check connection
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            // echo "Connected successfully";
        }



        public function insertStatistics($statistics) {
            $sql = "INSERT INTO statistics (game, team_name, team_members, score, won, date) VALUES (";
            $sql .= "'" . $statistics-> getGame() . "',' " . $statistics->getTeamName() . "',' " . $statistics->getTeamMembers() . "', '" . 
                            $statistics->getScore() . "', '" . $statistics->getWon() . "', '" . $statistics->getDate() . "')";

            if ($this->conn->query($sql) === TRUE) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $this->conn->error;
            }
        }

        public function getStatistics(){
            
            $statsArray = array();

            if ($result = $this->conn->query("SELECT * FROM statistics")) {
                // echo "Returned rows are: " . $result -> num_rows;

                foreach ($result as $row){
                    $game = $row['game'];
                    $teamName = $row['team_name'];
                    $teamMembers = $row['team_members'];
                    $score = $row['score'];
                    $won = $row['won'];
                    $date = $row['date'];

                    $stats = new Statistics($game, $teamName, $teamMembers, $score, $won, $date);
                    $statsArray[] = $stats;
                }
                
                // Free result set
                $result -> free_result();
            }
            return $statsArray;
        }
    }

?>
