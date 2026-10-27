<?php

session_start();

include "db.php";

$message = "";
$messageType = "";


/* =========================================
   REGISTRATION
========================================= */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";


    /* EMPTY CHECK */

    if (
        empty($name) ||
        empty($email) ||
        empty($password) ||
        empty($confirm_password)
    ) {

        $message = "Please fill all fields.";
        $messageType = "error";

    }


    /* PASSWORD LENGTH */

    elseif (strlen($password) < 6) {

        $message = "Password must contain at least 6 characters.";
        $messageType = "error";

    }


    /* PASSWORD MATCH */

    elseif ($password !== $confirm_password) {

        $message = "Passwords do not match.";
        $messageType = "error";

    }


    else {

        /* CHECK EMAIL */

        $checkSql = "SELECT id FROM users WHERE email = ?";

        $checkStmt = mysqli_prepare(
            $conn,
            $checkSql
        );

        mysqli_stmt_bind_param(
            $checkStmt,
            "s",
            $email
        );

        mysqli_stmt_execute($checkStmt);

        mysqli_stmt_store_result($checkStmt);


        if (mysqli_stmt_num_rows($checkStmt) > 0) {

            $message = "Email is already registered.";
            $messageType = "error";

        }

        else {

            /* HASH PASSWORD */

            $hashedPassword =
                password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );


            /* INSERT USER */

            $sql = "
                INSERT INTO users
                (name, email, password)
                VALUES (?, ?, ?)
            ";

            $stmt = mysqli_prepare(
                $conn,
                $sql
            );


            mysqli_stmt_bind_param(
                $stmt,
                "sss",
                $name,
                $email,
                $hashedPassword
            );


            if (mysqli_stmt_execute($stmt)) {

                $message =
                    "Registration successful! You can now login.";

                $messageType = "success";

            }

            else {

                $message =
                    "Registration failed. Please try again.";

                $messageType = "error";

            }


            mysqli_stmt_close($stmt);

        }


        mysqli_stmt_close($checkStmt);

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
    Student Registration | CSE Department
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

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    min-height: 100vh;

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
   ANIMATED BACKGROUND
===================================================== */

body::before {

    content: "";

    position: fixed;

    width: 400px;

    height: 400px;

    top: 80px;

    left: -180px;

    border-radius: 50%;

    background: #7c3aed;

    filter: blur(120px);

    opacity: 0.20;

    pointer-events: none;

    animation:
        moveGlow 8s infinite alternate ease-in-out;

}


body::after {

    content: "";

    position: fixed;

    width: 350px;

    height: 350px;

    right: -150px;

    bottom: 50px;

    border-radius: 50%;

    background: #06b6d4;

    filter: blur(110px);

    opacity: 0.18;

    pointer-events: none;

    animation:
        moveGlow2 10s infinite alternate ease-in-out;

}


@keyframes moveGlow {

    from {

        transform:
            translate(0,0);

    }

    to {

        transform:
            translate(220px,120px);

    }

}


@keyframes moveGlow2 {

    from {

        transform:
            translate(0,0);

    }

    to {

        transform:
            translate(-180px,-120px);

    }

}


/* =====================================================
   NAVIGATION
===================================================== */

nav {

    width: 94%;

    max-width: 1300px;

    height: 72px;

    margin: 20px auto;

    padding:
        0 28px;

    display: flex;

    align-items: center;

    justify-content: space-between;


    background:
        rgba(255,255,255,0.08);

    border:
        1px solid rgba(255,255,255,0.16);

    border-radius: 20px;


    backdrop-filter:
        blur(20px);

    -webkit-backdrop-filter:
        blur(20px);


    box-shadow:

        0 20px 50px
        rgba(0,0,0,0.40),

        inset 0 1px
        rgba(255,255,255,0.15);


    position: relative;

    z-index: 20;

}


/* LOGO */

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


/* NAV LINKS */

.nav-links {

    display: flex;

    gap: 8px;

}


.nav-links a {

    color: #cbd5e1;

    text-decoration: none;

    padding:
        11px 18px;

    border-radius: 12px;

    font-size: 14px;

    font-weight: 600;

    transition:
        0.3s;

}


.nav-links a:hover {

    color: white;

    background:
        rgba(255,255,255,0.10);

    transform:
        translateY(-3px);

}


/* =====================================================
   MAIN WRAPPER
===================================================== */

.register-wrapper {

    min-height:
        calc(100vh - 112px);

    display: flex;

    align-items: center;

    justify-content: center;

    padding:
        40px 20px 70px;

}


/* =====================================================
   3D CARD
===================================================== */

.register-card {

    width: 100%;

    max-width: 1100px;

    min-height: 650px;


    display: grid;

    grid-template-columns:
        1fr 1fr;


    position: relative;

    overflow: hidden;


    border-radius: 35px;


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
        transform 0.20s ease;

}


/* =====================================================
   LEFT PANEL
===================================================== */

.register-info {

    position: relative;

    padding: 60px;

    display: flex;

    flex-direction: column;

    justify-content: center;


    overflow: hidden;


    background:

        linear-gradient(
            145deg,
            rgba(124,58,237,0.38),
            rgba(6,182,212,0.10)
        );

}


/* DECORATIVE CIRCLE */

.register-info::before {

    content: "";

    position: absolute;

    width: 300px;

    height: 300px;

    top: -130px;

    right: -120px;

    border-radius: 50%;

    border:
        1px solid
        rgba(255,255,255,0.18);


    box-shadow:

        0 0 0 30px
        rgba(255,255,255,0.025),

        0 0 0 60px
        rgba(255,255,255,0.015);


    animation:
        rotateCircle 15s linear infinite;

}


@keyframes rotateCircle {

    from {

        transform:
            rotate(0deg);

    }

    to {

        transform:
            rotate(360deg);

    }

}


/* BADGE */

.badge {

    width: fit-content;

    padding:
        8px 15px;

    border-radius: 30px;

    font-size: 11px;

    font-weight: 700;

    letter-spacing: 2px;

    color: #ddd6fe;


    background:
        rgba(139,92,246,0.18);


    border:
        1px solid
        rgba(167,139,250,0.25);


    margin-bottom: 25px;

}


/* LEFT HEADING */

.register-info h1 {

    font-size: 50px;

    line-height: 1.05;

    font-weight: 800;

    margin-bottom: 22px;


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


/* LEFT DESCRIPTION */

.register-info > p {

    color:
        #cbd5e1;

    line-height: 1.8;

    font-size: 15px;

    max-width: 440px;

}


/* =====================================================
   FEATURES
===================================================== */

.features {

    margin-top: 35px;

    display: grid;

    gap: 14px;

}


.feature {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 14px;

    border-radius: 15px;


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


/* FEATURE ICON */

.feature-icon {

    width: 42px;

    height: 42px;

    flex-shrink: 0;


    display: flex;

    align-items: center;

    justify-content: center;


    border-radius: 12px;


    background:

        linear-gradient(
            135deg,
            #7c3aed,
            #06b6d4
        );


    font-size: 18px;

}


/* FEATURE TEXT */

.feature-text strong {

    display: block;

    font-size: 14px;

    margin-bottom: 4px;

}


.feature-text span {

    color:
        #94a3b8;

    font-size: 12px;

}


/* =====================================================
   RIGHT FORM
===================================================== */

.register-form {

    padding: 55px;

    display: flex;

    flex-direction: column;

    justify-content: center;


    background:
        rgba(2,6,23,0.28);

}


/* FORM LABEL */

.form-label {

    color:
        #94a3b8;

    font-size: 11px;

    letter-spacing: 2px;

    font-weight: 700;

    margin-bottom: 8px;

}


/* FORM TITLE */

.register-form h2 {

    font-size: 30px;

    margin-bottom: 8px;

}


.subtitle {

    color:
        #94a3b8;

    font-size: 14px;

    margin-bottom: 25px;

}


/* =====================================================
   MESSAGE
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


.message.success {

    color:
        #bbf7d0;

    background:
        rgba(34,197,94,0.12);

    border:
        1px solid
        rgba(34,197,94,0.25);

}


/* =====================================================
   LABELS
===================================================== */

.register-form label {

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

    margin-bottom: 17px;

}


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

    transition:
        0.3s;

}


/* INPUT */

.input-group input {

    width: 100%;

    height: 52px;

    padding:
        0 50px;

    color: white;

    background:
        rgba(0,0,0,0.25);


    border:
        1px solid
        rgba(255,255,255,0.12);


    border-radius: 14px;

    outline: none;

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
        rgba(124,58,237,0.15),

        0 0 0 3px
        rgba(124,58,237,0.10);

}


.input-group:focus-within
.input-icon {

    color:
        #a78bfa;

}


/* =====================================================
   SHOW/HIDE BUTTON
===================================================== */

.eye-btn {

    position: absolute;

    right: 12px;

    top: 50%;

    transform:
        translateY(-50%);


    border: none;

    background:
        transparent;

    color:
        #64748b;


    cursor: pointer;

    font-size: 11px;

    font-weight: 700;

    padding: 6px;

}


.eye-btn:hover {

    color:
        #67e8f9;

}


/* =====================================================
   PASSWORD STRENGTH
===================================================== */

.password-strength {

    height: 5px;

    width: 100%;

    margin-top: -5px;

    margin-bottom: 6px;

    background:
        rgba(255,255,255,0.08);

    border-radius: 10px;

    overflow: hidden;

}


#strengthFill {

    width: 0%;

    height: 100%;

    border-radius: 10px;


    background:

        linear-gradient(
            90deg,
            #ef4444,
            #f59e0b,
            #22c55e,
            #06b6d4
        );


    transition:
        width 0.4s ease;

}


#strengthText {

    color:
        #64748b;

    font-size: 11px;

    margin-bottom: 15px;

}


/* =====================================================
   PASSWORD MATCH
===================================================== */

#matchText {

    min-height: 18px;

    font-size: 11px;

    margin-top: -10px;

    margin-bottom: 10px;

}


.password-success {

    color:
        #35e0a1 !important;

}


.password-error {

    color:
        #ff8d9a !important;

}


.input-success {

    border-color:
        #35e0a1 !important;

}


.input-error {

    border-color:
        #ff6478 !important;

}


/* =====================================================
   REGISTER BUTTON
===================================================== */

.register-btn {

    width: 100%;

    height: 54px;

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
        rgba(124,58,237,0.25);


    transition:
        0.3s;

}


.register-btn:hover {

    transform:
        translateY(-4px);


    box-shadow:

        0 20px 45px
        rgba(6,182,212,0.25),

        0 10px 30px
        rgba(124,58,237,0.30);

}


.register-btn:active {

    transform:
        translateY(0);

}


/* =====================================================
   LOGIN
===================================================== */

.login-text {

    text-align: center;

    margin-top: 20px;

    color:
        #64748b;

    font-size: 12px;

}


.login-text a {

    color:
        #67e8f9;

    font-weight: 700;

    text-decoration: none;

}


.login-text a:hover {

    text-decoration:
        underline;

}


/* =====================================================
   FOOTER
===================================================== */

footer {

    text-align: center;

    padding: 22px;

    color:
        #64748b;

    border-top:
        1px solid
        rgba(255,255,255,0.08);

    background:
        rgba(0,0,0,0.15);

    font-size: 12px;

}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 900px) {

    .register-card {

        grid-template-columns:
            1fr;

    }


    .register-info {

        padding:
            45px;

    }


    .register-info h1 {

        font-size:
            40px;

    }


    .register-form {

        padding:
            45px;

    }

}


@media (max-width: 600px) {

    nav {

        height: auto;

        padding:
            15px;

        flex-direction:
            column;

        gap: 12px;

    }


    .nav-links {

        flex-wrap:
            wrap;

        justify-content:
            center;

    }


    .nav-links a {

        padding:
            8px 10px;

        font-size:
            12px;

    }


    .register-wrapper {

        padding:
            20px 12px 50px;

    }


    .register-info {

        padding:
            35px 25px;

    }


    .register-form {

        padding:
            35px 25px;

    }


    .register-info h1 {

        font-size:
            35px;

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
     REGISTER SECTION
===================================================== -->

<div class="register-wrapper">


    <div
        class="register-card"
        id="registerCard"
    >


        <!-- =================================================
             LEFT SIDE
        ================================================== -->

        <div class="register-info">


            <div class="badge">
                CSE STUDENT PORTAL
            </div>


            <h1>
                Build your<br>
                digital future.
            </h1>


            <p>

                Register for the Computer Science Department
                portal and access a modern academic experience
                designed for students.

            </p>


            <div class="features">


                <div class="feature">

                    <div class="feature-icon">
                        ✓
                    </div>


                    <div class="feature-text">

                        <strong>
                            Secure Registration
                        </strong>

                        <span>
                            Your information is securely protected
                        </span>

                    </div>

                </div>



                <div class="feature">

                    <div class="feature-icon">
                        ⚡
                    </div>


                    <div class="feature-text">

                        <strong>
                            24/7 Portal Access
                        </strong>

                        <span>
                            Access your student account anytime
                        </span>

                    </div>

                </div>



                <div class="feature">

                    <div class="feature-icon">
                        ★
                    </div>


                    <div class="feature-text">

                        <strong>
                            100% Student Focused
                        </strong>

                        <span>
                            Designed for a better academic experience
                        </span>

                    </div>

                </div>


            </div>


        </div>



        <!-- =================================================
             RIGHT SIDE
        ================================================== -->

        <div class="register-form">


            <div class="form-label">
                NEW STUDENT
            </div>


            <h2>
                Student Registration
            </h2>


            <p class="subtitle">

                Create your account and join the
                CSE student portal.

            </p>



            <!-- PHP MESSAGE -->

            <?php if ($message != "") { ?>

                <div
                    class="message <?php echo $messageType; ?>"
                >

                    <?php

                    echo htmlspecialchars(
                        $message
                    );

                    ?>

                </div>

            <?php } ?>



            <!-- =================================================
                 REGISTRATION FORM
            ================================================== -->

            <form
                method="POST"
                id="registrationForm"
                autocomplete="off"
            >


                <!-- NAME -->

                <label>
                    Full Name
                </label>


                <div class="input-group">

                    <span class="input-icon">
                        👤
                    </span>


                    <input
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Enter your full name"
                        autocomplete="off"
                        value=""
                        readonly
                        onfocus="this.removeAttribute('readonly');"
                        required
                    >

                </div>



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
                        name="email"
                        id="email"
                        placeholder="student@example.com"
                        autocomplete="off"
                        value=""
                        readonly
                        onfocus="this.removeAttribute('readonly');"
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
                        name="password"
                        id="password"
                        placeholder="Minimum 6 characters"
                        autocomplete="new-password"
                        value=""
                        readonly
                        onfocus="this.removeAttribute('readonly');"
                        required
                    >


                    <button
                        type="button"
                        class="eye-btn"
                        data-target="password"
                    >
                        Show
                    </button>

                </div>



                <!-- PASSWORD STRENGTH -->

                <div class="password-strength">

                    <div
                        id="strengthFill"
                    ></div>

                </div>


                <div id="strengthText">

                    Password strength

                </div>



                <!-- CONFIRM PASSWORD -->

                <label>
                    Confirm Password
                </label>


                <div class="input-group">

                    <span class="input-icon">
                        ◆
                    </span>


                    <input
                        type="password"
                        name="confirm_password"
                        id="confirm_password"
                        placeholder="Re-enter your password"
                        autocomplete="new-password"
                        value=""
                        readonly
                        onfocus="this.removeAttribute('readonly');"
                        required
                    >


                    <button
                        type="button"
                        class="eye-btn"
                        data-target="confirm_password"
                    >
                        Show
                    </button>

                </div>



                <!-- MATCH MESSAGE -->

                <div id="matchText"></div>



                <!-- BUTTON -->

                <button
                    type="submit"
                    class="register-btn"
                >

                    Create Student Account →

                </button>


            </form>



            <!-- LOGIN -->

            <p class="login-text">

                Already have an account?

                <a href="login.php">
                    Login to portal
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
   GET ELEMENTS
===================================================== */

const card =
    document.getElementById(
        "registerCard"
    );


const password =
    document.getElementById(
        "password"
    );


const confirmPassword =
    document.getElementById(
        "confirm_password"
    );


const strengthFill =
    document.getElementById(
        "strengthFill"
    );


const strengthText =
    document.getElementById(
        "strengthText"
    );


const matchText =
    document.getElementById(
        "matchText"
    );


const form =
    document.getElementById(
        "registrationForm"
    );



/* =====================================================
   3D CARD EFFECT
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
                translateY(-3px)
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

document
    .querySelectorAll(".eye-btn")
    .forEach(function(button) {


        button.addEventListener(
            "click",
            function() {


                const input =
                    document.getElementById(
                        button.dataset.target
                    );


                if (!input) {

                    return;

                }


                if (
                    input.type ===
                    "password"
                ) {


                    input.type =
                        "text";


                    button.textContent =
                        "Hide";


                }

                else {


                    input.type =
                        "password";


                    button.textContent =
                        "Show";

                }

            }
        );

    });



/* =====================================================
   PASSWORD STRENGTH
===================================================== */

function passwordStrength(value) {


    let score = 0;


    if (value.length >= 6) {

        score++;

    }


    if (value.length >= 10) {

        score++;

    }


    if (/[A-Z]/.test(value)) {

        score++;

    }


    if (/[0-9]/.test(value)) {

        score++;

    }


    if (
        /[^A-Za-z0-9]/.test(value)
    ) {

        score++;

    }


    return score;

}



/* =====================================================
   PASSWORD STRENGTH DISPLAY
===================================================== */

if (password) {


    password.addEventListener(
        "input",
        function() {


            const score =
                passwordStrength(
                    password.value
                );


            const widths = [

                "0%",

                "20%",

                "40%",

                "60%",

                "80%",

                "100%"

            ];


            const labels = [

                "Password strength",

                "Very weak",

                "Weak",

                "Good",

                "Strong",

                "Excellent"

            ];


            strengthFill.style.width =
                widths[score];


            strengthText.textContent =
                labels[score];


            checkMatch();

        }
    );

}



/* =====================================================
   PASSWORD MATCH
===================================================== */

function checkMatch() {


    if (
        !confirmPassword.value
    ) {


        matchText.textContent =
            "";


        confirmPassword.classList.remove(
            "input-success"
        );


        confirmPassword.classList.remove(
            "input-error"
        );


        return;

    }



    if (
        password.value ===
        confirmPassword.value
    ) {


        matchText.textContent =
            "✓ Passwords match";


        matchText.className =
            "password-success";


        confirmPassword.classList.remove(
            "input-error"
        );


        confirmPassword.classList.add(
            "input-success"
        );


    }

    else {


        matchText.textContent =
            "✕ Passwords do not match";


        matchText.className =
            "password-error";


        confirmPassword.classList.remove(
            "input-success"
        );


        confirmPassword.classList.add(
            "input-error"
        );

    }

}



/* =====================================================
   CONFIRM PASSWORD EVENT
===================================================== */

if (confirmPassword) {


    confirmPassword.addEventListener(
        "input",
        checkMatch
    );

}



/* =====================================================
   FORM VALIDATION
===================================================== */

if (form) {


    form.addEventListener(
        "submit",
        function(e) {


            if (
                password.value !==
                confirmPassword.value
            ) {


                e.preventDefault();


                matchText.textContent =
                    "✕ Passwords do not match";


                matchText.className =
                    "password-error";


                confirmPassword.focus();


                return;

            }


            if (
                password.value.length < 6
            ) {


                e.preventDefault();


                alert(
                    "Password must contain at least 6 characters."
                );


                password.focus();


                return;

            }

        }
    );

}



/* =====================================================
   CLEAR REGISTRATION FORM
===================================================== */

window.addEventListener(
    "pageshow",
    function() {


        if (form) {

            form.reset();

        }


        strengthFill.style.width =
            "0%";


        strengthText.textContent =
            "Password strength";


        matchText.textContent =
            "";


    }
);



/* =====================================================
   BUTTON 3D EFFECT
===================================================== */

const button =
    document.querySelector(
        ".register-btn"
    );


if (button) {


    button.addEventListener(
        "mousemove",
        function(e) {


            const rect =
                button.getBoundingClientRect();


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


            button.style.transform =

                `
                perspective(500px)
                rotateX(${rotateX}deg)
                rotateY(${rotateY}deg)
                translateY(-3px)
                `;

        }
    );



    button.addEventListener(
        "mouseleave",
        function() {


            button.style.transform =
                "translateY(0)";

        }
    );

}


</script>


</body>

</html>