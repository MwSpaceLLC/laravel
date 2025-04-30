<script async src="https://www.googletagmanager.com/gtag/js?id={{env('GOOGLE_ANALYTICS_ID')}}"></script>
<script src="https://www.google.com/recaptcha/api.js?render={{env('GOOGLE_RECAPTCHA_PUBLIC_KEY')}}"></script>

<script type="text/javascript" src="https://cs.iubenda.com/autoblocking/{{env('IUBENDA_SITE_ID')}}.js"></script>
<script type="text/javascript" src="//cdn.iubenda.com/cs/iubenda_cs.js" charset="UTF-8" async></script>

<script src="https://cdn.iubenda.com/iubenda.js"></script>
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

<!-- Google tag (gtag.js) -->
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', '{{env('GOOGLE_ANALYTICS_ID')}}');
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Seleziona tutti i form con la classe 'mw-contact-form'
        const forms = document.querySelectorAll('form.mw-contact-form');

        // azioni per il form
        forms.forEach(form => {
            // Seleziona tutti gli input e le textarea all'interno del form
            const inputs = form.querySelectorAll('input');
            const textareas = form.querySelectorAll('textarea');
            const submitButton = form.querySelector('button[type="submit"]');

            // Funzione per limitare la lunghezza
            function limitLength(element, maxLength) {

                if (element.name === 'name' || element.name === 'email' || element.name === 'message') {
                    element.setAttribute('required', 'true')
                }

                element.addEventListener('input', function (e) {
                    if (this.value.length > maxLength) {
                        this.value = this.value.slice(0, maxLength);
                    }
                });
            }

            // Applica il limite di 250 caratteri agli input
            inputs.forEach(input => limitLength(input, 100));

            // Applica il limite di 500 caratteri alle textarea
            textareas.forEach(textarea => limitLength(textarea, 500));

            // Aggiungi l'evento onsubmit personalizzato
            form.addEventListener('submit', function (e) {

                // Disabilita il pulsante e aggiungi i puntini di caricamento
                const originalButtonText = submitButton.textContent;
                submitButton.disabled = true;
                submitButton.textContent = originalButtonText + '...';

                // Previeni l'invio immediato del form
                e.preventDefault();

                grecaptcha.ready(async () => {
                    try {

                        const token = await grecaptcha.execute('{{env('GOOGLE_RECAPTCHA_PUBLIC_KEY')}}', {action: 'submit'});

                        // append the token
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'g-recaptcha-response';
                        input.value = token;
                        form.appendChild(input);

                        // submit the form
                        form.submit();

                    } catch (err) {
                        console.error('Errore:', err);
                        alert(err);
                        submitButton.disabled = false;
                        submitButton.textContent = originalButtonText;
                    }
                });

            });

        });
    });
</script>
