<?php
/**
 * Template Name: Contact Page Template
 *
 * This template is used for displaying the Contact page with mobile-specific adaptations.
 *
 * @package Lambo_Merch
 */

get_header();

// Include Mobile_Detect library if not already included
if (!class_exists('Mobile_Detect')) {
    require_once get_template_directory() . '/inc/mobile-detect.php';
}

$detect   = new Mobile_Detect;
$is_mobile = $detect->isMobile() && ! $detect->isTablet();
?>

<style>.mobile-layout{display:none}.desktop-layout{display:block}#wpforms-741{max-width:800px!important;margin:0 auto!important}#wpforms-741 .wpforms-field input,#wpforms-741 .wpforms-field textarea{width:100%!important;background:#282828!important;border:none!important;color:#fff!important;padding:12px 15px!important;border-radius:4px!important;font-size:14px!important;display:block!important;margin:0 0 16px!important}#wpforms-741 .wpforms-field-row{display:flex!important;justify-content:space-between!important;flex-wrap:wrap!important;margin-bottom:16px!important}#wpforms-741 .wpforms-one-half{width:48%!important;margin:0 1%!important}#wpforms-741 .wpforms-field-label{font-size:16px!important;color:#fff!important;font-weight:600!important;margin-bottom:8px!important}#wpforms-741 ::-webkit-input-placeholder{color:#fff!important}#wpforms-741 :-moz-placeholder{color:#fff!important;opacity:1!important}#wpforms-741 ::-moz-placeholder{color:#fff!important;opacity:1!important}#wpforms-741 :-ms-input-placeholder{color:#fff!important}#wpforms-741 ::placeholder{color:#fff!important}#wpforms-741 .wpforms-field input:focus,#wpforms-741 .wpforms-field textarea:focus{outline:#ff0000 solid 2px!important}#wpforms-741 .wpforms-submit{background:red!important;color:#fff!important;border:none!important;padding:12px 30px!important;font-weight:600!important;display:block!important;margin:20px auto!important;cursor:pointer!important;width:auto!important}.video-thumbnail iframe{width:100%!important}@media (max-width:767px){.mobile-layout{display:block!important}.desktop-layout{display:none!important}.video-thumbnail,.video-thumbnail iframe,.video-thumbnail img{width:100%!important}}@media (min-width:768px) and (max-width:1024px){.video-thumbnail iframe{height:432px!important}}@media (min-width:1025px) and (max-width:1366px){.video-thumbnail iframe{height:576px!important}}@media (min-width:1367px){.video-thumbnail iframe{height:695px!important}}#wpforms-741 .wpforms-field-row.wpforms-field-medium,#wpforms-741 input.wpforms-field-medium,#wpforms-741 select.wpforms-field-medium,.wp-core-ui #wpforms-741 .wpforms-field-row.wpforms-field-medium,.wp-core-ui #wpforms-741 input.wpforms-field-medium,.wp-core-ui #wpforms-741 select.wpforms-field-medium{max-width:none!important;width:100%!important}

/* Hide Contact Form 7 invisible captcha initially */
.cf7ic_instructions {
  display: none!important;
  transition: all 0.3s ease;
}

/* Show captcha when email field has been interacted with */
#wpforms-741.form-activated .cf7ic_instructions,
#wpforms-741 .wpforms-field-email input:not(:placeholder-shown) ~ .cf7ic_instructions,
#wpforms-741 .wpforms-field-email input:focus ~ .cf7ic_instructions,
#wpforms-741 .wpforms-field-email:focus-within .cf7ic_instructions {
  display: block!important;
}

/* Hide captcha wrapper span initially */
.wpcf7-form-control-wrap.cf7ic-wpf.kc_captcha,
.wpcf7-form-control-wrap.cf7ic-wpf,
.wpcf7-form-control-wrap.kc_captcha {
  display: none!important;
  height: 0!important;
  margin: 0!important;
  padding: 0!important;
  transition: all 0.3s ease;
}

/* Show captcha wrapper when email field has been interacted with */
#wpforms-741.form-activated .wpcf7-form-control-wrap.cf7ic-wpf.kc_captcha,
#wpforms-741.form-activated .wpcf7-form-control-wrap.cf7ic-wpf,
#wpforms-741.form-activated .wpcf7-form-control-wrap.kc_captcha,
#wpforms-741 .wpforms-field-email input:not(:placeholder-shown) ~ .wpcf7-form-control-wrap.cf7ic-wpf.kc_captcha,
#wpforms-741 .wpforms-field-email input:not(:placeholder-shown) ~ .wpcf7-form-control-wrap.cf7ic-wpf,
#wpforms-741 .wpforms-field-email input:not(:placeholder-shown) ~ .wpcf7-form-control-wrap.kc_captcha,
#wpforms-741 .wpforms-field-email input:focus ~ .wpcf7-form-control-wrap.cf7ic-wpf.kc_captcha,
#wpforms-741 .wpforms-field-email input:focus ~ .wpcf7-form-control-wrap.cf7ic-wpf,
#wpforms-741 .wpforms-field-email input:focus ~ .wpcf7-form-control-wrap.kc_captcha,
#wpforms-741 .wpforms-field-email:focus-within .wpcf7-form-control-wrap.cf7ic-wpf.kc_captcha,
#wpforms-741 .wpforms-field-email:focus-within .wpcf7-form-control-wrap.cf7ic-wpf,
#wpforms-741 .wpforms-field-email:focus-within .wpcf7-form-control-wrap.kc_captcha {
  display: block!important;
  height: auto!important;
  margin: 10px 0!important;
  padding: 10px!important;
}
</style>

<main id="primary" class="site-main">

  <!-- Desktop version -->
  <div class="desktop-layout">
    <div class="container">
      <div class="row">
        <div class="col-md-4 text-center">
          <img
            src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/Big_LM_logo.png"
            alt="Lambo Merch Logo"
            class="img-fluid"
            width="auto"
            height="100%">
        </div>
        <div class="col-md-8" style="padding-left:100px;">
          <h1 class="page-title"><span class="text-red">Get In Touch</span></h1>
          <div class="shop-description">
            <p>
              <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/address_icon.png"
                   alt="icon" class="img-fluid" height="25px" style="vertical-align:middle;">
              <b>ADDRESS:</b> 2027 Mayport Road Jacksonville, FL 32233
            </p>
            <p>
              <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/phone_icon.png"
                   alt="icon" class="img-fluid" height="30px" style="vertical-align:middle;">
              <b>CUSTOMER SERVICE:</b> 1-877-639-6842
            </p>
            <p>
              <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/email_icon-e1745428693535.png"
                   alt="icon" class="img-fluid" height="25px" style="vertical-align:middle;">
              <b>EMAIL:</b> support@lambomerch.com
            </p>
          </div>
        </div>
      </div>

      <!-- WPForms embed -->
      <div class="row mt-5">
        <div class="col-12 wpforms-container">
          <?php echo do_shortcode('[wpforms id="741" title="false" description="false"]'); ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile version -->
  <div class="mobile-layout">
    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <h1 class="page-title mobile-title"><span class="text-red">Get In Touch</span></h1>
          <div class="shop-description">
            <p>
              <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/address_icon.png"
                   alt="icon" class="img-fluid" height="25px" style="vertical-align:middle;">
              <b>ADDRESS:</b> 2027 Mayport Road Jacksonville, FL 32233
            </p>
            <p>
              <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/phone_icon.png"
                   alt="icon" class="img-fluid" height="30px" style="vertical-align:middle;">
              <b>CUSTOMER SERVICE:</b> 1-877-639-6842
            </p>
            <p>
              <img src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/email_icon-e1745428693535.png"
                   alt="icon" class="img-fluid" height="25px" style="vertical-align:middle;">
              <b>EMAIL:</b> support@lambomerch.com
            </p>
          </div>
        </div>
      </div>

      <!-- WPForms on mobile -->
      <div class="row mt-4">
        <div class="col-12 wpforms-container">
          <?php echo do_shortcode('[wpforms id="741" title="false" description="false"]'); ?>
        </div>
      </div>
    </div>
  </div>

</main>

<!-- Video Section -->
<div class="video-thumbnail" data-video-id="j0858-3YQJc" data-start="2">
  <img
    src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/Video.png"
    alt="Lamborghini Aventador SVJ Transformation"
    style="width:100%; display:block;">
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Video thumbnail functionality
    document.querySelectorAll('.video-thumbnail').forEach(function(container) {
      container.addEventListener('click', function handler() {
        var id    = this.dataset.videoId,
            start = this.dataset.start || 0,
            w     = this.offsetWidth,
            h     = w * 0.5625,
            src   = 'https://www.youtube.com/embed/' + id +
                    '?autoplay=1&rel=0&start=' + start;
        this.innerHTML =
          '<iframe width="100%" height="' + h + '" src="' + src + '" ' +
          'frameborder="0" allow="accelerometer; autoplay; clipboard-write; ' +
          'encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        this.style.cursor = 'default';
        this.removeEventListener('click', handler);
      });
    });

    // Handle captcha visibility for WPForms 741 - trigger on ANY field interaction
    const wpForm = document.getElementById('wpforms-741');
    if (wpForm) {
        const allInputs = wpForm.querySelectorAll('input, textarea, select');
        allInputs.forEach(function(input) {
            input.addEventListener('focus', function() {
                wpForm.classList.add('form-activated');
            });
            
            input.addEventListener('input', function() {
                if (this.value.length > 0) {
                    wpForm.classList.add('form-activated');
                }
            });
        });
    }
  });
</script>

<?php get_footer(); ?>