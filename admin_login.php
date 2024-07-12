<?php
require_once 'includes/db_config.php';
require_once 'includes/functions.php';

session_start();

// Обработка формы авторизации
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = validateForm($_POST['email']);
  $password = validateForm($_POST['password']);

  // Валидация данных
  if (empty($email) || empty($password)) {
    $error_message = "Пожалуйста, заполните все поля.";
  } else {
    // Проверка на совпадение с учетными данными администратора
    if ($email === 'help' && $password === 'helpme') {
      $_SESSION['user_id'] = 1; // Устанавливаем ID администратора
      header("Location: admin.php");
      exit;
    } else {
      $error_message = "Неверный логин или пароль.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Авторизация администратора</title>
  <link rel="stylesheet" href="bootstrap-5.3.3/bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Авторизация администратора</h2>
    <?php if (isset($error_message)) : ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
      </div>
    <?php endif; ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <label for="email">Логин:</label>
        <input type="text" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Пароль:</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="mt-4">
      <button type="submit" class="btn btn-primary">Войти</button>
      <a href="index.html" class="btn btn-outline-primary">Назад</a>

    </div>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="bootstrap-5.3.3/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>
</html>