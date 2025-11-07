// Dynamic Copyright Year Shortcode
// Add this to your theme's functions.php (preferably child theme)
function dynamic_copyright() {
    // Replace 'YourSiteName' with your website or client name
    return '&copy; ' . date('Y') . ' YourSiteName';
}
add_shortcode('copyright_year', 'dynamic_copyright');


