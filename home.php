<?php 

//home.php

session_start();

if(!isset($_SESSION['user_session_id']))
{
    header('location:index.php');
}

?>

<!doctype html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        
    </head>
    <body>

        <div class="container">

            <div class="mt-5 mb-5">

            
            <h2>Welcome User</h2>
            <p><a href="logout.php">Logout</a></p>
            <?php 
            echo '<pre>';
            print_r($_SESSION);
            echo '</pre>';
            ?>
            </div>

        </div>
    </body>
</html>

<script>

function check_session_cnt()
{
    var session_id = "<?php echo $_SESSION['user_session_id']; ?>";

    fetch('check_login.php').then(function(response){

        return response.json();

    }).then(function(responseData){

        if(responseData.output == 'logout')
        {
            // confirm("your account get logged in more than 2devices\nEither OK for get logged them all out or Cancel to contine .");

            if (confirm("your account get logged in more than 2devices\nEither OK for get logged them all out or Cancel to contine .") == true) {
                    window.location.href = 'logout.php';
                } else {
                    window.location.href = 'home.php';
                }
            // alert("you are logged in with more than two devices your all account getting logged out");
        }

    });
}



setInterval(function(){

    check_session_cnt();
    
}, 10000);

</script>