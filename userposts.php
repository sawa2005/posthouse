<?php include("includes/config.php"); ?>
<?php
$page_title = $_GET['user'] . "'s Posts";
include("includes/header.php");
?>

<div class="right">
    <div>
        <?php 
            Posts::loadUserPosts();

            if (isset($_GET['deleteid'])) {
                Posts::deletePost();
            }
        ?>
    </div>
</div>

<?php
include("includes/footer.php");