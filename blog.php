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
  
  <section class="welcome" style="margin-top:2rem">

        <div class="search">
            <form action="search.php" method="POST">
                <input type="text" placeholder="Search for articles" name="search">
                <button type="submit" name="submit-search"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <div class="welcome-cont">
            <h2>All Articles</h2>
            <form class="filter" method="POST">
                <button class="filter-button" name="desc">Date Desc</button>
                <button class="filter-button" name="asc">Date Asc</button>
                <button class="filter-button" name="a-z">Alphabetically A-Z</button>
                <button class="filter-button" name="z-a">Alphabetically Z-A</button>
            </form>
        </div>

        <div class="articles">
            <div class="articles-cont">
                <!-- Get all posts from posts and order by date descending -->
                <?php
                    // If no filter is set then filter by date desc
                    if (!isset($_REQUEST['desc']) && !isset($_REQUEST['asc']) && !isset($_REQUEST['a-z']) && !isset($_REQUEST['z-a'])) {
                        $sql = "SELECT * FROM posts ORDER BY created_at DESC";
                        $request = mysqli_query($conn, $sql);
                        $querryResults = mysqli_num_rows($request);

                        if ($querryResults > 0) {
                            while ($row = mysqli_fetch_assoc($request)) {
                                echo "<figure class='snip1527'>
                                        <div class='image'><img src='./assets/".$row['image']."' alt='pr-sample23' /></div>
                                            <figcaption>
                                                <div class='date'><span class='day'>".date('j', strtotime($row['created_at']))."</span><span class='month'>".date('F', strtotime($row['created_at']))."</span></div>
                                                <h3>".$row['title']."</h3>
                                                <p>".$row['text']."</p>
                                            </figcaption>
                                        <a href='article.php?title=".$row['title']."'></a>
                                    </figure>";
                            }
                        }
                    }

                    // Order by date desc
                    if (isset($_REQUEST['desc'])) {
                        $sql = "SELECT * FROM posts ORDER BY created_at DESC";
                        $request = mysqli_query($conn, $sql);
                        $querryResults = mysqli_num_rows($request);

                        if ($querryResults > 0) {
                            while ($row = mysqli_fetch_assoc($request)) {
                                     echo "<figure class='snip1527'>
                                        <div class='image'><img src='./assets/".$row['image']."' alt='pr-sample23' /></div>
                                            <figcaption>
                                                <div class='date'><span class='day'>".date('j', strtotime($row['created_at']))."</span><span class='month'>".date('F', strtotime($row['created_at']))."</span></div>
                                                <h3>".$row['title']."</h3>
                                                <p>".$row['text']."</p>
                                            </figcaption>
                                        <a href='article.php?title=".$row['title']."'></a>
                                    </figure>";
                            }
                        }
                    }

                    // Order by date asc
                    if (isset($_REQUEST['asc'])) {
                        $sql = "SELECT * FROM posts ORDER BY created_at ASC";
                        $request = mysqli_query($conn, $sql);
                        $querryResults = mysqli_num_rows($request);

                        if ($querryResults > 0) {
                            while ($row = mysqli_fetch_assoc($request)) {
                                     echo "<figure class='snip1527'>
                                        <div class='image'><img src='./assets/".$row['image']."' alt='pr-sample23' /></div>
                                            <figcaption>
                                                <div class='date'><span class='day'>".date('j', strtotime($row['created_at']))."</span><span class='month'>".date('F', strtotime($row['created_at']))."</span></div>
                                                <h3>".$row['title']."</h3>
                                                <p>".$row['text']."</p>
                                            </figcaption>
                                        <a href='article.php?title=".$row['title']."'></a>
                                    </figure>";
                            }
                        }
                    }

                    // Order alphabetically asc
                    if (isset($_REQUEST['a-z'])) {
                        $sql = "SELECT * FROM posts ORDER BY title ASC";
                        $request = mysqli_query($conn, $sql);
                        $querryResults = mysqli_num_rows($request);

                        if ($querryResults > 0) {
                            while ($row = mysqli_fetch_assoc($request)) {
                                     echo "<figure class='snip1527'>
                                        <div class='image'><img src='./assets/".$row['image']."' alt='pr-sample23' /></div>
                                            <figcaption>
                                                <div class='date'><span class='day'>".date('j', strtotime($row['created_at']))."</span><span class='month'>".date('F', strtotime($row['created_at']))."</span></div>
                                                <h3>".$row['title']."</h3>
                                                <p>".$row['text']."</p>
                                            </figcaption>
                                        <a href='article.php?title=".$row['title']."'></a>
                                    </figure>";
                            }
                        }
                    }

                    // Order alphabetically desc
                    if (isset($_REQUEST['z-a'])) {
                        $sql = "SELECT * FROM posts ORDER BY title DESC";
                        $request = mysqli_query($conn, $sql);
                        $querryResults = mysqli_num_rows($request);

                        if ($querryResults > 0) {
                            while ($row = mysqli_fetch_assoc($request)) {
                                     echo "<figure class='snip1527'>
                                        <div class='image'><img src='./assets/".$row['image']."' alt='pr-sample23' /></div>
                                            <figcaption>
                                                <div class='date'><span class='day'>".date('j', strtotime($row['created_at']))."</span><span class='month'>".date('F', strtotime($row['created_at']))."</span></div>
                                                <h3>".$row['title']."</h3>
                                                <p>".$row['text']."</p>
                                            </figcaption>
                                        <a href='article.php?title=".$row['title']."'></a>
                                    </figure>";
                            }
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