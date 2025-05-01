<?php
// Remove information disclosure headers
header_remove("X-Powered-By");
header_remove("Server");
header_remove("X-Runtime");
header_remove("X-Version");

// Set security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN"); // Fixed X-Frame-Options
header("X-XSS-Protection: 1; mode=block");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("Referrer-Policy: strict-origin-when-cross-origin");

// Content Security Policy - Uncommented and adjusted for your resources
// header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://*.jsdelivr.net https://*.cloudflare.com https://*.jquery.com https://*.bootstrapcdn.com https://*.googleapis.com; style-src 'self' 'unsafe-inline' https://*.bootstrapcdn.com https://*.jsdelivr.net https://*.cloudflare.com https://*.googleapis.com; img-src 'self' data: blob: *; font-src 'self' https://fonts.gstatic.com https://*.googleapis.com; connect-src 'self'; frame-src 'self'; frame-ancestors 'self'; form-action 'self';");

// Permissions Policy
header("Permissions-Policy: geolocation=(), microphone=(), payment=(), usb=(), battery=(), midi=(), notifications=()");

// Cross-Origin headers
header("Cross-Origin-Embedder-Policy: credentialless");
header("Cross-Origin-Opener-Policy: same-origin-allow-popups");
header("Cross-Origin-Resource-Policy: cross-origin");

// Hide PHP version
ini_set('expose_php', 'Off');
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
ini_set('display_errors', 'Off');

session_start();

require('../app/init.php');

$app = new App;