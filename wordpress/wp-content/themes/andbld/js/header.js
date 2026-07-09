document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const mainMenuContainer = document.querySelector('.main-menucontainer');

    if (menuToggle && mainMenuContainer) {
        menuToggle.addEventListener('click', function() {
            mainMenuContainer.classList.toggle('active');
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', !isExpanded);
        });

        // メニュー項目をクリックしたときにメニューを閉じる
        const menuItems = mainMenuContainer.querySelectorAll('a');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                mainMenuContainer.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
            });
        });

        // 画面外をクリックしたときにメニューを閉じる
        document.addEventListener('click', function(event) {
            if (!mainMenuContainer.contains(event.target) && !menuToggle.contains(event.target)) {
                mainMenuContainer.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
}); 