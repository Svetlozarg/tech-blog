<?php 

include './db/config.php';

session_start();

// If not loged in redirect to index
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

// Check if add comment button is clicked then add new comment
if(isset($_REQUEST['addComment'])) {
  $owner = $_SESSION['username'];
  $comment = $_REQUEST['comment'];

  // Check if comment is not empty
  if ($comment !== '') {
    $title = $_REQUEST['title'];
    $date = date("Y-m-d H:i:s");

    $sql = "INSERT INTO comments (owner, comment, title, created_at) VALUES ('$owner', '$comment', '$title', '$date')";

    mysqli_query($conn, $sql);

    header("Location: article.php?title=$title");
    exit();
  } else {
    echo "<script>alert('Please add text to the comment')</script>";
  }
}

// Check if add reply button is clicked then add new reply
if(isset($_REQUEST['addReply'])) {
  $replyComment = $_REQUEST['replyComment'];

  // Check if reply text is not empty
  if ($replyComment !== '') {
    $id = $_REQUEST['id'];
    $owner = $_SESSION['username'];

    $date = date("Y-m-d H:i:s");
    $title = $_REQUEST['title'];

    $sql = "INSERT INTO replies (owner, commentid, comment, created_at) VALUES ('$owner', '$id', '$replyComment', '$date')";

    mysqli_query($conn, $sql);

    header("Location: article.php?title=$title");
    exit();
  } else {
    echo "<script>alert('Please add text to the reply')</script>";
  }
}

// Check if delete article button is clicked then delete article
if(isset($_REQUEST['delete'])) {
  $title = $_REQUEST['title'];
  $sql = "DELETE FROM posts WHERE title = '$title'";
  $query = mysqli_query($conn, $sql);

  mysqli_query($conn, $sql);

  header("Location: blog.php");
  exit();
}

// Check if delete comment button is clicked then delete comment
if(isset($_REQUEST['deleteComment'])) {
  $title = $_REQUEST['title'];
  $id = $_REQUEST['id'];

  $sql = "DELETE FROM comments WHERE id = '$id'";

  mysqli_query($conn, $sql);

  header("Location: article.php?title=$title");
  exit();
}

// Check if delete reply button is clicked then delete reply
if(isset($_REQUEST['deleteReply'])) {
  $title = $_REQUEST['title'];
  $id = $_REQUEST['id'];

  $sql = "DELETE FROM replies WHERE id = '$id'";

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

  <section class="article-post" style="margin-top: 3rem">
    <?php
      // Get the desirable post's title and display article info from posts
      // Check if article found, if not display 404 ERROR NOT FOUND
      if(isset($_REQUEST['title'])) {
        $title = $_REQUEST['title'];

        $sql = "SELECT * FROM posts WHERE title = '$title'";
        $result = $conn->query($sql);

        // Create the html for the article with the date
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<div class='post-cont'>
            <h2>".$row['title']."</h2>
    
            <p>Article by ".$row['owner']."</p>
            <span>Created on ".$row['created_at']."</span>";

            // If the current user is the owner of the article or the user has the role of an admin,
            // Display Edit and Delete button
            if ($_SESSION['username'] === $row['owner'] || $_SESSION['role'] === 'Admin') {
              echo "<form method='POST' class='create-form'>";
              echo "<button class='post-cont-btn create'><a href='editArticle.php?title=".$row['title']."'>Edit article</a></button>";
              echo "<button class='post-cont-btn delete' name='delete'>Delete article</button>";
              echo "</form>";
            }
    
            echo"
            <img src='./assets/".$row['image']."' alt=''>
    
            <div class='post-body'>
              <p>".$row['text']."</p>
            </div>
          </div>";
          }

          // Show the comment and reply section with adding comment form
          if(isset($_REQUEST['title'])) {
            // Comment form
            echo "<section class='comments-box'>
                    <div class='comments-wrapper'>
                      <div class='add-comment'>
                        <h2>Comments</h2>
                        <form method='POST'>
                          <textarea name='comment' id='' cols='30' rows='10'></textarea>
                          <button name='addComment'>Add Comment</button>
                        </form>
                      </div>
                    <div class='comments'>";
    
            $title = $_REQUEST['title'];
            $sql = "SELECT * FROM comments WHERE (title = '$title') ORDER BY created_at DESC";
            $request = mysqli_query($conn, $sql);
            $querryResults = mysqli_num_rows($request);
            
            // Total number of comments
            echo "<p style='color: #dc143c'>".$querryResults ." comments</p>";

            if ($querryResults > 0) {
                while ($row = mysqli_fetch_assoc($request)) {
                  // Reply form
                  echo "<div class='reply-box' id='replyBox' style='display: none;'>
                          <form method='POST' action='article.php?title=".$row['title']."'>
                            <input id='replyID' type='hidden' value='' name='id'></input>
                            <textarea name='replyComment' id='' cols='30' rows='10'></textarea>
                            <button name='addReply'>Add Reply</button>
                          </form>
                        </div>";

                  // Display commets
                  echo "<div class='comment'>
                          <p>".$row['comment']."</p>
                          <div class='comment-box'>
                            <p class='comment-owner'>".$row['owner']."</p>
                            <p style='border-right: 1px solid gray; padding-right: 10px' class='comment-date'>".$row['created_at']."</p>";
                  // Show delete comment form if current user is the owner of the comment
                  // or has the role of an Admin
                  if ($_SESSION['username'] === $row['owner'] || $_SESSION['role'] === 'Admin') {
                    echo "<form method='POST' action='article.php?id=".$row['id']."'>
                            <input type='hidden' value='".$row['title']."' name='title'></input>";
                  }

                  // Reply button without check due to possibility for every user to reply
                  echo "<a class='reply-btn create' href='javascript:void(0)' id='".$row['id']."' onClick='reply(this)'>Reply</a>";

                  // Show delete comment button if current user is the owner of the comment 
                  if ($_SESSION['username'] === $row['owner'] || $_SESSION['role'] === 'Admin') {
                    echo "  <button name='deleteComment' class='comment-btn delete'>Delete</button>
                          </form>";
                  }
                    echo "</div>";

                  echo"</div>";

                  // Get all replies for the comment
                  $id = $row['id'];
                  $sqlReply = "SELECT * FROM replies WHERE (commentid = '$id') ORDER BY created_at DESC";
                  $requestReply = mysqli_query($conn, $sqlReply);
                  $querryResultsReply = mysqli_num_rows($requestReply);

                  
                  if ($querryResultsReply > 0) {
                    // Total number of replies for the comment
                    echo "<p style='padding-left:.5rem; margin: .5rem 0; color: #008080'>".$querryResultsReply ." replies</p>";
                    while ($rowReply = mysqli_fetch_assoc($requestReply)) {
                      // Reply
                      echo "<div class='comment-reply-box'>
                              <p>".$rowReply['comment']."</p>
                              <div class='comment-reply'>
                                <p>".$rowReply['owner']."</p>
                                <p class='reply-date'>".$rowReply['created_at']."</p>";

                      // Show delete button if the current user is the owner of the reply or has the role of admin
                      if ($_SESSION['username'] === $rowReply['owner'] || $_SESSION['role'] === 'Admin') {
                        echo "<form method='POST' action='article.php?id=".$rowReply['id']."'>
                                <input type='hidden' value='".$row['title']."' name='title'></input>
                                <button style='padding:0' name='deleteReply' class='comment-btn delete'>Delete</button>
                              </form>";
                      }

                        echo "</div>";
                      echo "</div>";
                    }
                  }
              }
            }

            echo "</div>
                </div>
              </section>";
          }
        } else {
          echo "<h2 style='text-align:center; margin: 2rem 0; font-size: 40px'>ERROR 404 - No article found</h2>";
        }
      }
    ?>
  </section> 

  <?php
      include_once './includes/footer.php';
  ?>

  <!-- Script for opening the reply form box -->
  <script>
    function reply(event) {
        var ID = event.id;
        $('#replyID').attr('value', ID);
        $("#replyBox").hide();
        $("#replyBox").show("slow");
    }
  </script>

</body>
</html>