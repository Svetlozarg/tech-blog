<?php 

include './db/config.php';

session_start();

// If not loged in redirect to index
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

// If new post button clicked, create new post with title, text, image, owner and current date
if(isset($_POST['new_post'])){
  // Get the title
  $title = $conn -> real_escape_string($_POST["title"]);
  // Get the text
  $text = $conn ->  real_escape_string($_POST["text"]);
  // Get the current username
  $owner = $_SESSION['username'];
  // Get the current date and time
  $date = date("Y-m-d H:i:s");

  // Get the name + extention of the image
  $image = $_FILES['image']['name'];
  // Get the temp folder name of the image
  $imageTmpName = $_FILES['image']['tmp_name'];
  // Get the image size
  $imageSize = $_FILES['image']['size'];
  // Get the error if one when uplading the image
  $imageError = $_FILES['image']['error'];
  // Get the image type
  $imageType = $_FILES['image']['type'];

  // Split the image and the extiontion on "."
  $imageExt = explode('.', $image);
  // Get the extention of the image
  $imageActualExt = strtolower(end($imageExt));

  // Create an array of allowed extentions
  $allowed = array('jpg', 'jpeg', 'png');

  // Check if title and text are not empty
  if($title !== '' && $text !== '') {
    // Check if given image extention is in the allowed extentions
    if (in_array($imageActualExt, $allowed)) {
      // Make sure that there are not any image errors
      if ($imageError === 0) {
        // Check if image size is less than 1 000 000
        if ($imageSize < 1000000) {
          // Create an unique id for the image name
          $imageNameNew = uniqid('', true).".".$imageActualExt;
          // Get the desired folder destination
          $imageDestination = 'assets/'.$imageNameNew;
          // Move the image from old tmp to the new
          move_uploaded_file($imageTmpName, $imageDestination);

          // Insert the post in the posts statement
          $sql = "INSERT INTO posts (title, text, owner, image, created_at) VALUES ('$title', '$text', '$owner', '$imageNameNew', '$date')";

          // Get the connection and run the sql statement
          mysqli_query($conn, $sql);
        
          // If everything is successful then relocate the user to the post
          header("Location: article.php?title=$title");
          exit();
        } else { 
              echo "<script>alert('Image size is too big.'); window.location.href='addArticle.php';</script>";
              exit();
        }
      } else {
            echo "<script>alert('There was an error uploading the image'); window.location.href='addArticle.php';</script>";
            exit();
      }
    } else {
          echo "<script>alert('PNG, JPG are only allowed for an image extention '); window.location.href='addArticle.php';</script>";
          exit();
    }
  } else {
    echo "<script>alert('Pleace add title and text to the article!'); window.location.href='addArticle.php';</script>";
    exit();
  }
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
        <h2>Create an Article</h2>

          <div class="create-body">
          <form method="POST" enctype="multipart/form-data">
              <label for="title">Title</label>
              <input type="text" name="title" id="" placeholder="Write your title" require>
              <label for="myfile">Select an image:</label>
              <input type="file" name="image">
              <label for="text">Write your article</label>
              <textarea name="text" id="" cols="30" rows="10" placeholder="Write your article text" require></textarea>
              <button name="new_post">Create Article</button>
            </form>
          </div>
      </div>
    </section>

    <?php
        include_once './includes/footer.php';
    ?>
</body>
</html>