<?php 

include './db/config.php';

session_start();

// If not loged in redirect to index
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

?>

<?php
	include_once './includes/header.php';
?>

<body>
    <?php
        include_once './includes/navbar.php';
    ?>
    <div class="search">
        <form action="search.php" method="POST">
            <input type="text" placeholder="Search for articles" name="search">
            <button type="submit" name="submit-search"><i class="fa fa-search"></i></button>
        </form>
    </div>

    <section class="article-search">
      <div class="article-search-cont">
        <h2>Results for: <?php echo $_POST['search']; ?></h2>
        <div class='articles-search'>
        <?php
        // Show the results for the given search data
        if(isset($_POST['submit-search'])) {
          $search = mysqli_real_escape_string($conn, $_POST['search']);

          $sql = "SELECT * FROM posts WHERE title LIKE '%$search%' OR text LIKE '%$search%' or owner LIKE '%$search%' OR created_at LIKE '%$search%'";

          $result = mysqli_query($conn, $sql);
          $queryResult = mysqli_num_rows($result);

          // Show the total results
          echo "<p class='results'>There are ".$queryResult." results</p>";

          // Display the results
          if($queryResult > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<a class='search-a' href='article.php?title=".$row['title']."'><div class='article-search-box'>
                      <h3>".$row['title']."</h3>
                      <p>Article by: ".$row['owner']."</p>
                      <span>Posted on: ".$row['created_at']."</span>
                    </div></a>
                    ";
            }
          }
        } else {
          header("Location: blog.php");
        }
      ?>
      </div>
      </div>
    </section>

    <?php
        include_once './includes/footer.php';
    ?>
</body>
</html>