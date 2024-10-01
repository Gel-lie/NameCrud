<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Update a Record - PHP CRUD Tutorial</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Update User Information</h1>
        </div>
        <?php

        $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record User ID not found.');
        include 'database.php';

        try {
            $query = "SELECT id, mm_manalo, mm_marie, mm_email, mm_female, mm_address FROM mm WHERE id = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            $stmt->bindParam(1, $id);

            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $manalo = $row['mm_manalo'];
            $marie = $row['mm_marie'];
            $email = $row['mm_email'];
            $female = $row['mm_female']; 
            $address = $row['mm_address']; 
        }

        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php
            if($_POST){
                try{
                    $query = "UPDATE mm
                                SET mm_manalo=:manalo, mm_marie=:marie, mm_email=:email, mm_female=:female, mm_address=:address
                                WHERE id = :id";

                    $stmt = $con->prepare($query);

                    $last_name=htmlspecialchars(strip_tags($_POST['mm_manalo']));
                    $first_name=htmlspecialchars(strip_tags($_POST['mm_marie']));
                    $email=htmlspecialchars(strip_tags($_POST['mm_email']));
                    $gender=htmlspecialchars(strip_tags($_POST['mm_female']));
                    $address=htmlspecialchars(strip_tags($_POST['mm_address']));

                    $stmt->bindParam(':manalo', $manalo);
                    $stmt->bindParam(':marie', $marie);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':female', $female);
                    $stmt->bindParam(':address', $address);
                    $stmt->bindParam(':id', $id);

                    if($stmt->execute()){
                        echo "<div class='alert alert-success'>Record was updated.</div>";
                    }else{
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
                catch(PDOException $exception){
                    die('ERROR: ' . $exception->getMessage());
                }
            }
        ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-responsive'>
        <tr>
            <td>Last Name</td>
            <td><input type='text' name='mm_manalo' value="<?php echo htmlspecialchars($manalo, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>First Name</td>
            <td><input type='text' name='mm_marie' value="<?php echo htmlspecialchars($marie, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type='text' name='mm_email' value="<?php echo htmlspecialchars($email, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Gender</td>
            <td><input type='text' name='mm_female' value="<?php echo htmlspecialchars($female, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Address</td>
            <td><input type='text' name='mm_address' value="<?php echo htmlspecialchars($address, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save Changes' class='btn btn_save' />
                <a href='index.php' class='btn btn_back'>Back to read records</a>
            </td>
        </tr>
    </table>
</form>

    </div> 
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>