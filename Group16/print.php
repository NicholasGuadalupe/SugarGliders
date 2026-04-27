<?php
$gridSize = isset($_POST['gridSize']) ? (int)$_POST['gridSize'] : 0;
$numColors = isset($_POST['numColors']) ? (int)$_POST['numColors'] : 0;
$colors = isset($_POST['colors']) ? $_POST['colors'] : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print View</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Did style in page due to unique formatting needs compared to rest of website */
        * {
            filter: grayscale(100%);
            -webkit-filter: grayscale(100%);
        }
        
        body {
            width: 8.5in;
            margin: 0 auto;
            padding: 0.5in;
            box-sizing: border-box;
        }
        
        @media print {
            body {
                width: 100%;
                padding: 0.25in;
            }
            
            @page {
                size: 8.5in 11in portrait;
                margin: 0.5in;
            }
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo {
            max-width: 100px;
            filter: grayscale(100%);
        }
        
        .color-table, .coordinate-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .color-table td, .coordinate-grid td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        
        .color-table .color-name {
            width: 20%;
        }
        
        .color-table .color-preview {
            width: 80%;
        }
        
        .coordinate-grid {
            table-layout: fixed;
        }
        
        .coordinate-grid td {
            aspect-ratio: 1;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="images/SugarGlidersLogo.png" alt="Sugar Gliders Logo" class="logo">
        <h1>Sugar Gliders</h1>
    </div>
    <table class="color-table">
        <?php foreach ($colors as $color): ?>
            <tr>
                <td class="color-name"><?php echo htmlspecialchars($color); ?></td>
                <td class="color-preview"><?php echo htmlspecialchars($color); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    
    <table class="coordinate-grid">
        <?php for ($row = 0; $row <= $gridSize; $row++): ?>
            <tr>
                <?php for ($col = 0; $col <= $gridSize; $col++): ?>
                    <td>
                        <?php
                        if ($row === 0 && $col === 0) {
                            echo '';
                        } elseif ($row === 0) {
                            echo chr(64 + $col);
                        } elseif ($col === 0) {
                            echo $row;
                        } else {
                            echo '';
                        }
                        ?>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>
</body>
</html>