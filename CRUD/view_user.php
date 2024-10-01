<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>User Information</h1>
        </div>
        <?php
            $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: ID not found.');
            include 'database.php';
            try {
                $query = "SELECT id, mm_manalo, mm_marie, mm_female, mm_email, mm_address FROM mm WHERE id = ? LIMIT 0,1";
                $stmt = $con->prepare($query);
                $stmt->bindParam(1, $id);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $mm_manalo = $row['mm_manalo'];
                $mm_gellie = $row['mm_marie'];
                $mm_female = $row['mm_female'];
                $mm_email = $row['mm_email'];
                $mm_address = $row['mm_address'];
            }
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        ?>
        <table class='table table-responsive'>
            <tr>
                <td>Last Name</td>
                <td><?php echo htmlspecialchars($mm_manalo, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>First Name</td>
                <td><?php echo htmlspecialchars($mm_gellie, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td><?php echo htmlspecialchars($mm_female, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo htmlspecialchars($mm_email, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><?php echo htmlspecialchars($mm_address, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href='index.php' class='btn btn_back'>Back to users</a>
                </td>
            </tr>
        </table>

    </div> 
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>