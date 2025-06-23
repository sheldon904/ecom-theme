<?php
/**
 * Template Name: Home Page
 *
 * The template for displaying the home page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Lambo_Merch
 */

get_header();
?>

<style>
/* Layout visibility control */
.mobile-layout {
    display: none; /* Hide on desktop by default */
}

.desktop-layout {
    display: block; /* Show on desktop by default */
}

/* Mobile styles */
@media (max-width: 767px) {
    .mobile-layout {
        display: block !important; /* Show on mobile */
    }
    
    .desktop-layout {
        display: none !important; /* Hide on mobile */
    }
    
    /* Mobile styling */
    .mobile-homepage-logo {
        width: 50%; /* Increased from 25% */
        margin: 20px auto;
        display: block;
    }
    .mobile-shop-now-container {
      position: relative;
      display: inline-block;
    }
    .mobile-shop-now-container img {
      width: auto !important;
      display: block;
    }
    .mobile-shop-now-button {
      position: absolute !important;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      margin: 0; 
      padding: 12px 30px;
      background-color: #ff0000;
      color: #fff;
      font-weight: bold;
      text-transform: uppercase;
      text-decoration: none;
      font-size: 18px;
    }
    
    .mobile-shop-now-button:hover {
        background-color: #cc0000;
        color: #fff;
    }
}

/* Video Thumbnail Styles */
.video-thumbnail {
  position: relative;
  overflow: hidden;
  cursor: pointer;
}

/* Make iframe fluid */
.video-thumbnail iframe {
  width: 100% !important;
}

/* Responsive tweaks */
@media (max-width: 767px) {
  .video-thumbnail,
  .video-thumbnail img,
  .video-thumbnail iframe {
    width: 100% !important;
  }
}
@media (min-width: 768px) and (max-width: 1024px) {
  .video-thumbnail iframe {
    height: 432px !important;
  }
}
@media (min-width: 1025px) and (max-width: 1366px) {
  .video-thumbnail iframe {
    height: 576px !important;
  }
}
@media (min-width: 1367px) {
  .video-thumbnail iframe {
    height: 695px !important;
  }
}
</style>

<main id="primary" class="site-main">
    <!-- Mobile layout (hidden by default on desktop) -->
    <div class="mobile-layout">
        <div class="container-fluid p-0">
            <div class="row no-gutters">
                <div class="col-12 text-center">
                    <!-- Bull image with SHOP NOW button below -->
                     <h1><span class="text-red">Bold</span> Gear for <span class="text-red">Bold</span> Enthusiasts</h1>
                    <div class="mobile-shop-now-container">
                        <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/bull_1.png" alt="Lamborghini Bull" class="img-fluid" />
                        <a href="/shop" class="mobile-shop-now-button">SHOP NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Desktop layout (hidden by default on mobile) -->
    <div class="desktop-layout">
        <div class="container-fluid p-0" style="padding-bottom: 200px;">
            <div class="row no-gutters">
                <div class="col-12 text-center">
                    <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/Big_LM_logo.png" alt="Lamborghini Merch Logo" class="img-fluid" />
                    <h1 style="font-family: 'Georgia', serif; font-style: italic;">Luxury Merch for Lambo Enthusiasts</h1>
                </div>
                
                <div class="col-12 text-center position-relative">
                    <!-- T-shirt box with SHOP NOW button overlay -->
                    <div class="shop-box-container">
                        <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/Shop_Box.png" alt="Lamborghini T-shirts for sale shop box" class="img-responsive centerimage" />
                        <a href="/shop" class="shop-now-button">SHOP NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="video-thumbnail" 
     data-video-id="j0858-3YQJc" 
     data-start="2">
  <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/Video.png"
       alt="Lamborghini Aventador SVJ Transformation"
       style="width:100%; display:block;">
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var thumbs = document.querySelectorAll('.video-thumbnail');
  thumbs.forEach(function(container) {
    container.addEventListener('click', function handler() {
      var videoId   = this.dataset.videoId;
      var startTime = this.dataset.start || 0;
      var w = this.offsetWidth;
      var h = w * 0.5625;  // 16:9

      var src = 'https://www.youtube.com/embed/' + videoId +
                '?autoplay=1&rel=0&start=' + startTime;

      this.innerHTML = '<iframe width="100%" ' +
                       'height="' + h + '" ' +
                       'src="' + src + '" ' +
                       'frameborder="0" ' +
                       'allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" ' +
                       'allowfullscreen></iframe>';

      this.style.cursor = 'default';
      this.removeEventListener('click', handler);
    });
  });
});
</script>

<?php
get_footer();
?>