<?php include("includes/config.php"); ?>
<?php
$page_title = "All Posts";
include("includes/header.php");
?>

<div class="right">
    <div>
        <h2>All Posts</h2>
        <?php 
            Posts::loadAllPosts();
        ?>
    </div>
</div>

<?php
include("includes/footer.php");