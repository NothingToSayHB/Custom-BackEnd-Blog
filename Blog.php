<?php
require_once './includes/db.php';
require_once './includes/fucntion.php';
require_once './includes/sessions.php';
require_once 'dateTime.php';
require_once 'DefaultHeader.php';
?>


    <div class="container">

        <div class="row mt-4 mb-4">

            <div class="col-sm-8">
            <?php 
            echo error_massage(); 
            echo success_massage();
            ?>
                <h1>Solo Back End with Admin Pannel</h1>
                <h2 class="lead">API for retards and for Maxim (hes reard for sure!)</h2>
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
                } else if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                    if ($page == 0 || $page < 1) {
                        $show_post_from = 0; 
                    } else {
                        $show_post_from = ($page*4) - 4;
                    }
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT $show_post_from,4";
                    $stmt = $connecting->query($sql);
                } else if (isset($_GET['category'])) {
                    $category = $_GET['category'];
                    $sql = "SELECT * FROM posts WHERE category = :category ORDER BY id desc";
                    $stmt = $connecting->prepare($sql);
                    $stmt->bindValue(':category', $category);
                    $stmt->execute();
                } else {
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
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
                            <a href="Blog.php?category=<?php echo $category?>">
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
                        <span class="badge badge-dark" style="float:right;">
                        Comment <?php echo approve_comments_acording_to_post($postId, 'ON');?>
                        </span>
                        <hr>
                        <p class="card-text">
                            <?php if (strlen($postText) > 150) $postText = substr($postText, 0, 150). ' ...'; ?>
                            <?php echo nl2br($postText);?>
                        </p>
                        <a href="FullPost.php?id=<?php echo $postId; ?>" style="float:right;">
                        <span class="btn btn-info">Read more >></span>
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
                <nav>
                    <ul class="pagination pagination-lg">
                        <!-- кнопка назад -->
                         <?php if (isset($page)) {
                            if ($page > 1) { ?>
                            <li class="page-item">
                                <a href="Blog.php?page=<?php echo $page - 1?>" class="page-link">&laquo;</a>
                            </li>
                        <?php } } ?>
                        <?php 
                        global $connecting;
                        $sql = "SELECT COUNT(*) FROM posts";
                        $stmt = $connecting->query($sql);
                        $row_pagination = $stmt->fetch();
                        $total_posts = array_shift($row_pagination); // 15
                        $post_pagination = $total_posts/4; // 4 almost .. 3.75 ok
                        $post_pagination = ceil($post_pagination); // 4 :p

                        for ($i = 1; $i <= $post_pagination; $i++) {
                         if (isset($page)){
                            if ($i == $page){ ?>
                        <li class="page-item active">
                            <a href="Blog.php?page=<?php echo $i;?>" class="page-link"><?php echo $i;?></a>
                        </li>
                            <?php
                             } else { 
                                ?>
                              <li class="page-item">
                                  <a href="Blog.php?page=<?php echo $i;?>" class="page-link"><?php echo $i;?></a>
                              </li>
                            <?php
                         } 
                         ?>
                         <?php  
                        } }
                        ?>
                        <!-- кнопка вперед -->
                        <?php if (isset($page) && !empty($page)) {
                            if ($page + 1 <= $post_pagination) { ?>
                            <li class="page-item">
                                <a href="Blog.php?page=<?php echo $page + 1?>" class="page-link">&raquo;</a>
                            </li>
                        <?php } } ?>
                    </ul>
                </nav>
            </div>
            <?php require_once 'SideBar.php';?>
           <?php require_once 'footer.php';?>