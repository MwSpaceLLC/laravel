@if(config('mwspace.iubenda.site_id') && config('mwspace.iubenda.policy_id'))
    <script type="text/javascript">
        var _iub = _iub || [];
        _iub.csConfiguration = {
            "askConsentAtCookiePolicyUpdate": true,
            "floatingPreferencesButtonDisplay": "{{config('mwspace.iubenda.floating')}}",
            "perPurposeConsent": true,
            "siteId": "{{config('mwspace.iubenda.site_id')}}",
            "cookiePolicyId": "{{config('mwspace.iubenda.policy_id')}}",
            "lang": "it",
            "banner": {
                "acceptButtonCaptionColor": "#FFFFFF",
                "acceptButtonColor": "#282828",
                "acceptButtonDisplay": true,
                "backgroundColor": "#FFFFFF",
                "closeButtonRejects": true,
                "customizeButtonCaptionColor": "#4D4D4D",
                "customizeButtonColor": "#DADADA",
                "customizeButtonDisplay": true,
                "explicitWithdrawal": true,
                "listPurposes": true,
                "logo": null,
                "ownerName": false,
                "position": "bottom",
                "showTitle": false,
                "textColor": "#000000"
            }
        };
    </script>

    <script type="text/javascript"
            src="https://cs.iubenda.com/autoblocking/{{config('mwspace.iubenda.site_id')}}.js"></script>
    <script type="text/javascript" src="//cdn.iubenda.com/cs/iubenda_cs.js" charset="UTF-8" async></script>

    <script type="text/javascript">(function (w, d) {
            var loader = function () {
                var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0];
                s.src = "https://cdn.iubenda.com/iubenda.js";
                tag.parentNode.insertBefore(s, tag);
            };
            if (w.addEventListener) {
                w.addEventListener("load", loader, false);
            } else if (w.attachEvent) {
                w.attachEvent("onload", loader);
            } else {
                w.onload = loader;
            }
        })(window, document);</script>
@endif

@if(config('mwspace.google.analytics_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{config('mwspace.google.analytics_id')}}"></script>

    <!-- Google tag (gtag.js) -->
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '{{config('mwspace.google.analytics_id')}}');
    </script>
@endif
