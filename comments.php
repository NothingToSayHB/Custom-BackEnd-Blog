<?php
require_once './includes/db.php';
require_once './includes/fucntion.php';
require_once './includes/sessions.php';
require_once 'dateTime.php';
require_once 'AdminHeader.php';
$_SESSION["trackengURL"] = $_SERVER['PHP_SELF']; // трек
confirm_login();

?>



    <!-- Main area -->

    <section class="container py-2 mb-4">
    <?php 
    echo error_massage(); 
    echo success_massage();?>
        <div class="row">
            <div class="col lg-12">
            <h1>Un-Approve Comments</h1>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Date&Time</th>
                            <th>name</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                
                <?php 
                global $connecting;
                $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
                $execute = $connecting->query($sql);
                $count = 0;
                while($row = $execute->fetch()):?> 
                <?php
                    $commentID = $row['id'];
                    $comment_date = $row['datetime'];
                    $commenter_name = $row['name'];
                    $comment_content = $row['comment'];
                    $comment_post_id = $row['post_id'];
                    $count++;
                    if (strlen($commenter_name) > 10) {
                        $commenter_name = substr($commenter_name, 0, 10) . '..';
                    }
                ?>
                    <tbody>
                        <tr>
                            <td><?php echo htmlentities($count);?></td>
                            <td><?php echo htmlentities($comment_date);?></td>
                            <td><?php echo htmlentities($commenter_name);?></td>
                            <td><?php echo htmlentities($comment_content);?></td>
                            <td><a class="btn btn-success" href="ApproveComments.php?id=<?php echo $commentID?>">Approve</a></td>
                            <td><a class="btn btn-danger" href="DeleteComments.php?id=<?php echo $commentID?>">Delete</a></td>
                            <td style="min-width:140px;"><a class="btn btn-primary" href="FullPost.php?id=<?php echo $comment_post_id;?>" target="_blank">Live Priveew</a></td>
                        </tr>
                    </tbody>
                <?php endwhile;?>
                </table>

                <h1>Approve Comments</h1>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Date&Time</th>
                            <th>name</th>
                            <th>Comment</th>
                            <th>Revert</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                
                <?php 
                global $connecting;
                $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
                $execute = $connecting->query($sql);
                $count = 0;
                while($row = $execute->fetch()):?> 
                <?php
                    $commentID = $row['id'];
                    $comment_date = $row['datetime'];
                    $commenter_name = $row['name'];
                    $comment_content = $row['comment'];
                    $comment_post_id = $row['post_id'];
                    $count++;
                    if (strlen($commenter_name) > 10) {
                        $commenter_name = substr($commenter_name, 0, 10) . '..';
                    }
                ?>
                    <tbody>
                        <tr>
                            <td><?php echo htmlentities($count);?></td>
                            <td><?php echo htmlentities($comment_date);?></td>
                            <td><?php echo htmlentities($commenter_name);?></td>
                            <td><?php echo htmlentities($comment_content);?></td>
                            <td style="min-width:140px;"><a class="btn btn-warning" href="DisApproveComments.php?id=<?php echo $commentID?>">Dis-Approve</a></td>
                            <td><a class="btn btn-danger" href="DeleteComments.php?id=<?php echo $commentID?>">Delete</a></td>
                            <td style="min-width:140px;"><a class="btn btn-primary" href="FullPost.php?id=<?php echo $comment_post_id;?>" target="_blank">Live Priveew</a></td>
                        </tr>
                    </tbody>
                <?php endwhile;?>
                </table>
            </div>
        </div>
    </section>

    <!-- Main area END-->


    <?php require_once 'footer.php';?>