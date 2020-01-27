<div class='container'>
<div class="columns">
<div class="column is-one-third">
    <div class="card">
    <div class="card-image">
        <figure class="image is-4by3">
        <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
        </figure>
    </div>
    <div class="card-content">
        <div class="media">
        <div class="media-content">
            <p class="title is-4">John Smith</p>
            <p class="subtitle is-6">@johnsmith</p>
        </div>
        </div>

        <div class="content">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        Phasellus nec iaculis mauris. <a>@bulmaio</a>.
        <a href="#">#css</a> <a href="#">#responsive</a>
        <br>
        <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
        </div>
    </div>
    <footer class="card-footer">
        <a href="#" class="card-footer-item">Like</a>
        <a href="#" class="card-footer-item">Comment</a>
    </footer>
    </div>
</div>

  <div class="column is-one-third">
        <div class="card">
        <div class="card-image">
            <figure class="image is-4by3">
            <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
            </figure>
        </div>
        <div class="card-content">
            <div class="media">
            <div class="media-content">
                <p class="title is-4">John Smith</p>
                <p class="subtitle is-6">@johnsmith</p>
                <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
            </div>
            </div>
            <div class="content">
            <div class="columns">
        <div class="column is-half">
            <span class="icon is-small is-left">
                <i class="fa fa-thumbs-up"></i>
            </span>
        Likes <span> 26 </span>
        </div>
        <div class="column">
        <span class="icon is-small is-left">
                <i class="fas fa-comments"></i>
            </span>
        Comments <span> 14 </span></div>
</div>
                
            </div>
        </div>
        <footer class="card-footer">
            <a href="#" class="card-footer-item">Like</a>
            
            <a href="#" class="card-footer-item">Comment</a>

        </footer>
        </div>
  </div>

</div>

<div class="block">
</div>
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
