<?php

session_start();

/* =========================================
   CHECK LOGIN
========================================= */

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit();

}

$user_name  = $_SESSION["user_name"];
$user_email = $_SESSION["user_email"];

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>
    Student Dashboard | CSE Department
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


html {
    scroll-behavior: smooth;
}


/* =====================================================
   BODY
===================================================== */

body {

    font-family:
        Arial,
        Helvetica,
        sans-serif;

    min-height: 100vh;

    color: white;

    background:

        radial-gradient(
            circle at 10% 20%,
            rgba(124, 58, 237, .30),
            transparent 30%
        ),

        radial-gradient(
            circle at 90% 80%,
            rgba(6, 182, 212, .25),
            transparent 30%
        ),

        linear-gradient(
            135deg,
            #020617,
            #0f172a,
            #111827
        );

    overflow-x: hidden;
}


/* =====================================================
   BACKGROUND GLOW
===================================================== */

body::before {

    content: "";

    position: fixed;

    width: 350px;
    height: 350px;

    top: 150px;
    left: -150px;

    border-radius: 50%;

    background:
        #7c3aed;

    filter:
        blur(130px);

    opacity: .20;

    pointer-events: none;

    animation:
        glow 8s infinite alternate;
}


body::after {

    content: "";

    position: fixed;

    width: 350px;
    height: 350px;

    bottom: 50px;
    right: -150px;

    border-radius: 50%;

    background:
        #06b6d4;

    filter:
        blur(130px);

    opacity: .18;

    pointer-events: none;

    animation:
        glow2 10s infinite alternate;
}


@keyframes glow {

    from {
        transform: translate(0,0);
    }

    to {
        transform: translate(250px,100px);
    }

}


@keyframes glow2 {

    from {
        transform: translate(0,0);
    }

    to {
        transform: translate(-250px,-100px);
    }

}


/* =====================================================
   NAVIGATION
===================================================== */

nav {

    width: 94%;

    max-width: 1400px;

    margin: 20px auto;

    min-height: 70px;

    padding:
        0 28px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    position: sticky;

    top: 15px;

    z-index: 100;

    border-radius: 20px;

    background:
        rgba(255,255,255,.07);

    border:
        1px solid
        rgba(255,255,255,.14);

    backdrop-filter:
        blur(20px);

    box-shadow:
        0 20px 50px
        rgba(0,0,0,.35);
}


/* LOGO */

.logo {

    font-size: 21px;

    font-weight: 800;

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

    gap: 5px;

}


.nav-links a {

    text-decoration: none;

    color:
        #cbd5e1;

    padding:
        11px 16px;

    border-radius: 12px;

    font-size: 13px;

    font-weight: 600;

    transition:
        .3s;
}


.nav-links a:hover {

    color: white;

    background:
        rgba(255,255,255,.10);

    transform:
        translateY(-3px);
}


/* =====================================================
   MAIN CONTAINER
===================================================== */

.container {

    width: 94%;

    max-width: 1400px;

    margin:
        40px auto 80px;
}


/* =====================================================
   WELCOME HERO
===================================================== */

.welcome {

    padding:
        55px 50px;

    border-radius:
        30px;

    background:

        linear-gradient(
            135deg,
            rgba(124,58,237,.35),
            rgba(6,182,212,.12)
        );

    border:
        1px solid
        rgba(255,255,255,.13);

    backdrop-filter:
        blur(20px);

    box-shadow:
        0 30px 80px
        rgba(0,0,0,.35);

    position: relative;

    overflow: hidden;

    transform-style:
        preserve-3d;

    transition:
        transform .2s;
}


.welcome::before {

    content:
        "CSE";

    position: absolute;

    right: 40px;

    top: 20px;

    font-size: 130px;

    font-weight: 900;

    color:
        rgba(255,255,255,.03);

}


.welcome-badge {

    display: inline-block;

    padding:
        8px 15px;

    border-radius:
        30px;

    background:
        rgba(139,92,246,.20);

    border:
        1px solid
        rgba(167,139,250,.30);

    color:
        #ddd6fe;

    font-size: 11px;

    letter-spacing:
        2px;

    font-weight: 700;

    margin-bottom:
        18px;
}


.welcome h1 {

    font-size:
        clamp(32px,5vw,58px);

    margin-bottom:
        12px;

    background:

        linear-gradient(
            90deg,
            white,
            #c4b5fd,
            #67e8f9
        );

    -webkit-background-clip:
        text;

    -webkit-text-fill-color:
        transparent;
}


.welcome p {

    color:
        #cbd5e1;

    font-size:
        15px;

    line-height:
        1.8;

    max-width:
        700px;
}


/* =====================================================
   SECTION TITLE
===================================================== */

.section-title {

    margin:
        50px 0 22px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;
}


.section-title h2 {

    font-size:
        27px;
}


.section-title span {

    color:
        #64748b;

    font-size:
        12px;
}


/* =====================================================
   OVERVIEW CARDS
===================================================== */

.stats {

    display:
        grid;

    grid-template-columns:
        repeat(4,1fr);

    gap:
        20px;
}


.stat-card {

    padding:
        25px;

    border-radius:
        22px;

    background:
        rgba(255,255,255,.06);

    border:
        1px solid
        rgba(255,255,255,.12);

    backdrop-filter:
        blur(15px);

    transition:
        .35s;

    transform-style:
        preserve-3d;

}


.stat-card:hover {

    transform:
        translateY(-10px)
        rotateX(4deg)
        rotateY(-4deg);

    background:
        rgba(255,255,255,.10);

    box-shadow:
        0 25px 50px
        rgba(0,0,0,.35);
}


.stat-icon {

    font-size:
        28px;

    margin-bottom:
        15px;
}


.stat-card h3 {

    font-size:
        28px;

    margin-bottom:
        5px;
}


.stat-card p {

    color:
        #94a3b8;

    font-size:
        12px;
}


/* =====================================================
   TWO COLUMN
===================================================== */

.two-column {

    display:
        grid;

    grid-template-columns:
        1.2fr .8fr;

    gap:
        25px;
}


/* =====================================================
   ANNOUNCEMENTS
===================================================== */

.announcement-container {

    display:
        grid;

    gap:
        15px;
}


.announcement {

    padding:
        22px;

    border-radius:
        18px;

    background:
        rgba(255,255,255,.06);

    border:
        1px solid
        rgba(255,255,255,.10);

    transition:
        .3s;

    cursor:
        pointer;

    position:
        relative;

    overflow:
        hidden;
}


.announcement:hover {

    transform:
        translateX(8px);

    background:
        rgba(124,58,237,.13);

    border-color:
        rgba(167,139,250,.30);
}


.announcement-header {

    display:
        flex;

    justify-content:
        space-between;

    align-items:
        center;

    margin-bottom:
        10px;
}


.announcement h3 {

    font-size:
        15px;
}


.date {

    color:
        #67e8f9;

    font-size:
        10px;

    padding:
        5px 9px;

    border-radius:
        20px;

    background:
        rgba(6,182,212,.10);
}


.announcement p {

    color:
        #94a3b8;

    font-size:
        12px;

    line-height:
        1.6;
}


/* =====================================================
   FACULTY
===================================================== */

.faculty-grid {

    display:
        grid;

    grid-template-columns:
        repeat(2,1fr);

    gap:
        15px;
}


.faculty {

    padding:
        22px;

    text-align:
        center;

    border-radius:
        20px;

    background:
        rgba(255,255,255,.06);

    border:
        1px solid
        rgba(255,255,255,.10);

    transition:
        .35s;

    transform-style:
        preserve-3d;
}


.faculty:hover {

    transform:
        translateY(-8px)
        rotateY(5deg);

    background:
        rgba(255,255,255,.10);

    box-shadow:
        0 20px 45px
        rgba(0,0,0,.30);
}


.faculty-avatar {

    width:
        65px;

    height:
        65px;

    margin:
        0 auto 14px;

    border-radius:
        50%;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    font-size:
        24px;

    font-weight:
        800;

    background:

        linear-gradient(
            135deg,
            #7c3aed,
            #06b6d4
        );

    box-shadow:
        0 10px 25px
        rgba(124,58,237,.25);
}


.faculty h3 {

    font-size:
        14px;

    margin-bottom:
        6px;
}


.faculty p {

    color:
        #94a3b8;

    font-size:
        11px;

    line-height:
        1.5;
}


/* =====================================================
   SUBJECTS
===================================================== */

.subject-grid {

    display:
        grid;

    grid-template-columns:
        repeat(3,1fr);

    gap:
        20px;
}


.subject {

    min-height:
        170px;

    padding:
        25px;

    border-radius:
        22px;

    position:
        relative;

    overflow:
        hidden;

    background:
        rgba(255,255,255,.06);

    border:
        1px solid
        rgba(255,255,255,.12);

    transition:
        .35s;

    cursor:
        pointer;

    transform-style:
        preserve-3d;
}


.subject:hover {

    transform:
        translateY(-10px)
        rotateX(5deg)
        rotateY(-5deg);

    box-shadow:
        0 25px 50px
        rgba(0,0,0,.35);
}


.subject-number {

    position:
        absolute;

    right:
        18px;

    top:
        12px;

    font-size:
        50px;

    font-weight:
        900;

    color:
        rgba(255,255,255,.04);
}


.subject-icon {

    font-size:
        28px;

    margin-bottom:
        20px;
}


.subject h3 {

    font-size:
        16px;

    margin-bottom:
        8px;
}


.subject p {

    color:
        #94a3b8;

    font-size:
        11px;

    line-height:
        1.6;
}


.subject-tag {

    display:
        inline-block;

    margin-top:
        15px;

    padding:
        5px 10px;

    border-radius:
        20px;

    font-size:
        9px;

    color:
        #c4b5fd;

    background:
        rgba(124,58,237,.12);
}


/* =====================================================
   STUDENT PROFILE
===================================================== */

.profile {

    padding:
        30px;

    border-radius:
        25px;

    background:
        rgba(255,255,255,.06);

    border:
        1px solid
        rgba(255,255,255,.12);

    display:
        flex;

    align-items:
        center;

    gap:
        25px;
}


.profile-avatar {

    width:
        85px;

    height:
        85px;

    border-radius:
        50%;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    font-size:
        30px;

    font-weight:
        800;

    background:

        linear-gradient(
            135deg,
            #7c3aed,
            #06b6d4
        );

    box-shadow:
        0 15px 35px
        rgba(124,58,237,.30);
}


.profile h2 {

    margin-bottom:
        7px;
}


.profile p {

    color:
        #94a3b8;

    font-size:
        13px;

    margin-bottom:
        5px;
}


/* =====================================================
   BUTTON
===================================================== */

.logout-btn {

    display:
        inline-block;

    margin-top:
        25px;

    padding:
        12px 22px;

    border-radius:
        12px;

    text-decoration:
        none;

    color:
        white;

    background:
        linear-gradient(
            135deg,
            #ef4444,
            #dc2626
        );

    font-size:
        12px;

    font-weight:
        700;

    transition:
        .3s;
}


.logout-btn:hover {

    transform:
        translateY(-4px);

    box-shadow:
        0 15px 30px
        rgba(239,68,68,.25);
}


/* =====================================================
   FOOTER
===================================================== */

footer {

    text-align:
        center;

    padding:
        25px;

    color:
        #64748b;

    border-top:
        1px solid
        rgba(255,255,255,.08);

    font-size:
        11px;
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media(max-width:1000px) {

    .stats {

        grid-template-columns:
            repeat(2,1fr);
    }

    .two-column {

        grid-template-columns:
            1fr;
    }

    .subject-grid {

        grid-template-columns:
            repeat(2,1fr);
    }

}


@media(max-width:650px) {

    nav {

        flex-direction:
            column;

        padding:
            15px;

        gap:
            10px;
    }

    .nav-links {

        flex-wrap:
            wrap;

        justify-content:
            center;
    }

    .welcome {

        padding:
            35px 25px;
    }

    .stats {

        grid-template-columns:
            1fr;
    }

    .subject-grid {

        grid-template-columns:
            1fr;
    }

    .faculty-grid {

        grid-template-columns:
            1fr;
    }

    .profile {

        flex-direction:
            column;

        text-align:
            center;
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

        <a href="#subjects">
            Subjects
        </a>

        <a href="#faculty">
            Faculty
        </a>

        <a href="#announcements">
            Announcements
        </a>

        <a href="logout.php">
            Logout
        </a>

    </div>

</nav>



<!-- =====================================================
     MAIN
===================================================== -->

<main class="container">


    <!-- WELCOME -->

    <section
        class="welcome"
        id="welcomeCard"
    >

        <div class="welcome-badge">
            CSE STUDENT PORTAL
        </div>


        <h1>
            Welcome,
            <?php
                echo htmlspecialchars($user_name);
            ?>
            👋
        </h1>


        <p>

            Welcome to the Computer Science Department
            Student Management Portal. Explore your subjects,
            faculty members, announcements and academic
            resources from one place.

        </p>

    </section>



    <!-- =================================================
         OVERVIEW
    ================================================== -->

    <div class="section-title">

        <h2>
            Academic Overview
        </h2>

        <span>
            Current Academic Year 2026
        </span>

    </div>


    <section class="stats">


        <div class="stat-card">

            <div class="stat-icon">
                📚
            </div>

            <h3>
                06
            </h3>

            <p>
                Active Subjects
            </p>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                👨‍🏫
            </div>

            <h3>
                08
            </h3>

            <p>
                Faculty Members
            </p>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                📢
            </div>

            <h3>
                04
            </h3>

            <p>
                New Announcements
            </p>

        </div>


        <div class="stat-card">

            <div class="stat-icon">
                🎓
            </div>

            <h3>
                CSE
            </h3>

            <p>
                Department
            </p>

        </div>


    </section>



    <!-- =================================================
         ANNOUNCEMENTS + PROFILE
    ================================================== -->

    <div class="two-column">


        <!-- ANNOUNCEMENTS -->

        <section id="announcements">

            <div class="section-title">

                <h2>
                    📢 Announcements
                </h2>

            </div>


            <div class="announcement-container">


                <div class="announcement">

                    <div class="announcement-header">

                        <h3>
                            Internal Examination
                        </h3>

                        <span class="date">
                            SEP 10
                        </span>

                    </div>

                    <p>

                        The first internal examination
                        timetable will be announced shortly.
                        Students are requested to check the
                        department portal regularly.

                    </p>

                </div>


                <div class="announcement">

                    <div class="announcement-header">

                        <h3>
                            Web Technology Lab
                        </h3>

                        <span class="date">
                            SEP 12
                        </span>

                    </div>

                    <p>

                        Students should complete the PHP,
                        MySQL and JavaScript laboratory
                        exercises before the next session.

                    </p>

                </div>


                <div class="announcement">

                    <div class="announcement-header">

                        <h3>
                            Department Seminar
                        </h3>

                        <span class="date">
                            SEP 18
                        </span>

                    </div>

                    <p>

                        A technical seminar on Artificial
                        Intelligence and Emerging Technologies
                        will be conducted in the seminar hall.

                    </p>

                </div>


            </div>

        </section>



        <!-- PROFILE -->

        <section>

            <div class="section-title">

                <h2>
                    👤 My Profile
                </h2>

            </div>


            <div class="profile">


                <div class="profile-avatar">

                    <?php
                        echo strtoupper(
                            substr($user_name, 0, 1)
                        );
                    ?>

                </div>


                <div>

                    <h2>

                        <?php
                            echo htmlspecialchars(
                                $user_name
                            );
                        ?>

                    </h2>


                    <p>

                        📧
                        <?php
                            echo htmlspecialchars(
                                $user_email
                            );
                        ?>

                    </p>


                    <p>
                        🎓 Computer Science Department
                    </p>


                    <p>
                        🟢 Student Account Active
                    </p>


                </div>


            </div>


            <a
                href="logout.php"
                class="logout-btn"
            >
                Logout →
            </a>


        </section>


    </div>



    <!-- =================================================
         FACULTY
    ================================================== -->

    <section id="faculty">

        <div class="section-title">

            <h2>
                👨‍🏫 Our Faculty
            </h2>

            <span>
                Computer Science Department
            </span>

        </div>


        <div class="faculty-grid">


            <div class="faculty">

                <div class="faculty-avatar">
                    DR
                </div>

                <h3>
                    Dr. Rajesh Kumar
                </h3>

                <p>
                    Professor & Head
                </p>

                <p>
                    Data Science & AI
                </p>

            </div>


            <div class="faculty">

                <div class="faculty-avatar">
                    AP
                </div>

                <h3>
                    Dr. Anitha Priya
                </h3>

                <p>
                    Associate Professor
                </p>

                <p>
                    Computer Networks
                </p>

            </div>


            <div class="faculty">

                <div class="faculty-avatar">
                    SK
                </div>

                <h3>
                    Prof. S. Karthik
                </h3>

                <p>
                    Assistant Professor
                </p>

                <p>
                    Web Technologies
                </p>

            </div>


            <div class="faculty">

                <div class="faculty-avatar">
                    MV
                </div>

                <h3>
                    Dr. Meena Vijay
                </h3>

                <p>
                    Assistant Professor
                </p>

                <p>
                    Database Systems
                </p>

            </div>


        </div>

    </section>



    <!-- =================================================
         SUBJECTS
    ================================================== -->

    <section id="subjects">

        <div class="section-title">

            <h2>
                📚 Current Subjects
            </h2>

            <span>
                Semester Courses
            </span>

        </div>


        <div class="subject-grid">


            <div class="subject">

                <div class="subject-number">
                    01
                </div>

                <div class="subject-icon">
                    💻
                </div>

                <h3>
                    Web Technology
                </h3>

                <p>
                    HTML, CSS, JavaScript, PHP,
                    MySQL and dynamic web development.
                </p>

                <span class="subject-tag">
                    THEORY + LAB
                </span>

            </div>


            <div class="subject">

                <div class="subject-number">
                    02
                </div>

                <div class="subject-icon">
                    🗄️
                </div>

                <h3>
                    Database Management
                </h3>

                <p>
                    SQL, relational databases,
                    normalization and database design.
                </p>

                <span class="subject-tag">
                    THEORY
                </span>

            </div>


            <div class="subject">

                <div class="subject-number">
                    03
                </div>

                <div class="subject-icon">
                    🌐
                </div>

                <h3>
                    Computer Networks
                </h3>

                <p>
                    Networking models, protocols,
                    IP addressing and network security.
                </p>

                <span class="subject-tag">
                    THEORY
                </span>

            </div>


            <div class="subject">

                <div class="subject-number">
                    04
                </div>

                <div class="subject-icon">
                    🤖
                </div>

                <h3>
                    Artificial Intelligence
                </h3>

                <p>
                    Intelligent agents, machine learning
                    concepts and AI applications.
                </p>

                <span class="subject-tag">
                    THEORY
                </span>

            </div>


            <div class="subject">

                <div class="subject-number">
                    05
                </div>

                <div class="subject-icon">
                    ⚙️
                </div>

                <h3>
                    Operating Systems
                </h3>

                <p>
                    Processes, memory management,
                    scheduling and file systems.
                </p>

                <span class="subject-tag">
                    THEORY
                </span>

            </div>


            <div class="subject">

                <div class="subject-number">
                    06
                </div>

                <div class="subject-icon">
                    🔐
                </div>

                <h3>
                    Cyber Security
                </h3>

                <p>
                    Security fundamentals, threats,
                    authentication and network protection.
                </p>

                <span class="subject-tag">
                    THEORY + LAB
                </span>

            </div>


        </div>

    </section>


</main>



<!-- =====================================================
     FOOTER
===================================================== -->

<footer>

    © 2026 CSE Department |
    Advanced Student Management System

</footer>



<script>

/* =====================================================
   3D WELCOME CARD
===================================================== */

const welcomeCard =
    document.getElementById("welcomeCard");


if (
    welcomeCard &&
    window.innerWidth > 800
) {

    welcomeCard.addEventListener(
        "mousemove",
        function(event) {

            const rect =
                welcomeCard.getBoundingClientRect();

            const x =
                event.clientX - rect.left;

            const y =
                event.clientY - rect.top;

            const rotateY =
                ((x / rect.width) - .5) * 5;

            const rotateX =
                ((y / rect.height) - .5) * -5;

            welcomeCard.style.transform =

                `perspective(1000px)
                 rotateX(${rotateX}deg)
                 rotateY(${rotateY}deg)
                 translateY(-4px)`;

        }
    );


    welcomeCard.addEventListener(
        "mouseleave",
        function() {

            welcomeCard.style.transform =
                "rotateX(0deg) rotateY(0deg)";

        }
    );

}


/* =====================================================
   SUBJECT 3D EFFECT
===================================================== */

document
    .querySelectorAll(".subject")
    .forEach(function(card) {

        card.addEventListener(
            "mousemove",
            function(event) {

                const rect =
                    card.getBoundingClientRect();

                const x =
                    event.clientX - rect.left;

                const y =
                    event.clientY - rect.top;

                const rotateY =
                    ((x / rect.width) - .5) * 8;

                const rotateX =
                    ((y / rect.height) - .5) * -8;

                card.style.transform =

                    `perspective(800px)
                     rotateX(${rotateX}deg)
                     rotateY(${rotateY}deg)
                     translateY(-8px)`;

            }
        );


        card.addEventListener(
            "mouseleave",
            function() {

                card.style.transform =
                    "";

            }
        );

    });


/* =====================================================
   FACULTY 3D EFFECT
===================================================== */

document
    .querySelectorAll(".faculty")
    .forEach(function(card) {

        card.addEventListener(
            "mousemove",
            function(event) {

                const rect =
                    card.getBoundingClientRect();

                const x =
                    event.clientX - rect.left;

                const y =
                    event.clientY - rect.top;

                const rotateY =
                    ((x / rect.width) - .5) * 8;

                const rotateX =
                    ((y / rect.height) - .5) * -8;

                card.style.transform =

                    `perspective(800px)
                     rotateX(${rotateX}deg)
                     rotateY(${rotateY}deg)
                     translateY(-8px)`;

            }
        );


        card.addEventListener(
            "mouseleave",
            function() {

                card.style.transform =
                    "";

            }
        );

    });


/* =====================================================
   ANNOUNCEMENT CLICK
===================================================== */

document
    .querySelectorAll(".announcement")
    .forEach(function(item) {

        item.addEventListener(
            "click",
            function() {

                item.style.transform =
                    "scale(1.02)";

                setTimeout(
                    function() {

                        item.style.transform =
                            "";

                    },
                    180
                );

            }
        );

    });

</script>


</body>

</html>