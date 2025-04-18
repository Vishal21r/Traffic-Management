document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mainNav = document.getElementById('mainNav');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
    
    if (mobileMenuToggle && mainNav && mobileMenuOverlay) {
        mobileMenuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            mobileMenuOverlay.classList.toggle('active');
            document.body.classList.toggle('menu-open');
        });
        
        mobileMenuOverlay.addEventListener('click', function() {
            mainNav.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
            document.body.classList.remove('menu-open');
        });
    }
    
    // Mobile dropdown toggle
    const dropdownItems = document.querySelectorAll('.has-dropdown > a');
    
    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            if (window.innerWidth <= 992) {
                e.preventDefault();
                this.parentNode.classList.toggle('active');
            }
        });
    });
});
