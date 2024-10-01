<!DOCTYPE HTML>
<html>
<head>
    <title>CRUD</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Create New User Data</h1>
        </div>

        <?php
            if($_POST){
                include 'database.php';
                try{
                    $query = "INSERT INTO mm (mm_marie, mm_manalo, mm_female, mm_email, mm_address)
                    VALUES (:fname, :lname, :gender, :email, :address)";

                    $stmt = $con->prepare($query);

                    $fname = htmlspecialchars(strip_tags($_POST['fname']));
                    $lname = htmlspecialchars(strip_tags($_POST['lname']));
                    $gender = htmlspecialchars(strip_tags($_POST['gender']));
                    $email = htmlspecialchars(strip_tags($_POST['email']));
                    $address = htmlspecialchars(strip_tags($_POST['address']));
                    
                    $stmt->bindParam(':fname', $fname);
                    $stmt->bindParam(':lname', $lname);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':address', $address);

                    if($stmt->execute()){
                        echo "<div class='alert alert-success'>Saved.</div>";
                    }else{
                        echo "<div class='alert alert-danger'>Unable to save.</div>";
                    }
                }

                catch(PDOException $exception){
                    die('ERROR: ' . $exception->getMessage());
                }
            }
            ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <table class='table table-responsive'>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='fname' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='lname' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td><input type='text' name='gender' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type='text' name='email' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><input type='text' name='address' class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn_save' />
                        <a href='index.php' class='btn btn_view'>View Users</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>