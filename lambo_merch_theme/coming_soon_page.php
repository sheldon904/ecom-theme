<?php
/**
 * Template Name: Coming Soon
 * Description: A simple coming soon page for Lambo Merch
 *
 * @package Lambo_Merch
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo get_bloginfo('name'); ?> - Coming Soon</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body, html {
            height: 100%;
            width: 100%;
            background-color: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Source Sans Pro', Arial, sans-serif;
            overflow: hidden;
        }
        
        .coming-soon-container {
            text-align: center;
            padding: 20px;
        }
        
        .logo {
            max-width: 400px;
            width: 100%;
            height: auto;
            margin-bottom: 30px;
        }
        
        .coming-soon-text {
            color: #fff;
            font-size: 24px;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .logo {
                max-width: 300px;
            }
            
            .coming-soon-text {
                font-size: 20px;
                letter-spacing: 1px;
            }
        }
        
        @media (max-width: 480px) {
            .logo {
                max-width: 250px;
            }
            
            .coming-soon-text {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="coming-soon-container">
        <img src="http://lambomerch.com/wp-content/uploads/2025/05/Big_LM_logo_header-e1746073431746.png" 
             alt="Lambo Merch Logo" 
             class="logo">
        <p class="coming-soon-text">Website Coming Soon</p>
    </div>
</body>
</html>