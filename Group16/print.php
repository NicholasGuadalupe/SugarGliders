<?php
/**
 * print.php — Milestone 2 Print View
 *
 * Receives via POST from color.php:
 *   gridSize       int
 *   numColors      int
 *   colorNames[]   array of color names
 *   colorHexes[]   array of hex values (matching colorNames)
 *   colorCoords[]  array of coordinate strings (matching colorNames)
 */

$gridSize   = isset($_POST['gridSize'])     ? (int)$_POST['gridSize']       : 0;
$numColors  = isset($_POST['numColors'])    ? (int)$_POST['numColors']      : 0;
$colorNames = isset($_POST['colorNames'])   ? $_POST['colorNames']          : [];
$colorHexes = isset($_POST['colorHexes'])   ? $_POST['colorHexes']         : [];
$colorCoords= isset($_POST['colorCoords'])  ? $_POST['colorCoords']        : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print View – SugarGliders</title>
    <style>
        /* ── Base reset ──────────────────────────────────────────── */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* ── Page sizing ─────────────────────────────────────────── */
        html, body {
            width: 8.5in;
            background: #fff;
            color: #000;
            font-family: Georgia, 'Times New Roman', serif;
        }

        body {
            padding: 0.5in 0.6in 0.5in 0.6in;
        }

        /* ── Grayscale on screen preview & print ────────────────── */
        @media screen {
            body { filter: grayscale(100%); }
        }

        @media print {
            body {
                width: 100%;
                padding: 0;
                filter: grayscale(100%);
                -webkit-filter: grayscale(100%);
                color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            @page {
                size: 8.5in 11in portrait;
                margin: 0.5in;
            }

            .no-print { display: none !important; }
        }

        /* ── Back button (screen only) ───────────────────────────── */
        .back-btn {
            display: inline-block;
            margin-bottom: 18px;
            padding: 8px 16px;
            background: #233952;
            color: #fff;
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-size: 0.88em;
            border-radius: 4px;
            cursor: pointer;
            border: none;
        }

        /* ── Header ──────────────────────────────────────────────── */
        .print-header {
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 2px solid #000;
            padding-bottom: 12px;
            margin-bottom: 22px;
        }

        .print-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .print-header-text h1 {
            font-size: 1.6em;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .print-header-text p {
            font-size: 0.82em;
            color: #444;
            margin-top: 2px;
        }

        /* ── Section headings ────────────────────────────────────── */
        .section-title {
            font-size: 1em;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
            border-bottom: 1px solid #000;
            padding-bottom: 4px;
        }

        /* ── Color selection table ───────────────────────────────── */
        .color-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            font-size: 0.92em;
        }

        .color-table th {
            background: #e0e0e0;
            border: 1px solid #000;
            padding: 6px 10px;
            text-align: left;
            font-weight: bold;
        }

        .color-table td {
            border: 1px solid #000;
            padding: 6px 10px;
            vertical-align: top;
        }

        .color-table .col-color { width: 30%; font-weight: bold; }
        .color-table .col-coords { width: 70%; }

        /* ── Coordinate grid ─────────────────────────────────────── */
        .coord-section {
            margin-top: 10px;
        }

        .coordinate-grid {
            border-collapse: collapse;
            table-layout: fixed;
        }

        .coordinate-grid th,
        .coordinate-grid td {
            border: 1px solid #000;
            width: 0.42in;
            height: 0.42in;
            text-align: center;
            vertical-align: middle;
            font-size: 0.8em;
            font-family: Arial, sans-serif;
            padding: 0;
        }

        .coordinate-grid th {
            background: #e8e8e8;
            font-weight: bold;
        }

        .coordinate-grid td.grid-cell {
            background: #fff !important;
        }
    </style>
</head>
<body>

    <button class="back-btn no-print" onclick="history.back()">&#8592; Back to Color Coordinator</button>

    <div class="print-header">
        <img src="images/SugarGlidersLogo.png" alt="SugarGliders Logo" class="print-logo">
        <div class="print-header-text">
            <h1>SugarGliders Studio</h1>
            <p>Color Coordination Tools &mdash; Printable View</p>
        </div>
    </div>

    <p class="section-title">Color Selection</p>

    <?php if (empty($colorNames)) : ?>
        <p style="font-style:italic; margin-bottom:20px;">No color data received. Please generate the grid on the Color Coordinator page first.</p>
    <?php else : ?>
        <table class="color-table">
            <thead>
                <tr>
                    <th class="col-color">Color</th>
                    <th class="col-coords">Coordinates</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($colorNames); $i++) :
                    $name   = htmlspecialchars($colorNames[$i],  ENT_QUOTES, 'UTF-8');
                    $hex    = htmlspecialchars($colorHexes[$i],  ENT_QUOTES, 'UTF-8');
                    $coords = htmlspecialchars($colorCoords[$i] ?? '', ENT_QUOTES, 'UTF-8');
                ?>
                    <tr>
                        <td class="col-color"><?php echo $name; ?> &mdash; <?php echo strtoupper($hex); ?></td>
                        <td class="col-coords"><?php echo $coords !== '' ? $coords : '&mdash;'; ?></td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if ($gridSize > 0) : ?>
        <div class="coord-section">
            <p class="section-title">Coordinate Grid</p>

            <table class="coordinate-grid">
                <?php for ($r = 0; $r <= $gridSize; $r++) : ?>
                    <tr>
                        <?php for ($c = 0; $c <= $gridSize; $c++) : ?>
                            <?php if ($r === 0 && $c === 0) : ?>
                                <th></th>

                            <?php elseif ($r === 0) : ?>
                                <th><?php echo chr(ord('A') + $c - 1); ?></th>

                            <?php elseif ($c === 0) : ?>
                                <th><?php echo $r; ?></th>

                            <?php else : ?>
                                <td class="grid-cell"></td>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>
    <?php endif; ?>

</body>
</html>