<?php
/**
 * Template Name: Contact Page Template
 *
 * This template is used for displaying the Contact page with mobile-specific adaptations.
 *
 * @package Lambo_Merch
 */

get_header();

// Generate random numbers for CAPTCHA
$captcha_num1 = rand(0, 20);
$captcha_num2 = rand(0, 20);
$captcha_answer = $captcha_num1 + $captcha_num2;

// Handle contact form submission
$contact_form_message = '';
$contact_form_success = false;

if ($_POST && isset($_POST['contact_form_nonce']) && wp_verify_nonce($_POST['contact_form_nonce'], 'contact_form_action')) {
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $message = sanitize_textarea_field($_POST['message']);
    $captcha_response = intval($_POST['captcha_answer']);
    $captcha_expected = intval($_POST['captcha_expected']);
    
    // Validate CAPTCHA first
    if ($captcha_response !== $captcha_expected) {
        $contact_form_message = 'Please solve the math problem correctly.';
    } elseif (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($message) && is_email($email)) {
        // Get admin email
        $admin_email = get_option('admin_email');
        
        // Email subject and headers
        $subject = 'New Contact Form Message from ' . get_bloginfo('name');
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        // Email body
        $email_body = '<html><body>';
        $email_body .= '<h2>New Contact Form Submission</h2>';
        $email_body .= '<p><strong>First Name:</strong> ' . esc_html($first_name) . '</p>';
        $email_body .= '<p><strong>Last Name:</strong> ' . esc_html($last_name) . '</p>';
        $email_body .= '<p><strong>Email:</strong> ' . esc_html($email) . '</p>';
        if (!empty($phone)) {
            $email_body .= '<p><strong>Phone:</strong> ' . esc_html($phone) . '</p>';
        }
        $email_body .= '<p><strong>Message:</strong><br>' . nl2br(esc_html($message)) . '</p>';
        $email_body .= '<p><strong>Date:</strong> ' . date('Y-m-d H:i:s') . '</p>';
        $email_body .= '<p><strong>Page:</strong> ' . get_permalink() . '</p>';
        $email_body .= '</body></html>';
        
        // Send email
        if (wp_mail($admin_email, $subject, $email_body, $headers)) {
            $contact_form_success = true;
            $contact_form_message = 'Thank you for your message! We\'ll get back to you soon.';
        } else {
            $contact_form_message = 'Sorry, there was an error sending your message. Please try again.';
        }
    } else {
        $contact_form_message = 'Please fill in all required fields with valid information.';
    }
}

// Include Mobile_Detect library if not already included
if (!class_exists('Mobile_Detect')) {
    require_once get_template_directory() . '/inc/mobile-detect.php';
}

$detect   = new Mobile_Detect;
$is_mobile = $detect->isMobile() && ! $detect->isTablet();
?>

<style>
/* Layout visibility control */
.mobile-layout { display: none; }
.desktop-layout { display: block; }

/* On narrow screens, swap */
@media (max-width: 767px) {
  .mobile-layout { display: block !important; }
  .desktop-layout { display: none !important; }
}

/* Remove number input arrows */
input[name="captcha_answer"]::-webkit-outer-spin-button,
input[name="captcha_answer"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[name="captcha_answer"] {
  -moz-appearance: textfield;
}
</style>

<main id="primary" class="site-main">

  <!-- Desktop version (hidden on mobile) -->
  <div class="desktop-layout">
    <div class="container">
      <!-- Get In Touch Header -->
      <div class="row">
        <div class="col-md-4 text-center">
          <img
            src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/Big_LM_logo.png"
            alt="Lambo Merch Logo"
            class="img-fluid"
            height="100%"
            width="auto"
          >
        </div>
        <div class="col-md-8" style="padding-left: 100px">
          <h1 class="page-title"><span class="text-red">Get In Touch</span></h1>
          <div class="shop-description">
            <p>
              <img
                src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/address_icon.png"
                alt="icon"
                class="img-fluid"
                height="25px"
                width="auto"
                style="vertical-align:middle;"
              >
              <b>ADDRESS:</b> 2027 Mayport Road Jacksonville, FL 32233
            </p>
            <p>
              <img
                src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/phone_icon.png"
                alt="icon"
                class="img-fluid"
                height="30px"
                width="auto"
                style="vertical-align:middle;"
              >
              <b>CUSTOMER SERVICE:</b> 1-877-639-6842
            </p>
            <p>
              <img
                src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/email_icon-e1745428693535.png"
                alt="icon"
                class="img-fluid"
                height="25px"
                width="auto"
                style="vertical-align:middle;"
              >
              <b>EMAIL:</b> support@lambomerch.com
            </p>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="row mt-5">
        <div class="col-12">
          <?php if (!empty($contact_form_message)): ?>
            <div style="margin-bottom: 20px; padding: 15px; border-radius: 5px; <?php echo $contact_form_success ? 'background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;' : 'background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;'; ?>">
              <?php echo esc_html($contact_form_message); ?>
            </div>
          <?php endif; ?>
          
          <div class="contact-form">
            <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
              <?php wp_nonce_field('contact_form_action', 'contact_form_nonce'); ?>
              
              <div class="row">
                <div class="col-md-6 mb-3">
                  <input type="text" name="first_name" placeholder="First Name" required
                         style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                         value="<?php echo isset($_POST['first_name']) ? esc_attr($_POST['first_name']) : ''; ?>">
                </div>
                <div class="col-md-6 mb-3">
                  <input type="text" name="last_name" placeholder="Last Name" required
                         style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                         value="<?php echo isset($_POST['last_name']) ? esc_attr($_POST['last_name']) : ''; ?>">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <input type="email" name="email" placeholder="Email" required
                         style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                         value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>">
                </div>
                <div class="col-md-6 mb-3">
                  <input type="tel" name="phone" placeholder="Phone"
                         style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                         value="<?php echo isset($_POST['phone']) ? esc_attr($_POST['phone']) : ''; ?>">
                </div>
              </div>
              <div class="row">
                <div class="col-12 mb-3">
                  <textarea name="message" placeholder="Message" rows="6" required
                            style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"><?php echo isset($_POST['message']) ? esc_textarea($_POST['message']) : ''; ?></textarea>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-md-4 mb-3 px-2">
                  <div style="
                    width:100%; height:50px; background:#444;
                    color:#ccc; display:flex; align-items:center;
                    justify-content:center; font-weight:bold; border-radius:0;
                    flex-direction:column; gap:2px; font-size:12px; padding:10px 5px 3px 5px;
                  ">
                    <span>What is <?php echo $captcha_num1; ?> + <?php echo $captcha_num2; ?>?</span>
                    <input type="text" name="captcha_answer" required style="
                      width:50px; height:18px; background:#666; border:none; 
                      color:#fff; text-align:center; font-size:11px;
                    " placeholder="?" 
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    <input type="hidden" name="captcha_expected" value="<?php echo $captcha_answer; ?>">
                  </div>
                </div>
                <div class="col-md-8 mb-3 px-2">
                  <button type="submit" style="
                    width:100%; height:50px; background:#ff0000;
                    color:#fff; border:none; display:flex;
                    align-items:center; justify-content:center;
                    font-weight:bold; border-radius:0;
                  ">SEND IT</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile version (hidden on desktop/tablet) -->
  <div class="mobile-layout">
    <div class="container">
      <!-- Header & Info centered; logo omitted -->
      <div class="row">
        <div class="col-12 text-center">
          <h1 class="page-title mobile-title"><span class="text-red">Get In Touch</span></h1>
          <div class="shop-description">
            <p>
              <img
                src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/address_icon.png"
                alt="icon" class="img-fluid" height="25px" width="auto"
                style="vertical-align:middle;"
              >
              <b>ADDRESS:</b> 2027 Mayport Road Jacksonville, FL 32233
            </p>
            <p>
              <img
                src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/phone_icon.png"
                alt="icon" class="img-fluid" height="30px" width="auto"
                style="vertical-align:middle;"
              >
              <b>CUSTOMER SERVICE:</b> 
              1-877-639-6842
            </p>
            <p>
              <img
                src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/email_icon-e1745428693535.png"
                alt="icon" class="img-fluid" height="25px" width="auto"
                style="vertical-align:middle;"
              >
              <b>EMAIL:</b> support@lambomerch.com
            </p>
          </div>
        </div>
      </div>

      <!-- Form stacked vertically for mobile -->
      <div class="row mt-4">
        <div class="col-12">
          <?php if (!empty($contact_form_message)): ?>
            <div style="margin-bottom: 20px; padding: 15px; border-radius: 5px; <?php echo $contact_form_success ? 'background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;' : 'background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;'; ?>">
              <?php echo esc_html($contact_form_message); ?>
            </div>
          <?php endif; ?>
          
          <div class="contact-form">
            <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
              <?php wp_nonce_field('contact_form_action', 'contact_form_nonce'); ?>
              
              <div style="margin-bottom:10px;">
                <input type="text" name="first_name" placeholder="First Name" required
                       style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                       value="<?php echo isset($_POST['first_name']) ? esc_attr($_POST['first_name']) : ''; ?>">
              </div>
              <div style="margin-bottom:10px;">
                <input type="text" name="last_name" placeholder="Last Name" required
                       style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                       value="<?php echo isset($_POST['last_name']) ? esc_attr($_POST['last_name']) : ''; ?>">
              </div>
              <div style="margin-bottom:10px;">
                <input type="email" name="email" placeholder="Email" required
                       style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                       value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>">
              </div>
              <div style="margin-bottom:10px;">
                <input type="tel" name="phone" placeholder="Phone"
                       style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                       value="<?php echo isset($_POST['phone']) ? esc_attr($_POST['phone']) : ''; ?>">
              </div>
              <div style="margin-bottom:20px;">
                <textarea name="message" placeholder="Message" rows="6" required
                          style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"><?php echo isset($_POST['message']) ? esc_textarea($_POST['message']) : ''; ?></textarea>
              </div>
              <div style="display:flex; gap:10px;">
                <div style="flex:0 0 60%;">
                  <div style="
                    width:100%; height:50px; background:#444;
                    color:#ccc; display:flex; align-items:center;
                    justify-content:center; font-weight:bold; border-radius:0;
                    flex-direction:column; gap:1px; font-size:10px; padding:5px 3px 3px 3px;
                  ">
                    <span>What is <?php echo $captcha_num1; ?> + <?php echo $captcha_num2; ?>?</span>
                    <input type="text" name="captcha_answer" required style="
                      width:35px; height:16px; background:#666; border:none; 
                      color:#fff; text-align:center; font-size:10px;
                    " placeholder="?" 
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    <input type="hidden" name="captcha_expected" value="<?php echo $captcha_answer; ?>">
                  </div>
                </div>
                <div style="flex:1;">
                  <button type="submit" style="
                    width:100%; height:50px; background:#ff0000;
                    color:#fff; border:none; display:flex;
                    align-items:center; justify-content:center;
                    font-weight:bold; border-radius:0;
                  ">SEND IT</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>

<!-- Video Section (unchanged) -->
<div
  class="video-thumbnail"
  data-video-id="j0858-3YQJc"
  data-start="2"
>
  <img
    src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/Video.png"
    alt="Lamborghini Aventador SVJ Transformation"
    style="width:100%; display:block;"
  >
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>

<style>
.video-thumbnail iframe { width:100% !important; }

/* Responsive heights */
@media (max-width:767px) {
  .video-thumbnail,
  .video-thumbnail img,
  .video-thumbnail iframe {
    width:100% !important;
  }
}
@media (min-width:768px) and (max-width:1024px) {
  .video-thumbnail iframe { height:432px !important; }
}
@media (min-width:1025px) and (max-width:1366px) {
  .video-thumbnail iframe { height:576px !important; }
}
@media (min-width:1367px) {
  .video-thumbnail iframe { height:695px !important; }
}
</style>

<?php get_footer(); ?>
