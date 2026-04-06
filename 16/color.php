<?php

//required colors and their hex values for users to choose from
$PALETTE = [
    'Red',
    'Orange',
    'Yellow',
    'Green',
    'Blue',
    'Purple',
    'Grey',
    'Brown',
    'Black',
    'Teal'
];

$PALETTE_HEX = [
    'Red' => '#E53935',
    'Orange' => '#FB8C00',
    'Yellow' => '#FDD835',
    'Green' => '#43A047',
    'Blue' => '#1E88E5',
    'Purple' => '#8E24AA',
    'Grey' => '#9E9E9E',
    'Brown' => '#6D4C41',
    'Black' => '#212121',
    'Teal' => '#00897B'
];

// error messages/ check for if valid or not.
$err_grid = '';
$err_colors = '';
$valid = false;

// input ofr frid size and cum colors
$grid_input = '';
$colors_input = '';

$grid_n = 0;
$num_colors = 0;

// get input, validate, error if bad, make table if good
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $grid_input = isset($_POST['grid_size']) ? trim($_POST['grid_size']) : '';

    $colors_input = isset($_POST['num_colors']) ? trim($_POST['num_colors']) : '';

    
    $grid_n = filter_var($grid_input, FILTER_VALIDATE_INT);

    if ($grid_n === false || $grid_n < 1 || $grid_n > 26) {
        $err_grid = 'Rows and columns must be a number between 1 and 26.';
    }

    $num_colors = filter_var($colors_input, FILTER_VALIDATE_INT);

    if ($num_colors === false || $num_colors < 1 || $num_colors > 10) {
        $err_colors = 'Number of colors must be between 1 and 10.';
    }

    if ($err_grid === '' && $err_colors === '') {
        $valid = true;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Color Coordinator - SugarGliders</title>
    <link rel="stylesheet" href="style.css">
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
                <li><a href="about.php">About</a></li>
                <li><a href="color.php" class="active">Color Coordinator</a></li>
            </ul>
        </nav>
    </header>

    <main>

        <section class="color-page-intro">
            <h2>Color Coordinator</h2>
            <p>
                Build a custom color list and coordinate grid for your project.
                Set the grid size and number of colors, then generate your layout below.
            </p>
        </section>

        <section class="color-page-body">

            <form class="coordinate-form" method="post" action="color.php">
                <div class="form-row">
                    <label for="grid_size">Rows and Columns</label>
                    <input
                        type="number"
                        id="grid_size"
                        name="grid_size"
                        min="1"
                        max="26"
                        value="<?php echo htmlspecialchars($grid_input, ENT_QUOTES, 'UTF-8'); ?>"
                    >
                    <span class="min-max-rule-form">Enter one number from 1 to 26.</span>
                </div>

                <div class="form-row">
                    <label for="num_colors">Number of Colors</label>
                    <input
                        type="number"
                        id="num_colors"
                        name="num_colors"
                        min="1"
                        max="10"
                        value="<?php echo htmlspecialchars($colors_input, ENT_QUOTES, 'UTF-8'); ?>"
                    >
                    <span class="min-max-rule-form">Enter one number from 1 to 10.</span>
                </div>


                <button type="submit" class="coord-submit">Generate</button>
            </form>

            <!-- errors -->
            <?php if ($err_grid !== '') : ?>
                <p class="form-error"><?php echo htmlspecialchars($err_grid, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>

            <?php if ($err_colors !== '') : ?>
                <p class="form-error"><?php echo htmlspecialchars($err_colors, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>

            <?php if ($valid) : ?>

                <p id="duplicate-color-msg" class="duplicate-color-msg" hidden></p>

        
                <table class="color-list-table">

                    <?php
                    for ($i = 0; $i < $num_colors; $i++) :

                        $selected = $PALETTE[$i];
                        $hex = $PALETTE_HEX[$selected];
                    ?>
                        <tr>

                            <!-- dropdown -->
                            <td class="color-list-select-cell">
                                <select id="color_sel_<?php echo $i; ?>" class="select-color-dropdown">
                                    <?php
                                    foreach ($PALETTE as $color) :
                                    ?>
                                        <option
                                            value="<?php echo htmlspecialchars($color, ENT_QUOTES, 'UTF-8'); ?>"
                                            <?php if ($color === $selected) echo 'selected'; ?>
                                        >
                                            <?php echo htmlspecialchars($color, ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>

                            <!-- color preview -->
                            <td class="color-list-preview-cell">
                                <span
                                    class="color-swatch"
                                    style="background-color: <?php echo htmlspecialchars($hex, ENT_QUOTES, 'UTF-8'); ?>;"
                                ></span>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </table>

                <div class="coord-grid-wrap">

                    <!-- coordinate grid -->
                    <table class="coord-grid-table">

                        <?php
                        for ($r = 0; $r <= $grid_n; $r++) :
                        ?>
                            <tr>
                                <?php
                                for ($c = 0; $c <= $grid_n; $c++) :
                                ?>

                                    <?php
                                    if ($r === 0 && $c === 0) :
                                    ?>
                                        <td></td>

                                    <?php

                                    elseif ($r === 0) :
                                    ?>
                                        <th>
                                            <?php echo htmlspecialchars(chr(ord('A') + $c - 1), ENT_QUOTES, 'UTF-8'); ?>
                                        </th>

                                    <?php

                                    elseif ($c === 0) :
                                    ?>
                                        <th><?php echo $r; ?></th>

                                    <?php

                                    else :
                                    ?>
                                        <td></td>
                                    <?php endif; ?>

                                <?php endfor; ?>
                            </tr>
                        <?php endfor; ?>

                    </table>
                </div>

                <!-- duplicate color checking -->
                <script>

                    var selects = document.querySelectorAll('.select-color-dropdown');

                    var msg = document.getElementById('duplicate-color-msg');

                    var colorHex = <?php echo json_encode($PALETTE_HEX); ?>;

                    for (var i = 0; i < selects.length; i++) {

                        selects[i].dataset.oldValue = selects[i].value;

                        selects[i].onchange = function () {

                            var duplicate = false;

                            for (var j = 0; j < selects.length; j++) {
                                if (selects[j] !== this && selects[j].value === this.value) {
                                    duplicate = true;
                                }
                            }

                            if (duplicate) {
                                this.value = this.dataset.oldValue;

                                msg.textContent = 'That color is already in use. Each row must use a different color.';
                                msg.hidden = false;
                            } else {

                                this.dataset.oldValue = this.value;

                                msg.hidden = true;
                            }

                            var row = this.parentNode.parentNode;
                            var swatch = row.querySelector('.color-swatch');

                            if (swatch) {
                                swatch.style.backgroundColor = colorHex[this.value];
                            }
                        };
                    }
                </script>

            <?php endif; ?>

        </section>

    </main>

    <footer>
        <p>&copy; 2026 SugarGliders CS312 Group Project</p>
    </footer>

</body>
</html>