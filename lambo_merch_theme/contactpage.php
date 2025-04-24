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

$detect = new Mobile_Detect;
// Check if user is on a mobile device
$is_mobile = $detect->isMobile() && !$detect->isTablet();
?>

<main id="primary" class="site-main">
<?php if (!$is_mobile): ?>
<!-- Desktop layout -->
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
                    > <b>ADDRESS:</b> 2027 Mayport Road Jacksonville, FL 32233
                </p>
                <p>
                    <img
                        src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/phone_icon.png"
                        alt="icon"
                        class="img-fluid"
                        height="30px"
                        width="auto"
                        style="vertical-align:middle;"
                    > <b>CUSTOMER SERVICE:</b> 1-877-639-6842
                </p>
                <p>
                    <img
                        src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/email_icon-e1745428693535.png"
                        alt="icon"
                        class="img-fluid"
                        height="25px"
                        width="auto"
                        style="vertical-align:middle;"
                    > <b>EMAIL:</b> support@lambomerch.com
                </p>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="contact-form">
                <form action="#" method="post">
                    <!-- name / contact fields -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input
                                type="text"
                                name="first_name"
                                placeholder="First Name"
                                required
                                style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                            >
                        </div>
                        <div class="col-md-6 mb-3">
                            <input
                                type="text"
                                name="last_name"
                                placeholder="Last Name"
                                required
                                style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                            >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input
                                type="email"
                                name="email"
                                placeholder="Email"
                                required
                                style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                            >
                        </div>
                        <div class="col-md-6 mb-3">
                            <input
                                type="tel"
                                name="phone"
                                placeholder="Phone"
                                style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                            >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <textarea
                                name="message"
                                placeholder="Message"
                                rows="6"
                                required
                                style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                            ></textarea>
                        </div>
                    </div>

                    <!-- CAPTCHA + SEND IT side-by-side under the form -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div
                                style="
                                    width:100%;
                                    height:50px;
                                    background:#444;
                                    color:#ccc;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    font-weight:bold;
                                    border-radius:0;
                                "
                            >CAPTCHA
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button
                                type="submit"
                                style="
                                    width:100%;
                                    height:50px;
                                    background:#ff0000;
                                    color:#fff;
                                    border:none;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    font-weight:bold;
                                    border-radius:0;
                                "
                            >SEND IT
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<!-- Mobile layout with centered content and no logo -->
<div class="container">
    <!-- Get In Touch Header - Centered without logo -->
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="page-title"><span class="text-red">Get In Touch</span></h1>
            <div class="shop-description text-center" style="margin-top: 20px;">
                <p>
                    <img
                        src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/address_icon.png"
                        alt="icon"
                        class="img-fluid"
                        height="25px"
                        width="auto"
                        style="vertical-align:middle;"
                    > <b>ADDRESS:</b> 2027 Mayport Road Jacksonville, FL 32233
                </p>
                <p>
                    <img
                        src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/phone_icon.png"
                        alt="icon"
                        class="img-fluid"
                        height="30px"
                        width="auto"
                        style="vertical-align:middle;"
                    > <b>CUSTOMER SERVICE:</b> 1-877-639-6842
                </p>
                <p>
                    <img
                        src="http://lambomerch.madefreshdev.cloud/wp-content/uploads/2025/04/email_icon-e1745428693535.png"
                        alt="icon"
                        class="img-fluid"
                        height="25px"
                        width="auto"
                        style="vertical-align:middle;"
                    > <b>EMAIL:</b> support@lambomerch.com
                </p>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="contact-form">
                <form action="#" method="post">
                    <!-- name / contact fields -->
                    <div class="row">
                        <div class="col-12 mb-3">
                            <input
                                type="text"
                                name="first_name"
                                placeholder="First Name"
                                required
                                style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                            >
                        </div>
                        <div class="col-12 mb-3">
                            <input
                                type="text"
                                name="last_name"
                                placeholder="Last Name"
                                required
                                style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                            >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <input
                                type="email"
                                name="email"
                                placeholder="Email"
                                required
                                style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                            >
                        </div>
                        <div class="col-12 mb-3">
                            <input
                                type="tel"
                                name="phone"
                                placeholder="Phone"
                                style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                            >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <textarea
                                name="message"
                                placeholder="Message"
                                rows="6"
                                required
                                style="width:100%; background:#282828; border:none; color:#fff; padding:12px 15px;"
                            ></textarea>
                        </div>
                    </div>

                    <!-- CAPTCHA + SEND IT stacked with padding -->
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div
                                style="
                                    width:100%;
                                    height:50px;
                                    background:#444;
                                    color:#ccc;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    font-weight:bold;
                                    border-radius:0;
                                "
                            >CAPTCHA
                            </div>
                        </div>
                        <div class="col-12">
                            <button
                                type="submit"
                                style="
                                    width:100%;
                                    height:50px;
                                    background:#ff0000;
                                    color:#fff;
                                    border:none;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    font-weight:bold;
                                    border-radius:0;
                                "
                            >SEND IT
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
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
            var id = this.dataset.videoId,
                start = this.dataset.start || 0,
                w = this.offsetWidth,
                h = w * 0.5625,
                src = 'https://www.youtube.com/embed/' + id +
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
.video-thumbnail iframe {
    width:100% !important;
}
/* Responsive heights */
@media (max-width:767px) {
    .video-thumbnail, .video-thumbnail img, .video-thumbnail iframe {
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