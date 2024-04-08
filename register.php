<?php include("includes/config.php"); ?>
<?php
$page_title = "Register";
include("includes/header.php");
?>

<div class="right">
    <div>
        <h2>Create an account</h2>
        <?php
            // Skapar en ny instans av Users
            if (isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['color'])) {
                new Users($_POST['username'], $_POST['pass'], $_POST['color'], date("Y-m-d"));
            }
        ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" class="account">
            <input type="password" name="pass" placeholder="Password" class="account">
            <input type="text" name="color" placeholder="Color (HEX)" class="account">
            <a href="https://htmlcolorcodes.com/" class="smalllink">What is a HEX-Color?</a>
            <input type="submit" value="Create" class="confirm">
        </form>
    </div>
</div>

<?php
include("includes/footer.php");