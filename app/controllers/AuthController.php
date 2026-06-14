<?php
class AuthController extends Controller {
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = (new Database())->connect();
    }

    public function index() {
        if (isset($_SESSION['role'])) {
            header('Location: /lab_nexus/dashboard');
            exit;
        }
        $this->login();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            // Loloskan jika hash cocok ATAU jika mengetik '123456' saat development
            if ($user && (password_verify($password, $user['password']) || $password === '123456')) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];

                header('Location: /lab_nexus/dashboard');
                exit;
            } else {
                $_SESSION['error'] = "Email atau Password salah!";
                header('Location: /lab_nexus/auth/login');
                exit;
            }
        }
        $this->view('auth/login');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $role = 'user';

            // Cek apakah email sudah terdaftar
            $check = $this->db->prepare("SELECT id FROM users WHERE email = :email");
            $check->execute(['email' => $email]);
            if ($check->fetch()) {
                $_SESSION['error'] = "Email sudah digunakan!";
                header('Location: /lab_nexus/auth/register');
                exit;
            }

            $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
            if ($stmt->execute(['name' => $name, 'email' => $email, 'password' => $password, 'role' => $role])) {
                $_SESSION['success'] = "Pendaftaran berhasil! Silakan login.";
                header('Location: /lab_nexus/auth/login');
                exit;
            } else {
                $_SESSION['error'] = "Gagal melakukan pendaftaran.";
            }
        }
        $this->view('auth/register');
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();
        header('Location: /lab_nexus/auth/login');
        exit;
    }
}