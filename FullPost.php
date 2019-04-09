<?php
require_once './includes/db.php';
require_once './includes/fucntion.php';
require_once './includes/sessions.php';
require_once 'dateTime.php';
require_once 'DefaultHeader.php';

$search_query_parametr = $_GET["id"];

//var_dump($search_query_parametr);

if (isset($_POST['submit'])) {

    $name = $_POST['commenterName'];
    $email = $_POST['commenterEmail'];
    $comment = $_POST['commenterText'];

    if (empty($name) || empty($email) || empty($comment)) {
        $_SESSION['ErrorMassage'] = 'All fiels must be no empty';
        redirect("FullPost.php?id=$search_query_parametr");
    } else if (strlen($comment) > 1000) {
        $_SESSION['ErrorMassage'] = 'Too big Comment';
        redirect("FullPost.php?id=$search_query_parametr");
    } else {
        // добавляется новоая категори в бд
        $sql = "INSERT INTO comments(datetime, name, email, comment, approvedby, status, post_id)";
        $sql .= "VALUES(:data, :name, :email, :comment, 'Pending', 'OFF', :postIdFromURL)";
        $stmt = $connecting->prepare($sql);
        $stmt->bindValue(':data', $datatime);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':comment', $comment);
        $stmt->bindValue(':postIdFromURL', $search_query_parametr);
        $execute = $stmt->execute();

        if ($execute) {
            $_SESSION['SuccessMassage'] = "Comment Submited";
            redirect("FullPost.php?id=$search_query_parametr");
        } else {
            $_SESSION['ErrorMassage'] = 'Something wrong. Try !';
            redirect("FullPost.php?id=$search_query_parametr");
        }
    }
}

?>


    <div class="container">
        <div class="row mt-4 mb-4">
            <div class="col-sm-8">
                <h1>Solo Back End with Admin Pannel</h1>
                <h2 class="lead">API for retards and for Maxim (hes reard for sure!)</h2>
                <?php 
                echo error_massage(); 
                echo success_massage();?>
                <?php
                global $connecting; 
                if (isset($_GET["searchButton"])) {
                    $search = $_GET["search"];
                    $sql = "SELECT * FROM posts WHERE datetime LIKE :search
                            OR title LIKE :search OR category LIKE :search
                            OR post LIKE :search";
                    $stmt = $connecting->prepare($sql);
                    $stmt->bindValue(':search', '%'.$search.'%');
                    $stmt->execute();
                } else {
                    $postIdFromURL = $_GET["id"];
                    $sql = "SELECT * FROM posts WHERE id='$postIdFromURL'";
                    $stmt = $connecting->query($sql);
                }
                while($row = $stmt->fetch()):?>
                <?php    
                    $postId = $row['id'];
                    $datetime = $row['datetime'];
                    $postTitle = $row['title'];
                    $category = $row['category'];
                    $admin = $row['author'];
                    $image = $row['image'];
                    $postText = $row['post'];
                 
                ?>
              
                <div class="card mb-4">
                    <img class="img-fluid card-img-top" src="./upload/<?php echo $image; ?>" alt="post-image">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo htmlentities($postTitle);?></h4>
                        <small class="text-muted">
                            Category:
                            <span class="text-dark">
                            <a href="Blog.php?category=<?php echo $category; ?>">
                            <?php echo htmlentities($category); ?>
                            </a> 
                            </span>
                            Written By
                            <span class="text-dark">
                            <a href="Profile.php?username=<?php echo $admin; ?>">
                            <?php echo htmlentities($admin); ?>
                            </a>
                            </span> 
                            On
                            <span class="text-dark">
                            <?php echo htmlentities($datetime);?>
                            </span>
                        </small>
                        <hr>
                        <p class="card-text">
                            <?php echo nl2br($postText);?>
                        </p>
                    </div>
                </div>
                <?php endwhile; ?>
                <span class="fieldinfo">Comments</span>
                <hr>
                <?php 
                global $connecting;
                $sql = "SELECT * FROM comments WHERE post_id = '$search_query_parametr'
                AND status = 'ON'";
                $stmt = $connecting->query($sql);
                while ($row = $stmt->fetch()): ?>
                <?php
                $commentDate = $row['datetime'];
                $commenterName = $row['name'];
                $commentText = $row['comment']; 
                ?>
                <div>
                    <div class="media comment-block">
                        <img src="./images/comment.png" width="40px;" height="40px;" alt="comment-img">
                        <div class="media-body ml-2">
                            <h6 class="lead">
                                <?php echo htmlentities($commenterName) ;?>
                            </h6>
                            <p class="small">
                                <?php echo htmlentities($commentDate);?>
                            </p>
                            <p>
                            <?php echo htmlentities($commentText);?>
                            </p>
                        </div>
                    </div>
                </div>
                <hr>
                <?php endwhile; ?>
                <div>
                <form method="post" action="FullPost.php?id=<?php echo $search_query_parametr;?>">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="fieldinfo">Comment Post</h5>
                        </div>
                        <div class="card-body">
                            <div class="form group">
                                <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input class="form-control" type="text" name="commenterName" placeholder="name">
                                </div>
                            </div>
                            <div class="form group mt-3">
                                <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input class="form-control" type="email" name="commenterEmail" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <textarea class="form-control" name="commenterText" cols="80" rows="6">

                                </textarea>
                            </div>
                            <div>
                                <button type="submit" name="submit" class="btn btn-primary">Comment</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <?php require_once 'SideBar.php';?>
           <?php require_once 'footer.php';?>