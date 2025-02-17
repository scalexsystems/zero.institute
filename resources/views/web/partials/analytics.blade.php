{{--Customer Support Drift Code--}}
@if(app()->environment('production'))
    <script>
    !function () {
        var t;
        if (t = window.driftt = window.drift = window.driftt || [], !t.init) return t.invoked ? void (window.console && console.error && console.error("Drift snippet included twice.")) : (t.invoked = !0,
                t.methods = ["identify", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on"],
                t.factory = function (e) {
                    return function () {
                        var n;
                        return n = Array.prototype.slice.call(arguments), n.unshift(e), t.push(n), t;
                    };
                }, t.methods.forEach(function (e) {
            t[e] = t.factory(e);
        }), t.load = function (t) {
            var e, n, o, r;
            e = 3e5, r = Math.ceil(new Date() / e) * e, o = document.createElement("script"),
                    o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + r + "/" + t + ".js",
                    n = document.getElementsByTagName("script")[0], n.parentNode.insertBefore(o, n);
        });
    }();
    drift.SNIPPET_VERSION = '0.2.0';
    drift.load('f2z3b8cva7rd')
    </script>

    {{--Heap Analytics--}}
    <script type="text/javascript">
    window.heap = window.heap || [], heap.load = function (e, t) {
        window.heap.appid = e, window.heap.config = t = t || {};
        var r = t.forceSSL || "https:" === document.location.protocol, a = document.createElement("script");
        a.type = "text/javascript", a.async = !0, a.src = (r ? "https:" : "http:") + "//cdn.heapanalytics.com/js/heap-" + e + ".js";
        var n = document.getElementsByTagName("script")[0];
        n.parentNode.insertBefore(a, n);
        for (var o = function (e) {
            return function () {
                heap.push([e].concat(Array.prototype.slice.call(arguments, 0)))
            }
        }, p = ["addEventProperties", "addUserProperties", "clearEventProperties", "identify", "removeEventProperty", "setEventProperties", "track", "unsetEventProperty"], c = 0; c < p.length; c++)heap[p[c]] = o(p[c])
    };
    heap.load("464716080");
    </script>

    {{--Google Tracking--}}
    <script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-78569809-2', 'auto');
    ga('send', 'pageview');
    </script>

    {{--Google Tag Manager--}}
    <noscript>
        <iframe src="//www.googletagmanager.com/ns.html?id=GTM-KK78LZ"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <script>
    (function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(), event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
                '//www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-KK78LZ');</script>

    {{--Facebook Pixel Code--}}
    <script>
    !function (f, b, e, v, n, t, s) {
        if (f.fbq)return;
        n = f.fbq = function () {
            n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq)f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window,
            document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

    fbq('init', '1771971653087393');
    fbq('track', "PageView");
    fbq('track', 'ViewContent');
    fbq('track', 'Lead');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
             src="https://www.facebook.com/tr?id=1771971653087393&ev=PageView&noscript=1"/></noscript>
@endif