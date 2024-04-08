<?php include("includes/config.php"); ?>
<?php
$page_title = "Edit Post";
include("includes/header.php");
?>

<div class="right">
    <div class="post">
        <h2>Edit Post</h2>
        <?php 
            Posts::editPost();
        ?>
    </div>
</div>

<?php
include("includes/footer.php");