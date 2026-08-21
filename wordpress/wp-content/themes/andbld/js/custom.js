/*
　読み込ませたいスクリプトはここに記載
	Description: JS Script
	Author: Tatsuya Nishida
*/

/*
	スクロールでクラス付与 
*/

jQuery(function($){
  $(window).on('scroll', function() {
    if ($(this).scrollTop() > 30) {
      $('.global-header').addClass('scrolled');
    } else {
      $('.global-header').removeClass('scrolled');
    }
  });
});

/*
	TOPに戻るボタンの制御
*/

jQuery(function($){
  var $backToTop = $('#back-to-top');
  var showThreshold = 300; // 300pxスクロールで表示
  var hideThreshold = 500; // 下部から500px以内で非表示
  
  $(window).on('scroll', function() {
    var scrollTop = $(this).scrollTop();
    var windowHeight = $(this).height();
    var documentHeight = $(document).height();
    var scrollBottom = documentHeight - scrollTop - windowHeight;
    
    // スクロール位置が300px以上で、かつ下部から500px以上離れている場合に表示
    if (scrollTop > showThreshold && scrollBottom > hideThreshold) {
      $backToTop.addClass('show');
    } else {
      $backToTop.removeClass('show');
    }
  });
  
  // スムーズスクロール
  $backToTop.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({
      scrollTop: 0
    }, 600);
  });
});

/*
  BLOGセクション 横スクロールナビ
*/
jQuery(function($){
  var $list      = $('.content-blog .blog-list');
  var $container = $('.content-blog .blog-scroll-container');
  var $prev      = $('.blog-scroll-prev');
  var $next      = $('.blog-scroll-next');

  if (!$list.length) return;

  // カード1枚分の幅を取得してスクロール量を決める
  function getCardWidth() {
    var $item = $list.find('.blog-item').first();
    if (!$item.length) return 0;
    var gap = parseInt($list.css('gap'), 10) || 30;
    return $item.outerWidth() + gap;
  }

  // ボタン・フェード状態を更新
  function updateNav() {
    var el = $list[0];
    var scrollLeft = $list.scrollLeft();
    var maxScroll  = el.scrollWidth - el.clientWidth;
    var atStart = scrollLeft <= 1;
    var atEnd   = maxScroll <= 1 || scrollLeft >= maxScroll - 1;

    $prev.toggleClass('is-hidden', atStart);
    $next.toggleClass('is-hidden', atEnd);
    $container.toggleClass('is-end', atEnd);
  }

  // 初期状態（レイアウト確定後）
  updateNav();
  $(window).on('load resize', updateNav);
  $list.on('scroll', updateNav);

  // 次へ：1カード分右へ smooth scroll
  $next.on('click', function(e) {
    e.preventDefault();
    $list.stop(true).animate({ scrollLeft: $list.scrollLeft() + getCardWidth() }, 350, updateNav);
  });

  // 前へ：1カード分左へ smooth scroll
  $prev.on('click', function(e) {
    e.preventDefault();
    $list.stop(true).animate({ scrollLeft: $list.scrollLeft() - getCardWidth() }, 350, updateNav);
  });

  // マウスドラッグによる横スクロール
  var isDragging  = false;
  var startX      = 0;
  var startScroll = 0;

  $list.on('mousedown', function(e) {
    // ナビボタン上ではドラッグ開始しない
    if ($(e.target).closest('.blog-scroll-btn').length) return;
    isDragging  = true;
    startX      = e.pageX;
    startScroll = $list.scrollLeft();
    $list.css('cursor', 'grabbing');
    e.preventDefault();
  });

  $(document).on('mousemove.blogScroll', function(e) {
    if (!isDragging) return;
    var dx = e.pageX - startX;
    $list.scrollLeft(startScroll - dx);
  });

  $(document).on('mouseup.blogScroll', function() {
    if (!isDragging) return;
    isDragging = false;
    $list.css('cursor', '');
    updateNav();
  });
});

