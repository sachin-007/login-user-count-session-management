<?php 


include 'database_connection.php';

$message = '';
$cnt=0;

if(isset($_POST["login_button"]))
{
    $formdata = array();

    if(empty($_POST["user_email"]))
    {
        $message .= '<li>Email Address is required</li>';
    }
    else
    {
        if(!filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL))
        {
            $message .= '<li>Invalid Email Address</li>';
        }
        else
        {
            $formdata['user_email'] = $_POST['user_email'];
        }
    }

    if(empty($_POST['user_password']))
    {
        $message .= '<li>Password is required</li>';
    }
    else
    {
        $formdata['user_password'] = $_POST['user_password'];
    }

    if($message == '')
    {
        $data = array(
            ':user_email'       =>  $formdata['user_email']
        );

        $query = "
        SELECT * FROM user_login 
        WHERE user_email = :user_email
        ";

        $statement = $connect->prepare($query);

        $statement->execute($data);

        if($statement->rowCount() > 0)
        {
            foreach($statement->fetchAll() as $row)
            {
                if($row['user_password'] == $formdata['user_password'])
                {
                    session_start();

                    
                    session_regenerate_id();
                    
                    $user_session_id = session_id();

                    $_SESSION['session_cnt']=$row['session_cnt']+1;


                    $sec=$_SESSION['session_cnt'];


                    $query = "
                    UPDATE user_login 
                    SET user_session_id = '".$user_session_id."',
                        session_cnt='".$sec."' 
                    WHERE user_id = '".$row['user_id']."'
                    ";

                    $connect->query($query);

                    $_SESSION['user_id'] = $row['user_id'];

                    $_SESSION['user_session_id'] = $user_session_id;

                    header('location:home.php');
                }
                else
                {
                    $message = '<li>Wrong Password</li>';
                }
            }
        }
        else
        {
            $message = '<li>Wrong Email Address</li>';
        }
    }
}

?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    </head>
    <body>

        <div class="container">

            <div class="row">
                <div class="col-md-3">&nbsp;</div>
                <div class="col-md-6">
                    <?php 
                    if($message != '')
                    {
                        echo '<div class="alert alert-danger"><ul>'.$message.'</ul></div>';
                    }
                    ?>
                    <div class="card">
                        <div class="card-header">Login</div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Email address</label>
                                    <input type="text" name="user_email" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="user_password" class="form-control" />
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <input type="submit" name="login_button" value="Login" class="btn btn-primary" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

