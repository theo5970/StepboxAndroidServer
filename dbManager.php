<?php 

    define('FAIL', "0;");
    define('SUCCESS', "1;");

    //유니티로부터 DB 접속 정보를 받아서 대입
    //$db_host = $_POST["db_host"];   
    //$db_user = $_POST["db_user"];
    //$db_passwd = $_POST["db_passwd"];
    //$db_name = $_POST["db_name"];

    $db_host = "localhost";    
    $db_user = "test";
    $db_passwd = "Rpdlaahqkdlf123!@#";
    $db_name = "test";

    echo $db_host;
    echo $db_user;
    echo $db_passwd;
    echo $db_name;

    echo "<br>";

    //Create database connection 
    $conn = mysqli_connect($db_host, $db_user, $db_passwd, $db_name)    //mysqli를 통해 접속한다. i가 붙은게 훨씬 빠르고 안정성이 높다고 한다.
        or die(FAIL."데이터베이스 연결 중에 문제가 발생하였습니다.");    //실패하면 php를 종료하고 실패 문구 출력
	mysqli_set_charset($conn,"utf8");
    

    //$query = $_POST["Query"];
    //$query = stripslashes($query);  //역슬래쉬 제거
    $query = "select * from test";

    //유니티로부터 받은 쿼리문 실행
    $result = mysqli_query($conn, $query) or die ("Invalid query: " . $query);
    
    //Initialize array variable 
    $dbdata = array(); 
    
    echo $query;
    echo "<br>";

    //select 쿼리
    if(strcasecmp($query[0],"s") == 0){
		if($result)
		{
			//Fetch into associative array 
            while ( $row = $result->fetch_assoc()) { 
                $dbdata[]=$row; 
            } 
            
            //Print array in JSON format 
            echo SUCCESS.json_encode($dbdata); 
		}
		else
		{
            echo FAIL.mysqli_error($conn);    //실패 이유를 보낸다.
            mysqli_close($conn);    //연결 된 DB를 해제한다.
			exit;
		}
    }
    //insert or update 쿼리
	else if(strcasecmp($query[0],"i") == 0 || strcasecmp($query[0],"u") == 0){
		if($result)
		{
			//$jsonText = "";
			echo SUCCESS;
			
			
			echo true;
			

			//SelectAll($conn);    //필요없지만 확인을 위해 DB 내의 모든 데이터를 출력한다.
		}
		else
		{
			echo FAIL.mysqli_error($conn);    //실패 이유를 보낸다.
			mysqli_close($conn);    //연결 된 DB를 해제한다.
			exit;
		}
    }
    //delete 쿼리
	else if(strcasecmp($query[0],"d") == 0){
		if($result)
		{
			//$jsonText = "";
			echo SUCCESS;
			
			
			echo true;
			

			//SelectAll($conn);    //필요없지만 확인을 위해 DB 내의 모든 데이터를 출력한다.
		}
		else
		{
			echo FAIL.mysqli_error($conn);    //실패 이유를 보낸다.
			mysqli_close($conn);    //연결 된 DB를 해제한다.
			exit;
		}
    }
    
    
?>
