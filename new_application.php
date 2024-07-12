<?php
require_once 'includes/db_config.php';
require_once 'includes/functions.php';

session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

// Обработка формы создания заявки
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $category = validateForm($_POST['category']);
  $description = validateForm($_POST['description']);

  // Валидация данных
  if (empty($category) || empty($description)) {
    $error_message = "Пожалуйста, заполните все поля.";
  } else {
    // Создание заявки
    if (createapplication($_SESSION['user_id'], $category, $description)) {
      header("Location: applications.php");
      exit;
    } else {
      $error_message = "Ошибка создания заявки. Пожалуйста, попробуйте снова.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Новая заявка</title>
  <link rel="stylesheet" href="bootstrap-5.3.3/bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Новая заявка</h2>
    <?php if (isset($error_message)) : ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
      </div>
    <?php endif; ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <label for="category">Категория:</label>
        <select class="form-control" id="category" name="category" required>
          <option value="Проблема с компьютером">Проблема с компьютером</option>
          <option value="Проблема с сетью">Проблема с сетью</option>
          <option value="Проблема с программным обеспечением">Проблема с программным обеспечением</option>
          <option value="Другая проблема">Другая проблема</option>
        </select>
      </div>
      <div class="form-group">
        <label for="description">Описание проблемы:</label>
        <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Создать заявку</button>
      <a href="logout.php" class="btn btn-outline-danger ">Выйти</a>
      <a href="applications.php" class="btn btn-outline-primary">Назад</a>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="bootstrap-5.3.3/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>
</html>