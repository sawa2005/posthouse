<?php include("includes/config.php"); ?>
<?php
$page_title = "Home";
include("includes/header.php");
?>

<div class="right">
    <div class="post">
        <h2>Create Post</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Title" class="input">
            <textarea name="content" cols="30" rows="10" placeholder="What's up?"></textarea>
            <input type="submit" value="Post" class="submit">
        </form>
        <?php 
            // Skapar en ny instans av News när titel och innehåll har specificerats om användaren är inloggad
            if (isset($_SESSION['loggedin_user'])) {
                if (isset($_POST['title']) && isset($_POST['content'])) {
                    new Posts($_POST['title'], $_POST['content'], date("Y-m-d H:i:s"), $_SESSION['loggedin_user']);
                }
            }

            else {
                echo '<p class="message">You must be logged in to post!</p>';
            }
        ?>
    </div>
    <div>
        <h2>Latest Posts</h2>
        <?php
            Posts::loadPosts()
        ?>
    </div>
</div>

<?php
include("includes/footer.php");