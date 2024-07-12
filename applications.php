<?php
require_once 'includes/db_config.php';
require_once 'includes/functions.php';

session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

// Получение информации о пользователе
$user = getUserInfo($_SESSION['user_id']);

// Получение списка заявок пользователя
$applications = getapplicationsByUser($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Заявки</title>
  <link rel="stylesheet" href="bootstrap-5.3.3/bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Ваши заявки</h2>
    <p class="mb-3">
      <a href="new_application.php" class="btn btn-primary">Создать новую заявку</a>
      <a href="logout.php" class="btn btn-outline-danger">Выйти</a>
      <a href="index.html" class="btn btn-outline-primary">На главную</a>

    </p>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Категория</th>
          <th>Описание</th>
          <th>Статус</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($applications->num_rows > 0) : ?>
          <?php while ($row = $applications->fetch_assoc()) : ?>
            <tr>
              <td><?php echo $row['category']; ?></td>
              <td><?php echo $row['description']; ?></td>
              <td><?php echo $row['status']; ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else : ?>
          <tr>
            <td colspan="3">У вас нет активных заявок.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="bootstrap-5.3.3/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>
</html>