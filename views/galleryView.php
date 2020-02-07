<div class='container'>
<div class="columns">
<!-- start of gallery section -->
<?php for($i = 0; $i < sizeof($pics); $i++) { ?>
    <?php if($i % 3 == 0) { ?>
        </div><div class="columns">
    <?php  }  ?>
    <!-- Image section -->
  <div class="column is-one-third">
        <div class="card">
            <div class="card-image">
                <figure class="image is-4by3">
                <img src='<?php echo $pics[$i]['img_path'] ?>' alt='<?php echo $pics[$i]['name'] ?>'>
                </figure>
            </div>
            <!-- printing the owner name & username + date of creation of the image -->
            <div class="card-content">
                <div class="media">
                    <div class="media-content">
                        <p class="title is-4"><?php echo $pics[$i]['firstName'].' '.$pics[$i]['lastName']?></p>
                        <p class="subtitle is-6"><?php echo '@'.$pics[$i]['username'] ?></p>
                        <p><time datetime="2016-1-1"><?php echo $pics[$i]['creation_date'] ?></time></p>
                    </div>
                </div>
                 <!-- Count of likes & comments per image -->
                <div class="content">
                    <div class="columns">
                        <div class="column is-half">
                            <span class="icon is-small is-left">
                                <i class="fa fa-thumbs-up"></i>
                            </span>
                        Likes <span> <?php echo $pics[$i]['countLikes'] ?> </span>
                        </div>
                        <div class="column">
                        <span class="icon is-small is-left">
                                <i class="fas fa-comments"></i>
                            </span>
                       Comments <span> <?php echo $pics[$i]['countComments'] ?> </span> 
                        </div>
                    </div>   
                </div>
            </div>
             <!-- Showing the like/unlike button for the logged in users only + view button for all users  -->
            <footer class="card-footer">
                <?php if (isset($_SESSION['loggedIn'])) { ?>
                <form action="index.php?page=addLike" method="post" class="card-footer-item">
                    <input type="hidden" name="picId" value="<?php echo $pics[$i]['picId'] ?>">
                    <input type="hidden" name="ownerUsername" value="<?php echo $pics[$i]['username'] ?>">
                    <input type="hidden" name="ownerEmail" value="<?php echo $pics[$i]['email'] ?>">
                    <input type="hidden" name="notify" value="<?php echo $pics[$i]['notify'] ?>">
                    <input class="button is-medium is-fullwidth is-info" value="<?php echo  ($pics[$i]['isLiked'] === 0 ? "Like" : "Unlike") ; ?>" type="submit" name="like">
                </form>
                <?php } ?>
                <form action="index.php?page=viewImageDetails" method="post" class="card-footer-item">
                    <input type="hidden" name="picId" value="<?php echo $pics[$i]['picId'] ?>">
                    <input class="button  is-medium is-fullwidth is-primary" value="View" type="submit" name="view">
                </form>
            </footer>
        </div>
  </div>
<?php } ?>
  <!-- end of image section -->
</div>
<div class="block">
</div>
 <!-- Pagination section -->
<nav class="pagination is-centered" role="navigation" aria-label="pagination">
<?= ($nbr - 1) < 1 ? "<a class='pagination-previous' disabled>Previous</a>" : "<a class='pagination-previous' href=\"index.php?page=gallery&nbr=".($nbr - 1)."\">Previous</a>" ?>
<?= ($nbr + 1) > $nbpages ? "<a class='pagination-next' disabled>Next page</a>" : "<a class='pagination-next' href=\"index.php?page=gallery&nbr=".($nbr + 1)."\">Next page</a>" ?>
  
  <ul class="pagination-list">
    <?php for ($i = 1; $i <= $nbpages; $i++) {
        if ($i == $nbr) {
        ?>
        <li><a class="pagination-link is-current"> <?php echo $i; ?></a></li>
        <?php } else { ?>
            <li><a class="pagination-link" href="index.php?page=gallery&nbr=<?= $i ?>"><?php echo $i; ?></a></li>
            <?php } ?>
    <?php } ?>
  </ul>
</nav>
</div>
