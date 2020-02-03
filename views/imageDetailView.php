<div class="container">
<div class="columns is-centered">
<!-- start of image section -->
  <div class="column is-10 ">
        <div class="card">
            <div class="card-image">
                <figure class="image is-4by3">
                <img src='<?php echo $pic['img_path'] ?>' alt='<?php echo $pic['name'] ?>'>
                </figure>
            </div>
            <div class="card-content">
                <div class="media">
                    <div class="media-content">
                        <p class="title is-4"><?php echo $pic['firstName'].' '.$pic['lastName']?></p>
                        <p class="subtitle is-6"><?php echo '@'.$pic['username'] ?></p>
                        <p><time datetime="2016-1-1"><?php echo $pic['creation_date'] ?></time></p>
                    </div>
                </div>
                <div class="content">
                    <div class="columns">
                        <div class="column is-half" style="color: blue">
                            <span class="icon is-small is-left">
                                <i class="fa fa-thumbs-up"></i>
                            </span>
                        Likes <span> <?php echo $pic['countLikes'] ?> </span>
                        </div>
                        <div class="column" style="color: burlywood">
                        <span class="icon is-small is-left">
                                <i class="fas fa-comments"></i>
                            </span>
                        Comments <span> <?php echo (sizeof($comment) == 0) ? 0 : $comment[0]['countComments'] ?> </span>
                        </div>
                    </div>   
                </div>
            </div>
            <footer class="card-footer">
            <?php if (isset($_SESSION['loggedIn'])) { ?>
                <form action="index.php?page=addLikeDetail" method="post" class="card-footer-item">
                    <input type="hidden" name="picId" value="<?php echo $pic['picId'] ?>">
                    <input type="hidden" name="ownerId" value="<?php echo $pic['userId'] ?>">
                    <input type="hidden" name="ownerUsername" value="<?php echo $pic['username'] ?>">
                    <input type="hidden" name="ownerEmail" value="<?php echo $pic['email'] ?>">
                    <input type="hidden" name="notify" value="<?php echo $pic['notify'] ?>">
                    <input class="button is-medium is-fullwidth is-info" value="<?php echo  ($pic['isLiked'] === 0 ? "Like" : "Unlike") ; ?>" type="submit" name="like">
                </form>
                <?php } ?>
                <!-- <form action="index.php?page=viewImageDetails" method="post" class="card-footer-item">
                    <input type="hidden" name="picId" value="<?php echo $pic['picId'] ?>">
                    <input class="button  is-medium is-fullwidth is-primary" value="View" type="submit" name="view">
                </form> -->
            </footer>
        </div>
        <div class="block"></div>
        <div class="box">
        <!-- title & description -->
            <article class="media">
                <div class="media-content">
                    <div class="content">
                        <?php if ($pic['title'] !== '') { ?>
                        <h2 class="title is-4" style="color: mediumaquamarine">Title: &nbsp; <?php echo $pic['title'] ?></h2> 
                        <?php } ?>
                        <?php if ($pic['description'] !== '') { ?>
                       <h2 class="title is-4" style="color: mediumaquamarine">Description: </h2>
                       <h5 class="title is-5"><?php echo $pic['description']  ?></h5>
                       <?php } ?>
                    </div>
                </div>
            </article>
        </div>
        <div class="block"></div>
        <?php if (isset($_SESSION['loggedIn'])) { ?>
        <form action="index.php?page=addComment" method="post">
        <article class="media">
            <!-- <figure class="media-left">
                <p class="image is-64x64">
                <img src="https://bulma.io/images/placeholders/128x128.png">
                </p>
            </figure> -->
            <div class="media-content">
                <div class="field">
                <p class="control">
                    <textarea class="textarea is-info" placeholder="Add a comment..." name="comment"></textarea>
                    <input type="hidden" name="picId" value="<?php echo $pic['picId'] ?>">
                    <input type="hidden" name="ownerUsername" value="<?php echo $pic['username'] ?>">
                    <input type="hidden" name="ownerEmail" value="<?php echo $pic['email'] ?>">
                    <input type="hidden" name="notify" value="<?php echo $pic['notify'] ?>">
                </p>
                </div>
                <nav class="level">
                <div class="level-left">
                    <div class="level-item">
                    <input class="button is-info" value="Submit" type="submit" name="addComment">
                    </div>
                </div>
                <!-- <div class="level-right">
                    <div class="level-item">
                    <label class="checkbox">
                        <input type="checkbox"> Press enter to submit
                    </label>
                    </div>
                </div> -->
                </nav>
            </div>
        </article>
        </form>
        <?php } ?>
        <div class="block"></div>
        <div class="box">
        <!-- List of comments -->
        <?php if (sizeof($comment) == 0) {
            echo "No Comments !!!";
        } ?>
        <?php for($i = 0; $i < sizeof($comment); $i++) { ?>
            <article class="media">
                <div class="media-content">
                    <div class="content">
                    <p>
                        <strong><?php echo $comment[$i]['firstName'].' '.$comment[$i]['lastName']?> </strong><small>@<?php echo $comment[$i]['username']  ?></small> 
                        <br>
                        <?php echo $comment[$i]['comment']  ?>
                        <br>
                        <p style="color: rosybrown"><small><?php echo $comment[$i]['creation_date'] ?></small></p>
                    </p>
                    </div>
                </div>
                <?php if (isset($_SESSION['loggedIn'])) { ?>
                <?php if (unserialize($_SESSION['user'])->getId() === $comment[$i]['userId']) { ?>
                <form action="index.php?page=delComment" method="post">
                         <div class="media-right">
                            <input class="button is-danger" value="Delete" type="submit" name="delComment">
                            <input type="hidden" name="picId" value="<?php echo $pic['picId'] ?>">
                            <input type="hidden" name="CommentId" value="<?php echo $comment[$i]['commentId'] ?>">
                        </div>
                </form> 
                <?php } }?>
            </article>
        <?php } ?>
        </div>








  </div>
  <!-- end of image section -->
</div>
</div>