<?php

/* 
3.1 Homepage (index.php)
Modern-looking design with your company name and logo.
A welcome message explaining what the site is about.
Navigation links to all other pages on the site.
*/

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SugarGliders Studio</title>
    <meta name="description" content="Color coordination tools by SugarGliders">
    <meta name="author" content="SugarGliders Group 16">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <div class="logo-container">
            <img src="SugarGlidersLogo.png" alt="SugarGliders Logo" class="logo">
            <h1>SugarGliders</h1>
        </div>

        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="color.php">Color Coordinator</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h2>Welcome to SugarGliders Studio</h2>
            <p>
                We help designers, artists, and teams organize and plan color schemes with precision.
                Use our Color Coordinator tool to generate customized color coordinate sheets
                for any project.
            </p>

            <a href="color.php" class="cta-button">
                Try the Color Coordinator
            </a>
        </section>

        <section class="features">
            <h2>What We Do</h2>

            <div class="feature-box">
                <h3>Color Coordination</h3>
                <p>
                    Generate custom coordinate grids to map and organize your color
                    selections across any project size.
                </p>
            </div>

            <div class="feature-box">
                <h3>Team Collaboration</h3>
                <p>
                    Share your color schemes with your team using a clean and printable layout.
                </p>
            </div>

            <div class="feature-box">
                <h3>Smart Validation</h3>
                <p>
                    Prevent duplicate color selections and maintain a clean,
                    conflict-free palette every time.
                </p>
            </div>
        </section>
    </main>

    <footer>
        <p> 2026 SugarGliders CS312 Group Project</p>
    </footer>

</body>
</html>