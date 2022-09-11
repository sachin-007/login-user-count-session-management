<?php 
include 'database_connection.php';

session_start();


$query2= "
SELECT session_cnt FROM user_login 
WHERE user_id = '".$_SESSION['user_id']."'
";

$max_login=3;

$result3 = $connect->query($query2);

foreach($result3 as $row){
	if($row['session_cnt']>=$max_login){
		$data['output'] = 'logout';
	}
	else
	{
		$data['output'] = 'login';
	}
}
echo json_encode($data);




$query = "
	SELECT user_session_id,session_cnt FROM user_login 
	WHERE user_id = '".$_SESSION['user_id']."'
";

$result = $connect->query($query);

foreach($result as $row)
{
	if($_SESSION['user_session_id'] != $row['user_session_id'])
	{
		$_SESSION['session_cnt']=$row['session_cnt']+1;

		$secse=$_SESSION['session_cnt'];

		$query1 = "
                    UPDATE user_login 
                    SET session_cnt='".$secse."' 
                    WHERE user_id = '".$row['user_id']."'
                    ";

                    $connect->query($query1);

		
	}
}

?>
