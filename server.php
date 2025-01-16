<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Allow: GET, POST, OPTIONS, PUT, DELETE');
header('Content-Type: application/json');

//<!--========== PHP CONNECTION TO DATABASE ==========-->
$host = "localhost";
$username = "root";
$pass = "";
$dbname = "jfb";
$method = $_SERVER['REQUEST_METHOD'];
$conn = mysqli_connect($host, $username, $pass, $dbname); //create connection

//check connection
if(!$conn){
      echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
      exit;
}

//funciones de utilidad para el server

function currentPeriod() {
    $result = array(
        'current_period' => '',
        'time_period' => '',
        'start_current_period' => '',
        'end_current_period' => '',
        'exist_period' => false,
        'isOpen' => 0
    );

    $conn = $GLOBALS['conn']; // Asegúrate de que la conexión está disponible

    $query = "SELECT * FROM period WHERE isOpen = 1";
    $query_result = mysqli_query($conn, $query);

    if (!$query_result) {
        throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($query_result) > 0) {
        $row = mysqli_fetch_assoc($query_result);

        $result['current_period'] = $row['name'];
        $result['start_current_period'] = $row['start_date'];
        $result['end_current_period'] = $row['end_date'];
        $result['exist_period'] = true;
        $result['isOpen'] = $row['isOpen'];
    }

    return $result;
}




function ifPeriodExist($name, $start, $end) {
	$existe = false;
	$resultado = mysqli_query($GLOBALS['conn'], "SELECT 1 FROM period WHERE (start_date BETWEEN '$start' AND '$end' OR end_date BETWEEN '$start' AND '$end' OR (start_date <= '$start' AND end_date >= '$end')) OR name = '$name'");
	if(mysqli_num_rows($resultado) > 0) $existe = true;
	return $existe;
}

function ifPersonExist($cedula){
  $existe = false;
  $resultado = mysqli_query($GLOBALS['conn'], "SELECT 1 FROM person WHERE cedula = '$cedula'");
  if(mysqli_num_rows($resultado) > 0) $existe = true;
  return $existe;	
}

function ifUserExist($user_name){
	$existe = false;
	$resultado = mysqli_query($GLOBALS['conn'], "SELECT 1 FROM user WHERE user_name = '$user_name'");
	if(mysqli_num_rows($resultado) > 0) $existe = true;
	return $existe;	
  }

function ifStudentExistRegistration($student_id){
	$existe = false;
	$current_period = currentPeriod()['current_period'];

	$resultado = mysqli_query($GLOBALS['conn'], "SELECT 1 FROM registration WHERE student_id = $student_id and period='$current_period'");
	if(mysqli_num_rows($resultado) > 0) $existe = true;
	return $existe;	
	}

function ifTeacherExist($cedula){
	$existe = false;
	$consulta = "SELECT person.id, teacher.person_id FROM person INNER JOIN teacher ON person.id = teacher.person_id WHERE cedula = '$cedula';";
	$resultado = mysqli_query($GLOBALS['conn'], $consulta);
	if(mysqli_num_rows($resultado) > 0) $existe = true;
	return $existe;	
	}	

function returnIdParent($cedula) {
    $resultado = mysqli_query($GLOBALS['conn'], "SELECT id FROM person WHERE cedula = '$cedula'");
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
        return $row['id'];
    } else {
        return null; 
    }
}

function row_sqlconector($consulta) {
	$row = array();
	$resultado = mysqli_query($GLOBALS['conn'], $consulta);
	if($resultado){
		$row = mysqli_fetch_assoc($resultado);
	}
	return $row;
  }

function returnDatPerson($id) {
	$obj = array();
    $resultado = mysqli_query($GLOBALS['conn'], "SELECT * FROM person WHERE id = $id");
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
		$obj = array(
			'id'=>$row['id'],
			'cedula' => $row['cedula'],
			'name' => $row['name'],
			'second_name' => $row['second_name'],
			'last_name'	=> $row['last_name'],
			'second_last_name' => $row['second_last_name'],
			'email'	=> $row['email'],
			'phone'	=> $row['phone'],
			'birthday' =>$row['birthday'],
			'gender' => $row['gender'],
			'address' => $row['address']
		);
    }
	return $obj;	
}

function returnDatPersonByCedula($cedula) {
	$obj = array();
    $resultado = mysqli_query($GLOBALS['conn'], "SELECT * FROM person WHERE cedula = $cedula");
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
		$obj = array(
			'id'=>$row['id'],
			'cedula' => $row['cedula'],
			'name' => $row['name'],
			'second_name' => $row['second_name'],
			'last_name'	=> $row['last_name'],
			'second_last_name' => $row['second_last_name'],
			'email'	=> $row['email'],
			'phone'	=> $row['phone'],
			'birthday' =>$row['birthday'],
			'gender' => $row['gender'],
			'address' => $row['address']
		);
    }
	return $obj;	
}

function returnDatPersonByStudentId($person_id) {
	$obj = array();
    $resultado = mysqli_query($GLOBALS['conn'], "SELECT * FROM person WHERE id = $person_id");
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
		$obj = array(
			'id'=>$row['id'],
			'cedula' => $row['cedula'],
			'name' => $row['name'],
			'last_name'	=> $row['last_name'],
		);
    }
	return $obj;	
}

function returnPersonId_student($id) {
    $resultado = mysqli_query($GLOBALS['conn'], "SELECT person_id FROM student WHERE person_id = $id");

	return $resultado;	
}



function returnSectionNamesByTeacher($teacher_id, $period) {
    $obj = array();
    $query = "SELECT CONCAT(s.year, ' año ', s.section_name) AS section_info
              FROM section s
              WHERE s.teacher_id = '$teacher_id'
              AND s.period = '$period'";
    $resultado = mysqli_query($GLOBALS['conn'], $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $obj[] = $row['section_info'];
        }
    }
    return $obj;
}


function returnListSection($period){
	$obj = array();
	$consulta = "SELECT * from section where period='$period'";		
	$resultado = mysqli_query($GLOBALS['conn'], $consulta);
	if ($resultado && mysqli_num_rows($resultado) > 0) {
		while($row = mysqli_fetch_assoc($resultado)) {
			$obj[]=array('id'=>$row['id'],'year'=>$row['year'],'section_name'=>$row['section_name'],'teacher_id'=>returnDatPerson($row['teacher_id']),'quota'=>$row['quota'],'period'=>$row['period']);
		}   			
	}
	return $obj;
}



function returnDatSection($id) {
	$obj = array();
    $resultado = mysqli_query($GLOBALS['conn'], "SELECT * FROM section WHERE id = $id");
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
		$obj=array('id'=>$row['id'],'year'=>$row['year'],'section_name'=>$row['section_name'],'teacher_id'=>returnDatPerson($row['teacher_id']),'quota'=>$row['quota'],'period'=>$row['period']);
    }
	return $obj;	
}

function returnDatSubject($id) {
	$obj = array();
    $resultado = mysqli_query($GLOBALS['conn'], "SELECT * FROM subject WHERE id = $id");
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
		$obj=array('id' => $row['id'],'name'=>$row['name']);
    }
	return $obj;	
}



function returnDatUser($id) {
	$obj = array();
    $resultado = mysqli_query($GLOBALS['conn'], "SELECT * FROM user WHERE user_id = $id");
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
		$obj=array('user_id'=>$row['user_id'],'person_id'=>$row['person_id'],'password'=>$row['password']);
    }
	return $obj;	
}


function returnRegisterList($student_id){
	$obj = array();
	$consulta = "SELECT * from registration where student_id = ".$student_id."";		
	$resultado = mysqli_query($GLOBALS['conn'], $consulta);

		while($row = mysqli_fetch_assoc($resultado)) {
			$obj[]=array('id'=>$row['id'],'year'=>$row['year'],'section_id'=>returnDatSection($row['section_id']),'parent_id'=>returnDatPerson($row['parent_id']),'period'=>$row['period']);
		}   			
	
	return $obj;
}


function returnChildrenRegistration($parentId){
	$obj = array();
	$consulta = "SELECT * from registration where parent_id = $parentId";		
	$resultado = mysqli_query($GLOBALS['conn'], $consulta);

		while($row = mysqli_fetch_assoc($resultado)) {
			$obj[]=array('id'=>$row['id'],'year'=>$row['year'],'section_id'=>returnDatSection($row['section_id']),'student_id'=>returnDatPerson($row['student_id']),'student_rel'=>$row['student_rel'],'period'=>$row['period']);
		}   			
	
	return $obj;
}



function returnTeacherData($teacher_id){
	$obj = array();
	$consulta = "SELECT * from teacher where person_id = ".$teacher_id."";		
	$resultado = mysqli_query($GLOBALS['conn'], $consulta);

		while($row = mysqli_fetch_assoc($resultado)) {
			$obj=array('id'=>$row['id'],'person_id'=>$row['person_id'],'total_work_charge'=> $row['total_work_charge'],'qualification'=>$row['qualification'],'degree'=>$row['degree'],'second_degree'=>$row['second_degree'],'second_qualification'=>$row['second_qualification'],'hiring'=>$row['hiring'],'dismissal'=>$row['dismissal']);
		}   			
	
	return $obj;
}


function returnNextSection($_year,$period){
	$year = ['primero', 'segundo', 'tercero', 'cuarto', 'quinto'];
	$section = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
	$next_section="";
	$next_year="";	
	$obj =array();
	$consulta = "SELECT * from section where period='$period' and year='$_year' order by section_name DESC limit 1";
	$resultado = mysqli_query($GLOBALS['conn'], $consulta);
	if ($resultado && mysqli_num_rows($resultado) > 0) {
		while($row = mysqli_fetch_assoc($resultado)) {
			if (in_array($row['year'], $year)) {
				if (in_array($row['section_name'], $section)) {
					for($index=0; $index<=count($section);$index++){
						if($section[$index] == $row['section_name']){
							if($index < count($section)){
								$next_year = $row['year'];
								$next_section = $section[$index+1];	
								break;
							}							
						}
					}
				}
				else{
					$next_year = $row['year'];
					$next_section = $section[0];						
				}
			}
			$obj=array('year'=>$next_year,'next_section'=>$next_section);			
		}   			
	}else{
		$obj=array('year'=>$_year,'next_section'=>$section[0]);			
	}
	return $obj;
}


function ifSubjectExists($name) {

	$resultado = mysqli_query($GLOBALS['conn'], "SELECT * FROM subject WHERE name = '".$name."'");
    if (mysqli_num_rows($resultado) > 0) {
       return true;
    } 	   
	return false;
}


function returnPersonName($person_id) {
    $resultado = mysqli_query($GLOBALS['conn'], "SELECT name FROM person WHERE id = $person_id");
    $row = mysqli_fetch_assoc($resultado);
    
    return $row['name']; // Devuelve solo el valor del nombre
}

function addToHistory($user_id, $action) {
    global $conn; // Necesario para acceder a la variable $conn
    $query = "INSERT INTO user_history (user_id,action) VALUES ($user_id,'$action')"; // Usa comillas simples para los valores de texto
    $result = mysqli_query($conn, $query);

    if (!$result) {
        throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
    }

    return array("message" => "ok"); // Devuelve el array en lugar de hacer echo
}



//-------------------------------------

//*******Metodos de Comunicacion con el Front *************

if ($method == "OPTIONS") {
    die();
}

if ($method == "POST") {
    try {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        //verifica el inicio de sesion
		if (isset($data['login'])) {
			$query = "SELECT * FROM user WHERE user_name='" . $data['user'] . "' AND isBlocked=0";
			$result = mysqli_query($conn, $query);
		
			if (!$result) {
				throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
			}
		
			$row = mysqli_fetch_array($result);
			$userExist = false;
			$pass = false;
			$user_id = '';
			$person_id = '';
			$isAdmin = 0;
		
			if (mysqli_num_rows($result) > 0) {
				$userExist = true;
				if (password_verify($data['password'], $row['password'])) {
					$pass = true;
					$user_id = $row['user_id'];
					$person_id = $row['person_id'];
					$isAdmin = $row['isAdmin'];
				}
			}
		
			// Obtener el periodo actual
			$periodQuery = "SELECT * FROM period WHERE isOpen=1";
			$periodResult = mysqli_query($conn, $periodQuery);
			$period = mysqli_fetch_array($periodResult);
		
			$response = array(
				'exists' => $userExist,
				'pass' => $pass,
				'user_id' => $user_id,
				'person_id' => $person_id,
				'isAdmin' => $isAdmin,
				'period' => array(
					'start_current_period' => $period['start_date'],
					'end_current_period' => $period['end_date']
				)
			);
		
			echo json_encode($response);
		}
		

		if(isset($data['SendPeriodData'])){
			$start_date = mysqli_real_escape_string($conn, $data['sinceDate']);
			$end_date = mysqli_real_escape_string($conn, $data['toDate']);
			$name = mysqli_real_escape_string($conn, $data['name']);
		
			$Q_time_period = mysqli_query($conn, "SELECT YEAR(NOW()) AS actual, YEAR(NOW() - INTERVAL 1 YEAR) AS anterior, YEAR(NOW() + INTERVAL 1 YEAR) AS siguiente");
			$row_time_period = mysqli_fetch_assoc($Q_time_period);
			$year_anterior = $row_time_period['anterior'];
			$year_actual = $row_time_period['actual'];
			$year_siguiente = $row_time_period['siguiente'];
		
			if((strtotime($start_date) >= strtotime("$year_anterior-01-01") && strtotime($end_date) <= strtotime("$year_actual-12-31")) ||
			   (strtotime($start_date) >= strtotime("$year_actual-01-01") && strtotime($end_date) <= strtotime("$year_siguiente-12-31"))) {
				
				if(ifPeriodExist($name, $start_date, $end_date)) {
					$response = array('message' => 'Ya existe un periodo en este rango de tiempo o el nombre ya está en uso');
					echo json_encode($response);
				} else {

					// Actualizamos el último periodo agregado para cerrar (isOpen = 0)
					$Q_last_period = mysqli_query($conn, "SELECT * FROM period ORDER BY end_date DESC LIMIT 1");
					$row_last_period = mysqli_fetch_assoc($Q_last_period);
					$last_period = $row_last_period['name'];
					
										
					if($row_last_period) {
						$last_period_id = $row_last_period['id'];
						mysqli_query($conn, "UPDATE period SET isOpen = 0 WHERE id = '$last_period_id'");
					}

					$query = "INSERT INTO period (start_date, end_date, name) VALUES ('$start_date', '$end_date', '$name')";
					$result = mysqli_query($conn, $query);

			
					if (!$result) {
						// Error en la consulta
						throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
					}
			
					$response = array('message' => 'ok');
					echo json_encode($response);
				}
			} else {
				$response = array('message' => 'Las fechas del periodo deben estar entre el año anterior y el actual, o entre el actual y el siguiente');
				echo json_encode($response);
			}
		}
		
		
		if(isset($data['update'])){ /* Actualiza segun un campo con su valor y  la tabla requerida*/

			$response = array('message' => 'Entrando');
			echo json_encode($response);

			$campo = mysqli_real_escape_string($conn, $data['campo']);
			$valor = mysqli_real_escape_string($conn, strtolower($data['valor']));
			$tabla = mysqli_real_escape_string($conn, $data['tabla']);
			
            $query = "UPDATE $tabla SET $campo = $valor WHERE user_id=".$data['update'];
            $result = mysqli_query($conn, $query);
            
            if (!$result) {
                // Error en la consulta
                throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
            }
			
			$response = array("message" => "ok");
			echo json_encode($response);
		}

		if(isset($data['updateSingleField'])){ /* Actualiza segun un campo con su valor y  la tabla requerida*/

			$campo = mysqli_real_escape_string($conn, $data['campo']);
			$valor = mysqli_real_escape_string($conn, strtolower($data['valor']));
			$tabla = mysqli_real_escape_string($conn, $data['tabla']);
			$whereCondition =	 mysqli_real_escape_string($conn, $data['whereCondition']);

			
            $query = "UPDATE $tabla SET $campo = $valor WHERE $whereCondition";
            $result = mysqli_query($conn, $query);
            
            if (!$result) {
                // Error en la consulta
                throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
            }
			
			$response = array("message" => "ok");
			echo json_encode($response);
		}


		if(isset($data['updateUser'])){ 
			// Actualiza según un campo con su valor y la tabla requerida
			header('Content-Type: application/json'); // Asegura el encabezado JSON
		
			$campo = mysqli_real_escape_string($conn, $data['campo']);
			$valor = mysqli_real_escape_string($conn, strtolower($data['valor']));
			$tabla = mysqli_real_escape_string($conn, $data['tabla']);
			
			$query = "UPDATE $tabla SET $campo = '$valor' WHERE user_id=".$data['updateUser']; 
			$result = mysqli_query($conn, $query);
		
			// Historial
			$historyName = returnPersonName($data['history']['person_id']);
			$texto = '';
		
			if ($valor == '1') {
				$texto = "$historyName ha deshabilitado a un usuario";
			} else {
				$texto = "$historyName ha habilitado a un usuario";
			}
			$historyResponse = addToHistory($data['history']['user'], $texto);
			// Fin Historial
		
			if (!$result) {
				// Error en la consulta
				$response = array("message" => "Error en la consulta SQL: " . mysqli_error($conn));
				echo json_encode($response);
				exit();
			}
			
			$response = array("message" => "ok");
			echo json_encode($response);
			exit();
		}
				

		if(isset($data['updateBlock'])){ 
			// Actualiza según un campo con su valor y la tabla requerida
			header('Content-Type: application/json'); // Asegura el encabezado JSON
			$response = array('message' => 'Entrando');
			echo json_encode($response);
		
			$campo = mysqli_real_escape_string($conn, $data['campo']);
			$valor = mysqli_real_escape_string($conn, strtolower($data['valor']));
			$tabla = mysqli_real_escape_string($conn, $data['tabla']);
			
			$query = "UPDATE $tabla SET $campo = '$valor' WHERE user_id=".$data['updateBlock']; 
			$result = mysqli_query($conn, $query);
		
			// Historial
			$texto = '';
		
			if($valor == '1'){
				$texto = returnPersonName($data['history']['person_id']) . " ha bloqueado a un usuario";
			} else {
				$texto = returnPersonName($data['history']['person_id']) . " ha desbloqueado a un usuario";
			}
			$historyResponse = addToHistory($data['history']['user'], $texto);
			// Fin Historial
		
			if (!$result) {
				// Error en la consulta
				$response = array("message" => "Error en la consulta SQL: " . mysqli_error($conn));
				echo json_encode($response);
				exit();
			}
			
			$response = array("message" => "ok");
			echo json_encode($response);
			exit();
		}
		
		

		if(isset($data['updateSingleField'])){ /* Actualiza segun un campo con su valor y  la tabla requerida*/

			$campo = mysqli_real_escape_string($conn, $data['campo']);
			$valor = mysqli_real_escape_string($conn, strtolower($data['valor']));
			$tabla = mysqli_real_escape_string($conn, $data['tabla']);
			$whereCondition =	 mysqli_real_escape_string($conn, $data['whereCondition']);

			
            $query = "UPDATE $tabla SET $campo = $valor WHERE $whereCondition";
            $result = mysqli_query($conn, $query);
            
            if (!$result) {
                // Error en la consulta
                throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
            }
			
			$response = array("message" => "ok");
			echo json_encode($response);
		}



		if(isset($data['updateSingleFieldSubject'])){ /* Actualiza segun un campo con su valor y  la tabla requerida*/

			$campo = mysqli_real_escape_string($conn, $data['campo']);
			$valor = mysqli_real_escape_string($conn, strtolower($data['valor']));
			$tabla = mysqli_real_escape_string($conn, $data['tabla']);
			$whereCondition =	 mysqli_real_escape_string($conn, $data['whereCondition']);

			
            $query = "UPDATE $tabla SET $campo = $valor WHERE $whereCondition";
            $result = mysqli_query($conn, $query);

			// Historial
			$historyName= returnPersonName($data['history']['person_id']);
			$texto = returnPersonName($data['history']['person_id'])." ha desabilitado una Materia";
			$historyResponse = addToHistory($data['history']['user'], $texto);
			//Fin Historial
            
            if (!$result) {
                // Error en la consulta
                throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
            }
			
			$response = array("message" => "ok");
			echo json_encode($response);
		}



		if(isset($data['dismiss'])){ /* Actualiza segun un campo con su valor y  la tabla requerida*/

			$id = mysqli_real_escape_string($conn, $data['id']);
			$dismiss = date("Y-m-d");

			
            $query = "UPDATE teacher SET dismissal = '$dismiss' WHERE person_id = $id";
            $result = mysqli_query($conn, $query);

			// Historial
			$historyName= returnPersonName($data['history']['person_id']);
			$texto = returnPersonName($data['history']['person_id'])." ha despedido a un Profesor";
			$historyResponse = addToHistory($data['history']['user'], $texto);
			//Fin Historial


            
            if (!$result) {
                // Error en la consulta
                throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
            }
			
			$response = array("message" => "ok");
			echo json_encode($response);
		}

				
		if (isset($data['inscribe'])) {
			$message = 'Insert is Null in Inscribe';

			function insertPerson($conn, $data) {
				// Escapa los valores para evitar inyección de SQL
				$nationality = mysqli_real_escape_string($conn, $data['nationality']);
				$cedula = mysqli_real_escape_string($conn, $data['cedula']);
				$nationality = mysqli_real_escape_string($conn, $data['nationality']);
				$name = mysqli_real_escape_string($conn, strtolower($data['name']));
				$second_name = mysqli_real_escape_string($conn, strtolower($data['second_name']));
				$last_name = mysqli_real_escape_string($conn, strtolower($data['last_name']));
				$second_last_name = mysqli_real_escape_string($conn, strtolower($data['second_last_name']));
				$email = mysqli_real_escape_string($conn, strtolower($data['email']));
				$phone = mysqli_real_escape_string($conn, $data['phone']);
				$birthday = mysqli_real_escape_string($conn, $data['birthday']);
				$gender = mysqli_real_escape_string($conn, $data['gender']);
				$address = mysqli_real_escape_string($conn, strtolower($data['address']));
				
				// ...otros campos

				$query = "INSERT INTO person (cedula, nationality, name, second_name,last_name,second_last_name,email,phone,birthday,gender,address) VALUES ('$cedula','$nationality','$name','$second_name','$last_name','$second_last_name','$email','$phone','$birthday','$gender','$address')";
				$result = mysqli_query($conn, $query);

				if (!$result) {
					throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
				}

				return mysqli_insert_id($conn);
			}

			if (!ifPersonExist($data['parent']['cedula'])) {
				$endIdParent = insertPerson($conn, $data['parent']);
				$QinserParent = "INSERT INTO parent (person_id) VALUES ($endIdParent)";
				$result_parent = mysqli_query($conn, $QinserParent);
				$message = 'Usuario Inscrito con exito';
				$icon = 'success';

				// Historial
				$historyName= returnPersonName($data['history']['person_id']);
				$texto = returnPersonName($data['history']['person_id'])." ha inscrito un estudiante";
				$historyResponse = addToHistory($data['history']['user'], $texto);
				//Fin Historial

			}else{
				$endIdParent = returnIdParent($data['parent']['cedula']);
			}

			if (!ifPersonExist($data['student']['cedula'])) {
				$endIdStudent = insertPerson($conn, $data['student']);
				$QinserStudent = "INSERT INTO student (person_id, parent_id) VALUES ($endIdStudent, $endIdParent)";
				$result_student = mysqli_query($conn, $QinserStudent);
				$message = 'Usuario Inscrito con exito';
				$icon = 'success';

				// Historial
				$historyName= returnPersonName($data['history']['person_id']);
				$texto = returnPersonName($data['history']['person_id'])." ha inscrito un estudiante";
				$historyResponse = addToHistory($data['history']['user'], $texto);
				//Fin Historial

			}else{
				$endIdStudent = returnIdParent($data['student']['cedula']);
			}

			if(!ifStudentExistRegistration($endIdStudent)){
				$QinserRegistration = "INSERT INTO registration (student_id,parent_id,student_rel,section_id,period,year) VALUES ($endIdStudent, $endIdParent,'".$data['parent']['student_rel']."',".$data['section_id'].",'".$data['period']."','".$data['section_year']."')";
				$result_student = mysqli_query($conn, $QinserRegistration);	
				$message = 'Usuario Inscrito con exito';
				$icon = 'success';

				// Historial
				$historyName= returnPersonName($data['history']['person_id']);
				$texto = returnPersonName($data['history']['person_id'])." ha inscrito un estudiante";
				$historyResponse = addToHistory($data['history']['user'], $texto);
				//Fin Historial

			}
			else{
				$message = 'Error: No puedes insertar el mismo estudiante dos veces en el mismo periodo.';
				$icon = 'error';

			}


			$response = array('message' => $message,'icon'=>$icon);
			echo json_encode($response);
		}


		if (isset($data['register_teacher'])) {

			$message = 'Insert is Null in Inscribe';
						
			$qualification = mysqli_real_escape_string($conn, $data['teacher']['qualification']);
			$degree = mysqli_real_escape_string($conn, $data['teacher']['degree']); 
			$second_qualification = mysqli_real_escape_string($conn, $data['teacher']['second_qualification']);
			$second_degree = mysqli_real_escape_string($conn, $data['teacher']['second_degree']);
			$total_work_charge = mysqli_real_escape_string($conn, $data['teacher']['total_work_charge']);
			$hiring = date("Y-m-d");

			function insertPerson($conn, $data) {
				// Escapa los valores para evitar inyección de SQL
				$nationality = mysqli_real_escape_string($conn, $data['nationality']);
				$cedula = mysqli_real_escape_string($conn, $data['cedula']);
				$name = mysqli_real_escape_string($conn, strtolower($data['name']));
				$second_name = mysqli_real_escape_string($conn, strtolower($data['second_name']));
				$last_name = mysqli_real_escape_string($conn, strtolower($data['last_name']));
				$second_last_name = mysqli_real_escape_string($conn, strtolower($data['second_last_name']));
				$email = mysqli_real_escape_string($conn, strtolower($data['email']));
				$phone = mysqli_real_escape_string($conn, $data['phone']);
				$birthday = mysqli_real_escape_string($conn, $data['birthday']);
				$gender = mysqli_real_escape_string($conn, $data['gender']);
				$address = mysqli_real_escape_string($conn, strtolower($data['address']));
				
				// ...otros campos

				$query = "INSERT INTO person (cedula, nationality, name, second_name,last_name,second_last_name,email,phone,birthday,gender,address) VALUES ('$cedula','$nationality','$name','$second_name','$last_name','$second_last_name','$email','$phone','$birthday','$gender','$address')";
				$result = mysqli_query($conn, $query);

				if (!$result) {
					throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
				}

				return mysqli_insert_id($conn);
			}

			if (!ifTeacherExist($data['person']['cedula'])) {
				$endIdTeacher = insertPerson($conn, $data['person']);
				$QinsertTeacher = "INSERT INTO teacher (person_id,qualification,degree,second_qualification,second_degree,total_work_charge,hiring) VALUES ($endIdTeacher,'$qualification','$degree','$second_qualification','$second_degree',$total_work_charge,'$hiring')";
				$result_teacher = mysqli_query($conn, $QinsertTeacher);
				if (!$result_teacher) {
					throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
				}

				// Historial
				$historyName= returnPersonName($data['history']['person_id']);
				$texto = returnPersonName($data['history']['person_id'])." ha registrado a un profesor";
				$historyResponse = addToHistory($data['history']['user'], $texto);
				//Fin Historial

				$message = 'Profesor Registrado con exito';
				$icon = 'success';

			}else{
				$message = 'Error: No puedes insertar el mismo profresor dos veces.';
				$icon = 'error';			
			}

			$response = array('message' => $message,'icon'=>$icon);
			echo json_encode($response);
		}


		if (isset($data['editTeacher'])) {

			$message = 'Editado';

				// Escapa los valores para evitar inyección de SQL
				$id = mysqli_real_escape_string($conn, $data['teacher']['id']);
				$nationality = mysqli_real_escape_string($conn, $data['teacher']['nationality']);
				$cedula = mysqli_real_escape_string($conn, $data['teacher']['cedula']);
				$name = mysqli_real_escape_string($conn, strtolower($data['teacher']['name']));
				$second_name = mysqli_real_escape_string($conn, strtolower($data['teacher']['second_name']));
				$last_name = mysqli_real_escape_string($conn, strtolower($data['teacher']['last_name']));
				$second_last_name = mysqli_real_escape_string($conn, strtolower($data['teacher']['second_last_name']));
				$email = mysqli_real_escape_string($conn, strtolower($data['teacher']['email']));
				$phone = mysqli_real_escape_string($conn, $data['teacher']['phone']);
				$address = mysqli_real_escape_string($conn, strtolower($data['teacher']['address']));
				$gender = mysqli_real_escape_string($conn, $data['teacher']['gender']);
				$birthday = mysqli_real_escape_string($conn, $data['teacher']['birthday']);
				// ...otros campos    
				$total_work_charge = mysqli_real_escape_string($conn, strtolower($data['teacher']['total_work_charge']));
				$qualification = mysqli_real_escape_string($conn, strtolower($data['teacher']['qualification']));
				$degree = mysqli_real_escape_string($conn, strtolower($data['teacher']['degree']));
				$second_qualification = mysqli_real_escape_string($conn, strtolower($data['teacher']['second_qualification']));
				$second_degree = mysqli_real_escape_string($conn, strtolower($data['teacher']['second_degree']));


				$query = "UPDATE person SET cedula='$cedula',nationality='$nationality',name='$name',second_name='$second_name',last_name='$last_name',second_last_name='$second_last_name',email='$email',phone='$phone',address='$address',gender='$gender',birthday='$birthday' WHERE id=$id";
				$result = mysqli_query($conn, $query);


				$second_query = "UPDATE teacher SET total_work_charge=$total_work_charge,qualification='$qualification',degree='$degree',second_qualification='$second_qualification',second_degree='$second_degree' WHERE person_id=$id";
				$second_result = mysqli_query($conn, $second_query);

				// Historial
				$historyName= returnPersonName($data['history']['person_id']);
				$texto = returnPersonName($data['history']['person_id'])." ha editado un profesor";
				$historyResponse = addToHistory($data['history']['user'], $texto);
				//Fin Historial

				if (!$result || !$second_result) {
					throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
					$message = 'Error';
				}

			$response = array('message' => $message);
			echo json_encode($response);
		}


		if (isset($data['addSection'])) {

			$message = 'Insertado';

				// Escapa los valores para evitar inyección de SQL
				$year = mysqli_real_escape_string($conn, $data['section']['year']);
				$SectionName = mysqli_real_escape_string($conn, $data['section']['SectionName']);
				$quota = mysqli_real_escape_string($conn, $data['section']['quota']);
				$person_id = mysqli_real_escape_string($conn, $data['section']['person_id']['id']);
				$period = mysqli_real_escape_string($conn, $data['section']['period']);
				
				// ...otros campos    
				$query = "INSERT INTO section (year,section_name,teacher_id,quota,period) VALUES ('$year','$SectionName',$person_id,$quota,'$period')";
				$result = mysqli_query($conn, $query);

				// Historial
				$historyName= returnPersonName($data['history']['person_id']);
				$texto = returnPersonName($data['history']['person_id'])." ha creado una sección";
				$historyResponse = addToHistory($data['history']['user'], $texto);
				//Fin Historial

				if (!$result) {
					throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
					$message = 'Error';
				}

			$response = array('message' => $message);
			echo json_encode($response);
		}

		
		if (isset($data['editSection'])) {

			$message = 'Editado';

				// Escapa los valores para evitar inyección de SQL
				$id = mysqli_real_escape_string($conn, $data['section']['id']);
				$year = mysqli_real_escape_string($conn, $data['section']['year']);
				$SectionName = mysqli_real_escape_string($conn, strtolower($data['section']['SectionName']));
				$quota = mysqli_real_escape_string($conn, $data['section']['quota']);
				$person_id = mysqli_real_escape_string($conn, $data['section']['person_id']['id']);
				$period = mysqli_real_escape_string($conn, $data['section']['period']);
				
				// ...otros campos    
				$query = "UPDATE section SET year='$year',section_name='$SectionName',teacher_id=$person_id,quota=$quota,period='$period' WHERE id=$id";
				$result = mysqli_query($conn, $query);

				// Historial
				$historyName= returnPersonName($data['history']['person_id']);
				$texto = returnPersonName($data['history']['person_id'])." ha editado una sección";
				$historyResponse = addToHistory($data['history']['user'], $texto);
				//Fin Historial

				if (!$result) {
					throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
					$message = 'Error';
				}

			$response = array('message' => $message);
			echo json_encode($response);
		}
		


		if (isset($data['disableRegistration'])) {
			$message = 'Editado';
		
			// Escapa los valores para evitar inyección de SQL
			$section_id = mysqli_real_escape_string($conn, $data['section_id']);
			$student_id = mysqli_real_escape_string($conn, $data['person_id']);
			$registration_id = mysqli_real_escape_string($conn, $data['registration_id']);
			
			// ...otros campos    
			$query = "DELETE FROM registration WHERE student_id='$student_id' AND section_id='$section_id' AND id='$registration_id'";
			$result = mysqli_query($conn, $query);
		
			// Historial
			$historyName = returnPersonName($data['history']['person_id']);
			$texto = returnPersonName($data['history']['person_id']) . " ha anulado una inscripción";
			$historyResponse = addToHistory($data['history']['user'], $texto);
			// Fin Historial
		
			if (!$result) {
				$message = 'Error en la consulta SQL: ' . mysqli_error($conn);
			} else {
				$message = 'anulado';
			}
		
			$response = array('message' => $message);
			echo json_encode($response);
		}
		
		


		if (isset($data['addSubjectToRoutine'])) {
			$message = '';
			$icon = '';
		
			// Escapa los valores para evitar inyección de SQL
			$day = mysqli_real_escape_string($conn, strtolower($data['day']));
			$section_id = mysqli_real_escape_string($conn, strtolower($data['section']));
			$subject_id = mysqli_real_escape_string($conn, strtolower($data['subject']));
			$start_hour = mysqli_real_escape_string($conn, strtolower($data['start']));
			$end_hour = mysqli_real_escape_string($conn, strtolower($data['end']));
			$period = mysqli_real_escape_string($conn, strtolower($data['period']));
			// ...otros campos
		
			// Verifica si ya existe una entrada con los mismos día, sección, hora de inicio y hora de cierre
			$checkQuery = "SELECT * FROM work_charge WHERE day=$day AND section_id=$section_id AND start_hour='$start_hour' AND end_hour='$end_hour' AND period='$period'";
			$checkResult = mysqli_query($conn, $checkQuery);
		
			if (mysqli_num_rows($checkResult) > 0) {
				// Si existe, actualiza la materia
				$updateQuery = "UPDATE work_charge SET subject_id=$subject_id WHERE day=$day AND section_id=$section_id AND start_hour='$start_hour' AND end_hour='$end_hour' AND period='$period'";
				$updateResult = mysqli_query($conn, $updateQuery);
		
				if (!$updateResult) {
					throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
					$message = 'Error al actualizar la materia';
					$icon = 'error';
				} else {
					$message = 'Materia actualizada con éxito';
					$icon = 'success';
				}
			} else {
				// Si no existe, inserta una nueva entrada
				$insertQuery = "INSERT INTO work_charge (day, section_id, subject_id, start_hour, end_hour,period) VALUES ($day, $section_id, $subject_id, '$start_hour', '$end_hour', '$period')";
				$insertResult = mysqli_query($conn, $insertQuery);
		
				if (!$insertResult) {
					throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
					$message = 'Error al añadir la materia';
					$icon = 'error';
				} else {
					$message = 'Materia añadida con éxito';
					$icon = 'success';
				}
			}
		
			$response = array('message' => $message, 'icon' => $icon);
			echo json_encode($response);
		}


		if (isset($data['addTeacherToRoutine'])) {
			$message = '';
			$icon = '';
			$title= '';
			// Escapa los valores para evitar inyección de SQL
			$day = mysqli_real_escape_string($conn, strtolower($data['day']));
			$section_id = mysqli_real_escape_string($conn, strtolower($data['section']));
			$teacher_id = mysqli_real_escape_string($conn, strtolower($data['teacher']));
			$start_hour = mysqli_real_escape_string($conn, strtolower($data['start']));
			$end_hour = mysqli_real_escape_string($conn, strtolower($data['end']));
			$period = mysqli_real_escape_string($conn, strtolower($data['period']));

			// Verifica si el profesor ya tiene una entrada con la misma hora de inicio y fin
			$teacherCheckQuery = "SELECT * FROM work_charge WHERE teacher_id=$teacher_id AND start_hour='$start_hour' AND end_hour='$end_hour' AND day=$day AND period='$period'";
			$teacherCheckResult = mysqli_query($conn, $teacherCheckQuery);
		
			if (mysqli_num_rows($teacherCheckResult) == 0) {
				
				$checkQuery = "SELECT * FROM work_charge WHERE day=$day AND section_id=$section_id AND start_hour='$start_hour' AND end_hour='$end_hour' AND period='$period'";
				$checkResult = mysqli_query($conn, $checkQuery);
				
				if (mysqli_num_rows($checkResult) > 0) {
					// Si existe, actualiza el teacher_id
					$updateQuery = "UPDATE work_charge SET teacher_id=$teacher_id WHERE day=$day AND section_id=$section_id AND start_hour='$start_hour' AND end_hour='$end_hour' AND period='$period'";
					$updateResult = mysqli_query($conn, $updateQuery);
					
					if (!$updateResult) {

						throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
						$title = 'No se pudo añadir al profesor';
						$message = 'Error al actualizar el profesor';
						$icon = 'error';

					} else {
		
						$title = 'Profesor añadido';
						$message = 'Profesor actualizado con éxito';
						$icon = 'success';
			
					}

				} else {
					// Si no existe, inserta una nueva entrada
					$insertQuery = "INSERT INTO work_charge (day, section_id, teacher_id, start_hour, end_hour,period) VALUES ($day, $section_id, $teacher_id, '$start_hour', '$end_hour', '$period')";
					$insertResult = mysqli_query($conn, $insertQuery);
		
					if (!$insertResult) {
						throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
						$message = 'Error al añadir el profesor';
						$icon = 'error';
					} else {
						$message = 'Profesor añadido con éxito';
						$icon = 'success';
					}
				}
			} else {
				$title = 'No se pudo añadir al profesor';
				$message = 'El profesor ya esta ocupado por esta hora';
				$icon = 'warning';
			}
		
			$response = array('message' => $message, 'icon' => $icon, 'title' => $title);
			echo json_encode($response);
		}


		if (isset($data['addSubject'])) {

			$subjectExist = false;
			$message = '';
			$icon = '';

				// Escapa los valores para evitar inyección de SQL
				$name = mysqli_real_escape_string($conn, strtolower($data['subject']['name']));
				// ...otros campos    


				if (ifSubjectExists($name) == true) {
					$message ='Cuidado: Esta materia ya existe';
					$icon = 'warning';					
				} else{
					$query = "INSERT INTO subject (name) VALUES ('$name')";
					$result = mysqli_query($conn, $query);

					// Historial
					$historyName= returnPersonName($data['history']['person_id']);
					$texto = returnPersonName($data['history']['person_id'])." ha añadido una materia";
					$historyResponse = addToHistory($data['history']['user'], $texto);
					//Fin Historial

					if (!$result) {
						throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
						$message = 'Error';
					}
					$message ='Materia añadida con exito';
					$icon = 'success';
				}
				$response = array('message' => $message,'icon'=>$icon);
				echo json_encode($response);
		}

		if (isset($data['addNestedSubject'])) {

			$subjectExist = false;
			$message = '';
			$icon = '';

				// Escapa los valores para evitar inyección de SQL
				$name = mysqli_real_escape_string($conn, strtolower($data['subject']['name']));
				// ...otros campos    


				if (ifSubjectExists($name) == true) {
					$message ='Cuidado: Esta materia ya existe';
					$icon = 'warning';					
				} else{
					$query = "INSERT INTO subject (name,grupo_estable) VALUES ('$name', 1)";
					$result = mysqli_query($conn, $query);

					// Historial
					$historyName= returnPersonName($data['history']['person_id']);
					$texto = returnPersonName($data['history']['person_id'])." ha añadido una materia";
					$historyResponse = addToHistory($data['history']['user'], $texto);
					//Fin Historial

					if (!$result) {
						throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
						$message = 'Error';
					}
					$message ='Materia añadida con exito';
					$icon = 'success';
				}
				$response = array('message' => $message,'icon'=>$icon);
				echo json_encode($response);
		}

		if (isset($data['editSubject'])) {

			$subjectExist = false;
			$message = '';
			$icon = '';

				// Escapa los valores para evitar inyección de SQL
				
				$id = mysqli_real_escape_string($conn, $data['subject']['id']);
				$name = mysqli_real_escape_string($conn, strtolower($data['subject']['name']));
				// ...otros campos    

					$query = "UPDATE subject SET name='$name' WHERE id=$id";
					$result = mysqli_query($conn, $query);

					// Historial
					$historyName= returnPersonName($data['history']['person_id']);
					$texto = returnPersonName($data['history']['person_id'])." ha editado una materia";
					$historyResponse = addToHistory($data['history']['user'], $texto);
					//Fin Historial

					if (!$result) {
						throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
						$message = 'Error';
					}
					$message ='Materia editada con exito';
					$icon = 'success';
				
				$response = array('message' => $message,'icon'=>$icon);
				echo json_encode($response);
		}


		if (isset($data['editUser'])) {

			$message = 'Editado';

				// Escapa los valores para evitar inyección de SQL
				$id = mysqli_real_escape_string($conn, $data['user']['id']);
				$user_name = mysqli_real_escape_string($conn, $data['user']['user_name']);
				$password = mysqli_real_escape_string($conn, $data['user']['password']);
				$isAdmin = mysqli_real_escape_string($conn, $data['user']['isAdmin']);
				
				
				if (empty($password)) {
					$hashContrasena =  returnDatUser($id)['password'];
				}
				else{
					$hashContrasena = password_hash($password, PASSWORD_BCRYPT);
				}
								
				// ...otros campos    
				$query = "UPDATE user SET 
					user_name='$user_name',
					password='$hashContrasena',
					isAdmin=$isAdmin where user_id=$id";

				$result = mysqli_query($conn, $query);

				// Historial
				$historyName= returnPersonName($data['history']['person_id']);
				$texto = returnPersonName($data['history']['person_id'])." ha editado a un usuario";
				$historyResponse = addToHistory($data['history']['user'], $texto);
				//Fin Historial

				if (!$result) {
					throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
					$message = 'Error';
				}

			$response = array('message' => $message);
			echo json_encode($response);
		}


		if (isset($data['addUser'])) { /** AGREGA NUEVOS USUARIOS DEL SISTEMA **/
			$message = 'Insert is Null in Inscribe';
			$icon = 'error';

			function insertPerson($conn, $data) {
				// Escapa los valores para evitar inyección de SQL
				$nationality = mysqli_real_escape_string($conn, $data['nationality']);
				$cedula = mysqli_real_escape_string($conn, $data['cedula']);
				$name = mysqli_real_escape_string($conn, strtolower($data['name']));
				$second_name = mysqli_real_escape_string($conn, strtolower($data['second_name']));
				$last_name = mysqli_real_escape_string($conn, strtolower($data['last_name']));
				$second_last_name = mysqli_real_escape_string($conn, strtolower($data['second_last_name']));
				$email = mysqli_real_escape_string($conn, strtolower($data['email']));
				$phone = mysqli_real_escape_string($conn, $data['phone']);
				$birthday = mysqli_real_escape_string($conn, $data['birthday']);
				$gender = mysqli_real_escape_string($conn, $data['gender']);
				$address = mysqli_real_escape_string($conn, strtolower($data['address']));
				
				// ...otros campos

				$query = "INSERT INTO person (nationality,cedula, name, second_name,last_name,second_last_name,email,phone,birthday,gender,address) VALUES ('$nationality','$cedula', '$name','$second_name','$last_name','$second_last_name','$email','$phone','$birthday','$gender','$address')";
				$result = mysqli_query($conn, $query);

				if (!$result) {
					throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
				}

				return mysqli_insert_id($conn);
			}


			if (!ifPersonExist($data['person']['cedula'])) {
				$endIdPerson = insertPerson($conn, $data['person']);

					if (!ifUserExist($data['userData']['user_name'])) {
						$hashContrasena = password_hash($data['userData']['password'], PASSWORD_BCRYPT);
						$QinsertUser = "INSERT INTO user (person_id,user_name,password,isAdmin) VALUES ($endIdPerson,'".$data['userData']['user_name']."','".$hashContrasena."',".$data['userData']['isAdmin'].")";
						$result = mysqli_query($conn, $QinsertUser);

						// Historial
						$historyName= returnPersonName($data['history']['person_id']);
						$texto = returnPersonName($data['history']['person_id'])." ha añadido a un usuario";
						$historyResponse = addToHistory($data['history']['user'], $texto);
						//Fin Historial
						if (!$result) {
							throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
						}												
						$message = 'Usuario añadido con exito...';
						$icon = 'success';
					} else{
						$message = 'Error: Este usuario ya existe';
						$icon = 'error';
					}
				
			}else{
				$endIdPerson = returnIdParent($data['person']['cedula']);
				if (!ifUserExist($data['userData']['user_name'])) {
					$hashContrasena = password_hash($data['userData']['password'], PASSWORD_BCRYPT);					
					$QinsertUser = "INSERT INTO user (person_id,user_name,password,isAdmin) VALUES ($endIdPerson,'".$data['userData']['user_name']."','".$hashContrasena."',".$data['userData']['isAdmin'].")";
					$result = mysqli_query($conn, $QinsertUser);

					
					// Historial
					$historyName= returnPersonName($data['history']['person_id']);
					$texto = returnPersonName($data['history']['person_id'])." ha añadido a un usuario";
					$historyResponse = addToHistory($data['history']['user'], $texto);
					//Fin Historial

					if (!$result) {
						throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
					}					
					$message = 'Usuario añadido con exito...';
					$icon = 'success';
				} else{
					$message ='Error: Este usuario ya existe';
					$icon = 'error';
				}
			}

			

			$response = array('message' => $message,'icon'=>$icon);
			echo json_encode($response);
		}


		if (isset($data['hola'])){
	
			$response = array('message' => 'good');
			echo json_encode($response);
		}


		if (isset($data['editStudent'])) {

			$message = 'Editado';

				// Escapa los valores para evitar inyección de SQL
				$id = mysqli_real_escape_string($conn, $data['student']['id']);
				$nationality = mysqli_real_escape_string($conn, $data['student']['nationality']);
				$cedula = mysqli_real_escape_string($conn, $data['student']['cedula']);
				$name = mysqli_real_escape_string($conn, strtolower($data['student']['name']));
				$second_name = mysqli_real_escape_string($conn, strtolower($data['student']['second_name']));
				$last_name = mysqli_real_escape_string($conn, strtolower($data['student']['last_name']));
				$second_last_name = mysqli_real_escape_string($conn, strtolower($data['student']['second_last_name']));
				$email = mysqli_real_escape_string($conn, strtolower($data['student']['email']));
				$phone = mysqli_real_escape_string($conn, $data['student']['phone']);
				$address = mysqli_real_escape_string($conn, strtolower($data['student']['address']));
				$gender = mysqli_real_escape_string($conn, $data['student']['gender']);
				$birthday = mysqli_real_escape_string($conn, $data['student']['birthday']);
				// ...otros campos    
				$query = "UPDATE person SET cedula='$cedula',nationality='$nationality',name='$name',second_name='$second_name',last_name='$last_name',second_last_name='$second_last_name',email='$email',phone='$phone',address='$address',gender='$gender',birthday='$birthday' WHERE id=$id";
				$result = mysqli_query($conn, $query);

				// Historial
				$historyName= returnPersonName($data['history']['person_id']);
				$texto = returnPersonName($data['history']['person_id'])." ha editado a un estudiante";
				$historyResponse = addToHistory($data['history']['user'], $texto);
				//Fin Historial

				if (!$result) {
					throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
					$message = 'Error';
				}

			$response = array('message' => $message);
			echo json_encode($response);
		}

		if (isset($data['editParent'])) {

			$message = 'Editado';

				// Escapa los valores para evitar inyección de SQL
				$id = mysqli_real_escape_string($conn, $data['student']['id']);
				$nationality = mysqli_real_escape_string($conn, $data['student']['nationality']);
				$cedula = mysqli_real_escape_string($conn, $data['student']['cedula']);
				$name = mysqli_real_escape_string($conn, strtolower($data['student']['name']));
				$second_name = mysqli_real_escape_string($conn, strtolower($data['student']['second_name']));
				$last_name = mysqli_real_escape_string($conn, strtolower($data['student']['last_name']));
				$second_last_name = mysqli_real_escape_string($conn, strtolower($data['student']['second_last_name']));
				$email = mysqli_real_escape_string($conn, strtolower($data['student']['email']));
				$phone = mysqli_real_escape_string($conn, $data['student']['phone']);
				$address = mysqli_real_escape_string($conn, strtolower($data['student']['address']));
				$gender = mysqli_real_escape_string($conn, $data['student']['gender']);
				$birthday = mysqli_real_escape_string($conn, $data['student']['birthday']);
				// ...otros campos    
				$query = "UPDATE person SET cedula='$cedula',nationality='$nationality',name='$name',second_name='$second_name',last_name='$last_name',second_last_name='$second_last_name',email='$email',phone='$phone',address='$address',gender='$gender',birthday='$birthday' WHERE id=$id";
				$result = mysqli_query($conn, $query);

				// Historial
				$historyName= returnPersonName($data['history']['person_id']);
				$texto = returnPersonName($data['history']['person_id'])." ha editado a un representante";
				$historyResponse = addToHistory($data['history']['user'], $texto);
				//Fin Historial

				if (!$result) {
					throw new Exception("Error en la consulta SQL: " . mysqli_error($conn));
					$message = 'Error';
				}

			$response = array('message' => $message);
			echo json_encode($response);
		}

    } catch (Exception $e) {		
        //http_response_code(500);
		$response = array('Error: ' => $e->getMessage());
		echo json_encode($response);		
        //echo json_encode(new stdClass()); // Devuelve un objeto JSON vacío
    }
}


if ($method == "GET") {

	if(isset($_GET['getpass'])){
		echo password_hash($_GET['getpass'], PASSWORD_BCRYPT);
	}

	if(isset($_GET['prueba'])){

		echo date("YYYY-MM-DD"); ;
	}

	if(isset($_GET['current_period'])){
		$time_period = "";
		$exist_period = false;
		$start_current_period = "";
		$end_current_period = "";
		$current_period = "";
		$isOpen = 1;
		$last_period = "";
		// Obtenemos los años
		$Q_time_period = mysqli_query($conn, "SELECT YEAR(NOW()) AS actual, YEAR(NOW() - INTERVAL 1 YEAR) AS anterior, YEAR(NOW() + INTERVAL 1 YEAR) AS siguiente");
		$row_time_period = mysqli_fetch_assoc($Q_time_period);
		$time_period_candidate1 = $row_time_period['anterior']."-".$row_time_period['actual'];
		$time_period_candidate2 = $row_time_period['actual']."-".$row_time_period['siguiente'];
	
		// Comprobamos si existe el periodo con cualquiera de los dos candidatos
		$Q_exist1 = mysqli_query($conn, "SELECT 1 FROM period WHERE name = '$time_period_candidate1'");
		$Q_exist2 = mysqli_query($conn, "SELECT 1 FROM period WHERE name = '$time_period_candidate2'");
		$exist_period = mysqli_num_rows($Q_exist1) > 0 || mysqli_num_rows($Q_exist2) > 0;
	
		if($exist_period){
			$current_date = date('Y-m-d');
			$Q_current_period = mysqli_query($conn, "SELECT * FROM period WHERE start_date <= '$current_date' AND end_date >= '$current_date' ORDER BY end_date DESC LIMIT 1");
			$row_current_period = mysqli_fetch_assoc($Q_current_period);
	
			if ($row_current_period) {
				$start_current_period = $row_current_period['start_date'];
				$end_current_period = $row_current_period['end_date'];
				$current_period = $row_current_period['name'];
				$isOpen = $row_current_period['isOpen'];
				$time_period = $row_current_period['name'];

				// Actualizamos el último periodo agregado para cerrar (isOpen = 0)
				$Q_second_last_period = mysqli_query($conn, "SELECT * FROM period ORDER BY end_date DESC LIMIT 1 OFFSET 1");
				$row_second_last_period = mysqli_fetch_assoc($Q_second_last_period);
				$last_period = $row_second_last_period['name'];
				
			} else {
				// Si no hay un periodo dentro de la fecha actual
				$exist_period = false;
				$time_period = "";
				$isOpen = 0;
	
				// Actualizamos el último periodo agregado para cerrar (isOpen = 0)
				$Q_last_period = mysqli_query($conn, "SELECT * FROM period ORDER BY end_date DESC LIMIT 1");
				$row_last_period = mysqli_fetch_assoc($Q_last_period);
				$last_period = $row_last_period['name'];

				/*
				if($row_last_period) {
					$last_period_id = $row_last_period['id'];
					mysqli_query($conn, "UPDATE period SET isOpen = 0 WHERE id = '$last_period_id'");
				}*/
			}
		}
	
		$obj = array(
			'current_period' => $current_period,
			'last_period' => $last_period,
			'time_period' => $time_period,
			'start_current_period' => $start_current_period,
			'end_current_period' => $end_current_period,
			'exist_period' => $exist_period,
			'isOpen' => $isOpen
		);
		echo json_encode($obj);
	}
	
	

	if(isset($_GET['person_list'])){
		$obj = array();
		$consulta = "SELECT
			person.id,
			person.nationality,
			person.cedula,
			person.name,
			person.phone,
			person.second_name,
			person.last_name,
			person.second_last_name,
			person.email,
			person.birthday,
			person.gender,
			person.address
			FROM
			person
			INNER JOIN
			teacher ON teacher.person_id = person.id
			INNER JOIN
			parent ON parent.person_id = person.id";
		$resultado = mysqli_query($conn, $consulta);
		if ($resultado && mysqli_num_rows($resultado) > 0) {
			while($row = mysqli_fetch_assoc($resultado)) {      
				$obj[]=array('id'=>$row['id'],'phone'=>$row['phone'],'nationality'=>$row['nationality'],'cedula'=>$row['cedula'],'name'=>$row['name'],'second_name'=>$row['second_name'],'last_name'=>$row['last_name'],'second_last_name'=>$row['second_last_name'],'email'=>$row['email'],'birthday'=>$row['birthday'],'gender'=>$row['gender'],'address'=>$row['address']);
			}   
		}
		echo json_encode($obj); 
	}		
	
	if(isset($_GET['teacher_list'])){
		$obj = array();
		$consulta = "SELECT 
		person.id,
		person.nationality,
		person.cedula,
		person.name,
		person.phone,
		person.second_name,
		person.last_name,
		person.second_last_name,
		person.email,
		person.birthday,
		person.gender,
		person.address 
		FROM person INNER JOIN teacher where teacher.person_id = person.id AND dismissal = 0000-00-00";
		$resultado = mysqli_query($conn, $consulta);
		if ($resultado && mysqli_num_rows($resultado) > 0) {
			while($row = mysqli_fetch_assoc($resultado)) {      
				$obj[]=array('id'=>$row['id'],'phone'=>$row['phone'],'cedula'=>$row['cedula'],'nationality'=>$row['nationality'],'name'=>$row['name'],'second_name'=>$row['second_name'],'last_name'=>$row['last_name'],'second_last_name'=>$row['second_last_name'],'email'=>$row['email'],'birthday'=>$row['birthday'],'gender'=>$row['gender'],'address'=>$row['address'], 'teacherData' => returnTeacherData($row['id']));
			}   
		}
		echo json_encode($obj); 
	}
	
	
	if(isset($_GET['parent_list'])){
		$obj = array();
		$consulta = "SELECT 
		person.id,
		person.nationality,
		person.cedula,
		person.name,
		person.phone,
		person.second_name,
		person.last_name,
		person.second_last_name,
		person.email,
		person.birthday,
		person.gender,
		person.address
		FROM person INNER JOIN parent where parent.person_id = person.id";
		$resultado = mysqli_query($conn, $consulta);
		if ($resultado && mysqli_num_rows($resultado) > 0) {
			while($row = mysqli_fetch_assoc($resultado)) {      
				$obj[]=array('id'=>$row['id'],'phone'=>$row['phone'],'cedula'=>$row['cedula'],'nationality'=>$row['nationality'],'name'=>$row['name'],'second_name'=>$row['second_name'],'last_name'=>$row['last_name'],'second_last_name'=>$row['second_last_name'],'email'=>$row['email'],'birthday'=>$row['birthday'],'gender'=>$row['gender'],'address'=>$row['address'],'profileData'=>returnChildrenRegistration($row['id']));
			}   
		}
		echo json_encode($obj); 
	}
	
	if(isset($_GET['student_list'])){
		$obj = array();
		$consulta = "SELECT 
		person.id,
		person.nationality,
		person.cedula,
		person.name,
		person.phone,
		person.second_name,
		person.last_name,
		person.second_last_name,
		person.email,
		person.birthday,
		person.gender,
		person.address 
		FROM person INNER JOIN student where student.person_id = person.id";
		$resultado = mysqli_query($conn, $consulta);
		if ($resultado && mysqli_num_rows($resultado) > 0) {
			while($row = mysqli_fetch_assoc($resultado)) {      
				$obj[]=array('id'=>$row['id'],'phone'=>$row['phone'],'cedula'=>$row['cedula'],'nationality'=>$row['nationality'],'name'=>$row['name'],'second_name'=>$row['second_name'],'last_name'=>$row['last_name'],'second_last_name'=>$row['second_last_name'],'email'=>$row['email'],'birthday'=>$row['birthday'],'gender'=>$row['gender'],'address'=>$row['address'],'registration' => returnRegisterList($row['id']));
			}   
		}
		echo json_encode($obj); 
	}


	if(isset($_GET['user_list'])){
		$obj = array();
		$consulta = "SELECT * FROM user where isDeleted=0";
		$resultado = mysqli_query($conn, $consulta);
		if ($resultado && mysqli_num_rows($resultado) > 0) {
			while($row = mysqli_fetch_assoc($resultado)) {      
				$obj[]=array('user_id'=>$row['user_id'],'person_id'=>returnDatPerson($row['person_id']),'password'=>$row['password'],'isAdmin'=>$row['isAdmin'],'user_name'=>$row['user_name'],'isBlocked'=>$row['isBlocked']);
			}   
		}
		echo json_encode($obj); 
	}

	if(isset($_GET['subject_list'])){
		$obj = array();
		$consulta = "SELECT * FROM subject WHERE grupo_estable=0 AND isDeleted=0";
		$resultado = mysqli_query($conn, $consulta);
		if ($resultado && mysqli_num_rows($resultado) > 0) {
			while($row = mysqli_fetch_assoc($resultado)) {      
				$obj[]=array('id'=>$row['id'],'name'=>$row['name']);
			} 
		}
		echo json_encode($obj);   
	}

	if(isset($_GET['nested_subject_list'])){
		$obj = array();
		$consulta = "SELECT * FROM subject WHERE grupo_estable=1 AND isDeleted=0";
		$resultado = mysqli_query($conn, $consulta);
		if ($resultado && mysqli_num_rows($resultado) > 0) {
			while($row = mysqli_fetch_assoc($resultado)) {      
				$obj[]=array('id'=>$row['id'],'name'=>$row['name']);
			} 
		}
		echo json_encode($obj);   
	}

if(isset($_GET['section_student_list'])){
    
    $section_id = $_GET['id']; 
    $obj = array();
    $consulta = "SELECT * FROM registration WHERE section_id = $section_id";
    $resultado = mysqli_query($conn, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        while($row = mysqli_fetch_assoc($resultado)) {
            
			$person_id_result = returnPersonId_student($row['student_id']);

            if (mysqli_num_rows($person_id_result) > 0) {

                $person_id_row = mysqli_fetch_assoc($person_id_result);

                $person_data = returnDatPersonByStudentId($person_id_row['person_id']);
				
                $obj[] = array(
                    'id' => $row['id'],
                    'name' => $person_data['name'],
					'person_id' => $person_data['id'],
                    'last_name' => $person_data['last_name'],
                    'cedula' => $person_data['cedula']
                );
            } else {
                // Mensaje de depuración
                error_log('No se encontró el person_id para student_id: ' . $row['student_id']);
            }
        }
    } else {
        // Mensaje de depuración
        error_log('No se encontraron registros en registration para section_id: ' . $section_id);
    }
    
    // Ver la cantidad de entradas en el array obj
    error_log('Total de entradas en obj: ' . count($obj));
    
    echo json_encode($obj);
}

	

	

	if(isset($_GET['section_list'])){
		$period = $_GET['period']; //en el link get debe venir el periodo		
		echo json_encode(returnListSection($period)); 
	}






	if (isset($_GET['this_section_list'])) { 
		$section_id = $_GET['id']; 
		$consulta = "SELECT teacher_id, year, section_name FROM section WHERE id={$section_id}";
		$resultado = mysqli_query($conn, $consulta);
	
		$obj = array(); // Inicializa el array fuera del bucle
	
		while ($row = mysqli_fetch_assoc($resultado)) {
			// Inicializa $section_name con el valor original
			$year = $row['year'];
	
			// Mapea los nombres de las secciones a sus valores numéricos
		switch ($row['year']) {
			case 'primero':
				$year = '1er';
				break;
			case 'segundo':
				$year = '2do';
				break;	
			case 'tercero':
				$year = '3er';
				break;	
			case 'cuarto':
				$year = '4to';
				break;
			case 'quinto':
				$year = '5to';
				break;			
			default:
				$year = $row['year'];
				break;
		}
	
			$obj = array(
				'teacher_id' => $row['teacher_id'],
				'section_name' => $row['section_name'],
				'year' => $year
			);
		}
	
		echo json_encode($obj); 
	}
	












	if(isset($_GET['registration_list'])){
		//en el link get debe venir el periodo		
		echo json_encode(returnRegisterList()); 
	}	
	
	if(isset($_GET['next_section'])){
		echo json_encode(returnNextSection($_GET['year'],$_GET['period']));
	}
	

	if(isset($_GET['sorted_section_list'])){
		$year = $_GET['year'];
		$period = $_GET['period'];
		$obj = array();
		$consulta = "SELECT * FROM section where year = '$year' and period='$period'";
		$resultado = mysqli_query($conn, $consulta);
		if ($resultado && mysqli_num_rows($resultado) > 0) {
			while($row = mysqli_fetch_assoc($resultado)) {
				$obj[]=array('id'=>$row['id'],'year'=>$row['year'],'section_name'=>$row['section_name'],'teacher_id'=>returnDatPerson($row['teacher_id']),'quota'=>$row['quota'],'period'=>$row['period']);
			}   
		}
		echo json_encode($obj); 
	}

	
	if(isset($_GET['period_list'])){

		$obj = array();
		$consulta = "SELECT name FROM period order by name DESC";
		$resultado = mysqli_query($conn, $consulta);
		if ($resultado && mysqli_num_rows($resultado) > 0) {
			while($row = mysqli_fetch_assoc($resultado)) {
				$obj[]=array('period'=>$row['name']);
			}   
		}
		echo json_encode($obj); 
	}


	
	if(isset($_GET['routine_list'])){
		$section_id = $_GET['id'];
		$obj = array();
		$consulta = "SELECT * FROM work_charge where section_id = '$section_id'";
		$resultado = mysqli_query($conn, $consulta);
		while($row = mysqli_fetch_assoc($resultado)) {
			$obj[] = array(
				'id' => $row['id'],
				'teacher_id' => $row['teacher_id'],
				'subject_id' => $row['subject_id'],
				'section_id' => $row['section_id'],
				'day' => $row['day'],
				'start_hour' => $row['start_hour'],
				'end_hour' => $row['end_hour']
			);
		}
		echo json_encode($obj); 
		// Agrega esto para depurar
		if (json_last_error() !== JSON_ERROR_NONE) {
			echo 'Error en la codificación JSON: ' . json_last_error_msg();
		}
	}

	if(isset($_GET['routine_list_teacher'])) {

		$period = currentPeriod()['current_period'];
		$teacher_id = $_GET['teacher_id'];
		$obj = array();
		$consulta = "SELECT * FROM work_charge where teacher_id = '$teacher_id' AND period='$period'";
		$resultado = mysqli_query($conn, $consulta);
		while($row = mysqli_fetch_assoc($resultado)) {
			$subject_data = row_sqlconector("select name from subject where id={$row['subject_id']}");
			$section_data = row_sqlconector("select CONCAT(year, ' ', section_name) AS seccion from section where id={$row['section_id']} and period='$period'");
	
			$obj[] = array(
				'day' => $row['day'],
				'start_hour' => $row['start_hour'],
				'end_hour' => $row['end_hour'],
				'subject' => $subject_data['name'], 
				'section' => $section_data['seccion'] ?? null
			);
		}
		echo json_encode($obj); 
	
		// Agrega esto para depurar
		if (json_last_error() !== JSON_ERROR_NONE) {
			echo 'Error en la codificación JSON: ' . json_last_error_msg();
		}
	}
	
	if (isset($_GET['stadistic'])) {
		$periodData = currentPeriod();
		$period = $periodData['current_period'];
		$sumParent = 0;
		$sumTeacher = 0;
		$sumSection = 0;
		$sumStudent = 0;
	
		$consulta = "SELECT count(student_id) as total FROM registration WHERE period = '$period'";
		$resultado = mysqli_query($conn, $consulta);
		$row = mysqli_fetch_assoc($resultado);
		$sumStudent = $row['total'];
	
		$consulta = "SELECT count(*) as total FROM teacher";
		$resultado = mysqli_query($conn, $consulta);
		$row = mysqli_fetch_assoc($resultado);
		$sumTeacher = $row['total'];
	
		$consulta = "SELECT count(*) as total FROM section WHERE period = '$period'";
		$resultado = mysqli_query($conn, $consulta);
		$row = mysqli_fetch_assoc($resultado);
		$sumSection = $row['total'];
	
		$consulta = "SELECT COALESCE(COUNT(DISTINCT registration.parent_id), 0) AS total FROM registration INNER JOIN parent ON registration.parent_id = parent.person_id WHERE registration.period = '$period';";
		$resultado = mysqli_query($conn, $consulta);
		$row = mysqli_fetch_assoc($resultado);
		$sumParent = $row['total'];
	
		$obj = array(
			"period" => $period,
			"sumStudent" => $sumStudent,
			"sumTeacher" => $sumTeacher,
			"sumSection" => $sumSection,
			"sumParent" => $sumParent
		);
	
		echo json_encode($obj);
	}
	

	if(isset($_GET['reportStatistics'])){

		$period = $_GET['period'];
	
		$obj = array(
			"period" => $period,
			"studentGenders" => _studentGender($period,$conn),
			"teacherGenders" => _teacherGender($period,$conn),
			"studentByPeriod" => _studentByPeriod($period,$conn),
			"studentByTurn" => _studentsByTurn($period,$conn),
			"studentRelTotal" => _studentRelTotal($period,$conn),
			"sectionByTurn" => _sectionsByPeriodAndTurno($period,$conn),
			"teacherByQualification" => _teacherByQualification($conn),
			"teacherByDegree" => _teacherByDegree($conn),

		);

		echo json_encode($obj); 
	}

	
	if(isset($_GET['history_data'])){
		$obj = array();
		$consulta = "SELECT * FROM user_history";
		$resultado = mysqli_query($conn, $consulta);
   	 	
		if ($resultado && mysqli_num_rows($resultado) > 0) {
        	while($row = mysqli_fetch_assoc($resultado)) {      
            	$obj[]=array('action'=>$row['action'],'date'=>$row['date']);
        	}   
    	}
    echo json_encode($obj); 
}
    

	
if(isset($_GET['getStudentsByPeriod'])){
	$obj = array();
	$consulta = "SELECT * FROM user_history";
	$resultado = mysqli_query($conn, $consulta);
		
	if ($resultado && mysqli_num_rows($resultado) > 0) {
		while($row = mysqli_fetch_assoc($resultado)) {      
			$obj[]=array('action'=>$row['action'],'date'=>$row['date']);
		}   
	}
echo json_encode($obj); 
}


if (isset($_GET['section_teacher'])) {
    $period = $_GET['period']; // En el link get debe venir el periodo

    $consulta = "SELECT DISTINCT p.id, CONCAT(p.name, ' ', p.last_name) AS full_name, p.cedula 
                 FROM section s 
                 JOIN person p ON s.teacher_id = p.id 
                 WHERE s.period='$period'";

    $obj = array();
    $resultado = mysqli_query($conn, $consulta);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        while ($row = mysqli_fetch_assoc($resultado)) {
            $sections = returnSectionNamesByTeacher($row['id'], $period);
            $obj[] = array(
                'full_name' => $row['full_name'],
                'cedula' => $row['cedula'],
                'sections' => $sections
            );
        }
    }

    echo json_encode($obj);
}







}





function _studentGender($period,$conn){

	$studentGenders = [];

	if ($period === 'all') {
		$genderQuery = "SELECT p.gender, COUNT(*) AS count FROM student s JOIN person p ON s.person_id = p.id GROUP BY p.gender;";
	} else{
		$genderQuery = "SELECT p.gender, COUNT(*) AS count FROM student s JOIN person p ON s.person_id = p.id JOIN registration r ON s.person_id = r.student_id WHERE r.period = '{$period}' GROUP BY p.gender;";

	}
	$result = mysqli_query($conn, $genderQuery);
	if ($result) {			
		while($row = mysqli_fetch_assoc($result)) {
			if(isset($row['gender'])){
				$studentGenders[] = array(
					'gender' => $row['gender'],
					'count' => $row['count'],
				);
			}
		}
	}

	if(empty($studentGenders)){
		$studentGenders = [
			array('gender' => 'femenino', 'count' => '0'),
			array('gender' => 'masculino', 'count' => '0')
		];	
	}

	return $studentGenders;

}


function _teacherGender($period,$conn){

	$teacherGenders = [];

	$teacherGenderQuery = "SELECT p.gender, COUNT(t.id) AS total_teachers FROM Teacher t JOIN Person p ON t.person_id = p.id GROUP BY p.gender;";

	
	$result = mysqli_query($conn, $teacherGenderQuery);
	if ($result) {			
		while($row = mysqli_fetch_assoc($result)) {
			if(isset($row['gender'])){
				$teacherGenders[] = array(
					'gender' => $row['gender'],
					'total_teachers' => $row['total_teachers'],
				);
			}
		}
	}

	if(empty($teacherGenders)){
		$teacherGenders = [
			array('gender' => 'femenino', 'total_teachers' => '0'),
			array('gender' => 'masculino', 'total_teachers' => '0')
		];	
	}

	return $teacherGenders;

}



function _studentByPeriod($period, $conn) {
    $studentsByPeriod = [];

    if ($period === 'all') {
        $studentsByPeriodQuery = "SELECT period, COUNT(*) AS total_entries FROM registration GROUP BY period;";
    } else {
        $studentsByPeriodQuery = "SELECT period, COUNT(*) AS total_entries FROM registration WHERE period = '{$period}' GROUP BY period;";
    }

    $result = mysqli_query($conn, $studentsByPeriodQuery);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $studentsByPeriod[] = array(
                'period' => $row['period'],
                'total_entries' => $row['total_entries'],
            );
        }
    }

    if (empty($studentsByPeriod)) {
        $studentsByPeriod = [
            array('period' => '-', 'total_entries' => '0'),
        ];
    }

    return $studentsByPeriod;
}




function _teacherByQualification($conn) {
    $teacherByQualification = [];

    $query = "SELECT qualification, COUNT(*) AS number_of_teachers FROM teacher GROUP BY qualification";

    $result = mysqli_query($conn, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $teacherByQualification[] = array(
                'qualification' => $row['qualification'],
                'number_of_teachers' => $row['number_of_teachers'],
            );
        }
        mysqli_free_result($result); // Liberar el resultado después de usarlo
    } else {
        error_log('Query failed: ' . mysqli_error($conn)); // Loguear el error para depuración
    }

    if (empty($teacherByQualification)) {
        $teacherByQualification = [
            array('qualification' => '-', 'number_of_teachers' => '0'),
        ];
    }

    return $teacherByQualification;
}


function _teacherByDegree($conn) {
    $teacherByDegree = [];

    $query = "SELECT COALESCE(degree, second_degree) AS combined_degree, COUNT(*) AS number_of_teachers FROM teacher GROUP BY combined_degree;";

    $result = mysqli_query($conn, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $teacherByDegree[] = array(
                'combined_degree' => $row['combined_degree'],
                'number_of_teachers' => $row['number_of_teachers'],
            );
        }
        mysqli_free_result($result); // Liberar el resultado después de usarlo
    } else {
        error_log('Query failed: ' . mysqli_error($conn)); // Loguear el error para depuración
    }

    if (empty($teacherByDegree)) {
        $teacherByDegree = [
            array('combined_degree' => '-', 'number_of_teachers' => '0'),
        ];
    }

    return $teacherByDegree;
}



function _studentsByTurn($period, $conn) {
    $studentsByTurn = [];

    $timeCondition = "(STR_TO_DATE(w.start_hour, '%h:%i %p') < STR_TO_DATE('12:15 PM', '%h:%i %p') OR STR_TO_DATE(w.end_hour, '%h:%i %p') < STR_TO_DATE('12:15 PM', '%h:%i %p'))
                      OR (STR_TO_DATE(w.start_hour, '%h:%i %p') >= STR_TO_DATE('01:00 PM', '%h:%i %p') OR STR_TO_DATE(w.end_hour, '%h:%i %p') >= STR_TO_DATE('01:00 PM', '%h:%i %p'))";

    if ($period === 'all') {
        $studentsByTurnQuery = "
            SELECT 
                CASE
                    WHEN (STR_TO_DATE(w.start_hour, '%h:%i %p') < STR_TO_DATE('12:15 PM', '%h:%i %p') OR STR_TO_DATE(w.end_hour, '%h:%i %p') < STR_TO_DATE('12:15 PM', '%h:%i %p'))
                        THEN 'Mañana'
                    WHEN (STR_TO_DATE(w.start_hour, '%h:%i %p') >= STR_TO_DATE('01:00 PM', '%h:%i %p') OR STR_TO_DATE(w.end_hour, '%h:%i %p') >= STR_TO_DATE('01:00 PM', '%h:%i %p'))
                        THEN 'Tarde'
                    ELSE 'Otro'
                END AS turno,
                COUNT(DISTINCT r.student_id) AS total_estudiantes
            FROM 
                registration r
            JOIN 
                section s ON r.section_id = s.id
            JOIN 
                work_charge w ON s.id = w.section_id
            GROUP BY 
                turno
            ORDER BY 
                turno;
        ";
    } else {
        $studentsByTurnQuery = "
            SELECT 
                CASE
                    WHEN (STR_TO_DATE(w.start_hour, '%h:%i %p') < STR_TO_DATE('12:15 PM', '%h:%i %p') OR STR_TO_DATE(w.end_hour, '%h:%i %p') < STR_TO_DATE('12:15 PM', '%h:%i %p'))
                        THEN 'Mañana'
                    WHEN (STR_TO_DATE(w.start_hour, '%h:%i %p') >= STR_TO_DATE('01:00 PM', '%h:%i %p') OR STR_TO_DATE(w.end_hour, '%h:%i %p') >= STR_TO_DATE('01:00 PM', '%h:%i %p'))
                        THEN 'Tarde'
                    ELSE 'Otro'
                END AS turno,
                COUNT(DISTINCT r.student_id) AS total_estudiantes
            FROM 
                registration r
            JOIN 
                section s ON r.section_id = s.id
            JOIN 
                work_charge w ON s.id = w.section_id
            WHERE 
                s.period = '{$period}'
            GROUP BY 
                turno
            ORDER BY 
                turno;
        ";
    }

    $result = mysqli_query($conn, $studentsByTurnQuery);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $studentsByTurn[] = array(
                'turno' => $row['turno'],
                'total_estudiantes' => $row['total_estudiantes'],
            );
        }
    }

    if (empty($studentsByTurn)) {
        $studentsByTurn = [
            array('turno' => '-', 'total_estudiantes' => '0'),
        ];
    }

    return $studentsByTurn;
}




function _sectionsByPeriodAndTurno($period, $conn) {
    $sectionsByPeriodAndTurno = [];

    $timeCondition = "(STR_TO_DATE(w.start_hour, '%h:%i %p') < STR_TO_DATE('12:15 PM', '%h:%i %p') OR STR_TO_DATE(w.end_hour, '%h:%i %p') < STR_TO_DATE('12:15 PM', '%h:%i %p'))
                      OR (STR_TO_DATE(w.start_hour, '%h:%i %p') >= STR_TO_DATE('01:00 PM', '%h:%i %p') OR STR_TO_DATE(w.end_hour, '%h:%i %p') >= STR_TO_DATE('01:00 PM', '%h:%i %p'))";

    if ($period === 'all') {
        $sectionsByPeriodAndTurnoQuery = "
            SELECT 
                s.period,
                CASE
                    WHEN (STR_TO_DATE(w.start_hour, '%h:%i %p') < STR_TO_DATE('12:15 PM', '%h:%i %p') OR STR_TO_DATE(w.end_hour, '%h:%i %p') < STR_TO_DATE('12:15 PM', '%h:%i %p'))
                        THEN 'Mañana'
                    WHEN (STR_TO_DATE(w.start_hour, '%h:%i %p') >= STR_TO_DATE('01:00 PM', '%h:%i %p') OR STR_TO_DATE(w.end_hour, '%h:%i %p') >= STR_TO_DATE('01:00 PM', '%h:%i %p'))
                        THEN 'Tarde'
                    ELSE 'Otro'
                END AS turno,
                COUNT(DISTINCT s.id) AS total_secciones
            FROM 
                section s
            JOIN 
                work_charge w ON s.id = w.section_id
            GROUP BY 
                s.period, turno
            ORDER BY 
                s.period, turno;
        ";
    } else {
        $sectionsByPeriodAndTurnoQuery = "
            SELECT 
                s.period,
                CASE
                    WHEN (STR_TO_DATE(w.start_hour, '%h:%i %p') < STR_TO_DATE('12:15 PM', '%h:%i %p') OR STR_TO_DATE(w.end_hour, '%h:%i %p') < STR_TO_DATE('12:15 PM', '%h:%i %p'))
                        THEN 'Mañana'
                    WHEN (STR_TO_DATE(w.start_hour, '%h:%i %p') >= STR_TO_DATE('01:00 PM', '%h:%i %p') OR STR_TO_DATE(w.end_hour, '%h:%i %p') >= STR_TO_DATE('01:00 PM', '%h:%i %p'))
                        THEN 'Tarde'
                    ELSE 'Otro'
                END AS turno,
                COUNT(DISTINCT s.id) AS total_secciones
            FROM 
                section s
            JOIN 
                work_charge w ON s.id = w.section_id
            WHERE 
                s.period = '{$period}'
            GROUP BY 
                s.period, turno
            ORDER BY 
                s.period, turno;
        ";
    }

    $result = mysqli_query($conn, $sectionsByPeriodAndTurnoQuery);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $sectionsByPeriodAndTurno[] = array(
                'period' => $row['period'],
                'turno' => $row['turno'],
                'total_secciones' => $row['total_secciones'],
            );
        }
    }

    if (empty($sectionsByPeriodAndTurno)) {
        $sectionsByPeriodAndTurno = [
            array('period' => '-', 'turno' => '-', 'total_secciones' => '0'),
        ];
    }

    return $sectionsByPeriodAndTurno;
}




function _studentRelTotal($period,$conn) {

    $studentRelTotal = [];

	if ($period === 'all') {
		$query = "SELECT student_rel, COUNT(student_rel) as total FROM `registration` GROUP by student_rel";
    } else {
		$query = "SELECT student_rel, COUNT(student_rel) as total FROM `registration` WHERE period='$period' GROUP by student_rel";
    }

    $result = mysqli_query($conn, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $studentRelTotal[] = array(
                'student_rel' => $row['student_rel'],
                'total' => $row['total'],
            );
        }
        mysqli_free_result($result); // Liberar el resultado después de usarlo
    } else {
        error_log('Query failed: ' . mysqli_error($conn)); // Loguear el error para depuración
    }

    if (empty($studentRelTotal)) {
        $studentRelTotal = [
            array('student_rel' => '-', 'total' => '0'),
        ];
    }

    return $studentRelTotal;
}











?>



