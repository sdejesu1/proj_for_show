<nav>

    <div class="loginDropdown">
        <button class="dropbtn"><img src="images/userIcon2.png">
            <i class="fa fa-caret-down"></i>
        </button>

        <div class="loginDropdown-content">
            <a class="<?php
                        if (PATH_PARTS['filename'] == "signUp") {
                            print 'activePage';
                        } ?>" href="signUp.php">Sign Up</a>

            <a class="<?php
                        if (PATH_PARTS['filename'] == "login") {
                            print 'activePage';
                        } ?>" href="login.php">Log In</a>

            <a class="<?php
                        if (PATH_PARTS['filename'] == "logout") {
                            print 'activePage';
                        } ?>" href="logout.php">Log Out</a>
        </div>
    </div>

    <a class="<?php
                if (PATH_PARTS['filename'] == "index") {
                    print 'activePage';
                } ?>" href="index.php">Home Page</a>

    <div class="indexDropdown">
        <button class="dropbtn">Lists
            <i class="fa fa-caret-down"></i>
        </button>

        <div class="indexDropdown-content">
            <a class="<?php
                        if (PATH_PARTS['filename'] == "yourPage") {
                            print 'activePage';
                        } ?>" href="yourPage.php">Your List</a>

            <a class="<?php
                        if (PATH_PARTS['filename'] == "authorsPage") {
                            print 'activePage';
                        } ?>" href="authorsPage.php">Author's List</a>

            <a class="<?php
                        if (PATH_PARTS['filename'] == "submitPage") {
                            print 'activePage';
                        } ?>" href="submitPage.php">Submit Entertainment</a>
        </div>
    </div>

    <a class="<?php
                if (PATH_PARTS['filename'] == "about") {
                    print 'activePage';
                } ?>" href="about.php">About</a>

    <a class="<?php
                if (PATH_PARTS['filename'] == "feedbackPage") {
                    print 'activePage';
                } ?>" href="feedbackPage.php">Feedback</a>

    <div class="adminDropdown">
        <button class="dropbtn">Admin
            <i class="fa fa-caret-down"></i>
        </button>

        <div class="adminDropdown-content">
            <a class="<?php
                        if (PATH_PARTS['filename'] == "adminHome") {
                            print 'activePage';
                        } ?>" href="admin/adminHome.php">Admin Home</a>

        </div>
    </div>

</nav>