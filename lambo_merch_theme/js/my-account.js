/**
 * Custom JavaScript for My Account pages
 */
document.addEventListener('DOMContentLoaded', function() {
    // Make navigation links styled properly when active
    const navLinks = document.querySelectorAll('.woocommerce-MyAccount-navigation-link a');
    navLinks.forEach(link => {
        if (link.parentElement.classList.contains('is-active')) {
            link.setAttribute('aria-current', 'page');
        }
    });

    // Toggle responsive navigation for small screens
    const navToggle = document.querySelector('.my-account-nav-toggle');
    if (navToggle) {
        navToggle.addEventListener('click', function() {
            const navigation = document.querySelector('.woocommerce-MyAccount-navigation');
            navigation.classList.toggle('is-open');
        });
    }

    // Remove duplicated h2 title
    const contentH2 = document.querySelector('.woocommerce-MyAccount-content > h2:first-child');
    if (contentH2) {
        contentH2.style.display = 'none';
    }

    // Add confirm dialog to payment method deletion
    const deleteButtons = document.querySelectorAll('.delete-method');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to remove this payment method?')) {
                e.preventDefault();
            }
        });
    });

    // Add confirm dialog to address deletion
    const addressDeleteButtons = document.querySelectorAll('.woocommerce-address-fields__field-wrapper button[name="delete"]');
    addressDeleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this address?')) {
                e.preventDefault();
            }
        });
    });


    // Password visibility toggle using checkboxes
    const passwordCheckboxes = document.querySelectorAll('.show-password-checkbox');
    
    passwordCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // Get the id of this checkbox to determine which password field to toggle
            const checkboxId = this.id;
            let passwordInputId;
            
            // Map checkbox IDs to their corresponding password input IDs
            if (checkboxId === 'show_password_current') {
                passwordInputId = 'password_current';
            } else if (checkboxId === 'show_password_1') {
                passwordInputId = 'password_1';
            } else if (checkboxId === 'show_password_2') {
                passwordInputId = 'password_2';
            } else if (checkboxId === 'show_login_password') {
                passwordInputId = 'password';
            } else if (checkboxId === 'show_reg_password') {
                passwordInputId = 'reg_password';
            }
            
            // Get the password input by ID
            const passwordInput = document.getElementById(passwordInputId);
            
            if (passwordInput) {
                if (this.checked) {
                    passwordInput.type = 'text';
                } else {
                    passwordInput.type = 'password';
                }
            }
        });
    });
    
    // Remove any remaining old show-password-input buttons
    document.querySelectorAll('button.show-password-input').forEach(button => {
        button.remove();
    });
});