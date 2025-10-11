<?php
require_once("../../admin/includes/config.php");
require_once("../../admin/includes/functions.php");
require_once("../../admin/includes/translate.php");

// CRUD API for tbl_themes and tbl_themes_categories images
$action = $_POST['action'] ?? '';
$themes_category_id = $_POST['themes_category_id'] ?? '';
$image_id = $_POST['image_id'] ?? '';

switch ($action) {
    case 'load':
        // Load images for a given themes_category_id
        $images = selectDB("tbl_themes", "`category` = '{$themes_category_id}' AND `status` = '0'");
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
            $target_dir = '../../assets/img/';
            $target_file = $target_dir . basename($_FILES['image']['name']);
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $data = [
                    'category' => $themes_category_id,
                    'enTitle' => $enTitle,
                    'arTitle' => $arTitle,
                    'enDetails' => $enDetails,
                    'arDetails' => $arDetails,
                    'image' => $_FILES['image']['name'],
                    'status' => '0'
                ];
                if (insertDB('tbl_themes', $data)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'DB insert failed']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'File upload failed']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'No image uploaded']);
        }
        break;
    case 'delete':
        // Delete image by id
        if ($image_id) {
            if (updateDB('tbl_themes', ['status' => '1'], "`id` = '{$image_id}'")) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Delete failed']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'No image id']);
        }
        break;
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
        break;
}
?>