<?php
    include 'connect.php';
?>

<header class="header">

    <section class="flex">
        
    <!--Nav bar-->
    <nav class="navbar navbar-expand-lg fixed-top" style="border-bottom:none;box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);">
        <div class="container-fluid">
            <a class="navbar-brand me-auto" href="admin.php">Admin Panel</a>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Tech Island</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                        <li class="nav-item" style="display:<?=$displayHome;?>;">
                            <a class="nav-link mx-lg-2 <?php echo $home;?>" aria-current="page" href="admin.php">Home</a>
                        </li>
                        <li class="nav-item" style="display:<?=$displayProducts;?>;">
                            <a class="nav-link mx-lg-2 <?php echo $products;?>" href="products.php">Products</a>
                        </li>
                        <li class="nav-item" style="display:<?=$displayOrders;?>;">
                            <a class="nav-link mx-lg-2 <?php echo $orders;?>" href="placed_orders.php">Orders</a>
                        </li>
                        <li class="nav-item" style="display:<?=$displayAdmin;?>;">
                            <a class="nav-link mx-lg-2 <?php echo $admin;?>" href="admin_accounts.php">Admin</a>
                        </li>
                        <li class="nav-item" style="display:<?=$displayUsers;?>;">
                            <a class="nav-link mx-lg-2 <?php echo $users;?>" href="users_accounts.php">Users</a>
                        </li>
                        <li class="nav-item" style="display:<?=$displayMessages;?>;">
                            <a class="nav-link mx-lg-2 <?php echo $mesages;?>" href="messages.php">Messages</a>
                        </li>
                    </ul>
                </div>
            </div>
            <button type="button" class="btn login-button" data-toggle="modal" data-target="#x"><i class="fa-solid fa-user"></i></button>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <!--Nav bar end-->

        <div class="profile">
            <?php

                $query = mysqli_query($conn,"SELECT * FROM users WHERE UserId = '$admin_id'");
                $fetch_profile = mysqli_fetch_assoc($query);
                              
            ?>
        </div>

                   
    </section>
    
        <div class="modal" tabindex="-1" role="dialog" id="x">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $fetch_profile['LastName']; ?></h5>
                        <button type="button" class="btn-close" data-dismiss="modal" area-label="Close" area-hidden="true"></button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-6">
                            <a href="LogReg.php" class="option-btn">Login</a>
                        </div>
                        <div class="col-6">
                            <a href="register_admin.php" class="option-btn">Register</a>
                        </div>
                    </div>
                    <div class="modal-body row">
                        <div class="col-6">
                            <a href="admin_logout.php" class="delete-btn" onclick="return confirm('Logout this site?');">Logout</a>
                        </div>
                        <div class="col-6">
                            <a href="update_profile.php" class="update-btn">Update Profile</a>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>

</header>