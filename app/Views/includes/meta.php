<?php
$controller_meta_title = $meta_title ?? null;
$controller_meta_description = $meta_description ?? null;
$controller_og_tags = $og_tags ?? null;
$controller_meta_keywords = $meta_keywords ?? null;

$pageTitles = [
    'home'           => 'Peak Potential Academy',
    'for-parents'    => 'For Parents | Peak Potential Academy',
    'for-school'     => 'For Schools | Peak Potential Academy',
    'for-students'   => 'For Students | Peak Potential Academy',
    'for-corporate'  => 'For Corporates | Peak Potential Academy',
    'our-story'      => 'Our Story | Peak Potential Academy',
    'contact-us'     => 'Contact Us | Peak Potential Academy',
    'enquiry'        => 'Customer Enquiry | Peak Potential Academy',
    'privacy-policy' => 'Privacy Policy | Peak Potential Academy',
    'terms'          => 'Terms & Conditions | Peak Potential Academy',
];

$pageDescriptions = [
    'home'           => 'Break the invisible loops holding you back. Peak Potential Academy helps students, parents, schools and organisations build emotional strength and life skills.',
    'for-parents'    => 'Science-backed tools and practical strategies to raise emotionally strong, well-behaved children in today’s digital world.',
    'for-school'     => 'Partner with Peak Potential Academy to help students manage emotions, break screen addiction and build inner skills they need to thrive.',
    'for-students'   => 'Help your child thrive in life, not just in exams — break screen addiction, manage emotions and build stronger habits.',
    'for-corporate'  => 'Raise emotionally resilient teams. Lead with clarity. Drive real transformation with Peak Potential Academy.',
    'our-story'      => 'Peak Potential Academy began with one belief: lasting change comes when we learn to understand our minds and choose our next step with intention.',
    'contact-us'     => 'Tell us a little about your goals, and the Peak Potential Academy team will be in touch.',
    'enquiry'        => 'Book a discovery call or demo with Peak Potential Academy. Tell us what you need and we will help you find the right next step.',
    'privacy-policy' => 'How Peak Potential Academy collects, uses and protects your information.',
    'terms'          => 'Please read these terms carefully before using the Peak Potential Academy website or services.',
];

$page = peak_page();
$meta_title = $controller_meta_title ?: ($pageTitles[$page] ?? 'Peak Potential Academy');
$meta_description = $controller_meta_description ?: ($pageDescriptions[$page] ?? '');
$meta_keywords = $controller_meta_keywords ?: 'Peak Potential Academy, emotional strength, screen addiction, parenting, student programmes';
$og_tags = $controller_og_tags ?? '';
?>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?= esc($meta_description) ?>">
<meta name="keywords" content="<?= esc($meta_keywords) ?>">
<meta name="author" content="Peak Potential Academy">
<title><?= esc($meta_title) ?></title>
<?= $og_tags ?>
