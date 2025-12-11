<?php

require_once 'config.php';

// Подключаемся к MySQL
$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (!$mysqli) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

// Устанавливаем кодировку
mysqli_set_charset($mysqli, DB_CHARSET);

/* === Приём данных от пользователя === */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Фильтрация
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $msg   = trim($_POST['msg'] ?? '');

    // Защита HTML + SQL
    $name  = htmlspecialchars(mysqli_real_escape_string($mysqli, $name));
    $email = htmlspecialchars(mysqli_real_escape_string($mysqli, $email));
    $msg   = htmlspecialchars(mysqli_real_escape_string($mysqli, $msg));

    // Проверка, что поля не пустые
    if ($name !== '' && $email !== '' && $msg !== '') {
        // SQL-вставка
        $sql = "INSERT INTO msgs (name, email, msg) VALUES ('$name', '$email', '$msg')";
        mysqli_query($mysqli, $sql);
    }

    // Перезапрос страницы
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}



if (isset($_GET['del'])) {
    $id = (int) $_GET['del'];

    $sql = "DELETE FROM msgs WHERE id = $id";
    mysqli_query($mysqli, $sql);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Гостевая книга</title>
</head>
<body>

<h1>Гостевая книга</h1>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

Ваше имя:<br>
<input type="text" name="name"><br>

Ваш E-mail:<br>
<input type="email" name="email"><br>

Сообщение:<br>
<textarea name="msg" cols="50" rows="5"></textarea><br><br>

<input type="submit" value="Добавить!">

</form>

<hr>

<?php


// Выборка всех сообщений в обратном порядке
$sql  = "SELECT * FROM msgs ORDER BY id DESC";
$res  = mysqli_query($mysqli, $sql);

// Кол-во сообщений
$count = mysqli_num_rows($res);
echo "<p>Сообщений в гостевой книге: <b>$count</b></p>";

// Вывод
while ($row = mysqli_fetch_assoc($res)) {
    echo "<div style='margin-bottom:20px; padding-bottom:10px; border-bottom:1px solid #ccc;'>";
    echo "<p><b>{$row['name']}</b> ({$row['email']})</p>";
    echo "<p>{$row['msg']}</p>";
    
    echo "<a href='?del={$row['id']}' onclick=\"return confirm('Удалить запись?');\">Удалить</a>";
    echo "</div>";
}

// Закрываем соединение
mysqli_close($mysqli);
?>

</body>
</html>
