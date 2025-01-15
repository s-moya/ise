// JavaScript Document
// IE11の判定
$(function(){

	//UserAgent
	var ua=window.navigator.userAgent;

	var browserIE=false;//IE判定
	var browser_v=0;//IEバージョン番号
	var browser_nm="";//browser名

	//IE判定
	if(ua.match(/MSIE/) || ua.match(/Trident/)) {
		//MSIE=7 8 9 10/Trident=11
		browserIE=true;
		if(ua.match(/MSIE/)){
			// browser_v=parseFloat(ua.match(/(MSIE¥s|rv:)([¥d¥.]+)/)[2]);
		}else{
			browser_v = ua.match(/(msie\s|rv:)([\d\.]+)/)[2];
		}
	}
	if (browserIE) {browser_nm="IE";}

	//IE以外は該当の文字があれば判定
	else if (ua.indexOf("Edge") > -1) {browser_nm="Edge";}
	else if (ua.indexOf("Firefox") > -1) {browser_nm="Firefox";}
	else if (ua.indexOf("Chrome") > -1) {browser_nm="Chrome";}
	else if (ua.indexOf("Opera") > -1) {browser_nm="Opera";}
	else if (ua.indexOf("Safari") > -1) {browser_nm="Safari";}
	else {browser_nm="Unknown";}

	var v_text="";
	if (browser_v) {v_text="" + browser_v;}
	//alert("BROWSER: " + browser_nm + v_text);
	if(v_text.indexOf('11') != -1){
		// $('html').addClass(browser_nm + v_text);
		$('html').addClass('ie').addClass('ie11');
	}

});
