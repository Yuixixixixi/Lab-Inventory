<?php
class InventoryController extends Controller {
    private $inModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /lab_nexus/auth/login');
            exit;
        }
        $this->inModel = new InventoryModel();
    }

    public function index() {
        $this->view('admin/inventory');
    }

    // GET data semua item (JSON)
    public function getData() {
        header('Content-Type: application/json');
        $items = $this->inModel->getAllItems();
        echo json_encode($items);
        exit;
    }

    // GET single item (untuk modal edit)
    public function getItem($id) {
        header('Content-Type: application/json');
        $item = $this->inModel->getItemById($id);
        echo json_encode($item);
        exit;
    }

    // ADD via AJAX
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $type = $_POST['type'];
            $quantity = (int)$_POST['quantity'];
            $threshold = (int)$_POST['threshold'];

            $response = [];
            if ($this->inModel->getItemByName($name)) {
                $response['success'] = false;
                $response['message'] = "Aset dengan nama '$name' sudah ada.";
            } else {
                if ($this->inModel->addItem($name, $type, $quantity, $threshold, 'Available')) {
                    $response['success'] = true;
                    $response['message'] = "Aset berhasil ditambahkan.";
                } else {
                    $response['success'] = false;
                    $response['message'] = "Gagal menambahkan aset.";
                }
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

    // EDIT via AJAX
    public function editAjax() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (int)$_POST['id'];
            $name = htmlspecialchars($_POST['name']);
            $type = $_POST['type'];
            $quantity = (int)$_POST['quantity'];
            $threshold = (int)$_POST['threshold'];
            $status = $_POST['status'];

            $response = [];
            if ($this->inModel->updateItem($id, $name, $type, $quantity, $threshold, $status)) {
                $response['success'] = true;
                $response['message'] = "Aset berhasil diperbarui.";
            } else {
                $response['success'] = false;
                $response['message'] = "Gagal memperbarui aset.";
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

    // DELETE via AJAX
    public function deleteAjax() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = (int)$_POST['id'];
            $response = [];
            if ($this->inModel->deleteItem($id)) {
                $response['success'] = true;
                $response['message'] = "Aset berhasil dihapus.";
            } else {
                $response['success'] = false;
                $response['message'] = "Gagal menghapus aset.";
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

    // Method edit asli (jika masih dibutuhkan untuk fallback, bisa dihapus)
    public function edit($id) {
        // Redirect ke index karena sudah pakai AJAX
        header('Location: /lab_nexus/inventory');
        exit;
    }

    public function delete($id) {
        // Redirect ke index karena sudah pakai AJAX
        header('Location: /lab_nexus/inventory');
        exit;
    }
}
?>