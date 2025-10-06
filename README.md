# Dynamic Copyright Year (functions.php snippet)

A lightweight PHP snippet for WordPress developers who want to display the current year dynamically without using any plugin.

## 🧠 Why Use It

Most developers manually update the copyright year every new year.
This snippet updates it automatically, keeping your footer always up-to-date.

## ⚙️ Installation

1. Copy the code below and paste it into your theme’s functions.php file (use a child theme if possible).

   // Dynamic Copyright Year Shortcode
   function dynamic_copyright() {
   return '&copy; ' . date('Y') . ' YourSiteName';
   }
   add_shortcode('copyright_year', 'dynamic_copyright');

2. Replace **YourSiteName** with your actual website or client name.

3. In Elementor, Gutenberg, or any text area that supports shortcodes, insert:

   [copyright_year]

4. That’s it! It will automatically show:

   © 2025 YourSiteName
   (and update automatically every new year)

## ✅ Features

- No plugin required
- Works with Elementor, Gutenberg, or Classic Editor
- 100% lightweight and clean

## 👨‍💻 Author

Developed by **Mujtaba Haider**  
Role: WordPress Developer
