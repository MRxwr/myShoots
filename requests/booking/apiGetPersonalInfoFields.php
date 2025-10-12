<?php
/**
 * GetPersonalInfoFields Endpoint
 * Returns personal info fields, themes, and extra items for a package
 */

if(!isset($_POST['package_id'])) {
    echo json_encode(['success' => false, 'message' => direction('Missing package ID', 'معرف الباقة مفقود')]);
    exit();
}

$packageId = intval($_POST['package_id']);

if ($package = selectDBNew("tbl_packages", [$packageId], "`id` = ? AND `status` = '0' AND `hidden` = '1'", "")) {
    $package = $package[0];
    
    // Get personal info fields with titles
    $personalInfoFields = [];
    $personalInfoIds = json_decode($package['personalInfo'], true);
    if ($personalInfoIds && is_array($personalInfoIds)) {
        foreach ($personalInfoIds as $field) {
            $personalInfoFields[] = [
                'id' => $field['id'],
                'title' => $field[direction('en','ar').'Title'],
                'type' => $field['type']
            ];
        }
    }
    
    // Get themes with their images
    $themesData = [];
    $themesCategories = json_decode($package['themes'], true);
    if ($themesCategories && is_array($themesCategories)) {
        foreach ($themesCategories as $category) {
            $categoryId = $category['id'];
            $categoryTitle = $category[direction('en','ar').'Title'];
            
            $themesInCategory = selectDB("tbl_themes", "`category` = '{$categoryId}' AND `status` = '0'");
            $categoryThemes = [];
            if ($themesInCategory) {
                foreach ($themesInCategory as $theme) {
                    $categoryThemes[] = [
                        'id' => $theme['id'],
                        'title' => $theme[direction('en','ar').'Title'],
                        'imageurl' => $theme['imageurl']
                    ];
                }
            }
            
            if (count($categoryThemes) > 0) {
                $themesData[] = [
                    'id' => $categoryId,
                    'title' => $categoryTitle,
                    'themes' => $categoryThemes
                ];
            }
        }
    }
    
    // Get extra items
    $extraItemsData = [];
    $extraItems = json_decode($package['extra_items'], true);
    if ($extraItems && is_array($extraItems)) {
        foreach ($extraItems as $item) {
            $extraItemsData[] = [
                'item' => $item['item_'.direction('en','ar')],
                'price' => $item['price']
            ];
        }
    }
    
    echo json_encode([
        'success' => true,
        'data' => [
            'personalInfo' => $personalInfoFields,
            'themes' => $themesData,
            'themes_count' => isset($package['themes_count']) ? intval($package['themes_count']) : 1,
            'extra_items' => $extraItemsData
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => direction('Package not found', 'الباقة غير موجودة')]);
}
exit();
?>
