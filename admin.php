<?php 

include './db/config.php';

session_start();

// If not loged in redirect to index
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

// Check if current user has admin if not redirect to welcome
if ($_SESSION['role'] !== 'Admin') {
  header("Location: welcome.php");
}

// Check if post delete button is clicked then get the title and delete from posts
if(isset($_REQUEST['delete'])) {
  $title = $_REQUEST['title'];
  $sql = "DELETE FROM posts WHERE title = '$title'";
  $query = mysqli_query($conn, $sql);

  header("Location: admin.php");
  exit();
}

// Check if create admin button is clicked then get the username and set the role to Admin
if(isset($_REQUEST['createAdmin'])) {
  $username = $_REQUEST['username'];
  $sql = ("UPDATE users SET role = 'Admin' WHERE username = '$username'");
  $query = mysqli_query($conn, $sql);

  header("Location: admin.php");
  exit();
}

// Check if create user button is clicked then get the username and set the role to User
if(isset($_REQUEST['createUser'])) {
  $username = $_REQUEST['username'];
  $sql = ("UPDATE users SET role = 'User' WHERE username = '$username'");
  $query = mysqli_query($conn, $sql);

  header("Location: admin.php");
  exit();
}

// Check if ban user button is clicked then get the username and set the ban to 1
if(isset($_REQUEST['banUser'])) {
  $username = $_REQUEST['username'];
  $sql = ("UPDATE users SET ban = '1' WHERE username = '$username'");
  $query = mysqli_query($conn, $sql);

  header("Location: admin.php");
  exit();
}

// Check if unban user is clicked then get the username and set the ban to 0
if(isset($_REQUEST['unbanUser'])) {
  $username = $_REQUEST['username'];
  $sql = ("UPDATE users SET ban = '0' WHERE username = '$username'");
  $query = mysqli_query($conn, $sql);

  header("Location: admin.php");
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

    <!-- Side Nav  -->
    <div class="menu">
      <ul>
        <li>
          <span onmouseenter="hoverEnter(0)">
            <i class="fa fa-tachometer"></i>
          </span>
        </li>
        <li>
          <span onmouseenter="hoverEnter(1)">
            <i class="fa fa-users"></i>
          </span>
        </li>
        <li>
          <span onmouseenter="hoverEnter(2)">
            <i class="fa fa-newspaper-o"></i>
          </span>
        </li>
        <span class="goo-index" id="goo-index"></span>
      </ul>
    </div>
    
    <!-- Admin Dashboard -->
    <div class="content-wrapper"> 
      <div id="screen_0" class="screen visible">
        <h2>Admin Dashboard</h2>
        <div class="dashbord-cont">
          <!-- Total Users -->
          <div class="dashbord dashbord-blue">
              <div class="icon-section">
                <i class="fa fa-users" aria-hidden="true"></i><br>
                <p>Total Users</p>
                <p>
                  <!-- Display total number of users -->
                  <?php
                    $sql = "SELECT * FROM users";
                    $request = mysqli_query($conn, $sql);
                    $querryResults = mysqli_num_rows($request);

                    echo $querryResults;
                  ?>
                </p>
              </div>
          </div>

          <!-- Total Articles -->
          <div class="dashbord dashbord-green">
            <div class="icon-section">
              <i class="fa fa-newspaper-o" aria-hidden="true"></i><br>
              <p>Total Articles</p>
              <p>
                <!-- Display total number of posts -->
                <?php
                  $sql = "SELECT * FROM posts";
                  $request = mysqli_query($conn, $sql);
                  $querryResults = mysqli_num_rows($request);

                  echo $querryResults;
                ?>
              </p>
            </div>
          </div>

          <!-- Database space -->
          <div class="dashbord dashbord-orange">
            <div class="icon-section">
              <i class="fa fa-database" aria-hidden="true"></i><br>
              <p>Total Database Size</p>
              <p>
                <!-- Display the total size of DB in MB -->
                <?php
                  $sql = "SHOW TABLE STATUS";
                  $request = mysqli_query($conn, $sql);

                  $dbsize = 0;

                  while($row = mysqli_fetch_assoc($request)) {

                      $dbsize += $row["Data_length"] + $row["Index_length"];

                  }

                  echo bcdiv($dbsize, 1048576, 4) . " MB";
                ?>
              </p>
            </div>
          </div>
        </div>
      </div>
      
       <div id="screen_1" class="screen">
         <div class="screen-wrapper">
           <h2 class="screen-title">All Users</h2>
            <!-- Display every user in a row with user, admin, ban and unban option  -->
            <?php
                $sql = "SELECT * FROM users";
                $request = mysqli_query($conn, $sql);
                $querryResults = mysqli_num_rows($request);

                if ($querryResults > 0) {
                    while ($row = mysqli_fetch_assoc($request)) {
                        echo "
                            <div class='admin-users'>
                              <h3 class='username'>".$row['username']."</h3>
                              <p class='email'>".$row['email']."</p>
                              <p class='role'>".$row['role']."</p>
                              <p>Ban: ".$row['ban']."</p>
                              <div class='admin-article-buttons'>
                                <form  method='POST' action='admin.php?username=".$row['username']."''>
                                  <button class='create-btn' name='createUser'>User</button>
                                  <button class='create-btn' name='createAdmin'>Admin</button>
                                  <button class='delete-btn' name='banUser'>Ban</button>
                                  <button class='create-btn' name='unbanUser'>Unban</button>
                                </form>
                              </div>
                            </div>
                        ";
                    }
                }
            ?>
         </div>
       </div>
      
      
       <div id="screen_2" class="screen">
          <div class="screen-wrapper">
           <h2 class="screen-title">All Articles</h2>
            <!-- Display every article in a row with edit and delete option -->
            <?php
              $sql = "SELECT title, owner, created_at as date FROM posts ORDER BY date DESC";
              $request = mysqli_query($conn, $sql);
              $querryResults = mysqli_num_rows($request);

                if ($querryResults > 0) {
                    while ($row = mysqli_fetch_assoc($request)) {
                        echo "
                            <div class='admin-users admin-articles'>
                              <h3 class='title'>".$row['title']."</h3>
                              <p class='owner'>".$row['owner']."</p>
                              <p class='date'>".date('j F, Y', strtotime($row['date']))."</p>
                              <div class='admin-article-buttons'>
                                <form method='POST' action='admin.php?title=".$row['title']."''>
                                  <button class='create'><a class='admin-btn' href='editArticle.php?title=".$row['title']."'>Edit</a></button>
                                  <button class='delete-btn' name='delete'>Delete</button>
                                </form>
                              </div>
                            </div>
                        ";
                    }
                }
            ?>
         </div>
      </div>
    </div>

    <?php
        include_once './includes/footer.php';
    ?>

    <!-- Script for navbar links -->
    <script>
      let gooIndex = document.getElementById('goo-index');
      let hoverEnter = index =>{
        gooIndex.style.top = 100*index+'px';
        let allScreens = document.querySelectorAll('.screen');
        allScreens.forEach(e=>{
          e.classList.remove('visible')
        })
        let nowVisible = document.getElementById('screen_'+index);
        nowVisible.classList.add('visible');
      }
    </script>
</body>
</html>