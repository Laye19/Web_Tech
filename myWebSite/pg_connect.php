<?php
//Set the header to JSON type to return JSON data to the client side (JavaScript) 
header('Content-Type: application/json');

    //Database connection
    $host   = 'localhost';
    $port   = '5432'; //Default PostgreSQL port
    $db     = 'mydb';
    $user   = 'postgres';
    $pass   = 'new_password';
    


    $conn_string = ("host=$host port=$port dbname=$db user=$user password=$pass");
    $dbconn = pg_connect($conn_string);

    //Check if the connection is successful 
    if($dbconn){
        echo json_decode(['error' => 'Could not connect to the database']);
        exit;
    }

    //Get the request method of the client request (GET, POST, PUT, DELETE) 
    $request_method = $_SERVER['REQUEST_METHOD'];   

        switch($request_method){
            case 'GET':
              $result = pg_query($dbconn, "SELECT * FROM mytable");
              if($result){
                echo json_encode(['error' => pg_last_error($dbconn)]);
                pg_close($dbconn);  
                exit;
              }

              $student = pg_fetch_all($result);
              if(!$students){
                $students = [];
              } 
                echo json_encode($student);
                break;
            
                case 'POST':
                    $data = json_decode(file_get_contents('php://input'), true);
            
                    $name = $data['name'];
                    $rollno = $data['rollno'];
                    $age = $data['age'];
                    $city = $data['city'];
                    $country = $data['country'];
            
                    $query = 'INSERT INTO student (name, rollno, age, city, country) VALUES ($1, $2, $3, $4, $5)';
                    $result = pg_query_params($dbconn, $query, array($name, $rollno, $age, $city, $country));
            
                    if ($result) {
                        echo json_encode(['message' => 'Student added successfully']);
                    } else {
                        echo json_encode(['error' => pg_last_error($dbconn)]);
                    }
                    break;
            
                case 'PUT':
                    $data = json_decode(file_get_contents('php://input'), true);
            
                    $id = $data['id'];
                    $name = $data['name'];
                    $rollno = $data['rollno'];
                    $age = $data['age'];
                    $city = $data['city'];
                    $country = $data['country'];
            
                    $query = 'UPDATE student SET name = $1, rollno = $2, age = $3, city = $4, country = $5 WHERE id = $6';
                    $result = pg_query_params($dbconn, $query, array($name, $rollno, $age, $city, $country, $id));
            
                    if ($result) {
                        echo json_encode(['message' => 'Student updated successfully']);
                    } else {
                        echo json_encode(['error' => pg_last_error($dbconn)]);
                    }
                    break;
            
                default:
                    echo json_encode(['error' => 'Invalid request method']);
                    break;
            }

        pg_close($dbconn);


?>