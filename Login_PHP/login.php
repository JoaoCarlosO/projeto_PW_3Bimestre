<!-- verificação de login -->
<?php
session_start();

// Simulando um usuário com hash MD5
$users = [
    'admin' => md5('password123'),
];

// Pega o usuário e a senha do formulário
$username = $_POST['username'];
$password = md5($_POST['password']);

// Verifica se o usuário existe e se a senha é válida
if (isset($users[$username]) && $users[$username] === $password) {
    $_SESSION['loggedin'] = true;
    header('Location: restrito.php');
} else {
    echo "Login inválido!";
}
?>