<?php
session_start();
if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    if ($action == 'add') {
        $name = $_POST['name'];
        $grade = $_POST['grade'];
        $_SESSION['students'][] = ['name' => $name, 'grade' => $grade];
    } elseif ($action == 'edit') {
        $index = $_POST['index'];
        $name = $_POST['name'];
        $grade = $_POST['grade'];
        $_SESSION['students'][$index] = ['name' => $name, 'grade' => $grade];
    } elseif ($action == 'delete') {
        $index = $_POST['index'];
        array_splice($_SESSION['students'], $index, 1);
    }
}

function calculateAverage($students) {
    if (count($students) == 0) return 0;
    $sum = 0;
    foreach ($students as $student) {
        $sum += $student['grade'];
    }
    return $sum / count($students);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Notas de Estudiantes</title>
    <style>
        body {
            background-color: black;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        table {
            width: 80%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid white;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: grey;
        }
    </style>
</head>
<body>
    <h1>Sistema de Notas de Estudiantes</h1>
    <form method="POST">
        <input type="hidden" name="action" value="add">
        <input type="text" name="name" placeholder="Nombre del estudiante" required>
        <input type="number" name="grade" placeholder="Nota" required>
        <button type="submit">Agregar</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Nota</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['students'] as $index => $student): ?>
                <tr>
                    <td><?php echo $student['name']; ?></td>
                    <td><?php echo $student['grade']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <input type="text" name="name" value="<?php echo $student['name']; ?>" required>
                            <input type="number" name="grade" value="<?php echo $student['grade']; ?>" required>
                            <button type="submit">Editar</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Promedio de Notas: <?php echo calculateAverage($_SESSION['students']); ?></h2>
</body>
</html>
