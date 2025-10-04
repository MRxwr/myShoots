<?php
require_once('../includes/config.php');
require_once('../includes/functions.php');
require_once('../includes/translate.php');

// Load images for a category
if (isset($_POST['action']) && $_POST['action'] == 'load' && isset($_POST['category_id'])) {
    $categoryId = intval($_POST['category_id']);
    $images = selectDB("tbl_galleries", "`category` = '{$categoryId}' AND `status` = '0' ORDER BY `id` DESC");
    
    if ($images && count($images) > 0) {
        foreach ($images as $image) {
            $enTitle = isset($image['enTitle']) ? htmlspecialchars($image['enTitle']) : '';
            $arTitle = isset($image['arTitle']) ? htmlspecialchars($image['arTitle']) : '';
            $enDetails = isset($image['enDetails']) ? htmlspecialchars($image['enDetails']) : '';
            $arDetails = isset($image['arDetails']) ? htmlspecialchars($image['arDetails']) : '';
            $title = direction('en','ar') == 'en' ? $enTitle : $arTitle;
            $details = direction('en','ar') == 'en' ? $enDetails : $arDetails;
            
            echo '<div class="gallery-image-item col-md-3">';
            echo '<button type="button" class="delete-image-btn" data-id="'.$image['id'].'">×</button>';
            echo '<img src="../logos/'.$image['imageurl'].'" alt="Gallery Image">';
            echo '<div class="gallery-image-info">';
            if (!empty($title)) {
                echo '<strong>'.$title.'</strong>';
            }
            if (!empty($details)) {
                echo '<div style="font-size:11px;">'.nl2br($details).'</div>';
            }
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p class="text-center col-12">'.direction("No images found","لا توجد صور").'</p>';
    }
    exit;
}

// Upload new image
if (isset($_POST['action']) && $_POST['action'] == 'upload' && isset($_FILES['image']) && isset($_POST['category_id'])) {
    $categoryId = intval($_POST['category_id']);
    $enTitle = isset($_POST['enTitle']) ? trim($_POST['enTitle']) : '';
    $arTitle = isset($_POST['arTitle']) ? trim($_POST['arTitle']) : '';
    $enDetails = isset($_POST['enDetails']) ? trim($_POST['enDetails']) : '';
    $arDetails = isset($_POST['arDetails']) ? trim($_POST['arDetails']) : '';
    
    try {
        // Upload image using the function
        $imageUrl = uploadImageBannerFreeImageHost($_FILES['image']['tmp_name']);
        
        if ($imageUrl && !empty($imageUrl)) {
            // Insert into database
            $data = array(
                'category' => $categoryId,
                'imageurl' => $imageUrl,
                'enTitle' => $enTitle,
                'arTitle' => $arTitle,
                'enDetails' => $enDetails,
                'arDetails' => $arDetails,
                'is_active' => 'Yes',
                'status' => '0'
            );
            
            if (insertDB("tbl_galleries", $data)) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false, 'error' => 'Database insert failed'));
            }
        } else {
            echo json_encode(array('success' => false, 'error' => 'Image upload failed'));
        }
    } catch (Exception $e) {
        echo json_encode(array('success' => false, 'error' => $e->getMessage()));
    }
    exit;
}

// Delete image
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['image_id'])) {
    $imageId = intval($_POST['image_id']);
    
    // Update status to deleted (soft delete)
    if (updateDB("tbl_galleries", array('status' => '1'), "`id` = '{$imageId}'")) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false));
    }
    exit;
}

echo json_encode(array('success' => false, 'error' => 'Invalid request'));
?>
