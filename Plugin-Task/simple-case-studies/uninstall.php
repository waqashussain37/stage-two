<?php
/**
 * Uninstall Simple Case Studies Plugin
 *
 * @package SimpleCaseStudies
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}


$case_studies = get_posts(array(
    'post_type' => 'case_study',
    'numberposts' => -1, 
));

foreach ($case_studies as $case_study) {
    wp_delete_post($case_study->ID, true); 
}

?>



