<!DOCTYPE html>
<html lang="en" >

<head>
	<script>
window.ts_endpoint_url = "https:\/\/slack.com\/beacon\/timing";

(function(e) {
	var n=Date.now?Date.now():+new Date,r=e.performance||{},t=[],a={},i=function(e,n){for(var r=0,a=t.length,i=[];a>r;r++)t[r][e]==n&&i.push(t[r]);return i},o=function(e,n){for(var r,a=t.length;a--;)r=t[a],r.entryType!=e||void 0!==n&&r.name!=n||t.splice(a,1)};r.now||(r.now=r.webkitNow||r.mozNow||r.msNow||function(){return(Date.now?Date.now():+new Date)-n}),r.mark||(r.mark=r.webkitMark||function(e){var n={name:e,entryType:"mark",startTime:r.now(),duration:0};t.push(n),a[e]=n}),r.measure||(r.measure=r.webkitMeasure||function(e,n,r){n=a[n].startTime,r=a[r].startTime,t.push({name:e,entryType:"measure",startTime:n,duration:r-n})}),r.getEntriesByType||(r.getEntriesByType=r.webkitGetEntriesByType||function(e){return i("entryType",e)}),r.getEntriesByName||(r.getEntriesByName=r.webkitGetEntriesByName||function(e){return i("name",e)}),r.clearMarks||(r.clearMarks=r.webkitClearMarks||function(e){o("mark",e)}),r.clearMeasures||(r.clearMeasures=r.webkitClearMeasures||function(e){o("measure",e)}),e.performance=r,"function"==typeof define&&(define.amd||define.ajs)&&define("performance",[],function(){return r}) // eslint-disable-line
})(window);

</script>
<script>;(function() {

'use strict';


window.TSMark = function(mark_label) {
	if (!window.performance || !window.performance.mark) return;
	performance.mark(mark_label);
};
window.TSMark('start_load');


window.TSMeasureAndBeacon = function(measure_label, start_mark_label) {
	if (start_mark_label === 'start_nav' && window.performance && window.performance.timing) {
		window.TSBeacon(measure_label, (new Date()).getTime() - performance.timing.navigationStart);
		return;
	}
	if (!window.performance || !window.performance.mark || !window.performance.measure) return;
	performance.mark(start_mark_label + '_end');
	try {
		performance.measure(measure_label, start_mark_label, start_mark_label + '_end');
		window.TSBeacon(measure_label, performance.getEntriesByName(measure_label)[0].duration);
	} catch(e) { return; }
};


window.TSBeacon = function(label, value) {
	var endpoint_url = window.ts_endpoint_url || 'https://slack.com/beacon/timing';
	(new Image()).src = endpoint_url + '?data=' + encodeURIComponent(label + ':' + value);
};

})();
</script>
 

<script>
window.TSMark('step_load');
</script>	<noscript><meta http-equiv="refresh" content="0; URL=/files/lsy123456798/F0GQL0YAF/diana_no_data.sql?nojsmode=1" /></noscript>
<script type="text/javascript">
(function() {
	var start_time = Date.now();
	var logs = [];
	var connecting = true;
	var ever_connected = false;
	var log_namespace;
		
	var logWorker = function(ob) {
		var log_str = ob.secs+' start_label:'+ob.start_label+' measure_label:'+ob.measure_label+' description:'+ob.description;
		
		if (TS.timing.getLatestMark(ob.start_label)){
			TS.timing.measure(ob.measure_label, ob.start_label);
			TS.log(88, log_str);
			
			if (ob.do_reset) {
				window.TSMark(ob.start_label);
			}
		} else {
			TS.maybeWarn(88, 'not timing: '+log_str);
		}
	}
	
	var log = function(k, description) {
		var secs = (Date.now()-start_time)/1000;

		logs.push({
			k: k,
			d: description,
			t: secs,
			c: !!connecting
		})
	
		if (!window.boot_data) return;
		if (!window.TS) return;
		if (!TS.timing) return;
		if (!connecting) return;
		
		// lazy assignment
		log_namespace = log_namespace || (function() {
			if (boot_data.app == 'client') return 'client';
			if (boot_data.app == 'space') return 'post';
			if (boot_data.app == 'api') return 'apisite';
			if (boot_data.app == 'mobile') return 'mobileweb';
			if (boot_data.app == 'web' || boot_data.app == 'oauth') return 'web';
			return 'unknown';
		})();
		
		var modifier = (TS.boot_data.feature_no_rollups) ? '_no_rollups' : '';
		
		logWorker({
			k: k,
			secs: secs,
			description: description,
			start_label: ever_connected ? 'start_reconnect' : 'start_load',
			measure_label: 'v2_'+log_namespace+modifier+(ever_connected ? '_reconnect__' : '_load__')+k,
			do_reset: false,
		});
	}
	
	var setConnecting = function(val) {
		val = !!val;
		if (val == connecting) return;
		
		if (val) {
			log('start');
			if (ever_connected) {
				// we just started reconnecting, so reset timing
				window.TSMark('start_reconnect');
				window.TSMark('step_reconnect');
				window.TSMark('step_load');
			}
		
			connecting = val;
			log('start');
		} else {
			log('over');
			ever_connected = true;
			connecting = val;
		}
	}
	
	window.TSConnLogger = {
		log: log,
		logs: logs,
		start_time: start_time,
		setConnecting: setConnecting
	}
})();

if(self!==top)window.document.write("\u003Cstyle>body * {display:none !important;}\u003C\/style>\u003Ca href=\"#\" onclick="+
"\"top.location.href=window.location.href\" style=\"display:block !important;padding:10px\">Go to Slack.com\u003C\/a>");
</script>


<script type="text/javascript">
window.callSlackAPIUnauthed = function(method, args, callback) {
	var url = '/api/'+method+'?t='+Date.now();
	var req = new XMLHttpRequest();
	
	req.onreadystatechange = function() {
		if (req.readyState == 4) {
			req.onreadystatechange = null;
			var obj;
			
			if (req.status == 200) {
				if (req.responseText.indexOf('{') == 0) {
					try {
						eval('obj = '+req.responseText);
					} catch (err) {
						console.warn('unable to do anything with api rsp');
					}
				}
			}
			
			obj = obj || {
				ok: false	
			}
			
			callback(obj.ok, obj, args);
		}
	}
	
	req.open('POST', url, 1);
	req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

	var args2 = [];
	for (i in args) {
		args2[args2.length] = encodeURIComponent(i)+'='+encodeURIComponent(args[i]);
	}

	req.send(args2.join('&'));
}
</script>

			
	
	<script type="text/javascript">
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', "UA-106458-17", 'slack.com');
		
						
		ga('send', 'pageview');

		
		(function(e,c,b,f,d,g,a){e.SlackBeaconObject=d;
		e[d]=e[d]||function(){(e[d].q=e[d].q||[]).push([1*new Date(),arguments])};
		e[d].l=1*new Date();g=c.createElement(b);a=c.getElementsByTagName(b)[0];
		g.async=1;g.src=f;a.parentNode.insertBefore(g,a)
		})(window,document,"script","https://slack.global.ssl.fastly.net/dcf8/js/libs/beacon.js","sb");
		sb('set', 'token', '3307f436963e02d4f9eb85ce5159744c');

					sb('set', 'user_id', "U0DNV6T9V");
							sb('set', 'user_' + "batch", "?");
							sb('set', 'user_' + "created", "2015-11-03");
						sb('set', 'name_tag', "cs3380kander" + '/' + "djbbq3");
				sb('track', 'pageview');

		function track(a){ga('send','event','web',a);sb('track',a);}

	</script>


		<script type='text/javascript'>
		
		(function(f,b){if(!b.__SV){var a,e,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
		for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=f.createElement("script");a.type="text/javascript";a.async=!0;a.src="//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";e=f.getElementsByTagName("script")[0];e.parentNode.insertBefore(a,e)}})(document,window.mixpanel||[]);
		

		mixpanel.init("12d52d8633a5b432975592d13ebd3f34");

		
			function mixpanel_track(){if(window.mixpanel)mixpanel.track.apply(mixpanel, arguments);}
			function mixpanel_track_forms(){if(window.mixpanel)mixpanel.track_forms.apply(mixpanel, arguments);}
			function mixpanel_track_links(){if(window.mixpanel)mixpanel.track_links.apply(mixpanel, arguments);}
		
	</script>
	
			<meta name="referrer" content="no-referrer">
			<meta name="superfish" content="nofish">
	<script type="text/javascript">



var TS_last_log_date = null;
var TSMakeLogDate = function() {
	var date = new Date();

	var y = date.getFullYear();
	var mo = date.getMonth()+1;
	var d = date.getDate();

	var time = {
	  h: date.getHours(),
	  mi: date.getMinutes(),
	  s: date.getSeconds(),
	  ms: date.getMilliseconds()
	};

	Object.keys(time).map(function(moment, index) {
		if (moment == 'ms') {
			if (time[moment] < 10) {
				time[moment] = time[moment]+'00';
			} else if (time[moment] < 100) {
				time[moment] = time[moment]+'0';
			}
		} else if (time[moment] < 10) {
			time[moment] = '0' + time[moment];
		}
	});

	var str = y + '/' + mo + '/' + d + ' ' + time.h + ':' + time.mi + ':' + time.s + '.' + time.ms;
	if (TS_last_log_date) {
		var diff = date-TS_last_log_date;
		//str+= ' ('+diff+'ms)';
	}
	TS_last_log_date = date;
	return str+' ';
}

var TSSSB = {
	env: (function() {
		var v = {
			win_ssb_version: null,
			win_ssb_version_minor: null,
			mac_ssb_version: null,
			mac_ssb_version_minor: null,
			mac_ssb_build: null,
			lin_ssb_version: null,
			lin_ssb_version_minor: null
		}
		
		var is_win = (navigator.appVersion.indexOf("Windows") !== -1);
		var is_lin = (navigator.appVersion.indexOf("Linux") !== -1);
		var is_mac = !!(navigator.userAgent.match(/(OS X)/g));

		if (navigator.userAgent.match(/(Slack_SSB)/g) || navigator.userAgent.match(/(Slack_WINSSB)/g)) {
			// Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.55.3 (KHTML, like Gecko) Slack_SSB/0.32
			var parts = navigator.userAgent.split('/');
			var version_str = parts[parts.length-1];
			var version_float = parseFloat(version_str);
			var versionA = version_str.split('.');
			var version_minor = (versionA.length == 3) ? parseInt(versionA[2]) : 0;
	
			if (navigator.userAgent.match(/(AtomShell)/g)) {
				// Electron-based app
				if (is_lin) {
					v.lin_ssb_version = version_float;
					v.lin_ssb_version_minor = version_minor;
				} else {
					v.win_ssb_version = version_float;
					v.win_ssb_version_minor = version_minor;
				}
			} else {
				// MacGap-based app
				v.mac_ssb_version = version_float;
				v.mac_ssb_version_minor = version_minor;
				
				// buildVersion() only available in 2.0 + (and not early builds)
				// returns a string like "2.0.0 (7447)" and we want the part in parens
				var app_ver = window.macgap && macgap.app && macgap.app.buildVersion && macgap.app.buildVersion();
				var matches = String(app_ver).match(/(?:\()(.*)(?:\))/);
				v.mac_ssb_build = (matches && matches.length == 2) ? parseInt(matches[1] || 0) : 0;
			}
		}

		return v;
	})(),
	
	

	call: function() {
		return false;
	}

	
}

</script>	<script type="text/javascript">
		
		var was_TS = window.TS;
		delete window.TS;
		TSSSB.call('didFinishLoading');
		if (was_TS) window.TS = was_TS;
	</script>
	    <meta charset="utf-8">
    <title>diana_no_data.sql | CS3380 Kander Slack</title>
    <meta name="author" content="Slack">

	
		
	
				
	
											
		
				<!-- output_css "core" -->
    <link href="https://slack.global.ssl.fastly.net/fae2/style/rollup-plastic.css" rel="stylesheet" type="text/css">

		<!-- output_css "before_file_pages" -->
    <link href="https://slack.global.ssl.fastly.net/e9e7/style/libs/codemirror.css" rel="stylesheet" type="text/css">

	<!-- output_css "file_pages" -->
    <link href="https://slack.global.ssl.fastly.net/a4128/style/rollup-file_pages.css" rel="stylesheet" type="text/css">

	<!-- output_css "regular" -->
    <link href="https://slack.global.ssl.fastly.net/5181/style/print.css" rel="stylesheet" type="text/css">
    <link href="https://slack.global.ssl.fastly.net/508c4/style/libs/lato-1-compressed.css" rel="stylesheet" type="text/css">

	

	
	
	

	<!--[if lt IE 9]>
	<script src="https://slack.global.ssl.fastly.net/ef0d/js/libs/html5shiv.js"></script>
	<![endif]-->

	
<link id="favicon" rel="shortcut icon" href="https://slack.global.ssl.fastly.net/66f9/img/icons/favicon-32.png" sizes="16x16 32x32 48x48" type="image/png" />

<link rel="icon" href="https://slack.global.ssl.fastly.net/0180/img/icons/app-256.png" sizes="256x256" type="image/png" />

<link rel="apple-touch-icon-precomposed" sizes="152x152" href="https://slack.global.ssl.fastly.net/66f9/img/icons/ios-152.png" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="https://slack.global.ssl.fastly.net/66f9/img/icons/ios-144.png" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="https://slack.global.ssl.fastly.net/66f9/img/icons/ios-120.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://slack.global.ssl.fastly.net/66f9/img/icons/ios-114.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://slack.global.ssl.fastly.net/0180/img/icons/ios-72.png" />
<link rel="apple-touch-icon-precomposed" href="https://slack.global.ssl.fastly.net/66f9/img/icons/ios-57.png" />

<meta name="msapplication-TileColor" content="#FFFFFF" />
<meta name="msapplication-TileImage" content="https://slack.global.ssl.fastly.net/66f9/img/icons/app-144.png" />	<script>
!function(a,b){function c(a,b){try{if("function"!=typeof a)return a;if(!a.bugsnag){var c=e();a.bugsnag=function(d){if(b&&b.eventHandler&&(u=d),v=c,!y){var e=a.apply(this,arguments);return v=null,e}try{return a.apply(this,arguments)}catch(f){throw l("autoNotify",!0)&&(x.notifyException(f,null,null,"error"),s()),f}finally{v=null}},a.bugsnag.bugsnag=a.bugsnag}return a.bugsnag}catch(d){return a}}function d(){B=!1}function e(){var a=document.currentScript||v;if(!a&&B){var b=document.scripts||document.getElementsByTagName("script");a=b[b.length-1]}return a}function f(a){var b=e();b&&(a.script={src:b.src,content:l("inlineScript",!0)?b.innerHTML:""})}function g(b){var c=l("disableLog"),d=a.console;void 0===d||void 0===d.log||c||d.log("[Bugsnag] "+b)}function h(b,c,d){if(d>=5)return encodeURIComponent(c)+"=[RECURSIVE]";d=d+1||1;try{if(a.Node&&b instanceof a.Node)return encodeURIComponent(c)+"="+encodeURIComponent(r(b));var e=[];for(var f in b)if(b.hasOwnProperty(f)&&null!=f&&null!=b[f]){var g=c?c+"["+f+"]":f,i=b[f];e.push("object"==typeof i?h(i,g,d):encodeURIComponent(g)+"="+encodeURIComponent(i))}return e.join("&")}catch(j){return encodeURIComponent(c)+"="+encodeURIComponent(""+j)}}function i(a,b){if(null==b)return a;a=a||{};for(var c in b)if(b.hasOwnProperty(c))try{a[c]=b[c].constructor===Object?i(a[c],b[c]):b[c]}catch(d){a[c]=b[c]}return a}function j(a,b){a+="?"+h(b)+"&ct=img&cb="+(new Date).getTime();var c=new Image;c.src=a}function k(a){var b={},c=/^data\-([\w\-]+)$/;if(a)for(var d=a.attributes,e=0;e<d.length;e++){var f=d[e];if(c.test(f.nodeName)){var g=f.nodeName.match(c)[1];b[g]=f.value||f.nodeValue}}return b}function l(a,b){C=C||k(J);var c=void 0!==x[a]?x[a]:C[a.toLowerCase()];return"false"===c&&(c=!1),void 0!==c?c:b}function m(a){return a&&a.match(D)?!0:(g("Invalid API key '"+a+"'"),!1)}function n(b,c){var d=l("apiKey");if(m(d)&&A){A-=1;var e=l("releaseStage"),f=l("notifyReleaseStages");if(f){for(var h=!1,k=0;k<f.length;k++)if(e===f[k]){h=!0;break}if(!h)return}var n=[b.name,b.message,b.stacktrace].join("|");if(n!==w){w=n,u&&(c=c||{},c["Last Event"]=q(u));var o={notifierVersion:H,apiKey:d,projectRoot:l("projectRoot")||a.location.protocol+"//"+a.location.host,context:l("context")||a.location.pathname,userId:l("userId"),user:l("user"),metaData:i(i({},l("metaData")),c),releaseStage:e,appVersion:l("appVersion"),url:a.location.href,userAgent:navigator.userAgent,language:navigator.language||navigator.userLanguage,severity:b.severity,name:b.name,message:b.message,stacktrace:b.stacktrace,file:b.file,lineNumber:b.lineNumber,columnNumber:b.columnNumber,payloadVersion:"2"},p=x.beforeNotify;if("function"==typeof p){var r=p(o,o.metaData);if(r===!1)return}return 0===o.lineNumber&&/Script error\.?/.test(o.message)?g("Ignoring cross-domain script error. See https://bugsnag.com/docs/notifiers/js/cors"):(j(l("endpoint")||G,o),void 0)}}}function o(){var a,b,c=10,d="[anonymous]";try{throw new Error("")}catch(e){a="<generated>\n",b=p(e)}if(!b){a="<generated-ie>\n";var f=[];try{for(var h=arguments.callee.caller.caller;h&&f.length<c;){var i=E.test(h.toString())?RegExp.$1||d:d;f.push(i),h=h.caller}}catch(j){g(j)}b=f.join("\n")}return a+b}function p(a){return a.stack||a.backtrace||a.stacktrace}function q(a){var b={millisecondsAgo:new Date-a.timeStamp,type:a.type,which:a.which,target:r(a.target)};return b}function r(a){if(a){var b=a.attributes;if(b){for(var c="<"+a.nodeName.toLowerCase(),d=0;d<b.length;d++)b[d].value&&"null"!=b[d].value.toString()&&(c+=" "+b[d].name+'="'+b[d].value+'"');return c+">"}return a.nodeName}}function s(){z+=1,a.setTimeout(function(){z-=1})}function t(a,b,c){var d=a[b],e=c(d);a[b]=e}var u,v,w,x={},y=!0,z=0,A=10;x.noConflict=function(){return a.Bugsnag=b,x},x.refresh=function(){A=10},x.notifyException=function(a,b,c,d){b&&"string"!=typeof b&&(c=b,b=void 0),c||(c={}),f(c),n({name:b||a.name,message:a.message||a.description,stacktrace:p(a)||o(),file:a.fileName||a.sourceURL,lineNumber:a.lineNumber||a.line,columnNumber:a.columnNumber?a.columnNumber+1:void 0,severity:d||"warning"},c)},x.notify=function(b,c,d,e){n({name:b,message:c,stacktrace:o(),file:a.location.toString(),lineNumber:1,severity:e||"warning"},d)};var B="complete"!==document.readyState;document.addEventListener?(document.addEventListener("DOMContentLoaded",d,!0),a.addEventListener("load",d,!0)):a.attachEvent("onload",d);var C,D=/^[0-9a-f]{32}$/i,E=/function\s*([\w\-$]+)?\s*\(/i,F="https://notify.bugsnag.com/",G=F+"js",H="2.4.7",I=document.getElementsByTagName("script"),J=I[I.length-1];if(a.atob){if(a.ErrorEvent)try{0===new a.ErrorEvent("test").colno&&(y=!1)}catch(K){}}else y=!1;if(l("autoNotify",!0)){t(a,"onerror",function(b){return function(c,d,e,g,h){var i=l("autoNotify",!0),j={};!g&&a.event&&(g=a.event.errorCharacter),f(j),v=null,i&&!z&&n({name:h&&h.name||"window.onerror",message:c,file:d,lineNumber:e,columnNumber:g,stacktrace:h&&p(h)||o(),severity:"error"},j),b&&b(c,d,e,g,h)}});var L=function(a){return function(b,d){if("function"==typeof b){b=c(b);var e=Array.prototype.slice.call(arguments,2);return a(function(){b.apply(this,e)},d)}return a(b,d)}};t(a,"setTimeout",L),t(a,"setInterval",L),a.requestAnimationFrame&&t(a,"requestAnimationFrame",function(a){return function(b){return a(c(b))}}),a.setImmediate&&t(a,"setImmediate",function(a){return function(){var b=Array.prototype.slice.call(arguments);return b[0]=c(b[0]),a.apply(this,b)}}),"EventTarget Window Node ApplicationCache AudioTrackList ChannelMergerNode CryptoOperation EventSource FileReader HTMLUnknownElement IDBDatabase IDBRequest IDBTransaction KeyOperation MediaController MessagePort ModalWindow Notification SVGElementInstance Screen TextTrack TextTrackCue TextTrackList WebSocket WebSocketWorker Worker XMLHttpRequest XMLHttpRequestEventTarget XMLHttpRequestUpload".replace(/\w+/g,function(b){var d=a[b]&&a[b].prototype;d&&d.hasOwnProperty&&d.hasOwnProperty("addEventListener")&&(t(d,"addEventListener",function(a){return function(b,d,e,f){return d&&d.handleEvent&&(d.handleEvent=c(d.handleEvent,{eventHandler:!0})),a.call(this,b,c(d,{eventHandler:!0}),e,f)}}),t(d,"removeEventListener",function(a){return function(b,d,e,f){return a.call(this,b,d,e,f),a.call(this,b,c(d),e,f)}}))})}a.Bugsnag=x,"function"==typeof define&&define.amd?define([],function(){return x}):"object"==typeof module&&"object"==typeof module.exports&&(module.exports=x)}(window,window.Bugsnag);
Bugsnag.apiKey = "2a86b308af5a81d2c9329fedfb4b30c7";
Bugsnag.appVersion = "a727acd1f3ce01cb188412099c6e0015b71dd4bf" + '-' + "1450295333";
Bugsnag.endpoint = "https://errors-webapp.slack-core.com/js";
Bugsnag.releaseStage = "prod";
Bugsnag.autoNotify = false;
Bugsnag.user = {id:"U0DNV6T9V",name:"djbbq3",email:"djbbq3@mail.missouri.edu"};
Bugsnag.metaData = {};
Bugsnag.metaData.team = {id:"T0DLN22RJ",name:"CS3380 Kander",domain:"cs3380kander"};
Bugsnag.refresh_interval = setInterval(function () { (window.TS && window.TS.client) ? Bugsnag.refresh() : clearInterval(Bugsnag.refresh_interval); }, 15 * 60 * 1000);
</script>
</head>

<body class="">

		  			<script>
		
			var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
			if (w > 1440) document.querySelector('body').classList.add('widescreen');
		
		</script>
	
  	
	

			<nav id="site_nav" class="no_transition">

	<div id="site_nav_contents">

		<div id="user_menu">
			<div id="user_menu_contents">
				<div id="user_menu_avatar">
										<span class="member_image thumb_48" style="background-image: url('https://secure.gravatar.com/avatar/41cc4c596a4cb198534a29831a057985.jpg?s=192&d=https%3A%2F%2Fslack.global.ssl.fastly.net%2F7fa9%2Fimg%2Favatars%2Fava_0026-192.png')" data-thumb-size="48" data-member-id="U0DNV6T9V"></span>
					<span class="member_image thumb_36" style="background-image: url('https://secure.gravatar.com/avatar/41cc4c596a4cb198534a29831a057985.jpg?s=72&d=https%3A%2F%2Fslack.global.ssl.fastly.net%2F66f9%2Fimg%2Favatars%2Fava_0026-72.png')" data-thumb-size="36" data-member-id="U0DNV6T9V"></span>
				</div>
				<h3>Signed in as</h3>
				<span id="user_menu_name">djbbq3</span>
			</div>
		</div>

		<div class="nav_contents">

			<ul class="primary_nav">
				<li><a href="/home"><i class="ts_icon ts_icon_home"></i>Home</a></li>
				<li><a href="/account"><i class="ts_icon ts_icon_user"></i>Account & Profile</a></li>
									<li><a href="/apps/manage"><i class="ts_icon ts_icon_plug"></i>Configure Apps</a></li>
								<li><a href="/archives"><i class="ts_icon ts_icon_inbox"></i>Message Archives</a></li>
				<li><a href="/files"><i class="ts_icon ts_icon_file"></i>Files</a></li>
				<li><a href="/team"><i class="ts_icon ts_icon_team_directory"></i>Team Directory</a></li>
									<li><a href="/stats"><i class="ts_icon ts_icon_dashboard"></i>Statistics</a></li>
													<li><a href="/customize"><i class="ts_icon ts_icon_magic"></i>Customize</a></li>
													<li><a href="/account/team"><i class="ts_icon ts_icon_cog_o"></i>Team Settings</a></li>
							</ul>

			
		</div>

		<div id="footer">

			<ul id="footer_nav">
				<li><a href="/is">Tour</a></li>
				<li><a href="/downloads">Download Apps</a></li>
				<li><a href="/brand-guidelines">Brand Guidelines</a></li>
				<li><a href="/help">Help</a></li>
				<li><a href="https://api.slack.com" target="_blank">API<i class="ts_icon ts_icon_external_link small_left_margin ts_icon_inherit"></i></a></li>
								<li><a href="/pricing">Pricing</a></li>
				<li><a href="/help/requests/new">Contact</a></li>
				<li><a href="/terms-of-service">Policies</a></li>
				<li><a href="http://slackhq.com/" target="_blank">Our Blog</a></li>
				<li><a href="https://slack.com/signout/13702070868?crumb=s-1450295977-eb0fe5692a-%E2%98%83">Sign Out<i class="ts_icon ts_icon_sign_out small_left_margin ts_icon_inherit"></i></a></li>
			</ul>

			<p id="footer_signature">Made with <i class="ts_icon ts_icon_heart"></i> by Slack</p>

		</div>

	</div>
</nav>	
			<header>
							<a id="menu_toggle" class="no_transition">
					<span class="menu_icon"></span>
					<span class="menu_label">Menu</span>
					<span class="vert_divider"></span>
				</a>
				<h1 id="header_team_name" class="inline_block no_transition">
					<a href="/home">
						<i class="ts_icon ts_icon_home" /></i>
						CS3380 Kander
					</a>
				</h1>
				<div class="header_nav">
					<div class="header_btns float_right">
						<a id="team_switcher">
							<i class="ts_icon ts_icon_th_large ts_icon_inherit"></i>
							<span class="block label">Teams</span>
						</a>
						<a href="/help" id="help_link">
							<i class="ts_icon ts_icon_life_ring ts_icon_inherit"></i>
							<span class="block label">Help</span>
						</a>
						<a href="/messages">
							<img src="https://slack.global.ssl.fastly.net/66f9/img/icons/ios-64.png" srcset="https://slack.global.ssl.fastly.net/66f9/img/icons/ios-32.png 1x, https://slack.global.ssl.fastly.net/66f9/img/icons/ios-64.png 2x" />
							<span class="block label">Launch</span>
						</a>
					</div>
								                    <ul id="header_team_nav">
			                        			                            <li class="active">
			                            	<a href="https://cs3380kander.slack.com/home" target="https://cs3380kander.slack.com/">
			                            					                            			<i class="ts_icon small ts_icon_check_circle_o active_icon s"></i>
			                            					                            					                            			<i class="team_icon small default" >CK</i>
			                            					                            		<span class="switcher_label team_name">CS3380 Kander</span>
			                            	</a>
			                            </li>
			                        			                            <li >
			                            	<a href="https://mucs3380.slack.com/home" target="https://mucs3380.slack.com/">
			                            					                            					                            			<i class="team_icon small default" >MC</i>
			                            					                            		<span class="switcher_label team_name">MU CS 3380</span>
			                            	</a>
			                            </li>
			                        			                        <li id="add_team_option"><a href="https://slack.com/signin" target="_blank"><i class="ts_icon ts_icon_plus team_icon small"></i> <span class="switcher_label">Sign in to another team...</span></a></li>
			                    </ul>
			                				</div>
			
			
		</header>
	
	<div id="page" >

		<div id="page_contents" class="">

<p class="print_only">
	<strong>Created by lsy123456798 on December 16, 2015 at 12:18 PM</strong><br />
	<span class="subtle_silver break_word">https://cs3380kander.slack.com/files/lsy123456798/F0GQL0YAF/diana_no_data.sql</span>
</p>

<div class="file_header_container no_print"></div>

<div class="alert_container">
		<div class="file_public_link_shared alert" style="display: none;">
		
	<i class="ts_icon ts_icon_link"></i> Public Link: <a class="file_public_link" href="https://slack-files.com/T0DLN22RJ-F0GQL0YAF-52511b3115" target="new">https://slack-files.com/T0DLN22RJ-F0GQL0YAF-52511b3115</a>
</div></div>

<div id="file_page" class="card top_padding">

	<p class="small subtle_silver no_print meta">
		12KB SQL snippet created on <span class="date">December 16th 2015</span>.
		This file is private.		<span class="file_share_list"></span>
	</p>

	<a id="file_action_cog" class="action_cog action_cog_snippet float_right no_print">
		<span>Actions </span><i class="ts_icon ts_icon_cog"></i>
	</a>
	<a id="snippet_expand_toggle" class="float_right no_print">
		<i class="ts_icon ts_icon_expand "></i>
		<i class="ts_icon ts_icon_compress hidden"></i>
	</a>

	<div class="large_bottom_margin clearfix">
		<pre id="file_contents">-- MySQL dump 10.13  Distrib 5.6.27, for debian-linux-gnu (x86_64)
--
-- Host: us-cdbr-azure-central-a.cloudapp.net    Database: dianakanderdatabase
-- ------------------------------------------------------
-- Server version	5.5.40-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE=&#039;+00:00&#039; */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=&#039;NO_AUTO_VALUE_ON_ZERO&#039; */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `business`
--

DROP TABLE IF EXISTS `business`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `business` (
  `business_id` int(11) NOT NULL AUTO_INCREMENT,
  `business_name` varchar(20) NOT NULL DEFAULT &#039;&#039;,
  `username` varchar(20) DEFAULT NULL,
  `address` varchar(30) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `last_modify_time` datetime DEFAULT NULL,
  `print_times` int(11) DEFAULT NULL,
  `last_print_time` datetime DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`business_id`)
) ENGINE=InnoDB AUTO_INCREMENT=272 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `business_intellectual_property`
--

DROP TABLE IF EXISTS `business_intellectual_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `business_intellectual_property` (
  `business_id` int(11) NOT NULL DEFAULT &#039;0&#039;,
  `intellectual_property_id` int(11) NOT NULL DEFAULT &#039;0&#039;,
  PRIMARY KEY (`business_id`,`intellectual_property_id`),
  KEY `intellectual_property_id` (`intellectual_property_id`),
  CONSTRAINT `business_intellectual_property_ibfk_1` FOREIGN KEY (`business_id`) REFERENCES `business` (`business_id`),
  CONSTRAINT `business_intellectual_property_ibfk_2` FOREIGN KEY (`intellectual_property_id`) REFERENCES `intellectual_property` (`intellectual_property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `business_key_partners`
--

DROP TABLE IF EXISTS `business_key_partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `business_key_partners` (
  `business_id` int(11) NOT NULL DEFAULT &#039;0&#039;,
  `key_partner_id` int(11) NOT NULL DEFAULT &#039;0&#039;,
  PRIMARY KEY (`business_id`,`key_partner_id`),
  KEY `key_partner_id` (`key_partner_id`),
  CONSTRAINT `business_key_partners_ibfk_1` FOREIGN KEY (`business_id`) REFERENCES `business` (`business_id`),
  CONSTRAINT `business_key_partners_ibfk_2` FOREIGN KEY (`key_partner_id`) REFERENCES `key_partners` (`key_partner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `business_sales_channels`
--

DROP TABLE IF EXISTS `business_sales_channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `business_sales_channels` (
  `business_id` int(11) NOT NULL DEFAULT &#039;0&#039;,
  `sales_channels_id` int(11) NOT NULL DEFAULT &#039;0&#039;,
  PRIMARY KEY (`business_id`,`sales_channels_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `business_team_member`
--

DROP TABLE IF EXISTS `business_team_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `business_team_member` (
  `business_id` int(11) NOT NULL DEFAULT &#039;0&#039;,
  `member_id` int(11) NOT NULL DEFAULT &#039;0&#039;,
  PRIMARY KEY (`business_id`,`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `competitive_analysis`
--

DROP TABLE IF EXISTS `competitive_analysis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competitive_analysis` (
  `competitive_analysis_id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) DEFAULT NULL,
  `current_behavior` varchar(200) DEFAULT NULL,
  `our_competitive_advantage` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`competitive_analysis_id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `financial_projection`
--

DROP TABLE IF EXISTS `financial_projection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financial_projection` (
  `finacial_projection_id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) DEFAULT NULL,
  `projection_time` varchar(20) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `financial_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`finacial_projection_id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `financial_type`
--

DROP TABLE IF EXISTS `financial_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financial_type` (
  `financial_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `financial_type_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`financial_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `funding`
--

DROP TABLE IF EXISTS `funding`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `funding` (
  `business_id` int(11) NOT NULL,
  `amount` float DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `intellectual_property`
--

DROP TABLE IF EXISTS `intellectual_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `intellectual_property` (
  `intellectual_property_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`intellectual_property_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `key_partners`
--

DROP TABLE IF EXISTS `key_partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `key_partners` (
  `key_partner_id` int(11) NOT NULL AUTO_INCREMENT,
  `partner_name` varchar(60) DEFAULT NULL,
  `title` varchar(40) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`key_partner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `market`
--

DROP TABLE IF EXISTS `market`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `market` (
  `market_aspect_id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) DEFAULT NULL,
  `aspect_type` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`market_aspect_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `market_effort`
--

DROP TABLE IF EXISTS `market_effort`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `market_effort` (
  `effort_id` int(11) NOT NULL AUTO_INCREMENT,
  `effort_when` varchar(30) DEFAULT NULL,
  `effort_description` varchar(200) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`effort_id`),
  KEY `business_id` (`business_id`),
  CONSTRAINT `market_effort_ibfk_1` FOREIGN KEY (`business_id`) REFERENCES `business` (`business_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `milestone_post_funding`
--

DROP TABLE IF EXISTS `milestone_post_funding`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `milestone_post_funding` (
  `funding_id` int(11) NOT NULL AUTO_INCREMENT,
  `funding_when` varchar(30) DEFAULT NULL,
  `funding_action` varchar(1000) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`funding_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `opportunity`
--

DROP TABLE IF EXISTS `opportunity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opportunity` (
  `opportunity_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_problem` varchar(1000) DEFAULT NULL,
  `problem_valildated` varchar(1000) DEFAULT NULL,
  `solution` varchar(1000) DEFAULT NULL,
  `solution_validated` varchar(1000) DEFAULT NULL,
  `current_status_of_solution` varchar(1000) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`opportunity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sales_channels`
--

DROP TABLE IF EXISTS `sales_channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_channels` (
  `sales_channels_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) DEFAULT NULL,
  `type_method` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`sales_channels_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `team_member`
--

DROP TABLE IF EXISTS `team_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) DEFAULT NULL,
  `lastname` varchar(20) DEFAULT NULL,
  `title` varchar(40) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `salt` varchar(20) DEFAULT NULL,
  `hashed_password` varchar(256) DEFAULT NULL,
  `user_type` enum(&#039;a&#039;,&#039;r&#039;) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-16 18:16:54
</pre>

		<p class="file_page_meta no_print" style="line-height: 1.5rem;">
			<label class="checkbox normal mini float_right no_top_padding no_min_width">
				<input type="checkbox" id="file_preview_wrap_cb"> wrap long lines
			</label>
		</p>

	</div>

	<div id="comments_holder" class="clearfix clear_both">
	<div class="col span_1_of_6"></div>
	<div class="col span_4_of_6 no_right_padding">
		<div id="file_page_comments">
					</div>	
		<form action="https://cs3380kander.slack.com/files/lsy123456798/F0GQL0YAF/diana_no_data.sql" 
		id="file_comment_form" 
					class="comment_form"
				method="post">
			<a href="/team/djbbq3" class="member_preview_link" data-member-id="U0DNV6T9V" >
			<span class="member_image thumb_36" style="background-image: url('https://secure.gravatar.com/avatar/41cc4c596a4cb198534a29831a057985.jpg?s=72&d=https%3A%2F%2Fslack.global.ssl.fastly.net%2F66f9%2Fimg%2Favatars%2Fava_0026-72.png')" data-thumb-size="36" data-member-id="U0DNV6T9V"></span>
		</a>		
		<input type="hidden" name="addcomment" value="1" />
	<input type="hidden" name="crumb" value="s-1450295977-94cd484bfe-☃" />

	<textarea id="file_comment" data-el-id-to-keep-in-view="file_comment_submit_btn" class="small comment_input small_bottom_margin autogrow-short" name="comment" wrap="virtual" ></textarea>
	<span class="input_note float_left cloud_silver file_comment_tip">shift+enter to add a new line</span>	<button id="file_comment_submit_btn" type="submit" class="btn float_right  ladda-button" data-style="expand-right"><span class="ladda-label">Add Comment</span></button>
</form>

<form
		id="file_edit_comment_form" 
					class="edit_comment_form hidden"
				method="post">
		<textarea id="file_edit_comment" class="small comment_input small_bottom_margin" name="comment" wrap="virtual"></textarea><br>
	<span class="input_note float_left cloud_silver file_comment_tip">shift+enter to add a new line</span>	<input type="submit" class="save btn float_right " value="Save" />
	<button class="cancel btn btn_outline float_right small_right_margin ">Cancel</button>
</form>	
	</div>
	<div class="col span_1_of_6"></div>
</div>
</div>

	

		
	</div>
	<div id="overlay"></div>
</div>





<script type="text/javascript">
var cdn_url = "https:\/\/slack.global.ssl.fastly.net";
var inc_js_setup_data = {
	emoji_sheets: {
		apple: 'https://slack.global.ssl.fastly.net/d4bf/img/emoji_2015_2/sheet_apple_64_indexed_256colors.png',
		google: 'https://slack.global.ssl.fastly.net/d4bf/img/emoji_2015_2/sheet_google_64_indexed_128colors.png',
		twitter: 'https://slack.global.ssl.fastly.net/d4bf/img/emoji_2015_2/sheet_twitter_64_indexed_128colors.png',
		emojione: 'https://slack.global.ssl.fastly.net/d4bf/img/emoji_2015_2/sheet_emojione_64_indexed_128colors.png',
	},
};
</script>
			<script type="text/javascript">
<!--
	// common boot_data
	var boot_data = {
		start_ms: Date.now(),
		app: 'web',
		user_id: 'U0DNV6T9V',
		no_login: false,
		version_ts: '1450295333',
		version_uid: 'a727acd1f3ce01cb188412099c6e0015b71dd4bf',
		cache_version: "v11-mouse",
		cache_ts_version: "v1-cat",
		redir_domain: 'slack-redir.net',
		signin_url: 'https://slack.com/signin',
		abs_root_url: 'https://slack.com/',
		api_url: '/api/',
		team_url: 'https://cs3380kander.slack.com/',
		image_proxy_url: 'https://slack-imgs.com/',
		beacon_timing_url: "https:\/\/slack.com\/beacon\/timing",
		beacon_error_url: "https:\/\/slack.com\/beacon\/error",
		api_token: 'xoxs-13702070868-13777231335-16635582039-d8fa3d923f',
		ls_disabled: false,

		feature_status: false,
		feature_archive_viewer: true,

		notification_sounds: [{"value":"b2.mp3","label":"Ding","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/b2.mp3"},{"value":"animal_stick.mp3","label":"Boing","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/animal_stick.mp3"},{"value":"been_tree.mp3","label":"Drop","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/been_tree.mp3"},{"value":"complete_quest_requirement.mp3","label":"Ta-da","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/complete_quest_requirement.mp3"},{"value":"confirm_delivery.mp3","label":"Plink","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/confirm_delivery.mp3"},{"value":"flitterbug.mp3","label":"Wow","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/flitterbug.mp3"},{"value":"here_you_go_lighter.mp3","label":"Here you go","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/here_you_go_lighter.mp3"},{"value":"hi_flowers_hit.mp3","label":"Hi","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/hi_flowers_hit.mp3"},{"value":"item_pickup.mp3","label":"Yoink","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/item_pickup.mp3"},{"value":"knock_brush.mp3","label":"Knock Brush","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/knock_brush.mp3"},{"value":"save_and_checkout.mp3","label":"Woah!","url":"https:\/\/slack.global.ssl.fastly.net\/dfc0\/sounds\/push\/save_and_checkout.mp3"},{"value":"none","label":"None"}],
		alert_sounds: [{"value":"frog.mp3","label":"Frog","url":"https:\/\/slack.global.ssl.fastly.net\/a34a\/sounds\/frog.mp3"}],
		call_sounds: [{"value":"call\/alert.mp3","label":"Alert","url":"https:\/\/slack.global.ssl.fastly.net\/b6a68\/sounds\/call\/alert.mp3"},{"value":"call\/incoming_ring.mp3","label":"Incoming ring","url":"https:\/\/slack.global.ssl.fastly.net\/b6a68\/sounds\/call\/incoming_ring.mp3"},{"value":"call\/outgoing_ring.mp3","label":"Outgoing ring","url":"https:\/\/slack.global.ssl.fastly.net\/b6a68\/sounds\/call\/outgoing_ring.mp3"},{"value":"call\/pop.mp3","label":"Incoming reaction","url":"https:\/\/slack.global.ssl.fastly.net\/fa957\/sounds\/call\/pop.mp3"},{"value":"call\/they_left_call.mp3","label":"They left call","url":"https:\/\/slack.global.ssl.fastly.net\/b6a68\/sounds\/call\/they_left_call.mp3"},{"value":"call\/you_left_call.mp3","label":"You left call","url":"https:\/\/slack.global.ssl.fastly.net\/b6a68\/sounds\/call\/you_left_call.mp3"},{"value":"call\/they_joined_call.mp3","label":"They joined call","url":"https:\/\/slack.global.ssl.fastly.net\/b6a68\/sounds\/call\/they_joined_call.mp3"},{"value":"call\/you_joined_call.mp3","label":"You joined call","url":"https:\/\/slack.global.ssl.fastly.net\/b6a68\/sounds\/call\/you_joined_call.mp3"}],

		feature_api_extended_2fa_backup: false,
		feature_member_viz_perf: false,
		feature_message_replies: false,
		feature_mpim_client: true,
		feature_new_message_markup: true,
		feature_ui_reference_v2: false,
		feature_fullscreen_prefs: true,
		feature_setactive_use_ms: true,
		feature_no_rollups: false,
		feature_strike: true,
		feature_show_version_info: false,
		feature_ephemeral_attachments: false,
		feature_web_lean: false,
		feature_web_lean_all_users: false,
		feature_deprecate_url_download: true,
		feature_rxn_skin_tone_modifiers: true,
		feature_all_skin_tones: false,
		feature_spaces: true,
		feature_pass_the_baton: false,
		feature_a11y_keyboard_shortcuts: false,
		feature_email_integration: true,
		feature_email_ingestion: false,
		feature_attachments_inline: false,
		feature_fix_files: true,
		feature_files_list: true,
		feature_chat_sounds: false,
		feature_image_proxy: true,
		feature_channel_eventlog_client: true,
		feature_macssb1_banner: true,
		feature_winssb1_banner: true,
		feature_winssb_beta_channel: false,
		feature_latest_event_ts: true,
		feature_elide_closed_dms: true,
		feature_client_allow_demand_fetching: true,
		feature_no_redirects_in_ssb: true,
		feature_referer_policy: true,
		feature_client_exif_orientation_on_uploads: true,
		feature_pricing_page_tweet_carousel: true,
		feature_archived_channels_in_quick_switcher: false,
		feature_more_field_in_message_attachments: false,
		feature_user_hidden_msgs: false,
		feature_file_url_private_conversion: false,
		feature_screenhero: false,
		feature_calls: false,
		feature_custom_fields: true,
		feature_in_app_photo: true,
		feature_non_admin_invites: false,
		feature_lazy_cpf: false,
		feature_integrations_message_preview: false,
		feature_paging_api: false,
		feature_enterprise_api: false,
		feature_bot_profile: false,
		feature_two_factor_via_sms: true,
		feature_two_factor_for_teams: true,
		feature_signup_invite_step: true,
		feature_separate_private_channels: true,
		feature_private_channels: true,
		feature_mpim_restrictions: false,
		feature_filter_select_component: true,
		feature_subteams: true,
		feature_subteams_hard_delete: false,
		feature_no_unread_counts: true,
		feature_command_list_metadata: true,
		feature_slack_command_button_use: true,
		feature_slack_command_button_create: true,
		feature_js_raf_queue: false,
		feature_downloads_enhancements: true,
		feature_marketing_video_getting_started: true,
		feature_getvisibletopbanners_performance: false,
		feature_channel_page_perf: false,
		feature_shared_channels: false,
		feature_fast_files_flexpane: false,
		feature_no_has_files: true,
		feature_tab_complete_search_changed: false,
		feature_whats_new: true,
		feature_custom_saml_signin_button_label: false,
		feature_app_directory: true,
		feature_subteams_at_mention_tweaks: false,
		feature_dnd_client: false,
		feature_dnd_admin_launch: true,
		feature_dnd_dark_launch: true,
		feature_file_viewer: false,
		feature_fix_thumbsup_sorting: true,
		feature_admin_alphabetic_subset: false,
		feature_attached_bot_users: true,
		feature_jumper: false,
		feature_client_fast_reconnect: false,
		feature_mac_app_download_path: false,
		feature_inline_video: false,

		img: {
			app_icon: 'https://slack.global.ssl.fastly.net/272a/img/slack_growl_icon.png'
		},
		page_needs_custom_emoji: false,
		page_needs_team_profile_fields: false
	};

	
	// client boot data
			boot_data.login_data = null;
	
//-->
</script>			
	
						<!-- output_js "core" -->
<script type="text/javascript" src="https://slack.global.ssl.fastly.net/8aeb8/js/rollup-core_required_libs.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://slack.global.ssl.fastly.net/6a22/js/rollup-core_required_ts.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://slack.global.ssl.fastly.net/d9ca/js/TS.web.js" crossorigin="anonymous"></script>

	<!-- output_js "core_web" -->
<script type="text/javascript" src="https://slack.global.ssl.fastly.net/33c6/js/rollup-core_web.js" crossorigin="anonymous"></script>

	<!-- output_js "secondary" -->
<script type="text/javascript" src="https://slack.global.ssl.fastly.net/9eebb/js/rollup-secondary_a_required.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://slack.global.ssl.fastly.net/4035/js/rollup-secondary_b_required.js" crossorigin="anonymous"></script>

				<!-- output_js "regular" -->
<script type="text/javascript" src="https://slack.global.ssl.fastly.net/5070/js/TS.web.comments.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://slack.global.ssl.fastly.net/760c/js/TS.web.file.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://slack.global.ssl.fastly.net/eaf6/js/libs/codemirror.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://slack.global.ssl.fastly.net/6183/js/codemirror_load.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://slack.global.ssl.fastly.net/b9df/js/TS.ui.messages.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://slack.global.ssl.fastly.net/cee3/js/TS.user_groups.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://slack.global.ssl.fastly.net/40700/js/TS.ui.admin_user_groups.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://slack.global.ssl.fastly.net/90de/js/TS.ui.inline_saver.js" crossorigin="anonymous"></script>

		<script type="text/javascript">
	<!--
		boot_data.page_needs_custom_emoji = true;
		
		boot_data.file = {"id":"F0GQL0YAF","created":1450289883,"timestamp":1450289883,"name":"diana_no_data.sql","title":"diana_no_data.sql","mimetype":"text\/plain","filetype":"sql","pretty_type":"SQL","user":"U0DMGNMJL","editable":true,"size":12002,"mode":"snippet","is_external":false,"external_type":"","is_public":false,"public_url_shared":false,"display_as_bot":false,"username":"","url":"https:\/\/slack-files.com\/files-pub\/T0DLN22RJ-F0GQL0YAF-52511b3115\/diana_no_data.sql","url_download":"https:\/\/slack-files.com\/files-pub\/T0DLN22RJ-F0GQL0YAF-52511b3115\/download\/diana_no_data.sql","url_private":"https:\/\/files.slack.com\/files-pri\/T0DLN22RJ-F0GQL0YAF\/diana_no_data.sql","url_private_download":"https:\/\/files.slack.com\/files-pri\/T0DLN22RJ-F0GQL0YAF\/download\/diana_no_data.sql","permalink":"https:\/\/cs3380kander.slack.com\/files\/lsy123456798\/F0GQL0YAF\/diana_no_data.sql","permalink_public":"https:\/\/slack-files.com\/T0DLN22RJ-F0GQL0YAF-52511b3115","edit_link":"https:\/\/cs3380kander.slack.com\/files\/lsy123456798\/F0GQL0YAF\/diana_no_data.sql\/edit","preview":"-- MySQL dump 10.13  Distrib 5.6.27, for debian-linux-gnu (x86_64)\n--\n-- Host: us-cdbr-azure-central-a.cloudapp.net    Database: dianakanderdatabase\n-- ------------------------------------------------------\n-- Server version\t5.5.40-log","preview_highlight":"\u003Cdiv class=\"CodeMirror cm-s-default CodeMirrorServer\"\u003E\n\u003Cdiv class=\"CodeMirror-code\"\u003E\n\u003Cdiv\u003E\u003Cpre\u003E\u003Cspan class=\"cm-comment\"\u003E-- MySQL dump 10.13  Distrib 5.6.27, for debian-linux-gnu (x86_64)\u003C\/span\u003E\u003C\/pre\u003E\u003C\/div\u003E\n\u003Cdiv\u003E\u003Cpre\u003E\u003Cspan class=\"cm-comment\"\u003E--\u003C\/span\u003E\u003C\/pre\u003E\u003C\/div\u003E\n\u003Cdiv\u003E\u003Cpre\u003E\u003Cspan class=\"cm-comment\"\u003E-- Host: us-cdbr-azure-central-a.cloudapp.net    Database: dianakanderdatabase\u003C\/span\u003E\u003C\/pre\u003E\u003C\/div\u003E\n\u003Cdiv\u003E\u003Cpre\u003E\u003Cspan class=\"cm-comment\"\u003E-- ------------------------------------------------------\u003C\/span\u003E\u003C\/pre\u003E\u003C\/div\u003E\n\u003Cdiv\u003E\u003Cpre\u003E\u003Cspan class=\"cm-comment\"\u003E-- Server version\t5.5.40-log\u003C\/span\u003E\u003C\/pre\u003E\u003C\/div\u003E\n\u003C\/div\u003E\n\u003C\/div\u003E\n","lines":320,"lines_more":315,"channels":[],"groups":[],"ims":["D0DNW0ZGA"],"comments_count":0};
		boot_data.file.comments = [];

		

		var g_editor;

		$(function(){

			var wrap_long_lines = !!TS.model.code_wrap_long_lines;

			g_editor = CodeMirror(function(elt){
				var content = document.getElementById("file_contents");
				content.parentNode.replaceChild(elt, content);
			}, {
				value: $('#file_contents').text(),
				lineNumbers: true,
				matchBrackets: true,
				indentUnit: 4,
				indentWithTabs: true,
				enterMode: "keep",
				tabMode: "shift",
				viewportMargin: Infinity,
				readOnly: true,
				lineWrapping: wrap_long_lines
			});

			$('#file_preview_wrap_cb').bind('change', function(e) {
				TS.model.code_wrap_long_lines = $(this).prop('checked');
				g_editor.setOption('lineWrapping', TS.model.code_wrap_long_lines);
			})

			$('#file_preview_wrap_cb').prop('checked', wrap_long_lines);

			CodeMirror.switchSlackMode(g_editor, "sql");
		});

		
		$('#file_comment').css('overflow', 'hidden').autogrow();
	//-->
	</script>

			<script type="text/javascript">TS.boot(boot_data);</script>
	<!-- slack-www391 / 2015-12-16 11:59:37 / va727acd1f3ce01cb188412099c6e0015b71dd4bf -->
<style>.color_9f69e7:not(.nuc) {color:#9F69E7;}.color_4bbe2e:not(.nuc) {color:#4BBE2E;}.color_e7392d:not(.nuc) {color:#E7392D;}.color_3c989f:not(.nuc) {color:#3C989F;}.color_674b1b:not(.nuc) {color:#674B1B;}.color_e96699:not(.nuc) {color:#E96699;}.color_e0a729:not(.nuc) {color:#E0A729;}.color_684b6c:not(.nuc) {color:#684B6C;}.color_5b89d5:not(.nuc) {color:#5B89D5;}.color_2b6836:not(.nuc) {color:#2B6836;}.color_99a949:not(.nuc) {color:#99A949;}.color_df3dc0:not(.nuc) {color:#DF3DC0;}.color_4cc091:not(.nuc) {color:#4CC091;}.color_9b3b45:not(.nuc) {color:#9B3B45;}.color_d58247:not(.nuc) {color:#D58247;}.color_bb86b7:not(.nuc) {color:#BB86B7;}.color_5a4592:not(.nuc) {color:#5A4592;}.color_db3150:not(.nuc) {color:#DB3150;}.color_235e5b:not(.nuc) {color:#235E5B;}.color_9e3997:not(.nuc) {color:#9E3997;}.color_53b759:not(.nuc) {color:#53B759;}.color_c386df:not(.nuc) {color:#C386DF;}.color_385a86:not(.nuc) {color:#385A86;}.color_a63024:not(.nuc) {color:#A63024;}.color_5870dd:not(.nuc) {color:#5870DD;}.color_ea2977:not(.nuc) {color:#EA2977;}.color_50a0cf:not(.nuc) {color:#50A0CF;}.color_d55aef:not(.nuc) {color:#D55AEF;}.color_d1707d:not(.nuc) {color:#D1707D;}.color_43761b:not(.nuc) {color:#43761B;}.color_e06b56:not(.nuc) {color:#E06B56;}.color_8f4a2b:not(.nuc) {color:#8F4A2B;}.color_902d59:not(.nuc) {color:#902D59;}.color_de5f24:not(.nuc) {color:#DE5F24;}.color_a2a5dc:not(.nuc) {color:#A2A5DC;}.color_827327:not(.nuc) {color:#827327;}.color_3c8c69:not(.nuc) {color:#3C8C69;}.color_8d4b84:not(.nuc) {color:#8D4B84;}.color_84b22f:not(.nuc) {color:#84B22F;}.color_4ec0d6:not(.nuc) {color:#4EC0D6;}.color_e23f99:not(.nuc) {color:#E23F99;}.color_e475df:not(.nuc) {color:#E475DF;}.color_619a4f:not(.nuc) {color:#619A4F;}.color_a72f79:not(.nuc) {color:#A72F79;}.color_7d414c:not(.nuc) {color:#7D414C;}.color_aba727:not(.nuc) {color:#ABA727;}.color_965d1b:not(.nuc) {color:#965D1B;}.color_4d5e26:not(.nuc) {color:#4D5E26;}.color_dd8527:not(.nuc) {color:#DD8527;}.color_bd9336:not(.nuc) {color:#BD9336;}.color_e85d72:not(.nuc) {color:#E85D72;}.color_dc7dbb:not(.nuc) {color:#DC7DBB;}.color_bc3663:not(.nuc) {color:#BC3663;}.color_9d8eee:not(.nuc) {color:#9D8EEE;}.color_8469bc:not(.nuc) {color:#8469BC;}.color_73769d:not(.nuc) {color:#73769D;}.color_b14cbc:not(.nuc) {color:#B14CBC;}</style>
</body>
</html>