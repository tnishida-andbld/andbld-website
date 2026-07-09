document.addEventListener('DOMContentLoaded', function() {
    const bgImages = document.querySelectorAll('.fv-bg-image');
    
    if (!bgImages.length) return;
    
    let currentIndex = 0;
    let changeInterval;
    const changeDuration = 4000; // 8秒間隔で切り替え
    
    // 背景画像切り替え関数
    function changeBackground() {
        // 現在の画像を非アクティブに
        bgImages[currentIndex].classList.remove('active');
        bgImages[currentIndex].classList.add('next');
        
        // 次の画像のインデックスを計算
        currentIndex = (currentIndex + 1) % bgImages.length;
        
        // 次の画像をアクティブに
        bgImages[currentIndex].classList.remove('next');
        bgImages[currentIndex].classList.add('active');
        
        // 前の画像のクラスをクリア
        setTimeout(() => {
            const prevIndex = (currentIndex - 1 + bgImages.length) % bgImages.length;
            bgImages[prevIndex].classList.remove('next');
        }, 2000);
    }
    
    // 自動切り替え開始
    function startAutoChange() {
        changeInterval = setInterval(changeBackground, changeDuration);
    }
    
    // 自動切り替え停止
    function stopAutoChange() {
        clearInterval(changeInterval);
    }
    
    // 初期化
    startAutoChange();
    
    // ページが非表示になった時に自動切り替えを停止
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopAutoChange();
        } else {
            startAutoChange();
        }
    });
    
    // 画像のプリロード（パフォーマンス向上）
    bgImages.forEach((img, index) => {
        if (index > 0) { // 最初の画像以外をプリロード
            const imgUrl = img.style.backgroundImage.replace(/url\(['"]?(.*?)['"]?\)/i, '$1');
            const preloadImg = new Image();
            preloadImg.src = imgUrl;
        }
    });
}); 