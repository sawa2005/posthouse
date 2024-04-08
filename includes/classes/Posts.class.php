<?php 
    $connstring = getenv('DB_CONN_STRING');
    
    class Posts {
        // Egenskaper
        public $title;
        public $content;
        public $postDate;
        public $author;

        // Metoder
        function __construct(string $title, string $content, string $postDate, string $author) {
            if (isset($_POST['title']) && isset($_POST['content'])) {
                $this->title = $title;
                $this->content = $content;
                $this->postDate = $postDate;
                $this->author = $author;
                
                // Läser in inläggets uppgifter
                $title = $_POST['title'];
                $content = $_POST['content'];
                $postDate = date("Y-m-d H:i:s");
                $author = $_SESSION['loggedin_user'];

                // Om någon av fälten är tomma
                if ($title == "" or $content == "") {
                    echo '<p class="message">Fill in both fields!</p>';
                }
                
                else {
                    // Anslut till databasen
                    $db = mysqli_connect($connstring) or die('Fel vid anslutning');

                    // SQL-fråga  för att skriva till databasen
                    $sql = "INSERT INTO posts(title, postDate, content, author) VALUES('$title', '$postDate', '$content', '$author');";
                    $result = mysqli_query($db, $sql);

                    // Stäng databasanslutningen
                    $db->close();

                    // Ladda om sida
                    header("Location:http://posthouse.one/index.php");
                }
            }
        }

        static function loadPosts() {
            $db = mysqli_connect($connstring) or die('Fel vid anslutning');

            // SQL-fråga för att läsa ut allt (*) från tabellen posts i rätt ordning
            $sql = "SELECT * FROM (posts JOIN users ON author = username) ORDER BY postDate DESC;";
            $result = mysqli_query($db, $sql) or die('Fel vid SQL-fråga');

            // Loopa genom fem rader
            for ($i = 0; $i <= 4; $i++) {
                $row = mysqli_fetch_array($result);
                if ($row !== null) {
                    echo '<article>
                            <a href="userposts.php?user=' . $row['username'] . '" class="username" style="color:' . $row['color'] . ';">' . $row['author'] . '</a>
                            <p class="date">' . $row['postDate'] . '</p>
                            <div>
                                <h3>' . $row['title'] . '</h3>
                                <p>' . $row['content'] . '</p>
                            </div>
                         </article>';
                }
            }
    
            $db->close();
        }

        static function loadAllPosts() {
            $db = mysqli_connect($connstring) or die('Fel vid anslutning');

            // SQL-fråga för att läsa ut allt (*) från tabellen posts och users där author = username i rätt ordning
            $sql = "SELECT * FROM (posts JOIN users ON author = username) ORDER BY postDate DESC;";
            $result = mysqli_query($db, $sql) or die('Fel vid SQL-fråga');

            // Loopa genom alla rader
            while ($row = mysqli_fetch_array($result)) {
                echo '<article>
                        <a href="userposts.php?user=' . $row['username'] . '" class="username" style="color:' . $row['color'] . ';">' . $row['author'] . '</a>
                        <p class="date">' . $row['postDate'] . '</p>
                        <div>
                            <h3>' . $row['title'] . '</h3>
                            <p>' . $row['content'] . '</p>
                        </div>
                      </article>';
                }
    
            $db->close();
        }

        static function loadUserPosts() {
            if(isset($_GET['user'])) {
                $user = $_GET['user'];

                $db = mysqli_connect($connstring) or die('Fel vid anslutning');

                // SQL-fråga för att läsa ut allt (*) från tabellen users från rätt användare
                $sql = "SELECT * FROM users WHERE username = '$user';";
                $result = mysqli_query($db, $sql) or die('Fel vid SQL-fråga');
                $row = mysqli_fetch_array($result);

                echo "<h2>" . $user . "'s Profile</h2>";
                echo '<h4>Username</h4>
                      <p>' . $row['username'] . '</p>
                      <h4>Account created</h4>
                      <p>' . $row['createDate'] . '</p>
                      <h4>Color code</h4>
                      <p class="color" style="color:' . $row['color'] . ';">' . $row['color'] . '</p>';

                echo "<h2>Posts</h2>";

                $db->close();

                $db = mysqli_connect($connstring) or die('Fel vid anslutning');

                /* SQL-fråga för att läsa ut allt (*) från tabellen posts från rätt användare */
                $sql = "SELECT * FROM posts WHERE author = '$user' ORDER BY postDate DESC;";
                $result = mysqli_query($db, $sql) or die('Fel vid SQL-fråga');

                /* Läser ut olika resultat beroende på om användaren är loggad in i rätt konto (för att kunna radera och redigera inlägg) */
                if (isset($_SESSION['loggedin_user'])) {
                    if ($user == $_SESSION['loggedin_user']) {          
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<article>
                                    <p class="date">' . $row['postDate'] . '</p>
                                    <div>
                                        <h3>' . $row['title'] . '</h3>
                                        <p>' . $row['content'] . '</p>
                                    </div>
                                    <div class="edit">
                                        <a href="editpost.php?postid=' . $row['ID'] . '">Edit Post</a>
                                        <a href="userposts.php?user=' . $user . '&deleteid=' . $row['ID'] . '" class="delete">Delete Post</a>
                                    </div>
                                  </article>';
                            }
                    }
    
                    else {
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<article>
                                    <p class="date">' . $row['postDate'] . '</p>
                                    <div>
                                        <h3>' . $row['title'] . '</h3>
                                        <p>' . $row['content'] . '</p>
                                    </div>
                                  </article>';
                            }
                    }
                }

                else {
                    while ($row = mysqli_fetch_array($result)) {
                        echo '<article>
                                <p class="date">' . $row['postDate'] . '</p>
                                <div>
                                    <h3>' . $row['title'] . '</h3>
                                    <p>' . $row['content'] . '</p>
                                </div>
                              </article>';
                        }
                }

                $db->close();
            }
        }

        static function deletePost() {
            $deleteid = $_GET['deleteid'];
            $user = $_GET['user'];

            $db = mysqli_connect($connstring) or die('Fel vid anslutning');

            // SQL-fråga för att ta bort specifik artikel
            $sql = "DELETE FROM posts WHERE ID=$deleteid";
            $result = mysqli_query($db, $sql) or die('Fel vid SQL-fråga');

            header("Location:http://posthouse.one/userposts.php?user=$user");

            $db->close();
        }

        static function editPost() {
            $postid = $_GET['postid'];

            $db = mysqli_connect($connstring) or die('Fel vid anslutning');

            // SQL-fråga för att läsa ut allt (*) från tabellen post där id = id:et från posten
            $sql = "SELECT * FROM posts WHERE ID = $postid;";
            $result = mysqli_query($db, $sql) or die('Fel vid SQL-fråga');
            $row = mysqli_fetch_array($result);

            echo '<form method="POST">
                    <input type="text" name="title" class="input" value="' . $row['title'] .'">
                    <textarea name="content" id="" cols="30" rows="10">' . $row['content'] .'</textarea>
                    <input type="submit" value="Edit" class="submit">
                </form>';

            $db->close();

            if (isset($_POST['title']) && isset($_POST['content'])) {         
                $title = $_POST['title'];
                $content = $_POST['content'];
                $postDate = date("Y-m-d H:i:s");
                $author = $_SESSION['loggedin_user'];

                if ($title == "" or $content == "") {
                    echo '<p class="message">Fill in both fields!</p>';
                }
                
                else {
                    $db = mysqli_connect($connstring) or die('Fel vid anslutning');

                    /* SQL-fråga för att uppdatera inlägget */
                    $sql = "UPDATE posts SET postDate = '$postDate', title = '$title', content = '$content' WHERE ID = $postid";
                    $result = mysqli_query($db, $sql);

                    $db->close();

                    header("Location:http://posthouse.one/index.php");
                }
            }
        }
    }
?>