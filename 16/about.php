<?php
/*
3.2 About Page (about.php)
Meet the Team section with team member cards.
Matches the existing SugarGliders Studio design.
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About – SugarGliders Studio</title>
    <meta name="description" content="Team behind SugarGliders Studio">
    <meta name="author" content="SugarGliders Group 16">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="about.css">
</head>

<body>

    <header>
        <div class="logo-container">
            <img src="images/SugarGlidersLogo.png" alt="SugarGliders Logo" class="logo">
            <h1>SugarGliders</h1>
        </div>

        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php" class="active">About</a></li>
                <li><a href="color.php">Color Coordinator</a></li>
            </ul>
        </nav>
    </header>

    <main>

        <section class="about-group">
            <h2>Meet the Team</h2>
            <p>
                SugarGliders Studio was created by a group of CSU students passionate about design and efficiency.
                Here is the team behind the project.
            </p>
        </section>

        <section class="team-grid">
            <div class="team-card">
                <div class="avatar">
                    <img src="images/NicholasGuadalupe.png" alt="Nicholas Guadalupe Image" class="avatar-img"></span>
                </div>
                <h3 class="member-name">Nicholas Guadalupe</h3>
                <p class="member-role">Project Coordinator</p>
                <p class="member-bio">
                    A senior attending Colorado State University currently studying Computer science.
                    Focuses on managing  project guidelines and following proper procedures to ensure project goals are met.
                </p>
            </div>

            <div class="team-card">
                <div class="avatar">
                    <img src="images/SugarGlidersLogo.png" alt="SugarGliders Logo" class="avatar-img">
                </div>
                <h3 class="member-name">Cameron Will </h3>
                <p class="member-role">Something</p>
                <p class="member-bio">
                   Something
                </p>
            </div>

            <div class="team-card">
                <div class="avatar">
                    <img src="images/SugarGlidersLogo.png" alt="SugarGliders Logo" class="avatar-img">
                </div>
                <h3 class="member-name">Cameron Hugg</h3>
                <p class="member-role">Something</p>
                <p class="member-bio">
                    Something
                </p>
            </div>

            <div class="team-card">
                <div class="avatar">
                    <img src="images/SugarGlidersLogo.png" alt="SugarGliders Logo" class="avatar-img">
                </div>
                <h3 class="member-name">Carter Hickerson</h3>
                <p class="member-role">Something</p>
                <p class="member-bio">
                    Something
                </p>
            </div>

        </section>

    </main>

    <footer>
        <p> 2026 SugarGliders CAS312 Group Project</p>
    </footer>

</body>
</html>