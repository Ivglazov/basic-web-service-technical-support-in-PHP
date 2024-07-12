<?php
// Функция для валидации формы
function validateForm($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Функция для регистрации пользователя
function registerUser($fullname, $phone, $email, $password, $department) {
  global $conn;

  // Хеширование пароля
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Подготовка запроса
  $sql = "INSERT INTO users (fullname, phone, email, password, department) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssss", $fullname, $phone, $email, $hashed_password, $department);

  // Выполнение запроса
  if ($stmt->execute()) {
    return true;
  } else {
    return false;
  }
}

// Функция для авторизации пользователя
function loginUser($email, $password) {
  global $conn;

  // Подготовка запроса
  $sql = "SELECT id, password FROM users WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  // Проверка существования пользователя
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Сравнение пароля
    if (password_verify($password, $row['password'])) {
      $_SESSION['user_id'] = $row['id'];
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

// Функция для получения информации о пользователе
function getUserInfo($user_id) {
  global $conn;

  // Подготовка запроса
  $sql = "SELECT * FROM users WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();

  // Возврат информации о пользователе
  if ($result->num_rows > 0) {
    return $result->fetch_assoc();
  } else {
    return false;
  }
}

// Функция для создания новой заявки
function createapplication($user_id, $category, $description) {
  global $conn;

  // Подготовка запроса
  $sql = "INSERT INTO applications (user_id, category, description, status) VALUES (?, ?, ?, 'Новое')";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iss", $user_id, $category, $description);

  // Выполнение запроса
  if ($stmt->execute()) {
    return true;
  } else {
    return false;
  }
}

// Функция для получения списка заявок пользователя
function getapplicationsByUser($user_id) {
  global $conn;

  // Подготовка запроса
  $sql = "SELECT * FROM applications WHERE user_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();

  // Возврат списка заявок
  return $result;
}

// Функция для обновления статуса заявки
function updateapplicationStatus($application_id, $status) {
  global $conn;

  // Подготовка запроса
  $sql = "UPDATE applications SET status = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si", $status, $application_id);

  // Выполнение запроса
  if ($stmt->execute()) {
    return true;
  } else {
    return false;
  }
}

// Функция для получения списка всех заявок
function getAllapplications() {
  global $conn;

  // Подготовка запроса
  $sql = "SELECT * FROM applications";
  $result = $conn->query($sql);

  // Возврат списка заявок
  return $result;
}
?>