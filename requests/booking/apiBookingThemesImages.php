<?php
// Files already included by requests/index.php
// No need to include them again

// CRUD API for tbl_themes and tbl_themes_categories images
error_reporting(E_ALL);
ini_set('display_errors', 1);

$action = $_POST['action'] ?? '';
$themes_category_id = $_POST['themes_category_id'] ?? '';
$image_id = $_POST['image_id'] ?? '';

// Debug: Output incoming POST data for troubleshooting
if (isset($_POST['debug']) || isset($_GET['debug'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'POST' => $_POST,
        'FILES' => $_FILES,
        'action' => $action,
        'themes_category_id' => $themes_category_id,
        'image_id' => $image_id
    ]);
    exit;
}

switch ($action) {
    case 'load':
        // Load images for a given themes_category_id
        $images = selectDB("tbl_themes", "`category` = '{$themes_category_id}' AND `status` = '0'");
        if (!$images && $themes_category_id == '') {
            echo '<p>Debug: themes_category_id is empty</p>';
        }
        if ($images) {
            foreach ($images as $img) {
                echo '<div class="gallery-image-item col-md-3">';
                echo '<img src="../../assets/img/' . htmlspecialchars($img['image']) . '" alt="" />';
                echo '<div class="gallery-image-info">';
                echo '<strong>' . htmlspecialchars($img['enTitle']) . '</strong>';
                echo '<span>' . htmlspecialchars($img['arTitle']) . '</span>';
                echo '</div>';
                echo '<button class="delete-image-btn" data-id="' . $img['id'] . '">×</button>';
                echo '</div>';
            }
        } else {
            echo '<p>No images found.</p>';
        }
        break;
    case 'upload':
        // Upload new image
        $enTitle = $_POST['enTitle'] ?? '';
        $arTitle = $_POST['arTitle'] ?? '';
        $enDetails = $_POST['enDetails'] ?? '';
        $arDetails = $_POST['arDetails'] ?? '';
        if (!empty($_FILES['image']['name'])) {
            // Debug: Check if uploadImageThemesFreeImageHost exists
            if (!function_exists('uploadImageThemesFreeImageHost')) {
                echo json_encode(['success' => false, 'error' => 'Function uploadImageThemesFreeImageHost does not exist']);
                exit;
            }
            $image = uploadImageThemesFreeImageHost($_FILES['image']['tmp_name']);
            if ($image) {
                $data = [
                    'category' => $themes_category_id,
                    'enTitle' => $enTitle,
                    'arTitle' => $arTitle,
                    'enDetails' => $enDetails,
                    'arDetails' => $arDetails,
                    'image' => $image,
                    'status' => '0'
                ];
                if (insertDB('tbl_themes', $data)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'DB insert failed', 'data' => $data]);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'File upload failed', 'file' => $_FILES['image']]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'No image uploaded', 'files' => $_FILES]);
        }
        break;
    case 'delete':
        // Delete image by id
        if ($image_id) {
            $result = updateDB('tbl_themes', ['status' => '1'], "`id` = '{$image_id}'");
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Delete failed', 'image_id' => $image_id]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'No image id', 'image_id' => $image_id]);
        }
        break;
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
        break;
}
?>