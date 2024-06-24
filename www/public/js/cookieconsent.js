document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si l'utilisateur a déjà donné son consentement
    if (!getCookie('cookies_accepted')) {
        setTimeout(function() {
            var overlay = document.getElementById('cookie-overlay');
            var banner = document.getElementById('cookie-banner');
            
            overlay.style.display = 'block';
            banner.style.display = 'block';

            setTimeout(function() {
                overlay.classList.add('show');
                banner.classList.add('show');
            }, 10); // Déclenche la transition après avoir rendu les éléments visibles
        }, 1000); // Délai de 1 seconde avant l'affichages
    }

    document.getElementById('accept-cookies').addEventListener('click', function() {
        handleCookieConsent();
    });

    document.getElementById('decline-cookies').addEventListener('click', function() {
        handleCookieConsent();
    });

    function handleCookieConsent() {
        setCookie('cookies_accepted', 'true', 365);
        var overlay = document.getElementById('cookie-overlay');
        var banner = document.getElementById('cookie-banner');

        overlay.classList.remove('show');
        banner.classList.remove('show');

        setTimeout(function() {
            overlay.style.display = 'none';
            banner.style.display = 'none';
        }, 1000); // Correspond au temps de la transition

        loadGoogleAnalytics();
    }

    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    function loadGoogleAnalytics() {
        console.log('Loading Google Analytics');
        var script = document.createElement("script");
        script.async = true;
        script.src = "https://www.googletagmanager.com/gtag/js?id=G-0KM60CKMNN";
        document.head.appendChild(script);

        script.onload = function() {
            console.log('Google Analytics script loaded');
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-0KM60CKMNN');
        };
    }
});
