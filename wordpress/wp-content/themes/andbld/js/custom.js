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

