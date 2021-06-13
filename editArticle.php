<?php 

include './db/config.php';

session_start();

// If not loged in redirect to index
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

// Check if update button is clicked then get new title and new text and set the new data of post in posts
if (isset($_REQUEST['update'])) {
  $title = $_REQUEST['title'];
  $text = $_REQUEST['text'];
  $id = $_REQUEST['id'];

  $sql = ("UPDATE posts SET title = '$title', text = '$text' WHERE id = '$id'");

  mysqli_query($conn, $sql);

  header("Location: article.php?title=$title");
  exit();
}
?>

<?php
	include_once './includes/header.php';
?>

<body>
    <?php
        include_once './includes/navbar.php';
    ?>

    <section class="create-post">
      <div class="create-post-cont">
        <!-- Display edit article form with article's data -->
        <?php
          if(isset($_REQUEST['title'])) {
            $title = $_REQUEST['title'];
    
            $sql = "SELECT * FROM posts WHERE title = '$title'";
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                if ($row['owner'] == $_SESSION['username'] || $_SESSION['role'] === 'Admin') {
                echo "<h2>".$_REQUEST['title']."</h2>";
                
                echo "<div class='create-body'>
                       <form method='POST' action='editArticle.php?id=".$row['id']."'>
                          <label for='title'>Title</label>
                          <input type='text' name='title' id='' value='".$row['title']."'>
                          <label for='text'>Write your article</label>
                          <textarea name='text' id='' cols='30' rows='10' placeholder=''>".$row['text']."</textarea>
                          <button name='update'>Edit Article</button>
                        </form>
                    </div>";
                  } else {
                    header("Location: welcome.php");
                  }
              }
            } else {
              echo "<h2>ERROR 404 - No article found</h2>";
            }
          }
        ?>
      </div>
    </section>

    <?php
        include_once './includes/footer.php';
    ?>
</body>
</html>