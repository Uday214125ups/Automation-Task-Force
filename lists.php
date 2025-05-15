


<?php
session_start();
if (isset($_SESSION['signup'])){if ($_SESSION['signup'] == true) {
    echo "<script>alert('Signup Successfull')</script>";
}}
unset($_SESSION['signup']);
if (isset($_SESSION['invalid'])) {
    echo "<script>alert('Invalid Credentials')</script>";
}
unset($_SESSION['invalid']);
?>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
    <script>
        function checkUsernameAvailability() {
            let username = document.getElementById("username").value;
            let statusElement = document.getElementById("username-status");
            let submitButton = document.getElementById("submitBtn");

            // Disable the submit button initially
            submitButton.disabled = true;

            if (username.length > 0) {
                // Use AJAX to send the username to a PHP script
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "check_username.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function () {
                    if (xhr.status == 200) {
                        // If the username is available, show a success message and enable the button
                        if (xhr.responseText == "available") {
                            statusElement.textContent = "Username is available.";
                            statusElement.style.color = "green";
                            submitButton.disabled = false; // Enable the submit button
                        }
                        // If the username is already taken, show an error message and keep the button disabled
                        else {
                            statusElement.textContent = "Username is already taken.";
                            statusElement.style.color = "red";
                            submitButton.disabled = true; // Disable the submit button
                        }
                    }
                };
                xhr.send("username=" + username);
            } else {
                statusElement.textContent = "";
                submitButton.disabled = true; // Disable the submit button if no username is entered
            }
        }
    </script>
</head>
<body>

<div id="container" class="container">
    <!-- FORM SECTION -->
    <div class="row">
        <!-- SIGN UP -->
        <div class="col align-items-center flex-col sign-up">
            <div class="form-wrapper align-items-center">
                <div class="form sign-up">
                    <div class="input-group">
                        <i class='bx bxs-user'></i>
                        <form method="post" action="signup.php">
                            <span id="username-status"></span>
                            <input type="text" pattern="^[a-zA-Z0-9_]+$" title="Username can only contain letters, digits, and underscores" id="username" name="username" placeholder="Username" onkeyup="checkUsernameAvailability()">
                    </div>
                    <div class="input-group">
                        <i class='bx bx-mail-send'></i>
                        <input type="email" name="email" placeholder="Email">
                    </div>
                    <div class="input-group">
                        <i class='bx bxs-lock-alt'></i>
                        <input type="password" name="password" placeholder="Password">
                    </div>
                    <div class="input-group">
                        <i class='bx bxs-lock-alt'></i>
                        <input type="password" name="confirm_password" placeholder="Confirm password">
                    </div>
                    <button type="submit" id="submitBtn" disabled>Sign up</button>
                    </form>
                    <p>
                        <span>
                            Already have an account?
                        </span>
                        <b onclick="toggle()" class="pointer">
                            Sign in here
                        </b>
                    </p>
                </div>
            </div>
        </div>
        <!-- END SIGN UP -->
        <!-- SIGN IN -->

        <div class="col align-items-center flex-col sign-in">
            <div class="form-wrapper align-items-center">

                <div class="form sign-in">
                    <div class="input-group">
                        <i class='bx bxs-user'></i>
                        <form method="post" action="login_check.php">
                            <input type="text" name="username" placeholder="Username">
                    </div>
                    <div class="input-group">
                        <i class='bx bxs-lock-alt'></i>
                        <input type="password" name="password" placeholder="Password">
                    </div>
                    <button>
                        Sign in
                    </button>
                    </form>
                    <p>
                        <b>
                            Forgot password?
                        </b>
                    </p>
                    <p>
                        <span>
                            Don't have an account?
                        </span>
                        <b onclick="toggle()" class="pointer">
                            Sign up here
                        </b>
                    </p>
                </div>
            </div>
            <div class="form-wrapper">

            </div>
        </div>
        <!-- END SIGN IN -->
    </div>
    <!-- END FORM SECTION -->
    <!-- CONTENT SECTION -->
    <div class="row content-row">
        <!-- SIGN IN CONTENT -->
        <div class="col align-items-center flex-col">
            <div class="text sign-in">
                <h2>
                    Welcome
                </h2>

            </div>
            <div class="img sign-in">

            </div>
        </div>
        <!-- END SIGN IN CONTENT -->
        <!-- SIGN UP CONTENT -->
        <div class="col align-items-center flex-col">
            <div class="img sign-up">

            </div>
            <div class="text sign-up">
                <h2>
                    Join with us
                </h2>

            </div>
        </div>
        <!-- END SIGN UP CONTENT -->
    </div>
    <!-- END CONTENT SECTION -->
</div>

<script>
    let container = document.getElementById('container')

    toggle = () => {
        container.classList.toggle('sign-in')
        container.classList.toggle('sign-up')
    }

    setTimeout(() => {
        container.classList.add('sign-in')
    }, 200)
</script>

</body>
</html>

