<?php

session_start();

include "db.php";

$message = "";
$messageType = "";


/* =========================================
   LOGIN PROCESS
========================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";


    if (empty($email) || empty($password)) {

        $message = "Please enter email and password.";
        $messageType = "error";

    } else {

        $sql = "
            SELECT id, name, email, password
            FROM users
            WHERE email = ?
        ";


        $stmt = mysqli_prepare(
            $conn,
            $sql
        );


        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $email
        );


        mysqli_stmt_execute($stmt);


        $result =
            mysqli_stmt_get_result($stmt);


        if (mysqli_num_rows($result) == 1) {

            $user =
                mysqli_fetch_assoc($result);


            if (
                password_verify(
                    $password,
                    $user["password"]
                )
            ) {

                $_SESSION["user_id"] =
                    $user["id"];

                $_SESSION["user_name"] =
                    $user["name"];

                $_SESSION["user_email"] =
                    $user["email"];


                header(
                    "Location: dashboard.php"
                );

                exit();

            } else {

                $message =
                    "Incorrect password.";

                $messageType =
                    "error";

            }

        } else {

            $message =
                "Email not registered.";

            $messageType =
                "error";

        }


        mysqli_stmt_close($stmt);

    }

}

?>


<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    Student Login | CSE Department
</title>


<style>

/* =====================================================
   RESET
===================================================== */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}


/* =====================================================
   BODY
===================================================== */

html {
    scroll-behavior: smooth;
}


body {

    min-height: 100vh;

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    color: white;

    overflow-x: hidden;


    background:

        radial-gradient(
            circle at 10% 20%,
            rgba(124,58,237,0.35),
            transparent 30%
        ),

        radial-gradient(
            circle at 90% 80%,
            rgba(6,182,212,0.30),
            transparent 30%
        ),

        linear-gradient(
            135deg,
            #020617,
            #0f172a,
            #111827
        );

}


/* =====================================================
   GLOWING BACKGROUND
===================================================== */

body::before {

    content: "";

    position: fixed;

    width: 420px;
    height: 420px;

    left: -180px;
    top: 120px;

    border-radius: 50%;

    background: #7c3aed;

    filter: blur(120px);

    opacity: 0.22;

    pointer-events: none;

    animation:
        glowMove 8s infinite alternate ease-in-out;

}


body::after {

    content: "";

    position: fixed;

    width: 380px;
    height: 380px;

    right: -160px;
    bottom: 50px;

    border-radius: 50%;

    background: #06b6d4;

    filter: blur(110px);

    opacity: 0.20;

    pointer-events: none;

    animation:
        glowMove2 10s infinite alternate ease-in-out;

}


@keyframes glowMove {

    from {
        transform: translate(0,0);
    }

    to {
        transform: translate(250px,100px);
    }

}


@keyframes glowMove2 {

    from {
        transform: translate(0,0);
    }

    to {
        transform: translate(-220px,-100px);
    }

}


/* =====================================================
   NAVIGATION
===================================================== */

nav {

    width: 94%;

    max-width: 1300px;

    min-height: 70px;

    margin: 20px auto;

    padding: 0 28px;

    display: flex;

    align-items: center;

    justify-content: space-between;


    border-radius: 20px;

    background:
        rgba(255,255,255,0.07);

    border:
        1px solid
        rgba(255,255,255,0.15);


    backdrop-filter:
        blur(20px);

    -webkit-backdrop-filter:
        blur(20px);


    box-shadow:

        0 20px 50px
        rgba(0,0,0,0.35),

        inset 0 1px
        rgba(255,255,255,0.15);


    position: relative;

    z-index: 10;

}


/* =====================================================
   LOGO
===================================================== */

.logo {

    font-size: 21px;

    font-weight: 800;

    letter-spacing: 1px;


    background:

        linear-gradient(
            90deg,
            #a78bfa,
            #22d3ee
        );


    -webkit-background-clip:
        text;

    -webkit-text-fill-color:
        transparent;

}


/* =====================================================
   NAV LINKS
===================================================== */

.nav-links {

    display: flex;

    gap: 7px;

}


.nav-links a {

    text-decoration: none;

    color: #cbd5e1;

    font-size: 14px;

    font-weight: 600;

    padding: 11px 17px;

    border-radius: 12px;

    transition: 0.3s;

}


.nav-links a:hover {

    color: white;

    background:
        rgba(255,255,255,0.10);

    transform:
        translateY(-3px);

}


/* =====================================================
   LOGIN AREA
===================================================== */

.login-wrapper {

    min-height:
        calc(100vh - 180px);

    display: flex;

    justify-content: center;

    align-items: center;

    padding:
        40px 20px 70px;

}


/* =====================================================
   LOGIN CARD
===================================================== */

.login-card {

    width: 100%;

    max-width: 1000px;

    min-height: 570px;


    display: grid;

    grid-template-columns:
        1fr 1fr;


    border-radius: 35px;

    overflow: hidden;


    background:
        rgba(255,255,255,0.07);


    border:
        1px solid
        rgba(255,255,255,0.16);


    backdrop-filter:
        blur(25px);

    -webkit-backdrop-filter:
        blur(25px);


    box-shadow:

        0 50px 100px
        rgba(0,0,0,0.55),

        inset 0 1px
        rgba(255,255,255,0.15);


    transform-style:
        preserve-3d;


    transition:
        transform 0.2s ease;

}


/* =====================================================
   LEFT LOGIN INFORMATION
===================================================== */

.login-info {

    padding: 60px;

    display: flex;

    flex-direction: column;

    justify-content: center;


    background:

        linear-gradient(
            145deg,
            rgba(124,58,237,0.38),
            rgba(6,182,212,0.10)
        );


    position: relative;

    overflow: hidden;

}


/* =====================================================
   DECORATIVE CIRCLE
===================================================== */

.login-info::before {

    content: "";

    position: absolute;

    width: 330px;
    height: 330px;

    right: -160px;
    top: -150px;

    border-radius: 50%;

    border:
        1px solid
        rgba(255,255,255,0.18);


    box-shadow:

        0 0 0 35px
        rgba(255,255,255,0.025),

        0 0 0 70px
        rgba(255,255,255,0.015);


    animation:
        circleRotate 15s linear infinite;

}


@keyframes circleRotate {

    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }

}


/* =====================================================
   BADGE
===================================================== */

.badge {

    width: fit-content;

    padding:
        8px 15px;

    margin-bottom: 25px;

    border-radius: 30px;

    color: #ddd6fe;

    font-size: 11px;

    font-weight: 700;

    letter-spacing: 2px;


    background:
        rgba(139,92,246,0.18);


    border:
        1px solid
        rgba(167,139,250,0.25);

}


/* =====================================================
   LEFT HEADING
===================================================== */

.login-info h1 {

    font-size: 48px;

    line-height: 1.05;

    margin-bottom: 22px;

    font-weight: 800;


    background:

        linear-gradient(
            90deg,
            #ffffff,
            #c4b5fd,
            #67e8f9
        );


    -webkit-background-clip:
        text;

    -webkit-text-fill-color:
        transparent;

}


/* =====================================================
   LEFT DESCRIPTION
===================================================== */

.login-info > p {

    max-width: 400px;

    color:
        #cbd5e1;

    line-height: 1.8;

    font-size: 14px;

}


/* =====================================================
   FEATURE BOXES
===================================================== */

.login-features {

    margin-top: 30px;

    display: grid;

    gap: 13px;

}


.feature {

    display: flex;

    align-items: center;

    gap: 14px;

    padding: 13px;

    border-radius: 14px;

    background:
        rgba(255,255,255,0.06);


    border:
        1px solid
        rgba(255,255,255,0.08);


    transition:
        0.3s;

}


.feature:hover {

    transform:
        translateX(8px)
        translateZ(15px);

    background:
        rgba(255,255,255,0.11);

}


.feature-icon {

    width: 40px;
    height: 40px;

    display: flex;

    align-items: center;

    justify-content: center;

    flex-shrink: 0;

    border-radius: 12px;


    background:

        linear-gradient(
            135deg,
            #7c3aed,
            #06b6d4
        );

}


.feature strong {

    display: block;

    font-size: 13px;

    margin-bottom: 3px;

}


.feature span {

    color:
        #94a3b8;

    font-size: 11px;

}


/* =====================================================
   RIGHT LOGIN FORM
===================================================== */

.login-form {

    padding: 60px;

    display: flex;

    flex-direction: column;

    justify-content: center;


    background:
        rgba(2,6,23,0.28);

}


/* =====================================================
   FORM TITLE
===================================================== */

.form-label {

    color:
        #94a3b8;

    font-size: 11px;

    letter-spacing: 2px;

    font-weight: 700;

    margin-bottom: 10px;

}


.login-form h2 {

    font-size: 31px;

    margin-bottom: 8px;

}


.subtitle {

    color:
        #94a3b8;

    font-size: 14px;

    margin-bottom: 28px;

}


/* =====================================================
   ERROR MESSAGE
===================================================== */

.message {

    padding:
        12px 15px;

    margin-bottom: 18px;

    border-radius: 12px;

    font-size: 13px;

}


.message.error {

    color:
        #fecaca;

    background:
        rgba(239,68,68,0.12);

    border:
        1px solid
        rgba(239,68,68,0.25);

}


/* =====================================================
   LABEL
===================================================== */

.login-form label {

    display: block;

    color:
        #cbd5e1;

    font-size: 12px;

    font-weight: 600;

    margin-bottom: 7px;

}


/* =====================================================
   INPUT GROUP
===================================================== */

.input-group {

    position: relative;

    margin-bottom: 20px;

}


/* =====================================================
   INPUT ICON
===================================================== */

.input-icon {

    position: absolute;

    left: 17px;

    top: 50%;

    transform:
        translateY(-50%);

    color:
        #64748b;

    font-size: 16px;

    pointer-events: none;

    transition: 0.3s;

}


/* =====================================================
   INPUT
===================================================== */

.input-group input {

    width: 100%;

    height: 54px;

    padding:
        0 50px;

    border-radius: 14px;

    border:
        1px solid
        rgba(255,255,255,0.12);


    outline: none;

    color: white;

    background:
        rgba(0,0,0,0.25);


    font-size: 14px;

    transition:
        0.3s;

}


.input-group input::placeholder {

    color:
        #64748b;

}


.input-group input:focus {

    border-color:
        #8b5cf6;

    transform:
        translateY(-2px);


    box-shadow:

        0 10px 30px
        rgba(124,58,237,0.18),

        0 0 0 3px
        rgba(124,58,237,0.10);

}


.input-group:focus-within
.input-icon {

    color:
        #a78bfa;

    transform:
        translateY(-50%)
        scale(1.15);

}


/* =====================================================
   SHOW PASSWORD
===================================================== */

.eye-btn {

    position: absolute;

    right: 12px;

    top: 50%;

    transform:
        translateY(-50%);

    border: none;

    background: transparent;

    color:
        #64748b;

    cursor: pointer;

    font-size: 11px;

    font-weight: 700;

    padding: 7px;

    transition: 0.3s;

}


.eye-btn:hover {

    color:
        #67e8f9;

}


/* =====================================================
   LOGIN BUTTON
===================================================== */

.login-btn {

    width: 100%;

    height: 55px;

    border: none;

    border-radius: 14px;

    color: white;

    font-size: 14px;

    font-weight: 700;

    cursor: pointer;


    background:

        linear-gradient(
            135deg,
            #7c3aed,
            #06b6d4
        );


    box-shadow:

        0 15px 35px
        rgba(124,58,237,0.28);


    transition:
        transform 0.2s,
        box-shadow 0.2s;

}


.login-btn:hover {

    box-shadow:

        0 20px 45px
        rgba(6,182,212,0.25),

        0 10px 30px
        rgba(124,58,237,0.30);

}


.login-btn:active {

    transform:
        scale(0.98);

}


/* =====================================================
   REGISTER LINK
===================================================== */

.register-text {

    text-align: center;

    margin-top: 22px;

    color:
        #64748b;

    font-size: 12px;

}


.register-text a {

    color:
        #67e8f9;

    text-decoration: none;

    font-weight: 700;

}


.register-text a:hover {

    text-decoration:
        underline;

}


/* =====================================================
   FOOTER
===================================================== */

footer {

    text-align: center;

    padding:
        22px;

    color:
        #64748b;

    font-size: 12px;

    border-top:
        1px solid
        rgba(255,255,255,0.08);

    background:
        rgba(0,0,0,0.15);

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 900px) {

    .login-card {

        grid-template-columns:
            1fr;

    }


    .login-info {

        padding:
            45px;

    }


    .login-form {

        padding:
            45px;

    }

}


@media (max-width: 600px) {

    nav {

        flex-direction:
            column;

        padding:
            15px;

        gap: 12px;

    }


    .nav-links {

        flex-wrap:
            wrap;

        justify-content:
            center;

    }


    .nav-links a {

        font-size:
            12px;

        padding:
            8px 10px;

    }


    .login-wrapper {

        padding:
            20px 12px 50px;

    }


    .login-info {

        padding:
            35px 25px;

    }


    .login-form {

        padding:
            35px 25px;

    }


    .login-info h1 {

        font-size:
            36px;

    }

}

</style>

</head>


<body>


<!-- =====================================================
     NAVIGATION
===================================================== -->

<nav>

    <div class="logo">
        CSE Department
    </div>


    <div class="nav-links">

        <a href="index.php">
            Home
        </a>

        <a href="about.php">
            About Us
        </a>

        <a href="register.php">
            Register
        </a>

        <a href="login.php">
            Login
        </a>

    </div>

</nav>



<!-- =====================================================
     LOGIN
===================================================== -->

<div class="login-wrapper">


    <div
        class="login-card"
        id="loginCard"
    >


        <!-- =================================================
             LEFT SIDE
        ================================================== -->

        <div class="login-info">


            <div class="badge">
                CSE STUDENT PORTAL
            </div>


            <h1>
                Welcome<br>
                Back.
            </h1>


            <p>

                Access your Computer Science Department
                student portal and continue your academic
                journey.

            </p>


            <div class="login-features">


                <div class="feature">

                    <div class="feature-icon">
                        🔐
                    </div>


                    <div>

                        <strong>
                            Secure Login
                        </strong>

                        <span>
                            Your password is protected
                        </span>

                    </div>

                </div>



                <div class="feature">

                    <div class="feature-icon">
                        ⚡
                    </div>


                    <div>

                        <strong>
                            Fast Access
                        </strong>

                        <span>
                            Quickly access your student portal
                        </span>

                    </div>

                </div>



                <div class="feature">

                    <div class="feature-icon">
                        ✓
                    </div>


                    <div>

                        <strong>
                            Student Account
                        </strong>

                        <span>
                            Your academic information in one place
                        </span>

                    </div>

                </div>


            </div>


        </div>



        <!-- =================================================
             RIGHT SIDE
        ================================================== -->

        <div class="login-form">


            <div class="form-label">
                STUDENT LOGIN
            </div>


            <h2>
                Sign in to your account
            </h2>


            <p class="subtitle">

                Enter your credentials to continue.

            </p>



            <!-- PHP MESSAGE -->

            <?php if ($message != "") { ?>

                <div class="message error">

                    <?php

                    echo htmlspecialchars(
                        $message
                    );

                    ?>

                </div>

            <?php } ?>



            <!-- =================================================
                 LOGIN FORM
            ================================================== -->

            <form
                method="POST"
                id="loginForm"
                autocomplete="off"
            >


                <!-- EMAIL -->

                <label>
                    Email Address
                </label>


                <div class="input-group">

                    <span class="input-icon">
                        @
                    </span>


                    <input
                        type="email"
                        name="login_email"
                        id="login_email"
                        placeholder="Enter your email"
                        autocomplete="off"
                        value=""
                        readonly
                        onfocus="
                            this.removeAttribute('readonly');
                        "
                        required
                    >

                </div>



                <!-- PASSWORD -->

                <label>
                    Password
                </label>


                <div class="input-group">

                    <span class="input-icon">
                        ◆
                    </span>


                    <input
                        type="password"
                        name="login_password"
                        id="login_password"
                        placeholder="Enter your password"
                        autocomplete="new-password"
                        value=""
                        readonly
                        onfocus="
                            this.removeAttribute('readonly');
                        "
                        required
                    >


                    <button
                        type="button"
                        class="eye-btn"
                        id="eyeButton"
                    >
                        Show
                    </button>

                </div>



                <!-- LOGIN -->

                <button
                    type="submit"
                    class="login-btn"
                    id="loginButton"
                >

                    Login to Portal →

                </button>


            </form>



            <!-- REGISTER -->

            <p class="register-text">

                Don't have an account?

                <a href="register.php">
                    Create Account
                </a>

            </p>


        </div>


    </div>


</div>



<!-- =====================================================
     FOOTER
===================================================== -->

<footer>

    © 2026 CSE Department
    Advanced Student Management System

</footer>



<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script>


/* =====================================================
   ELEMENTS
===================================================== */

const card =
    document.getElementById(
        "loginCard"
    );


const password =
    document.getElementById(
        "login_password"
    );


const eyeButton =
    document.getElementById(
        "eyeButton"
    );


const loginButton =
    document.getElementById(
        "loginButton"
    );


const form =
    document.getElementById(
        "loginForm"
    );



/* =====================================================
   3D CARD MOUSE EFFECT
===================================================== */

if (
    card &&
    window.matchMedia(
        "(min-width: 901px)"
    ).matches
) {


    card.addEventListener(
        "mousemove",
        function(e) {


            const rect =
                card.getBoundingClientRect();


            const x =
                e.clientX -
                rect.left;


            const y =
                e.clientY -
                rect.top;


            const rotateY =
                ((x / rect.width) - 0.5)
                * 8;


            const rotateX =
                ((y / rect.height) - 0.5)
                * -8;


            card.style.transform =

                `
                perspective(1200px)
                rotateX(${rotateX}deg)
                rotateY(${rotateY}deg)
                translateY(-5px)
                scale(1.01)
                `;

        }
    );



    card.addEventListener(
        "mouseleave",
        function() {


            card.style.transform =

                `
                perspective(1200px)
                rotateX(0deg)
                rotateY(0deg)
                translateY(0)
                scale(1)
                `;

        }
    );

}



/* =====================================================
   SHOW / HIDE PASSWORD
===================================================== */

eyeButton.addEventListener(
    "click",
    function() {


        if (
            password.type ===
            "password"
        ) {

            password.type =
                "text";

            eyeButton.textContent =
                "Hide";

        }

        else {

            password.type =
                "password";

            eyeButton.textContent =
                "Show";

        }

    }
);



/* =====================================================
   LOGIN BUTTON 3D EFFECT
===================================================== */

loginButton.addEventListener(
    "mousemove",
    function(e) {


        const rect =
            loginButton.getBoundingClientRect();


        const x =
            e.clientX -
            rect.left;


        const y =
            e.clientY -
            rect.top;


        const rotateY =
            ((x / rect.width) - 0.5)
            * 5;


        const rotateX =
            ((y / rect.height) - 0.5)
            * -5;


        loginButton.style.transform =

            `
            perspective(500px)
            rotateX(${rotateX}deg)
            rotateY(${rotateY}deg)
            translateY(-3px)
            `;

    }
);


loginButton.addEventListener(
    "mouseleave",
    function() {

        loginButton.style.transform =
            "translateY(0)";

    }
);



/* =====================================================
   FORM SUBMIT ANIMATION
===================================================== */

form.addEventListener(
    "submit",
    function() {

        loginButton.innerHTML =
            "Authenticating...";

        loginButton.style.opacity =
            "0.8";

    }
);



/* =====================================================
   CLEAR INPUTS WHEN PAGE LOADS
===================================================== */

window.addEventListener(
    "pageshow",
    function() {

        const email =
            document.getElementById(
                "login_email"
            );


        if (email) {

            email.value = "";

        }


        if (password) {

            password.value = "";

            password.type =
                "password";

        }


        eyeButton.textContent =
            "Show";

    }
);

</script>


</body>

</html>