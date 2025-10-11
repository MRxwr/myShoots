<?php
$action = $_POST['action'] ?? '';
$themes_category_id = $_POST['themes_category_id'] ?? '';
$image_id = $_POST['image_id'] ?? '';

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
                echo '<img src="../logos/themes/' . htmlspecialchars($img['image']) . '" alt="" />';
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
            // Check for upload errors
            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                echo json_encode(['success' => false, 'error' => 'File upload error: ' . $_FILES['image']['error']]);
                exit;
            }
            
            // Check if function exists
            if (!function_exists('uploadImageThemesFreeImageHost')) {
                echo json_encode(['success' => false, 'error' => 'Function uploadImageThemesFreeImageHost does not exist']);
                exit;
            }
            
            $image = uploadImageThemesFreeImageHost($_FILES['image']['tmp_name']);
            
            if ($image && $image !== '') {
                $data = [
                    'category' => $themes_category_id,
                    'enTitle' => $enTitle,
                    'arTitle' => $arTitle, 
                    'enDetails' => $enDetails,
                    'arDetails' => $arDetails,
                    'imageurl' => $image,
                    'status' => '0'
                ];
                if (insertDB('tbl_themes', $data)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'DB insert failed']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Image hosting service failed. Please check your internet connection or try again later.']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'No image file selected']);
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