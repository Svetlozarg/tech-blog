<header>
  <h1 class="logo">Tech-Blog</h1>
  <input type="checkbox" id="nav-toggle" class="nav-toggle">
  <nav>
    <ul>
      <li><a href="welcome.php">Home</a></li>
      <li><a href="blog.php">Blog</a></li>
      <li><a href="addArticle.php">Add Article</a></li>
      <?php
        if ($_SESSION['role'] === "Admin") {
          echo "
            <li>
              <a href=\"admin.php\">Admin Panel</a>
            </li>
          ";
        }
      ?>
      <li class="right-nav">
          <a href="logout.php">Logout</a>
      </li>
    </ul>
  </nav>
  <label for="nav-toggle" class="nav-toggle-label">
    <span></span>
  </label>
</header>