<?php
/**
 * GetPackageForBooking Endpoint
 * Returns package details for creating a manual booking
 */

if(!isset($_POST['package_id'])) {
    echo json_encode(['success' => false, 'message' => direction('Missing package ID', 'معرف الباقة مفقود')]);
    exit();
}

$packageId = intval($_POST['package_id']);

if ($package = selectDBNew("tbl_packages", [$packageId], "`id` = ? AND `status` = '0' AND `hidden` = '1'", "")) {
    $package = $package[0];
    
    echo json_encode([
        'success' => true,
        'data' => [
            'id' => $package['id'],
            'title' => $package[direction('en','ar').'Title'],
            'price' => $package['price'],
            'currency' => $package['currency'],
            'time' => json_decode($package['time'], true),
            'personalInfo' => json_decode($package['personalInfo'], true),
            'extra_items' => json_decode($package['extra_items'], true),
            'themes' => json_decode($package['themes'], true),
            'themes_count' => isset($package['themes_count']) ? intval($package['themes_count']) : 1
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => direction('Package not found', 'الباقة غير موجودة')]);
}
exit();
?>
