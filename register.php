<?php
require_once 'includes/db_config.php';
require_once 'includes/functions.php';

// Обработка формы регистрации
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullname = validateForm($_POST['fullname']);
  $phone = validateForm($_POST['phone']);
  $email = validateForm($_POST['email']);
  $password = validateForm($_POST['password']);
  $department = validateForm($_POST['department']);

  // Валидация данных
  if (empty($fullname) || empty($phone) || empty($email) || empty($password) || empty($department)) {
    $error_message = "Пожалуйста, заполните все поля.";
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_message = "Неверный формат электронной почты.";
  } else if (strlen($password) < 5) {
    $error_message = "Пароль должен быть не менее 5 символов.";
  } else {
    // Регистрация пользователя
    if (registerUser($fullname, $phone, $email, $password, $department)) {
      header("Location: login.php");
      exit;
    } else {
      $error_message = "Ошибка регистрации. Пожалуйста, попробуйте снова.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Регистрация</title>
  <link rel="stylesheet" href="bootstrap-5.3.3/bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Регистрация</h2>
    <?php if (isset($error_message)) : ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
      </div>
    <?php endif; ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <div class="form-group">
        <label for="fullname">ФИО:</label>
        <input type="text" class="form-control" id="fullname" name="fullname" required>
      </div>
      <div class="form-group">
        <label for="phone">Телефон:</label>
        <input type="tel" class="form-control" id="phone" name="phone" pattern="+7(\d{3}/\d{3}-\d{2}-\d{2})" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Пароль:</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="department">Ваш отдел:</label>
        <input type="text" class="form-control" id="department" name="department" required>
      </div>
      <div class="mt-4">
      <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
      <a href="login.php" class="btn btn-outline-info">Авторизироваться</a>
      <a href="index.html" class="btn btn-outline-primary">На главную</a>
    </div>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="bootstrap-5.3.3/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>
</html>