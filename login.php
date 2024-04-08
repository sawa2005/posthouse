<?php include("includes/config.php"); ?>
<?php
$page_title = "Log In";
include("includes/header.php");
?>

<div class="right">
    <div>
        <h2>Log In</h2>
        <?php 
            if(isset($_POST['username']) && isset($_POST['pass'])) {
                Users::logIn();
            }
        ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" class="account">
            <input type="password" name="pass" placeholder="Password" class="account">
            <input type="submit" value="Log In" class="confirm">
        </form>
    </div>
</div>

<?php
include("includes/footer.php");