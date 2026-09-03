<?php
/**
 * Shared layout variables for Peak Potential Academy header/footer.
 */

helper('theme');

$setting = is_array($setting ?? null) ? $setting : [];
$social = is_array($social ?? null) ? $social : [];
$comment = is_array($comment ?? null) ? $comment : [];
$page_contact = is_array($page_contact ?? null) ? $page_contact : [];
$page_home = is_array($page_home ?? null) ? $page_home : [];
$page_home_lang_independent = is_array($page_home_lang_independent ?? null) ? $page_home_lang_independent : [];

try {
    $Model_common = new \App\Models\Model_common();
    if ($setting === []) {
        $setting = $Model_common->all_setting() ?: [];
    }
    if ($social === []) {
        $social = $Model_common->all_social() ?: [];
    }
    if ($comment === []) {
        $comment = $Model_common->all_comment() ?: [];
    }
    if ($page_contact === []) {
        $page_contact = $Model_common->all_page_contact() ?: [];
    }
    if ($page_home === []) {
        $page_home = $Model_common->all_page_home() ?: [];
    }
    if ($page_home_lang_independent === []) {
        $page_home_lang_independent = $Model_common->all_page_home_lang_independent() ?: [];
    }
} catch (\Throwable $e) {
    $setting = $setting ?: [];
    $social = $social ?: [];
    $comment = $comment ?: [];
    $page_contact = $page_contact ?: [];
}

$class_name = theme_current_controller();
$current_page = $current_page ?? peak_page();
$GLOBALS['peak_current_page'] = $current_page;
$is_home = theme_is_home();

$logo_url = ! empty($setting['logo'])
    ? theme_upload($setting['logo'])
    : peak_img('logo.png');

$site_email = peak_site_email($setting, $page_contact);
$site_phone = peak_site_phone($setting, $page_contact);
$site_phone_href = peak_site_phone_href($setting, $page_contact);
$instagram_url = peak_social_url($social ?? [], 'instagram');
$linkedin_url = peak_social_url($social ?? [], 'linkedin');
$youtube_url = peak_social_url($social ?? [], 'youtube');
$facebook_url = peak_social_url($social ?? [], 'facebook');
