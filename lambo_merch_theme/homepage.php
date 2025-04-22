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

// Using CSS media queries for responsive design instead of PHP device detection
// We no longer need the PHP variable
?>

<main id="primary" class="site-main">
    <!-- Desktop Layout (hidden on mobile via CSS) -->
    <div class="container-fluid p-0 desktop-only" style="padding-bottom: 200px;">
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
    
    <!-- Mobile Layout (hidden on desktop via CSS) -->
    <div class="container-fluid p-0 mobile-only">
        <div class="row no-gutters">
            <div class="col-12 text-center">
                <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/Big_LM_logo.png" alt="Lamborghini Merch Logo" class="mobile-homepage-logo" />
                <h1 class="mobile-homepage-title" style="font-family: 'Georgia', serif; font-style: italic;">Luxury Merch for Lambo Enthusiasts</h1>
            </div>
            
            <div class="col-12 text-center">
                <!-- Bull image with SHOP NOW button overlay -->
                <div class="mobile-shop-now-container">
                    <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/bull_1.png" alt="Lamborghini Bull" class="img-fluid" />
                    <a href="/shop" class="mobile-shop-now-button">SHOP NOW</a>
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
  // Handle responsive display toggling
  function handleResponsiveDisplay() {
    var isMobile = window.matchMedia("(max-width: 767px)").matches;
    var desktopElements = document.querySelectorAll('.desktop-only');
    var mobileElements = document.querySelectorAll('.mobile-only');
    
    // Set visibility based on screen width
    desktopElements.forEach(function(el) {
      // Handle special display requirements for footer content
      if (el.classList.contains('row') && el.closest('.footer-widgets')) {
        // For footer rows, which need to display as flex
        el.style.display = isMobile ? 'none' : 'flex';
      } else {
        el.style.display = isMobile ? 'none' : 'block';
      }
      el.style.visibility = isMobile ? 'hidden' : 'visible';
    });
    
    mobileElements.forEach(function(el) {
      // Handle special display requirements for footer content
      if (el.classList.contains('row') && el.closest('.footer-widgets')) {
        // For footer rows, which need to display as flex
        el.style.display = isMobile ? 'flex' : 'none';
      } else {
        el.style.display = isMobile ? 'block' : 'none';
      }
      el.style.visibility = isMobile ? 'visible' : 'hidden';
    });
  }
  
  // Run on page load
  handleResponsiveDisplay();
  
  // Run on window resize
  window.addEventListener('resize', handleResponsiveDisplay);
  
  // Video thumbnail click handling
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

<style>
/* Video Thumbnail Styles */
.video-thumbnail {
  position: relative;
  overflow: hidden;
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
<?php
get_footer();

