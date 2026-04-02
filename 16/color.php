<?php


$PALETTE = [
    'Red', 'Orange', 'Yellow', 'Green', 'Blue', 'Purple', 'Grey', 'Brown', 'Black', 'Teal',
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
    'Teal' => '#00897B',
];

$err_grid = null;
$err_colors = null;
$valid = false;
$grid_n = 0;
$num_colors = 0;

$grid_input = '';
$colors_input = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $grid_input = isset($_POST['grid_size']) ? trim((string) $_POST['grid_size']) : '';
    $colors_input = isset($_POST['num_colors']) ? trim((string) $_POST['num_colors']) : '';

    $grid_n = filter_var($grid_input, FILTER_VALIDATE_INT);
    if ($grid_n === false || $grid_n < 1 || $grid_n > 26) {
        $err_grid = 'Rows and columns must be a number between 1 and 26.';
    }

    $num_colors = filter_var($colors_input, FILTER_VALIDATE_INT);
    if ($num_colors === false || $num_colors < 1 || $num_colors > 10) {
        $err_colors = 'Number of colors must be between 1 and 10.';
    }

    if ($err_grid === null && $err_colors === null) {
        $valid = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Color Coordinator – SugarGliders Studio</title>
    <meta name="description" content="Generate color coordinate grids with SugarGliders Studio">
    <meta name="author" content="SugarGliders Group 16">
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

            <form class="coord-form" method="post" action="color.php" novalidate>
                <div class="form-row">
                    <label for="grid_size">Rows and columns</label>
                    <input type="number" id="grid_size" name="grid_size" min="1" max="26"
                           value="<?php echo htmlspecialchars($grid_input, ENT_QUOTES, 'UTF-8'); ?>"
                           required>
                    <span class="form-hint">One number for both (1–26).</span>
                </div>
                <div class="form-row">
                    <label for="num_colors">Number of colors</label>
                    <input type="number" id="num_colors" name="num_colors" min="1" max="10"
                           value="<?php echo htmlspecialchars($colors_input, ENT_QUOTES, 'UTF-8'); ?>"
                           required>
                    <span class="form-hint">How many colors to show (1–10).</span>
                </div>
                <button type="submit" class="coord-submit">Generate</button>
            </form>

            <?php if ($err_grid !== null) : ?>
                <p class="form-error" role="alert"><?php echo htmlspecialchars($err_grid, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <?php if ($err_colors !== null) : ?>
                <p class="form-error" role="alert"><?php echo htmlspecialchars($err_colors, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>

            <?php if ($valid) : ?>
                <p id="color-dup-msg" class="color-dup-msg" role="status" aria-live="polite" hidden></p>

                <table class="color-list-table">
                    <?php for ($i = 0; $i < $num_colors; $i++) :
                        $selected = $PALETTE[$i];
                        $hex = $PALETTE_HEX[$selected];
                        ?>
                        <tr>
                            <td class="color-list-select-cell">
                                <label class="visually-hidden" for="color_sel_<?php echo $i; ?>">Color <?php echo $i + 1; ?></label>
                                <select id="color_sel_<?php echo $i; ?>" class="color-select" data-index="<?php echo $i; ?>">
                                    <?php foreach ($PALETTE as $cname) : ?>
                                        <option value="<?php echo htmlspecialchars($cname, ENT_QUOTES, 'UTF-8'); ?>"
                                            <?php echo $cname === $selected ? ' selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cname, ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td class="color-list-preview-cell">
                                <span class="color-display-name"><?php echo htmlspecialchars($selected, ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="color-swatch" style="background-color: <?php echo htmlspecialchars($hex, ENT_QUOTES, 'UTF-8'); ?>;"></span>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </table>

                <div class="coord-grid-wrap">
                <table class="coord-grid-table">
                    <?php for ($r = 0; $r <= $grid_n; $r++) : ?>
                        <tr>
                            <?php for ($c = 0; $c <= $grid_n; $c++) : ?>
                                <?php if ($r === 0 && $c === 0) : ?>
                                    <td></td>
                                <?php elseif ($r === 0) : ?>
                                    <th scope="col"><?php echo htmlspecialchars(chr(ord('A') + $c - 1), ENT_QUOTES, 'UTF-8'); ?></th>
                                <?php elseif ($c === 0) : ?>
                                    <th scope="row"><?php echo (string) $r; ?></th>
                                <?php else : ?>
                                    <td></td>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </tr>
                    <?php endfor; ?>
                </table>
                </div>

                <script>
                (function () {
                    var PALETTE_HEX = <?php echo json_encode($PALETTE_HEX, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

                    function updateRow(select) {
                        var row = select.closest('tr');
                        if (!row) return;
                        var nameEl = row.querySelector('.color-display-name');
                        var swatch = row.querySelector('.color-swatch');
                        var v = select.value;
                        if (nameEl) nameEl.textContent = v;
                        if (swatch && PALETTE_HEX[v]) swatch.style.backgroundColor = PALETTE_HEX[v];
                    }

                    var selects = document.querySelectorAll('.color-select');
                    var dupMsg = document.getElementById('color-dup-msg');

                    selects.forEach(function (sel) {
                        sel.dataset.prev = sel.value;
                    });

                    selects.forEach(function (sel) {
                        sel.addEventListener('change', function () {
                            var newVal = sel.value;
                            var clash = false;
                            selects.forEach(function (other) {
                                if (other !== sel && other.value === newVal) {
                                    clash = true;
                                }
                            });
                            if (clash) {
                                sel.value = sel.dataset.prev;
                                if (dupMsg) {
                                    dupMsg.textContent = 'That color is already in use. Each row must use a different color.';
                                    dupMsg.hidden = false;
                                }
                                return;
                            }
                            sel.dataset.prev = newVal;
                            if (dupMsg) {
                                dupMsg.textContent = '';
                                dupMsg.hidden = true;
                            }
                            updateRow(sel);
                        });
                    });
                })();
                </script>
            <?php endif; ?>

        </section>

    </main>

    <footer>
        <p> 2026 SugarGliders CS312 Group Project</p>
    </footer>

</body>
</html>
