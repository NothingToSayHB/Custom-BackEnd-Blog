<?php
require_once './includes/db.php';
require_once './includes/fucntion.php';
require_once './includes/sessions.php';
require_once 'dateTime.php';



?>
            <div class="col-sm-4">
                <div class="card mt-4">
                    <div class="card-body">
                    <?php 
                    global $connecting;
                    $sql = "SELECT * FROM sidebar";
                    $stmt = $connecting->query($sql);
                    while ($row = $stmt->fetch()) {
                        $image = $row['simage'];
                        $text = $row['stext'];
                    }
                    ?>
                        <img src="./images/<?php echo $image;?>" class="d-block img-fluid mb-3" alt="side-bar-image">
                        <p class="text-center">
                        <?php echo $text; ?>
                        </p>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header bg-dark text-light">
                        <h2 class="lead">Sigh Up (only for admins)</h2>
                    </div>
                    <div class="card-body">
                        <a href="Login.php" class="btn btn-danger btn-block text-center text-white mb-4">Login</a>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <h2 class="lead">Categories</h2>
                        </div>
                        <div class="card-body">
                            <?php 
                            global $connecting;
                            $sql = "SELECT * FROM category ORDER BY id desc";
                            $stmt = $connecting->query($sql);
                            while ($row = $stmt->fetch()) {
                                $categoryID = $row['id'];
                                $category_name = $row['title'];
                            
                            ?>
                            <a href="Blog.php?category=<?php echo $category_name; ?>">
                            <span class="heading">
                                <?php echo htmlentities($category_name);?>
                            </span>
                            </a>
                            <br>
                            <?php } ?>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h2 class="lead">Recent Posts</h2>
                    </div>
                    <div class="card-body">
                        <?php 
                        global $connecting;
                        $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                        $stmt = $connecting->query($sql);
                        while ($row = $stmt->fetch()) {
                            $id = $row['id'];
                            $title = $row['title'];
                            $datetime = $row['datetime'];
                            $image = $row['image'];
                        
                        ?>
                        <div class="media">
                            <img class="d-block img-fluid align-self-start" width="90px;" src="./upload/<?php echo $image;?>" alt="recent-image">
                            <div class="media-body ml-2">
                               <a href="FullPost.php?id=<?php echo $id;?>"><h6 class="lead"><?php echo htmlentities($title); ?></h6></a>
                                <p class="small"><?php echo htmlentities($datetime); ?></p>
                            </div>
                        </div>
                        <hr>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main area -->

    

    <!-- Main area END-->