<?php
require "db.php";

$message = "";
$error = "";


// ADD COLOR

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_color"])) {
    $name = trim($_POST["name"]);
    $hex = strtoupper(trim($_POST["hex"]));

    if (!preg_match("/^#[0-9A-F]{6}$/", $hex)) {
        $error = "Hex value must be in the format #RRGGBB.";
    } else {
        // Check for duplicates
        $check = $conn->prepare("SELECT id FROM colors WHERE LOWER(name) = LOWER(?) OR hex_value = ?");
        $check->bind_param("ss", $name, $hex);
        $check->execute();
        $checkResult = $check->get_result();

        if ($checkResult->num_rows > 0) {
            $error = "That color name or hex value already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO colors (name, hex_value) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $hex);

            if ($stmt->execute()) {
                $message = "Color added successfully.";
            } else {
                $error = "Could not add color.";
            }

            $stmt->close();
        }

        $check->close();
    }
}


// EDIT COLOR

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["edit_color"])) {
    $id = intval($_POST["edit_id"]);
    $name = trim($_POST["edit_name"]);
    $hex = strtoupper(trim($_POST["edit_hex"]));

    if (!preg_match("/^#[0-9A-F]{6}$/", $hex)) {
        $error = "Hex value must be in the format #RRGGBB.";
    } else {
        $stmt = $conn->prepare("UPDATE colors SET name = ?, hex_value = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $hex, $id);

        if ($stmt->execute()) {
            $message = "Color updated successfully.";
        } else {
            $error = "That color name or hex value already exists.";
        }

        $stmt->close();
    }
}


// DELETE CONFIRMATION STEP

$deleteCandidate = null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["request_delete"])) {
    $delete_id = intval($_POST["delete_id"]);

    $countResult = $conn->query("SELECT COUNT(*) AS total FROM colors");
    $countRow = $countResult->fetch_assoc();
    $totalColors = intval($countRow["total"]);

    if ($totalColors < 2) {
        $error = "You cannot delete a color when the databse has less than 2 colors.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM colors WHERE id = ?");
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $deleteCandidate = $result->fetch_assoc();

        $stmt->close();
    }
}


//DELETE

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["confirm_delete"])) {
    $delete_id = intval($_POST["delete_id"]);

    $countResult = $conn->query("SELECT COUNT(*) AS total FROM colors");
    $countRow = $countResult->fetch_assoc();
    $totalColors = intval($countRow["total"]);

    if ($totalColors < 2) {
        $error = "You cannot delete a color when the databse has less than 2 colors.";
    } else {
        $stmt = $conn->prepare("DELETE FROM colors WHERE id = ?");
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            $message = "Color deleted successfully.";
        } else {
            $error = "Could not delete color.";
        }

        $stmt->close();
    }
}


// GET COLORS FOR DISPLAY

$result = $conn->query("SELECT * FROM colors ORDER BY name");
$colors = [];

while ($row = $result->fetch_assoc()) {
    $colors[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Color Selection</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Color Selection</h1>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="color.php">Color Coordinate</a>
    <a href="print.php">Print</a>
    <a href="colors.php">Color Selection</a>
</nav>

<main>

    <section>
        <h2>Current Colors</h2>

        <table border="1">
            <tr>
                <th>Name</th>
                <th>Hex Value</th>
                <th>Preview</th>
            </tr>

            <?php foreach ($colors as $color): ?>
                <tr>
                    <td><?php echo htmlspecialchars($color["name"]); ?></td>
                    <td><?php echo htmlspecialchars($color["hex_value"]); ?></td>
                    <td style="background-color: <?php echo htmlspecialchars($color["hex_value"]); ?>;">
                        &nbsp;
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>

    <section>
        <h2>Add a Color</h2>

        <?php if ($message !== ""): ?>
            <div class="form-message error-message">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <?php if ($error !== ""): ?>
        <div class="form-message error-message">
            <?php echo htmlspecialchars($error); ?>
        </div>
<?php endif; ?>

        <form method="post" action="colors.php">
            <label>
                Name:
                <input type="text" name="name" required>
            </label>

            <label>
                Hex Value:
                <input type="text" name="hex" placeholder="#FFFFFF" required>
            </label>

            <button type="submit" name="add_color">Add Color</button>
        </form>
    </section>

    <section>
        <h2>Edit a Color</h2>

        <form method="post" action="colors.php">
            <label>
                Color:
                <select name="edit_id" required>
                    <?php foreach ($colors as $color): ?>
                        <option value="<?php echo $color["id"]; ?>">
                            <?php echo htmlspecialchars($color["name"]); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label>
                New Name:
                <input type="text" name="edit_name" required>
            </label>

            <label>
                New Hex Value:
                <input type="text" name="edit_hex" placeholder="#FFFFFF" required>
            </label>

            <button type="submit" name="edit_color">Update Color</button>
        </form>
    </section>

    <section>
        <h2>Delete a Color</h2>

        <form method="post" action="colors.php">
            <label>
                Color:
                <select name="delete_id" required>
                    <?php foreach ($colors as $color): ?>
                        <option value="<?php echo $color["id"]; ?>">
                            <?php echo htmlspecialchars($color["name"]); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <button type="submit" name="request_delete">Delete Color</button>
        </form>

        <?php if ($deleteCandidate !== null): ?>
            <div class="delete-confirm-box">
                <p>
                    Are you sure you want to delete
                    <strong><?php echo htmlspecialchars($deleteCandidate["name"]); ?></strong>
                    —
                    <?php echo htmlspecialchars($deleteCandidate["hex_value"]); ?>?
                </p>

                <form method="post" action="colors.php">
                    <input type="hidden" name="delete_id" value="<?php echo $deleteCandidate["id"]; ?>">
                    <button type="submit" name="confirm_delete">Yes, Delete</button>
                    <a href="colors.php">Cancel</a>
                </form>
            </div>
        <?php endif; ?>
    </section>

</main>

<footer>
    <p>&copy; 2026 SugarGliders CAS312 Group Projec</p>
</footer>

</body>
</html>