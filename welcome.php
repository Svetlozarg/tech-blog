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
    <section class="banner">
        <div class="banner-cont">
           <?php echo "<h1>Welcome " . $_SESSION['username'] . "</h1>"; ?>
           <h2>To the biggest Tech Blog on the planet</h2>
        </div>
    </section>
    <section class="welcome">
        <div class="welcome-cont">
            <h2>Trending Articles</h2>
        </div>

        <div class="articles">
            <div class="articles-cont">
            <!-- Get all posts from posts and order by date descending and limit to 9 articles -->
                <?php
                    $sql = "SELECT title, text, owner, image, created_at as date FROM posts ORDER BY date DESC LIMIT 9";
                    $request = mysqli_query($conn, $sql);
                    $querryResults = mysqli_num_rows($request);

                    if ($querryResults > 0) {
                        while ($row = mysqli_fetch_assoc($request)) {
                            echo "<figure class='snip1527'>
                                        <div class='image'><img src='./assets/".$row['image']."' alt='pr-sample23' /></div>
                                            <figcaption>
                                                <div class='date'><span class='day'>".date('j', strtotime($row['date']))."</span><span class='month'>".date('F', strtotime($row['date']))."</span></div>
                                                <h3>".$row['title']."</h3>
                                                <p>".$row['text']."</p>
                                            </figcaption>
                                        <a href='article.php?title=".$row['title']."'></a>
                                    </figure>";
                        }
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