<script src="https://cdn.jsdelivr.net/gh/MwSpaceLLC/formSubmitLoading@1.2/formSubmitLoading.min.js"></script>
<script type="text/javascript" src="https://cs.iubenda.com/autoblocking/{{env('IUBENDA_POLICY_ID')}}.js"></script>
<script type="text/javascript" src="//cdn.iubenda.com/cs/iubenda_cs.js" charset="UTF-8" async></script>
<script src="https://cdn.iubenda.com/iubenda.js"></script>
<script type="text/javascript">
    const _iub = _iub || [];
    _iub.csConfiguration = {
        "askConsentAtCookiePolicyUpdate": true,
        "floatingPreferencesButtonDisplay": "top-left",
        "perPurposeConsent": true,
        "siteId": "{{env('IUBENDA_POLICY_ID')}}",
        "cookiePolicyId": "{{env('IUBENDA_COOKIE_ID')}}",
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

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{env('GOOGLE_ANALYTICS')}}"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', '{{env('GOOGLE_ANALYTICS')}}');
</script>
