(function() {
    var config = window.APPOINT_MODAL_CONFIG || {};
    var base = config.assetsBase || '/js/appointments/modals/';
    var modules = [
        'cancel',
        'only-cancel',
        'only-reschedule',
        'reminder',
        'attach',
        'send-attach',
        'send-recipe',
        'add-vaccine',
        'add-desparat',
        'add-external-vaccine',
        'notes',
        'recipe',
        'recipe-add',
        'recipe-edit',
        'show-recipe',
        'search-user',
        'create-user',
        'create-pet',
        'grooming',
        'physical-exam'
    ];

    function loadScript(src) {
        return new Promise(function(resolve) {
            var script = document.createElement('script');
            script.src = src;
            script.async = false;
            script.onload = function() { resolve(); };
            script.onerror = function() { resolve(); };
            document.head.appendChild(script);
        });
    }

    var chain = Promise.resolve();
    modules.forEach(function(name) {
        chain = chain.then(function() {
            return loadScript(base + name + '.js');
        });
    });
})();
