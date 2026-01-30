(function() {
    const module = window.AppointmentsStart;
    if (!module) {
        return;
    }
    const routes = module.routes || {};
    const texts = module.texts || {};
    const helpers = module.helpers || {};

    module.vaccines = module.vaccines || {};

    module.vaccines.getBreed = function() {
        const type = $('#animaltype').val();
        if (!routes.getBreed) {
            return;
        }

        const request = helpers.ajaxPost
            ? helpers.ajaxPost(routes.getBreed, { type: type }, { beforeSend: function() {} })
            : $.ajax({
                type: 'POST',
                url: routes.getBreed,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': helpers.getCsrfToken ? helpers.getCsrfToken() : ''
                },
                data: {
                    type: type
                },
                beforeSend: function() {}
            });

        request.done(function(data) {
            var html = `<option value="">${texts.select || ''}</option>`;
            $.each(data.rows || [], function(i, item) {
                html = html + '<option value="' + item.id + '">' + item.title + '</option>';
            });

            $('#breed').html(html);
        });
    };
})();
