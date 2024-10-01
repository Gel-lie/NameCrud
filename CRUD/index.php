<!DOCTYPE HTML>
<html>
<head>
    <title>CRUD</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <style>
    .m-r-1em{ margin-right:1em; }
    .m-b-1em{ margin-bottom:1em; }
    .m-l-1em{ margin-left:1em; }
    .mt0{ margin-top:0; }
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>User Informations</h1>
        </div>

        <div class="form">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
                <div class="form-group">
                    <label for="searchLastName">Search by Last Name:</label>
                    <input type="text" name="searchLastName" id="searchLastName" class="form-control" />
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <?php
                include 'database.php';

                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $records_per_page = 5;
                $from_record_num = ($records_per_page * $page) - $records_per_page;
                $action = isset($_GET['action']) ? $_GET['action'] : "";

                if ($action == 'deleted') {
                    echo "<div class='alert alert-success'>Record has been deleted.</div>";
                }

                $searchLastName = isset($_GET['searchLastName']) ? $_GET['searchLastName'] : "";
                $query = "SELECT id, mm_manalo, mm_marie, mm_email, mm_female, mm_address
                        FROM mm
                        WHERE mm_manalo LIKE :searchLastName
                        ORDER BY id DESC
                        LIMIT :from_record_num, :records_per_page";

                $stmt = $con->prepare($query);
                $stmt->bindParam(":searchLastName", $searchLastName, PDO::PARAM_STR);
                $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
                $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
                $stmt->execute();

                $num = $stmt->rowCount();

                if ($num > 0) {
                    echo "<table class='table table-responsive'>";
                    echo "<tr>
                        <th>ID</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Address</th>
                    </tr>";

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<tr>
                            <td>{$id}</td>
                            <td>{$mm_manalo}</td>
                            <td>{$mm_marie}</td>
                            <td>{$mm_female}</td>
                            <td>{$mm_email}</td>
                            <td>{$mm_address}</td>
                            <td>
                                <a href='view_user.php?id={$id}' class='btn btn_view m-r-1em'>Read</a>
                                <a href='update.php?id={$id}' class='btn btn_update m-r-1em'>Update</a>
                                <a href='#' onclick='delete_user({$id});' class='btn btn_delete'>Delete</a>
                            </td>
                        </tr>";
                    }

                    echo "</table>";

                    $query = "SELECT COUNT(*) as total_rows FROM mm";
                    $stmt = $con->prepare($query);
                    $stmt->execute();

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $total_rows = $row['total_rows'];

                    $page_url="index.php?";
                    include_once "paging.php";
                } else {
                    echo "<div class='alert alert-danger'>No records found.</div>";
                }
            ?>
        </div>
        <?php
            include 'database.php';

            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $records_per_page = 5;
            $from_record_num = ($records_per_page * $page) - $records_per_page;
            $action = isset($_GET['action']) ? $_GET['action'] : "";

            if($action=='deleted'){
                echo "<div class='alert alert-success'>Record has been deleted.</div>";
            }

            $query = "SELECT id, mm_manalo, mm_marie, mm_email, mm_female, mm_address FROM mm ORDER BY id DESC
                        LIMIT :from_record_num, :records_per_page";
            $stmt = $con->prepare($query);
            $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
            $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
            $stmt->execute();

            $num = $stmt->rowCount();

            echo "<a href='create.php' class='btn btn_update m-b-1em'>Add New User</a>";

            if($num>0){

                echo "<table class='table table-responsive'>";
                echo "<tr>
                    <th>ID</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Address</th>
                </tr>";

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
    
                    echo "<tr>
                        <td>{$id}</td>
                        <td>{$mm_manalo}</td>
                        <td>{$mm_marie}</td>
                        <td>{$mm_female}</td>
                        <td>{$mm_email}</td>
                        <td>{$mm_address}</td>
                        <td>";

                            echo "<a href='view_user.php?id={$id}' class='btn btn_view m-r-1em'>Read</a>";

                            echo "<a href='update.php?id={$id}' class='btn btn_update m-r-1em'>Update</a>";

                            echo "<a href='#' onclick='delete_user({$id});'  class='btn btn_delete'>Delete</a>";
                        echo "</td>";
                    echo "</tr>";
                }

                echo "</table>";

                $query = "SELECT COUNT(*) as total_rows FROM mm";
                $stmt = $con->prepare($query);
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $total_rows = $row['total_rows'];

                $page_url="index.php?";
                include_once "paging.php";
            }

            else{
                echo "<div class='alert alert-danger'>No records found.</div>";
            }
            ?>
    </div>  

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type='text/javascript'>
function delete_user( id ){
    var answer = confirm('Do you want to delete this user?');
    if (answer){
        window.location = 'delete.php?id=' + id;
    }
}
</script>
</body>
</html>