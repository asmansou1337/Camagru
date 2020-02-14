<div class='container'>
<div class="columns">
<!-- start of gallery section -->
<?php if (sizeof($pics) == 0)
    echo "No pictures Yet !!";?>
<?php foreach($pics as $key => $img) { ?>
    <?php if($key % 3 == 0) { ?>
        </div><div class="columns">
    <?php  }  ?>
    <!-- Image section -->
  <div class="column is-one-third">
        <div class="card">
            <div class="card-image">
                <figure class="image is-4by3">
                <img src='<?php echo $img->getPath(); ?>' alt='<?php echo $img->getName(); ?>'>
                </figure>
            </div>
            <!-- printing the owner name & username + date of creation of the image -->
            <div class="card-content">
                <div class="media">
                    <div class="media-content">
                        <p class="title is-4"><?php echo $img->getOwnerFirstName() .' '. $img->getOwnerLastName() ?></p>
                        <p class="subtitle is-6"><?php echo '@'.$img->getOwnerUsername() ?></p>
                        <p><time datetime="2016-1-1"><?php echo $img->getCreationDate() ?></time></p>
                    </div>
                </div>
                 <!-- Count of likes & comments per image -->
                <div class="content">
                    <div class="columns">
                        <div class="column is-half">
                            <span class="icon is-small is-left">
                                <i class="fa-thumbs-up"></i>
                            </span>
                        Likes <span> <?php echo $img->getCountLikes() ?> </span>
                        </div>
                        <div class="column">
                        <span class="icon is-small is-left">
                                <i class="fa-comments"></i>
                            </span>
                       Comments <span> <?php echo $img->getCountComments() ?> </span> 
                        </div>
                    </div>   
                </div>
            </div>
             <!-- Showing the like/unlike button for the logged in users only + view button for all users  -->
            <footer class="card-footer">
                <?php if (isset($_SESSION['loggedIn'])) { ?>
                <form action="index.php?page=addLike" method="post" class="card-footer-item">
                    <input type="hidden" name="picId" value="<?php echo $img->getId(); ?>">
                    <input class="button is-medium is-fullwidth is-info" value="<?php echo  ($img->getIsLiked() === 0 ? "Like" : "Unlike") ; ?>" type="submit" name="like">
                </form>
                <?php } ?>
                <form action="index.php?page=viewImageDetails" method="post" class="card-footer-item">
                    <input type="hidden" name="picId" value="<?php echo $img->getId(); ?>">
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
