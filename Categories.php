<?php 
require_once './includes/db.php';
require_once './includes/fucntion.php';
require_once './includes/sessions.php';
require_once 'dateTime.php'; 
require_once 'AdminHeader.php';

$_SESSION["trackengURL"] = $_SERVER['PHP_SELF']; 
confirm_login();

if (isset($_POST['submit'])) {
    $category = $_POST['CategoryTitle'];
    $admin = $_SESSION['user_name'];

    if (empty($category)) {
        $_SESSION['ErrorMassage'] = 'All fiels must be no empty';
        redirect("Categories.php");
    } else if (strlen($category) < 3) {
        $_SESSION['ErrorMassage'] = 'Too short category';
        redirect("Categories.php");
    } else if (strlen($category) > 49) {
        $_SESSION['ErrorMassage'] = 'Too big category';
        redirect("Categories.php");
    } else {
        // добавляется новоая категори в бд
        $sql = "INSERT INTO category(title, author, datetime)";
        $sql .= "VALUES(:categoryName, :adminName, :data)";
        $stmt = $connecting->prepare($sql);
        $stmt->bindValue(':categoryName', $category);
        $stmt->bindValue(':adminName', $admin);
        $stmt->bindValue(':data', $datatime);
        $execute = $stmt->execute();

        if ($execute) {
            $_SESSION['SuccessMassage'] = "Category with id: " . $connecting->lastInsertId() . " Added";
            redirect("Categories.php"); 
        } else {
            $_SESSION['ErrorMassage'] = 'Something wrong. Try !';
            redirect("Categories.php");
        }
    }
}

?>


    <!-- Main area -->

    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10">
                <?php echo error_massage(); echo success_massage();?>
                <form action="Categories.php" method="post">
                    <div class="card bg-secondary text-light">
                        <div class="card-header">
                            <h1>Add new Categories</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="CategoryTitle"><span class="fieldinfo"> Category Title: </span></label>
                                <input class="form-control" type="text" name="CategoryTitle" id="title">
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block">
                                        <i class="fas fa-arrow-left"></i>
                                        Back to Dashboard
                                    </a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                   <button type='submit' name="submit" class="btn btn-success btn-block">
                                   <i class="fas fa-check"></i>
                                   Publish
                                   </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <h1>Existing Categories</h1>
                <hr>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Date&Time</th>
                            <th>Category name</th>
                            <th>Creator name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                
                <?php 
                global $connecting;
                $sql = "SELECT * FROM category ORDER BY id desc";
                $execute = $connecting->query($sql);
                $count = 0;
                while($row = $execute->fetch()):?> 
                <?php
                    $categoryID = $row['id'];
                    $category_date = $row['datetime'];
                    $category_name = $row['title'];
                    $creater_name = $row['author'];
                    $count++;
                    if (strlen($commenter_name) > 10) {
                        $commenter_name = substr($commenter_name, 0, 10) . '..';
                    }
                ?>
                    <tbody>
                        <tr>
                            <td><?php echo htmlentities($count);?></td>
                            <td><?php echo htmlentities($category_date);?></td>
                            <td><?php echo htmlentities($category_name);?></td>
                            <td><?php echo htmlentities($creater_name);?></td>
                            <td><a class="btn btn-danger" href="DeleteCategory.php?id=<?php echo $categoryID?>">Delete</a></td>
                        </tr>
                    </tbody>
                <?php endwhile;?>
                </table>
            </div>
        </div>
    </section>

    <!-- Main area END-->


    <?php require_once 'footer.php';?>