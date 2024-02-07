<!-- navbar start -->
<?php
$navstmt = $db->prepare("SELECT * FROM settings where option = 'settings' and features = 'header' ");
$navstmt->execute();
$brand=$navstmt->fetch(PDO::FETCH_ASSOC);
?>
<nav class="navbar navbar-dark ccolor  px-0  border-bottom navbar-expand-lg navbar-expand-md fixed-top ">
        <div class="container-fluid">
            <div class="btn-group">
                <button data-bs-target="#sidebar" data-bs-toggle="collapse" class="navbar-toggler p-0 border-0 me-2">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="../index.php"><?php echo $brand['action']; ?></a>
            </div>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                </svg>
            </button>
            <div class="offcanvas offcanvas-end bg-dark" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">...</h5>
                    <button type="button" class="btn-close bg-light" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                        </li>
                        
                        <li class="nav-item dropdown me-0">
                            <?php 
                            if (isset($_SESSION['activeuser'])) {
                                $imgid = $_SESSION['activeuser'];
                                $imgstmt = $db->prepare("SELECT * FROM member where id = '$imgid' ");
                                $imgstmt->execute();
                                $imgrow=$imgstmt->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?php echo $imgrow['photo']; ?>" alt="user" width="30" height="30" class="rounded-circle">
                                </a>
                                <?php
                            }else{
                            ?>
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="img/user.png" alt="user" width="30" height="30" class="rounded-circle">
                            </a>
                            <?php
                            }
                            ?>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <?php 
                                if (isset($_SESSION['username'])) {
                                    echo '<li>
                                    <a class="dropdown-item" href="#">'.$_SESSION['username'].'</a>
                                </li>';
                                }
                                ?>
                                <li>
                                    <a class="dropdown-item" href="dashboard.php">Dashboard</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" 
                                    href="logout.php?logout=true">Sign out</a>
                                </li>
                            </ul>
                            </li>     

                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- navbar end -->