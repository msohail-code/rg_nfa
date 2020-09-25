<?php 
/*$check_arr =array_unique( array ( "a","b","ε",' ' ,' ','a' ));
print_r($check_arr);
for ($i=0; $i < sizeof($check_arr); $i++) { 
	//echo strstr( "aR", $check_arr[$i] );
	if (strstr("aRε", $check_arr[$i])) {
		echo "matched";
	} else{
		echo "not matched";
	}
}

exit();*/
if (isset($_POST['rg_data'])) {
	$rg_data = $_POST['rg_data'];
	$all_stm = explode("\n", $rg_data);

	$variables_small = [];
	$all_rows =[];
	$low_char = [];
	$up_char = [];
	$point_cell =[];
	for ($i=0; $i < count($all_stm); $i++) {
		if ($all_stm[$i] == '' or $all_stm[$i] == NULL or empty($all_stm[$i])) {
		 	continue;
		 } 
		 
		$eachline =  explode("->", $all_stm[$i]);
		//echo $eachline[1]."<br/>";


		
		
		$point_cell[] = $eachline[0];
		
		
		$with_or = explode("|", $eachline[1]);

		$expresion[] = $eachline[1];
		
		
		for ($x=0; $x < count($with_or); $x++){
			//print_r(str_split($with_or[$x]));
			foreach (str_split($with_or[$x]) as $char) {
				
				//echo $char;
				if (ctype_lower($char)) {
					$variables_small[] = $char;
					$low_char[] = $char;
					//$up_char ='';
				} elseif(ctype_upper($char)){
					$up_char[] = $char;
					//$low_char = '';
				} elseif(!ctype_alpha($char) ){

					$variables_small[] = '~';
					$low_char[] = '~';
				}



				

			}

			
			
		}
		
	}
	$up_char = array_combine(range(0, count($up_char) + (-1)), array_values($up_char)); 

			/*echo "<br/>lOWER CHARS ";
			print_r($low_char);
			echo "<br/>UPPER chars ";
			print_r($up_char);
			echo "<br/> point cells ";
			print_r($point_cell);
			echo "<br/> expresions ";
			print_r($expresion);
			
			echo "<br/>";*/


			
	$all_headings = array_unique($variables_small);
	$unique_up_chars = array_unique($up_char);
	$all_headings = array_combine(range(0, count($all_headings) + (-1)), array_values($all_headings)); 
	
	//print_r($all_headings);

			for($i = 0; $i < count($point_cell); $i++){
				$all_rows[] = "<tr>";
				if ($i == 0) {
					$all_rows[$i] .= "<td>>$point_cell[$i]</td>";
				} elseif ($i== count($point_cell) - 1) {
					$all_rows[$i] .= "<td>* $point_cell[$i]</td>";
				}else{
					$all_rows[$i] .= "<td> $point_cell[$i]</td>";
				}

				for ($j=0; $j < count($all_headings); $j++) { 
					//$expresion[$i] = str_replace('~', 'ε', $expresion[$i]);
					
						if (strstr($expresion[$i], $all_headings[$j])) {
							
							$new_ex = explode("|", $expresion[$i]);
							//$new_ex = array_combine(range(0, count($new_ex) + (-1)), array_values($new_ex)); 
							for ($x=0; $x < count($new_ex); $x++) { 
								//echo "<br>";
								//echo $new_ex[$x].$all_headings[$j]." ";
								//echo "<br>";
								$simple_ex = str_split($new_ex[$x]);
								/*if ($j==2 && $i == 3) {
									echo $all_headings[$j];
									print_r($simple_ex );
								}*/
								

								for ($y=0; $y < count($simple_ex); $y++) { 
									if (ctype_upper($simple_ex[$y])) {
										//echo "<br>".$simple_ex[$y];
										$new_char[$i][] = $simple_ex[$y];
									} 
									/*elseif(!ctype_alpha($simple_ex[$y])){
										$new_char[$i][] = $simple_ex[$y];
									}*/
								}
							}
						} else{
							$new_char[$i][$j] = '';
						}
					
					/*echo "$expresion[$i], $all_headings[$j]";
					if($i == 1)
						break;
					if (!strpos($expresion[$i], $all_headings[$j])) {
						$all_rows[$i] .= "<td>$up_char[$i]</td>";
						$all_rows[$i] .= "<td> &#8709;</td>";
					}*/
				}
				/*if ($i == 3) {
					echo "<br>";
					echo "<br>";
					echo "<pre>";
					print_r($new_char);
					echo "</pre>";
					echo "<br>";
					echo "<br>";
				}*/

				for ($z=0; $z < count($new_char[$i]); $z++) { 
					if($z == count($point_cell)-1){
						continue;
					}
					/*print_r($new_char[$i]);
					echo $new_char[$i][$z];*/
					if($new_char[$i][$z] == ''){
						$all_rows[$i] .= "<td> &#8709;</td>";
					} else{
						$all_rows[$i] .= "<td>".$new_char[$i][$z]."</td>";
					}
				}

				
				$all_rows[$i] .= "</tr>";
			}


	echo "<div class='table_nfa_epsilon'><table class='table'><thead>";



	// Start of table header
	echo "<tr id='epsilon_nfa_head'><th></th>";
	foreach ($all_headings as $heading) {
		$t_heading = ($heading == '~')? "ε": $heading;
		echo "<th>".$t_heading."</th>";
	}
	echo "</tr></thead>";
	// End of table header
	foreach ($all_rows as $row) {
		echo $row;
	}
	echo "</table></div>";
	echo "<div class='table_nfa_epsilon'><button id='without_epsilon_btn' onclick='without_epsilon()' style='margin-top: 100px;' class='button'>To without &epsilon;</button></div><div class='table_nfa_epsilon' id='without_epsilon'></div>";
	echo '<div class="clear"></div>';
}



//Without epsilon
if (isset($_POST['no_epsilon'])) {
	$rg_data = $_POST['no_epsilon'];
	$all_stm = explode("\n", $rg_data);

	$variables_small = [];
	$all_rows =[];
	$low_char = [];
	$up_char = [];
	$point_cell =[];
	for ($i=0; $i < count($all_stm); $i++) {
		if ($all_stm[$i] == '' or $all_stm[$i] == NULL or empty($all_stm[$i])) {
		 	continue;
		 } 
		 
		$eachline =  explode("->", $all_stm[$i]);
		//echo $eachline[1]."<br/>";


		
		
		$point_cell[] = $eachline[0];
		
		
		$with_or = explode("|", $eachline[1]);

		$expresion[] = $eachline[1];
		
		
		for ($x=0; $x < count($with_or); $x++){
			//print_r(str_split($with_or[$x]));
			foreach (str_split($with_or[$x]) as $char) {
				
				//echo $char;
				if (ctype_lower($char)) {
					$variables_small[] = $char;
					$low_char[] = $char;
					//$up_char ='';
				} elseif(ctype_upper($char)){
					$up_char[] = $char;
					//$low_char = '';
				} 



				

			}

			
			
		}
		
	}
	$up_char = array_combine(range(0, count($up_char) + (-1)), array_values($up_char)); 

			/*echo "<br/>lOWER CHARS ";
			print_r($low_char);
			echo "<br/>UPPER chars ";
			print_r($up_char);
			echo "<br/> point cells ";
			print_r($point_cell);
			echo "<br/> expresions ";
			print_r($expresion);
			
			echo "<br/>";*/


			
	$all_headings = array_unique($variables_small);
	$unique_up_chars = array_unique($up_char);
	$all_headings = array_combine(range(0, count($all_headings) + (-1)), array_values($all_headings)); 
	
	//print_r($all_headings);

			for($i = 0; $i < count($point_cell); $i++){
				$all_rows[] = "<tr>";
				if ($i == 0) {
					$all_rows[$i] .= "<td>>$point_cell[$i]</td>";
				} elseif ($i== count($point_cell) - 1) {
					$all_rows[$i] .= "<td>* $point_cell[$i]</td>";
				}else{
					$all_rows[$i] .= "<td> $point_cell[$i]</td>";
				}

				$new_ex = explode("|", $expresion[$i]);

				for ($j=0; $j < count($all_headings); $j++) { 
					//$expresion[$i] = str_replace('~', 'ε', $expresion[$i]);
					
						if (strstr($expresion[$i], $all_headings[$j])) {
							
							//$new_ex = explode("|", $expresion[$i]);
							//$new_ex = array_combine(range(0, count($new_ex) + (-1)), array_values($new_ex)); 
							for ($x=0; $x < count($new_ex); $x++) { 
								//echo "<br>";
								//echo $new_ex[$x].$all_headings[$j]." ";
								//echo "<br>";
								$simple_ex = str_split($new_ex[$x]);
								/*if ($j==2 && $i == 3) {
									echo $all_headings[$j];
									print_r($simple_ex );
								}*/
								//print_r($simple_ex);

								for ($y=0; $y < count($simple_ex); $y++) { 
									if (ctype_upper($simple_ex[$y])) {
										//echo "<br>".$simple_ex[$y];
										$new_char[$i][] = $simple_ex[$y];
									} 
									/*elseif(!ctype_alpha($simple_ex[$y])){
										$new_char[$i][] = $simple_ex[$y];
									}*/
								}
							}
						}/*elseif (strstr($expresion[$i], '~')) {
							$simple_ex = str_split($expresion[$i]);
								echo "<br>";
								print_r($simple_ex);

								for ($k=0; $k < count($simple_ex); $k++) { 
									if (ctype_upper($simple_ex[$k])) {
										$new_char[$i][$y] = ','.$simple_ex[$k];
									}
								}
								break;
							//$new_char[$i][$j] = ','.;
						}*/ else{
							//echo $expresion[$i];
							$new_char[$i][] = '';
						}
					
					/*echo "$expresion[$i], $all_headings[$j]";
					if($i == 1)
						break;
					if (!strpos($expresion[$i], $all_headings[$j])) {
						$all_rows[$i] .= "<td>$up_char[$i]</td>";
						$all_rows[$i] .= "<td> &#8709;</td>";
					}*/
				}
				/*if ($i == 3) {
					echo "<br>";
					echo "<br>";
					echo "<pre>";
					print_r($new_char);
					echo "</pre>";
					echo "<br>";
					echo "<br>";
				}*/

				for ($z=0; $z < count($new_char[$i]); $z++) { 
					if($z >= count($point_cell)-2){
						continue;
					}
					/*print_r($new_char[$i]);
					echo $new_char[$i][$z];*/
					if($new_char[$i][$z] == ''){
						$all_rows[$i] .= "<td> &#8709;</td>";
					} else{
						$all_rows[$i] .= "<td>".$new_char[$i][$z]."</td>";
					}
				}

				
				$all_rows[$i] .= "</tr>";
			}


	echo "<div class='table_nfa_epsilon'><table class='table'><thead>";



	// Start of table header
	echo "<tr id='epsilon_nfa_head'><th></th>";
	foreach ($all_headings as $heading) {
		$t_heading = ($heading == '~')? "ε": $heading;
		echo "<th>".$t_heading."</th>";
	}
	echo "</tr></thead>";
	// End of table header
	foreach ($all_rows as $row) {
		echo $row;
	}
	echo "</table></div>";
	echo '<div class="clear"></div>';

}


if(isset($_POST['input_state']) && isset($_POST['nfa_rest'])){
	$states = $_POST['input_state'];
	$rest_nfa = $_POST['nfa_rest'];

	$states_arr = explode(",", $states);
	for ($i=0; $i < count($states_arr); $i++) { 
		$headings[] = $states_arr[$i];
	}

	$other_rows = explode("\n", $rest_nfa);
	//print_r($other_rows);
	echo "<br>";
	$rows_data = [];
	for ($j=0; $j < count($other_rows); $j++) { 
		$rows_data[$j] = "<tr>";
		$single_cell = explode(",", $other_rows[$j]);
		for ($k=0; $k < count($single_cell); $k++) { 
			$cell_text = ($single_cell[$k] == '#')? "∅": $single_cell[$k];
			$rows_data[$j] .= "<td>$cell_text</td>";
			if ($k==0) {
				$variable_cap[] = $single_cell[$k];
			} else{
				$variable_all[$j][] = $single_cell[$k];
			}
			
		}

		$rows_data[$j] .= "</tr>";

	}
	//print_r($variable_cap);echo "<br>";
	//print_r($headings);echo "<br>";
		$our_ex = 0;
		foreach ($variable_all as $key => $value) {
			//print_r($value);echo "<br>";
			for ($l=0; $l < count($headings); $l++) { 
				$seperator = "";
				if ($value[$l] != "#") {

					if (!empty($our_values[$our_ex])) {
						if ($l > 0) {
							$seperator = "|";
						} else {
							$seperator = "";
						}
						$our_values[$our_ex] .= $seperator.$headings[$l].$value[$l];
					} else{
						$our_values[$our_ex] = $seperator.$headings[$l].$value[$l];
					}
				}
			}
			$our_ex++;
		}


	//echo "<br>";echo "<br>";echo "<br>";
	//print_r($our_values);echo "<br>";
	
	
		
	echo "<div class='table_nfa_epsilon'><label for=''>Transition Table</label><table class='table'><thead>";



	// Start of table header
	echo "<tr id='epsilon_nfa_head'><th></th>";
	foreach ($headings as $heading) {
		$t_heading = ($heading == '~')? "ε": $heading;
		echo "<th>".$t_heading."</th>";
	}
	echo "</tr></thead>";
	// End of table header
	foreach ($rows_data as $row) {
		echo $row;
	}
	echo "</table></div>";
	//echo '<div class="clear">';
	echo '<div class="table_nfa_epsilon"><form><label>Regualr Grammer</label><br><textarea class="rg_input" cols="30" rows="6" readonly="true">';
	for ($m=0; $m < count($variable_cap); $m++) { 
		echo $variable_cap[$m]."→".str_replace("~", "&epsilon;", $our_values[$m])."\n";
	}
	echo '</textarea></form></div><br><div class="clear"></div>';


}


/*
foreach (str_split($with_or[$x]) as $val_set) {
				if (ctype_lower($val_set)) {
					$low_char = $val_set;
					
				}
				if (ctype_upper($val_set) && in_array($low_char, $variables_small)) {
					$all_rows[$i] .= "<td>".$val_set."</td>";
				} else{
					$all_rows[$i] .= "<td>&#8709;</td>";
				}
			}
*/
 ?>