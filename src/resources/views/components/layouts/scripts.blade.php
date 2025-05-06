@if(env('IUBENDA_SITE_ID') !== null && env('IUBENDA_POLICY_ID') !== null)
    <script type="text/javascript">
        const _iub = _iub || [];
        _iub.csConfiguration = {
            "askConsentAtCookiePolicyUpdate": true,
            "floatingPreferencesButtonDisplay": "{{env('IUBENDA_FLOATING_PREFERENCE','anchored-center-right')}}",
            "perPurposeConsent": true,
            "siteId": "{{env('IUBENDA_SITE_ID')}}",
            "cookiePolicyId": "{{env('IUBENDA_POLICY_ID')}}",
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

    <script type="text/javascript" src="https://cs.iubenda.com/autoblocking/{{env('IUBENDA_SITE_ID')}}.js"></script>
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

@if(env('GOOGLE_ANALYTICS_ID') !== null)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{env('GOOGLE_ANALYTICS_ID')}}"></script>

    <!-- Google tag (gtag.js) -->
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '{{env('GOOGLE_ANALYTICS_ID')}}');
    </script>
@endif

@if(env('GOOGLE_RECAPTCHA_PUBLIC_KEY') !== null)
    <script src="https://cdn.mwspace.com/script/g.reCAPTCHA.min.js"></script>
@endif
