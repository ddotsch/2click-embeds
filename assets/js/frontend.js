(function() {
    'use strict';

    if(typeof TwoClickEmbeds === 'undefined' || !TwoClickEmbeds.providerScripts) {
        return;
    }

    const COOKIE = TwoClickEmbeds.cookieName;
    const providerScripts = TwoClickEmbeds.providerScripts;

    function getConsent() {
        const consent = [];
        const cookie = document.cookie.split('; ').find(row => row.startsWith(COOKIE + '='));

        if (cookie) {
            const value = cookie.split('=')[1];
            return value.split(',');
        }
        
        return consent;
    }

    function setConsent(consent) {
        const filtered = consent.filter(Boolean);
        const date = new Date();
        date.setTime(date.getTime() + 365*24*60*60*1000);
        const expires = "expires=" + date.toUTCString();

        if (filtered.length === 0) {
            document.cookie = COOKIE + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
        } else {
            document.cookie = COOKIE + "=" + filtered.join(',') + ";" + expires + ";path=/";
        }
    }

    function addConsent(slug) {
        const consent = getConsent();
        if (!consent.includes(slug)) {
            consent.push(slug);
            setConsent(consent);
        }
    }

    function removeConsent(slug) {
        let consent = getConsent();
        consent = consent.filter(item => item !== slug);
        setConsent(consent);
    }

    function loadProviderScript(slug) {
        if (providerScripts[slug]) {
            const script = document.createElement('script');
            script.src = providerScripts[slug];
            script.async = true;
            document.body.appendChild(script);
        }
    }

    function loadProviderEmbeds(slug) {
        document.querySelectorAll(`.external-2click[data-provider-slug="${slug}"]`).forEach(wrapper => {
            wrapper.classList.add('is-loaded');
            const target = wrapper.querySelector('.external-2click-target');
            const placeholder = wrapper.querySelector('.external-placeholder');

            if (target && target.dataset.src) {
                target.setAttribute('src', target.dataset.src);
            }

            if(placeholder) {
                placeholder.remove();
            }
        });
        loadProviderScript(slug);
    }

    document.addEventListener('click', function(event) {
        //load external content
        if (event.target && event.target.classList.contains('external-load')) {
            
            const wrapper = event.target.closest('.external-2click');
            const slug = wrapper.getAttribute('data-provider-slug');

            addConsent(slug);
            loadProviderEmbeds(slug);
        }

        //revoke consent
        if (event.target && event.target.dataset.revoke) {
            event.preventDefault();
            const slug = event.target.dataset.revoke;
            
            removeConsent(slug);
            window.location.reload(true);
        }
    });

    getConsent().forEach(loadProviderEmbeds);
})();