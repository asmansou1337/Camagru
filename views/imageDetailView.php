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
                        <div class="column is-half">
                            <span class="icon is-small is-left">
                                <i class="fa fa-thumbs-up"></i>
                            </span>
                        Likes <span> <?php echo $pic['countLikes'] ?> </span>
                        </div>
                        <div class="column">
                        <span class="icon is-small is-left">
                                <i class="fas fa-comments"></i>
                            </span>
                        Comments <span> 14 </span>
                        </div>
                    </div>   
                </div>
            </div>
            <footer class="card-footer">
                <form action="index.php?page=addLike" method="post" class="card-footer-item">
                    <input type="hidden" name="picId" value="<?php echo $pic['picId'] ?>">
                    <input type="hidden" name="ownerId" value="<?php echo $pic['userId'] ?>">
                    <input type="hidden" name="ownerUsername" value="<?php echo $pic['username'] ?>">
                    <input type="hidden" name="ownerEmail" value="<?php echo $pic['email'] ?>">
                    <input type="hidden" name="notify" value="<?php echo $pic['notify'] ?>">
                    <input class="button is-medium is-fullwidth" value="<?php echo  ($pic['isLiked'] === 0 ? "Like" : "Unlike") ; ?>" type="submit" name="like">
                </form>
              
                <form action="index.php?page=viewImageDetails" method="post" class="card-footer-item">
                    <input type="hidden" name="picId" value="<?php echo $pic['picId'] ?>">
                    <input class="button  is-medium is-fullwidth is-primary" value="View" type="submit" name="view">
                </form>
            </footer>
        </div>
  </div>
  <!-- end of image section -->
</div>
</div>