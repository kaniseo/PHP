
<?php
	class Game {
		//global variables
		var $turn;
		var $position;
		var $win = false;
		var $turn_count = 0;
		
		//constructor
		function __construct($squares){
			$this->position = str_split($squares);
		}
		
		//start the game and also displays winner when game is over
		function gameStart(){
			if($this->winner('X') == true){
				echo "<center>GAME OVER <br> X wins </center>";
				$this->win = true;
			}else if($this->winner('O') == true){
				echo "<center>GAME OVER <br> O wins </center>";
				$this->win = true;
			}
			
			$this->turn();
			
			
			if($this->turn_count == 9 && $this->win == false){
				echo "<center>It's a tie</center>";
			}
			
			$this->display();
			
		}
		
		//calculates who's turn it is
		function turn(){
			
			for($i = 0; $i < 9; $i++){
				if($this->position[$i] == "X" ||
				   $this->position[$i] == "O"){
					$this->turn_count++;
				}
			}
			
			if(($this->turn_count%2) == 1){
				$this->computer_turn();
			}else{
				$this->turn = "X";
			}
		}
		
		//method for computing computer's actions
		function computer_turn(){
			$available_moves = array();
			for($i = 0; $i < 9; $i++){
				if ($this->position[$i] == '-'){
					array_push($available_moves, $i);
				}
			}
			if(count($available_moves) > 1){
				$random_move = $available_moves[array_rand($available_moves)];
				
				if($this->win == false){	
					$move_found = true;
					$this->newposition = $this->position;
					$this->newposition = $this->position;
					$this->newposition[$random_move] = "O";
					$move = implode($this->newposition);
					$link = '?board='.$move;
					header("Location:".$link);
					die();
				}
			}
		}
		
		//method that checks for winner
		function winner($token){
			
			//check for horizontal win combo
			for($row=0; $row<3; $row++){
				$result = true;
				for($col=0; $col<3; $col++){
					if($this->position[3*$row+$col] != $token){
						$result = false;
					}
				}
				if ($result == true){
					return $result;
				}
			}
			
			//check for vertical win combo
			for($row=0; $row<3; $row++){
				$result = true;
				for($col=0; $col<3; $col++){
					if($this->position[$row+($col*3)] != $token){
						$result = false;
					}
				}
				if ($result == true){
					return $result;
				}
			}
			
			//check for diagonal win combo
			//0-4-8 and 2-4-6
			for($diag=0; $diag<3; $diag+=2){
				$result = true;
				for($col=0; $col<3; $col++){
					if($this->position[$diag+($col*(4-$diag))] != $token){
						$result = false;
					}
				}
				if ($result == true){
					return $result;
				}
			}

			return $result;
		}
		
		//display function for the board
		function display(){
			echo '<link rel="stylesheet" type="text/css" href="mystyle.css">';
			echo '<table border="1" cols="3" style=" font-size:40px; font-weight:bold">';
			echo "<tr>";
			for ($pos = 0; $pos<9; $pos++){
				echo $this->show_cell($pos);
				if ($pos%3 == 2) echo "</tr><tr>";
			}
			echo "</tr>";
			echo "</table>";
		}
		
		//show the content of the cell in the board
		function show_cell($which){
			$token = $this->position[$which];
			if($token <> '-') return '<td>'.$token.'</td>';
			$this->newposition = $this->position;
			$this->newposition = $this->position;
			$this->newposition[$which] = "X";
			$move = implode($this->newposition);
			$link = '?board='.$move;
			
			if($this->win == false){
				return '<td class="unselected"><a href="'.$link.'">-</a></td>';
			}else{
				return '<td></td>';
			}
			
		}
		
		//method for handling game restart
		function restart_game(){
			$link = '?board='."---------";
			echo '<br><br><br>';
			echo '<a href="'.$link.'" class="button"><center>Reset Board</center></a>';
		}
	}

	$game = new Game($_GET['board']);
	echo '<h1> <center>COMP 4711 TIC TAC TOE GAME </center></h1>';
	echo '<div style="width:350px; margin:0 auto">';
	$game->gameStart();
	$game->restart_game();
	echo '</div>';	
	
?>
	