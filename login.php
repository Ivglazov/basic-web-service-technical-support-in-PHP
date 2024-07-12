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
    // Авторизация пользователя
    if (loginUser($email, $password)) {
      header("Location: applications.php");
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
  <title>Авторизация</title>
  <link rel="stylesheet" href="bootstrap-5.3.3/bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Авторизация</h2>
    <?php if (isset($error_message)) : ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
      </div>
    <?php endif; ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Пароль:</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="mt-4">
      <button type="submit" class="btn btn-primary">Войти</button>
      <a href="register.php" class="btn btn-outline-info">Зарегистрироваться</a>
      <a href="index.html" class="btn btn-outline-primary">На главную</a>

    </div>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="bootstrap-5.3.3/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>
</html>