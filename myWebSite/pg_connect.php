<?
    $host   = 'localhost';
    $db     = 'mydb';
    $user   = 'postgres';
    $pass   = 'new_password';
    $port   = '5432'; //Default PostgreSQL port


    $connect_string = ()"host=$host port=$port dbname=$db user=$user password=$pass");
    $conn = pg_connect($connect_string);

    if($conn)
        //handle Get request to fetch database
        {
            if($_SERVER['REQUEST_METHOD'] === 'GET')
            {
                $result = 
            }
        }
        pg_close($conn);


?>