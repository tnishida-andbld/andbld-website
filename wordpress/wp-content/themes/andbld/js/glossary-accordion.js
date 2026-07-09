/**
 * Glossary Table of Contents Accordion
 * 用語集の目次アコーディオン機能
 */

document.addEventListener('DOMContentLoaded', function() {
    // 目次要素を取得
    const tableOfContents = document.querySelector('.table-of-contents');
    
    if (!tableOfContents) {
        return; // 目次が存在しない場合は処理を終了
    }
    
    // 目次の内容を取得
    const tocContent = tableOfContents.innerHTML;
    
    // 目次の高さを制限するためのラッパーを作成
    const tocWrapper = document.createElement('div');
    tocWrapper.className = 'toc-accordion-wrapper';
    tocWrapper.style.position = 'relative';
    tocWrapper.style.overflow = 'hidden';
    tocWrapper.style.height = '200px'; // 初期表示高さ
    
    // 目次の内容をラッパーに移動
    tableOfContents.innerHTML = '';
    tableOfContents.appendChild(tocWrapper);
    tocWrapper.innerHTML = tocContent;
    
    // ボタンを作成
    const toggleButton = document.createElement('button');
    toggleButton.className = 'toc-toggle-btn';
    toggleButton.textContent = '目次を開く';
    toggleButton.style.cssText = `
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, #fff4f4);
        border: none;
        padding: 40px 20px 10px;
        cursor: pointer;
        color: var(--color-primary);
        transition: all 0.3s ease;
        font-size: 1rem;
        text-align: right;
        line-height: 40px;
        border-radius: 0 0 10px 10px;
    `;
    
    // ボタンを目次に追加
    tableOfContents.appendChild(toggleButton);
    
    // アコーディオン状態を管理
    let isExpanded = false;
    
    // ボタンクリックイベント
    toggleButton.addEventListener('click', function() {
        if (isExpanded) {
            // 閉じる
            tocWrapper.style.height = '200px';
            toggleButton.textContent = '目次を開く';
            toggleButton.style.background = 'linear-gradient(transparent, #fff4f4)';
            isExpanded = false;
        } else {
            // 開く
            const fullHeight = tocWrapper.scrollHeight;
            tocWrapper.style.height = fullHeight + 'px';
            toggleButton.textContent = '閉じる';
            toggleButton.style.background = 'linear-gradient(transparent, #fff4f4)';
            isExpanded = true;
        }
    });
    
    // 目次の高さが100px以下の場合はボタンを非表示
    function checkTocHeight() {
        if (tocWrapper.scrollHeight <= 100) {
            toggleButton.style.display = 'none';
            tocWrapper.style.height = 'auto';
        } else {
            toggleButton.style.display = 'block';
        }
    }
    
    // 初期チェック
    checkTocHeight();
    
    // ウィンドウリサイズ時に再チェック
    window.addEventListener('resize', checkTocHeight);
}); 