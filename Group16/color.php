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

// input for grid size and num colors
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
    <style>
        /* Coordinate column in the top table */
        .color-list-table .coord-cell {
            width: 40%;
            font-size: 0.9em;
            color: #233952;
            text-align: left;
            padding-left: 10px;
        }
        /* Radio button cell */
        .color-list-table .radio-cell {
            width: 5%;
            text-align: center;
        }
        /* Make grid cells clickable */
        .coord-grid-table td.paintable {
            cursor: pointer;
            transition: background-color 0.1s;
        }
        .coord-grid-table td.paintable:hover {
            opacity: 0.85;
        }
        /* Duplicate color message */
        .duplicate-color-msg {
            color: #5C415D;
            font-weight: bold;
            text-align: center;
            margin: 8px 0;
            display: none;
        }
        /* Print form sits below the grid */
        .print-form-wrap {
            text-align: center;
            margin-top: 20px;
        }
    </style>
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
                <li><a href="colors.php">Color Selection</a></li>
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

            <?php if ($err_grid !== '') : ?>
                <p class="form-error"><?php echo htmlspecialchars($err_grid, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>

            <?php if ($err_colors !== '') : ?>
                <p class="form-error"><?php echo htmlspecialchars($err_colors, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>

            <?php if ($valid) : ?>

                <p id="duplicate-color-msg" class="duplicate-color-msg"></p>

                <table class="color-list-table" id="colorListTable">
                    <?php
                    for ($i = 0; $i < $num_colors; $i++) :
                        $selected = $PALETTE[$i];
                        $hex = $PALETTE_HEX[$selected];
                    ?>
                        <tr data-row="<?php echo $i; ?>">

                            <td class="radio-cell">
                                <input
                                    type="radio"
                                    name="active_color"
                                    class="color-radio"
                                    value="<?php echo $i; ?>"
                                    <?php if ($i === 0) echo 'checked'; ?>
                                >
                            </td>

                            <td class="color-list-select-cell">
                                <select id="color_sel_<?php echo $i; ?>" class="select-color-dropdown" data-row="<?php echo $i; ?>">
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

                            <td class="color-list-preview-cell">
                                <span
                                    class="color-swatch"
                                    style="background-color: <?php echo htmlspecialchars($hex, ENT_QUOTES, 'UTF-8'); ?>;"
                                ></span>
                            </td>

                            <td class="coord-cell" id="coords_<?php echo $i; ?>"></td>
                        </tr>
                    <?php endfor; ?>
                </table>

                <div class="coord-grid-wrap">
                    <table class="coord-grid-table" id="coordGrid">
                        <?php
                        for ($r = 0; $r <= $grid_n; $r++) :
                        ?>
                            <tr>
                                <?php
                                for ($c = 0; $c <= $grid_n; $c++) :
                                ?>
                                    <?php if ($r === 0 && $c === 0) : ?>
                                        <td></td>

                                    <?php elseif ($r === 0) : ?>
                                        <th><?php echo htmlspecialchars(chr(ord('A') + $c - 1), ENT_QUOTES, 'UTF-8'); ?></th>

                                    <?php elseif ($c === 0) : ?>
                                        <th><?php echo $r; ?></th>

                                    <?php else : ?>
                                        <td class="paintable"
                                            data-col="<?php echo chr(ord('A') + $c - 1); ?>"
                                            data-row="<?php echo $r; ?>"
                                        ></td>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </tr>
                        <?php endfor; ?>
                    </table>
                </div>

                <div class="print-form-wrap">
                    <form method="POST" action="print.php" id="printForm">
                        <input type="hidden" name="gridSize" value="<?php echo $grid_n; ?>">
                        <input type="hidden" name="numColors" value="<?php echo $num_colors; ?>">
                        <div id="printHiddenFields"></div>
                        <button type="submit" class="coord-submit" onclick="preparePrintData()">Print View</button>
                    </form>
                </div>

                <script>
                (function () {
                    var NUM_ROWS  = <?php echo $grid_n; ?>;
                    var NUM_COLORS = <?php echo $num_colors; ?>;
                    var colorHex = <?php echo json_encode($PALETTE_HEX); ?>;

                    // painted[rowIndex] = Set of coordinate strings (e.g. "A1")
                    var painted = [];
                    for (var i = 0; i < NUM_COLORS; i++) painted.push({});

                    var selects  = document.querySelectorAll('.select-color-dropdown');
                    var radios   = document.querySelectorAll('.color-radio');
                    var msg      = document.getElementById('duplicate-color-msg');
                    var grid     = document.getElementById('coordGrid');

                    function getActiveRow() {
                        for (var i = 0; i < radios.length; i++) {
                            if (radios[i].checked) return parseInt(radios[i].value);
                        }
                        return 0;
                    }

                    function getColorForRow(i) {
                        return selects[i].value;
                    }

                    function sortCoords(coords) {
                        var arr = Object.keys(coords);
                        arr.sort(function (a, b) {
                            var aLetter = a.charAt(0), aNum = parseInt(a.slice(1));
                            var bLetter = b.charAt(0), bNum = parseInt(b.slice(1));
                            if (aLetter < bLetter) return -1;
                            if (aLetter > bLetter) return 1;
                            return aNum - bNum;
                        });
                        return arr;
                    }

                    function updateCoordDisplay(rowIdx) {
                        var cell = document.getElementById('coords_' + rowIdx);
                        if (!cell) return;
                        var sorted = sortCoords(painted[rowIdx]);
                        cell.textContent = sorted.join(', ');
                    }

                    function updateSwatch(rowIdx) {
                        var row = selects[rowIdx].parentNode.parentNode;
                        var swatch = row.querySelector('.color-swatch');
                        if (swatch) swatch.style.backgroundColor = colorHex[selects[rowIdx].value];
                    }

                    function repaintGrid() {
                        var cells = grid.querySelectorAll('td.paintable');
                        for (var ci = 0; ci < cells.length; ci++) {
                            var coord = cells[ci].dataset.col + cells[ci].dataset.row;
                            var foundColor = null;
                            for (var ri = 0; ri < NUM_COLORS; ri++) {
                                if (painted[ri][coord]) {
                                    foundColor = colorHex[getColorForRow(ri)];
                                    break;
                                }
                            }
                            cells[ci].style.backgroundColor = foundColor ? foundColor : '';
                        }
                    }

                    for (var i = 0; i < selects.length; i++) {
                        selects[i].dataset.oldValue = selects[i].value;
                    }

                    for (var i = 0; i < selects.length; i++) {
                        (function (idx) {
                            selects[idx].onchange = function () {
                                var newVal = this.value;
                                var oldVal = this.dataset.oldValue;

                                // Check for duplicate
                                var duplicate = false;
                                for (var j = 0; j < selects.length; j++) {
                                    if (selects[j] !== this && selects[j].value === newVal) {
                                        duplicate = true;
                                        break;
                                    }
                                }

                                if (duplicate) {
                                    this.value = oldVal;
                                    msg.textContent = 'That color is already in use. Each row must use a different color.';
                                    msg.style.display = 'block';
                                    return;
                                }

                                msg.style.display = 'none';
                                this.dataset.oldValue = newVal;


                                updateSwatch(idx);
                                repaintGrid();
                            };
                        })(i);
                    }

                    var paintableCells = grid.querySelectorAll('td.paintable');
                    for (var ci = 0; ci < paintableCells.length; ci++) {
                        paintableCells[ci].addEventListener('click', function () {
                            var col   = this.dataset.col;
                            var row   = this.dataset.row;
                            var coord = col + row;
                            var activeRow = getActiveRow();

                            for (var ri = 0; ri < NUM_COLORS; ri++) {
                                if (ri !== activeRow) {
                                    delete painted[ri][coord];
                                    updateCoordDisplay(ri);
                                }
                            }

                            painted[activeRow][coord] = true;
                            updateCoordDisplay(activeRow);

                            this.style.backgroundColor = colorHex[getColorForRow(activeRow)];
                        });
                    }

                    window.preparePrintData = function () {
                        var container = document.getElementById('printHiddenFields');
                        container.innerHTML = '';

                        for (var i = 0; i < NUM_COLORS; i++) {
                            var colorName = getColorForRow(i);
                            var hex       = colorHex[colorName];
                            var coordStr  = sortCoords(painted[i]).join(', ');

                            var nameInput  = document.createElement('input');
                            nameInput.type  = 'hidden';
                            nameInput.name  = 'colorNames[]';
                            nameInput.value = colorName;
                            container.appendChild(nameInput);

                            var hexInput  = document.createElement('input');
                            hexInput.type  = 'hidden';
                            hexInput.name  = 'colorHexes[]';
                            hexInput.value = hex;
                            container.appendChild(hexInput);

                            var coordInput  = document.createElement('input');
                            coordInput.type  = 'hidden';
                            coordInput.name  = 'colorCoords[]';
                            coordInput.value = coordStr;
                            container.appendChild(coordInput);
                        }
                    };

                })();
                </script>

            <?php endif; ?>

        </section>

    </main>

    <footer>
        <p>&copy; 2026 SugarGliders CS312 Group Project</p>
    </footer>

</body>
</html>