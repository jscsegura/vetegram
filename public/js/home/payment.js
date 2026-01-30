(function () {
    const Home = window.Home = window.Home || {};
    const config = window.HOME_PAYMENT_CONFIG || {};
    const texts = config.texts || {};

    async function initTilopay() {
        if (!window.Tilopay || !config.tilopay) {
            return;
        }

        const initialize = await Tilopay.Init(config.tilopay);

        if (initialize.message === 'Success') {
            $('#msgError').hide();
            await setTestMode(initialize.environment);
            await chargeMethods(initialize.methods || []);
            await chargeCards(initialize.cards || []);
        } else {
            $('#msgError').html('<i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>' + initialize.message);
            $('#msgError').show();
        }
    }

    async function setTestMode(test) {
        if (test === 'PROD') {
            $('#msgTest').hide();
        } else {
            $('#msgTest').show();
        }
    }

    async function chargeMethods(methods) {
        methods.forEach(function (method) {
            if (method.type === 'card') {
                const option = document.createElement('option');
                option.value = method.id;
                option.text = method.name;
                const select = document.getElementById('tlpy_payment_method');
                if (select) {
                    select.appendChild(option);
                }
            }
        });
    }

    async function chargeCards(cards) {
        let totalCards = 0;

        cards.forEach(function (card) {
            const option = document.createElement('option');
            option.value = card.id;
            option.text = card.name;
            const select = document.getElementById('tlpy_saved_cards');
            if (select) {
                select.appendChild(option);
                totalCards++;
            }
        });

        if (totalCards > 0) {
            $('#selectToken').show();
        }
    }

    function selectCard(card) {
        if (card === '') {
            $('.withToken').show();
        } else {
            $('.withToken').hide();
        }
    }

    async function pay() {
        let validate = true;

        if (!$('#terms').is(':checked')) {
            validate = false;
            $('#msgError').html('<i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>' + (texts.termAccept || ''));
            $('#msgError').show();
        }

        if (validate) {
            if (typeof Home.setCharge === 'function') {
                setCharge();
            }

            const payment = await Tilopay.startPayment();

            if (payment.message !== '') {
                $('#msgError').html('<i class="fa-solid fa-triangle-exclamation opacity-50 me-2"></i>' + payment.message);
                $('#msgError').show();

                if (typeof Home.hideCharge === 'function') {
                    hideCharge();
                }
            } else {
                $('#msgError').hide();
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        initTilopay();
    });

    Home.selectCard = selectCard;
    Home.pay = pay;
})();
