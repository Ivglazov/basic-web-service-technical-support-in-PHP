<?php
require_once 'includes/db_config.php';
require_once 'includes/functions.php';

session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] !== 1)) {
  header("Location: admin_login.php");
  exit;
}

// Получение списка всех заявок
$applications = getAllapplications();

// Обработка формы обновления статуса заявки
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $application_id = $_POST['application_id'];
  $status = $_POST['status'];

  // Обновление статуса заявки
  if (updateapplicationStatus($application_id, $status)) {
    header("Location: admin.php");
    exit;
  } else {
    $error_message = "Ошибка обновления статуса заявки. Пожалуйста, попробуйте снова.";
  }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Панель администратора</title>
  <link rel="stylesheet" href="bootstrap-5.3.3/bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Панель администратора</h2>
    <a href="logout.php" class="btn btn-danger fw-bold btn-lg">Выйти</a>
    <?php if (isset($error_message)) : ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
      </div>
    <?php endif; ?>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>ФИО</th>
          <th>Отдел</th>
          <th>Категория</th>
          <th>Описание</th>
          <th>Статус</th>
          <th>Действия</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($applications->num_rows > 0) : ?>
          <?php while ($row = $applications->fetch_assoc()) : ?>
            <tr>
              <td><?php
                // Получение информации о пользователе по id
                $user = getUserInfo($row['user_id']);
                echo $user['fullname'];
              ?></td>
              <td><?php echo $user['department']; ?></td>
              <td><?php echo $row['category']; ?></td>
              <td><?php echo $row['description']; ?></td>
              <td><?php echo $row['status']; ?></td>
              <td>
                <?php if ($row['status'] === 'Новое') : ?>
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" name="application_id" value="<?php echo $row['id']; ?>">
                    <select class="form-control" name="status">
                      <option value="В процессе">В процессе</option>
                      <option value="Выполнено">Выполнено</option>
                      <option value="Отменено">Отменено</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Изменить статус</button>
                  </form>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else : ?>
          <tr>
            <td colspan="6">Нет активных заявок.</td>
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