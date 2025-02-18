
var timer = false;
var winTop;
var winHeight;
var mediaQuery_mobile = 768;

$(document).ready(function(){

  setZoom();

  // gNav toggle
  // ------------------------------------------------
  $('.menuToggle a').click(function(){
    currentScroll = $(window).scrollTop();
    if($(this).hasClass('opened')){
      $('body').css({
        position : 'relative',
        top: 'inherit'
      });
      $('html, body').prop({scrollTop: currentScroll});
    }else{
      $('body').css({
        top: -1 * currentScroll
      });
    }
    $('.menuToggle a').toggleClass('opened');
    $('.spNav').toggle();
    $('body').toggleClass('menu-on');
    return false;
  });

  $('.spNav .parentNav>a').click(function(){
    $(this).toggleClass('active');
		$(this).next('ul').toggle();
    return false;
  });

  $('.spNav input#s').focus(function(){
    $(this).addClass('inputFocus');
  });
  $('.spNav input#s').blur(function(){
    if($(this).val() == ""){
      $(this).removeClass('inputFocus');
    }
  });
  // ------------------------------------------------

  // event single tab
  // ------------------------------------------------
  $('.tabIndex a').click(function(){
    $(this).toggleClass('tabOpened');
    $(this).parent().next('.tabDetail').toggleClass('tabDetailOpened');
    setZoom();
    return false;
  });
  // ------------------------------------------------

  // event calendar Yeaer, Month
  // ------------------------------------------------
  $('.pullDownCurrent>a').each(function(){
    $(this).click(function(){
      var selectThemeTopPos = parseInt( $(this).css('top') );
  		var selectThemeHeight = parseInt( $(this).height() + selectThemeTopPos );
      $(this).parent().next('.pullDownSchedule').css('top', selectThemeHeight);
  		$(this).parent().next('.pullDownSchedule').toggle();
  		return false;
    });
  });

  // if($('.selectYearMonth').is(':visible')){
	// }
  $('.pullDownSchedule li>a').click(function(){
    $(this).removeAttr( 'class' );
    var selectedTheme = $(this).text();
    var themeName = $(this).attr( 'class' );
    $(this).addClass( 'selected ' + themeName ).text( selectedTheme );
    setTimeout(function(){
      $(this).next('.pullDownSchedule').hide();
    },100);
  });

  // ------------------------------------------------
  init();
});


// リサイズ
//-----------------------------------------------------------
$(window).resize(function() {
	// init();
  setZoom();
  if (timer !== false) {
    clearTimeout(timer);
  }
  timer = setTimeout(function() {
	// map.setCenter(cemeteryLatlng); //gmapsを中心に移動させる
	init();
	}, 50);
});

//initialize
//-----------------------------------------------------------
function init(){
	$('.fixHeight').fixHeight();
	setClassbyWidth();
  setIndexKeyImage();
  setTable();
  toggleMenu();
  if(getBrowserWidth() >= mediaQuery_mobile){
  }else{
  }
}

function setClassbyWidth(){
	if(getBrowserWidth() >= mediaQuery_mobile){
		$('html').addClass('desktopSize');
		$('html').removeClass('mobileSize');
	}else{
		$('html').removeClass('desktopSize');
		$('html').addClass('mobileSize');
	}
}

function setTable(){
	if($('.mobileSize').length){
		// テーブル
		if( !$('.free_area table.seted').length ){

			$('.free_area table').not('.notFormat').each(function(){

				$(this).find('tbody td').each(function(){
					var tdText = $(this).html();
					$(this).text(' ');
					$(this).append('<div class="contentTd" />');
					$(this).find('.contentTd').html(tdText);
				});

				$(this).find('thead tr th').each(function(){
          var trEq = $(this).parent('tr').index();
          var midashiEq = parseInt($(this).index());

          var thRowspan = 0;
          var attrThRow = $(this).attr("rowspan");
          if( typeof attrThRow !== 'undefined' && attrThRow !== false ){
            thRowspan = parseInt($(this).attr('rowspan'));
          }

          var thColspan = 0;
          var attrThCol = $(this).attr("colspan");
          if( typeof attrThCol !== 'undefined' && attrThCol !== false ){
            if( midashiEq ) thColspan = parseInt($(this).attr('colspan'));
          }

					var midashi = '<font class="midashi">' + $(this).text() + '</font>';
          // thead 1つめ以降のtr
          if(trEq>0){
            var midashiTag = midashi;
          }else{
            var midashiTag = '<div class="midashiTh">' + midashi + '</div>';
          }

          var nextTbody = $(this).parents('thead').next('tbody');
					var nextTbodyTR = $(this).parents('thead').next('tbody').find('tr');
					// var cloneTarget = '';

          nextTbodyTR.each(function(){

            // 縦に続く場合
            var tdRowspan = 0;
            var tdRowspanTrIndex = 0;
            var targetTd = $(this).find('td');
            var attrTdRow = targetTd.eq(midashiEq).attr("rowspan");
            if( typeof attrTdRow !== 'undefined' && attrTdRow !== false ){
              targetTd.eq(midashiEq).addClass('hasRow');
              tdRowspan = parseInt(targetTd.eq(midashiEq).attr('rowspan'));
              tdRowspanTrIndex = parseInt($(this).index());
              for (var next = 1; next < tdRowspan; next++) {
                nextTbody.find('tr').eq((tdRowspanTrIndex + next)).addClass('hasRowTR');
              }
            }

            // 横に続く場合
            if(thColspan){
              targetTd.eq(midashiEq).addClass('colMaster');
              for (var i = midashiEq; i <= thColspan; i++) {
                targetTd.eq( i+1 ).addClass('colCopy').prepend(midashiTag);
              }
            }

            // チケットのテーブル
            if($(this).hasClass('hasRowTR') && nextTbodyTR.parents('table').hasClass('ticket_table')){
              if(midashiEq > 0){
                if(trEq>0){
                  targetTd.not('.table_item').eq(midashiEq).find('.midashiTh').append(midashiTag);
                }else{
                  if(!nextTbodyTR.parents('table').hasClass('line1')){
                    targetTd.not('.colCopy').not('.table_item:nth-of-type(2)').eq(midashiEq-1).prepend(midashiTag);
                  }else{
                    targetTd.not('.colCopy').not('.table_item:nth-of-type(1)').eq(midashiEq-1).prepend(midashiTag);
                  }
                }
              }

            // それ以外
            }else{
              if(trEq>0){
                targetTd.not('.table_item').eq(midashiEq).find('.midashiTh').append(midashiTag);
              }else{
                if(!nextTbodyTR.parents('table').hasClass('line1')){
                  targetTd.not('.colCopy').not('.table_item:nth-of-type(2)').eq(midashiEq).prepend(midashiTag);
                }else{
                  targetTd.not('.colCopy').not('.table_item:nth-of-type(1)').eq(midashiEq).prepend(midashiTag);
                }
              }

            }
          });

					// midashi.clone(true).prependTo( cloneTarget );
				});
			});

			$('.free_area table').addClass('seted');
		}

	}else{

	}
}

//モニタの幅を取得
function getBrowserWidth(){
  if (window.innerWidth){
		return window.innerWidth;
	}else if(document.documentElement && document.documentElement.clientWidth != 0){
		return document.documentElement.clientWidth;
	}else if(document.body){
		return document.body.clientWidth;
	}return 0;
}

//モニタの高さを取得
function getBrowserHeight(){
  if (window.innerHeight){
		return window.innerHeight;
	}else if(document.documentElement && document.documentElement.clientHeight != 0){
		return document.documentElement.clientHeight;
	}else if(document.body){
		return document.body.clientHeight;
	}return 0;
}

function setIndexKeyImage(){
  if($('.indexKeyImage').length){
    $('.mobileSize .indexKeyImage').css('height', getBrowserWidth() * 0.525);
    $('.desktopSize .indexKeyImage').css('height', 454);
  }
}

function toggleMenu(){
}

function setZoom(){
  $('.zoom').each(function(){
    $.fn.responsiveTable = (function() {
      var $window = $(window);
      return function() {
        var $el = this;
        // var $zoomTarget = this.find('>table');
        var $zoomTarget = this.find('>.zoom--target');
        var onResize = function() {
          var width = $zoomTarget.outerWidth();
          var height = $zoomTarget.outerHeight();
          var $parent = $el.parent();
          var containerWidth = $parent.width();
          var ratio = containerWidth / width;
          if (ratio < 1) {
            $el.height( height * ratio );
            $zoomTarget.css('transform', 'scale(' + ratio + ')');
          } else {
            $el.height('');
            $zoomTarget.css('transform', '');
          }
        };
        $zoomTarget.css('transformOrigin', '0 0');
        $window.on('resize', onResize);
        onResize();
      };
    }());
    $(this).responsiveTable();
  });
}