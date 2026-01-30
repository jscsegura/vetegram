(function() {
    const config = window.INVOICE_CREATE_CONFIG || {};
    const products = config.products || [];
    const labels = config.labels || {};
    const helpers = window.vetegramHelpers || {};

    const selectors = {
        form: '#frmInv',
        typeInput: '#typeInvoice',
        rows: '#rowsInvoice',
        total: '#printerGranTotal',
        clientSelect: '#client'
    };

    function initSelect2(context) {
        if (helpers.initSelect2) {
            helpers.initSelect2('.select2', {}, context || null);
        }
    }

    function initDateDropper() {
        if (typeof dateDropper === 'undefined') {
            return;
        }
        new dateDropper({
            selector: '.dDropper',
            format: 'd/m/y',
            expandable: true,
            showArrowsOnHover: true
        });
    }

    function showDeleteConfirm() {
        const SwalLib = window.Swal || window.swal;
        if (!SwalLib) return Promise.resolve(false);
        const swalWithBootstrapButtons = SwalLib.mixin({
            customClass: {
                confirmButton: 'btn btn-primary btn-sm text-uppercase px-4 marginleft20',
                cancelButton: 'btn btn-danger btn-sm text-uppercase px-4'
            },
            buttonsStyling: false
        });
        return swalWithBootstrapButtons.fire({
            title: labels.deleteRowTitle || '',
            text: labels.deleteRowText || '',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: labels.deleteYes || '',
            cancelButtonText: labels.deleteNo || '',
            reverseButtons: true
        }).then((result) => result.isConfirmed);
    }

    function selectClient(select) {
        if (!select) return;
        const option = select.options[select.selectedIndex];
        if (!option) return;
        const name = option.getAttribute('data-name') || '';
        const phone = option.getAttribute('data-phone') || '';
        const email = option.getAttribute('data-email') || '';
        const typedni = option.getAttribute('data-typedni') || '';
        const dni = option.getAttribute('data-dni') || '';

        const nameInput = document.getElementById('invoiceName');
        const typeInput = document.getElementById('invoiceDniType');
        const dniInput = document.getElementById('invoiceDni');
        const phoneInput = document.getElementById('invoicePhone');
        const emailInput = document.getElementById('invoiceEmail');

        if (nameInput) nameInput.value = name;
        if (typeInput) typeInput.value = typedni;
        if (dniInput) dniInput.value = dni;
        if (phoneInput) phoneInput.value = phone;
        if (emailInput) emailInput.value = email;
    }

    function validateForm() {
        let valid = true;
        document.querySelectorAll('.requerido').forEach((elem) => {
            const value = (elem.value || '').toString().trim();
            if (value === '') {
                elem.classList.add('is-invalid');
                valid = false;
            } else {
                elem.classList.remove('is-invalid');
            }
        });
        if (valid && typeof setCharge === 'function') {
            setCharge();
        }
        return valid;
    }

    function createInvoice(type) {
        const typeInput = document.querySelector(selectors.typeInput);
        const form = document.querySelector(selectors.form);
        if (typeInput) typeInput.value = type;
        if (form) {
            if (typeof form.requestSubmit === 'function') {
                form.requestSubmit();
            } else {
                form.submit();
            }
        }
    }

    function getRandom() {
        let random = Math.random();
        random = random + '';
        random = random.replace('.', '');
        random = random.replaceAll(/0/g, '1');
        return random;
    }

    function formatCurrency(value) {
        if (typeof numeral === 'undefined') {
            return `¢${Number(value).toFixed(2)}`;
        }
        return '¢' + numeral(value).format('0,0.00');
    }

    function getLineId(target) {
        if (!target) return null;
        const lineId = target.getAttribute('data-line-id');
        if (lineId) return lineId;
        const row = target.closest('[data-line-id]');
        return row ? row.getAttribute('data-line-id') : null;
    }

    function buildProductsOptions(lineId) {
        let list = `<option value="">${labels.selectLabel || ''}</option>`;
        list += `<option value="0" data-line-id="${lineId}" data-id="0" data-description="" data-subprice="0" data-price="0" data-type="gravado" data-cabys="3564001000000" data-rate="08" data-unit="Producto">Otro</option>`;
        products.forEach((value) => {
            list += `<option value="${value.id}" data-line-id="${lineId}" data-id="${value.id}" data-description="${value.description}" data-subprice="${value.subprice}" data-price="${value.price}" data-type="${value.type}" data-cabys="${value.cabys}" data-rate="${value.rate}" data-unit="${value.unit}">${value.title}</option>`;
        });
        return list;
    }

    function renderAddLineRow() {
        return `<tr id="btnAddline"><td class="px-2 px-lg-3 py-0 py-md-2 py-lg-4 text-end shadow-none" colspan="9"><button type="button" class="btn btn-outline-primary btn-sm px-4" data-invoice-action="line-add"><i class="fa-solid fa-plus me-1"></i>${labels.addLine || ''}</button></td></tr>`;
    }

    function newLine() {
        const lineId = getRandom();
        const listProducts = buildProductsOptions(lineId);
        const rowHtml = `
            <tr id="rowInvoice${lineId}" data-line-id="${lineId}">
                <input type="hidden" name="productCode[]" id="productCode${lineId}" class="productCodeList" value="${lineId}">
                <input type="hidden" name="productId[]" id="productId${lineId}" value="0">
                <input type="hidden" name="cabys[]" id="cabys${lineId}" value="">
                <input type="hidden" name="unit[]" id="unit${lineId}" value="">
                <td class="px-2 py-2 py-lg-4" data-label="Eliminar:">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-invoice-action="line-remove" data-line-id="${lineId}">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </td>
                <td class="px-2 py-2 py-lg-4" data-label="Cantidad:">
                    <div class="d-table">
                        <div class="input-group w-auto align-items-center">
                            <input type="text" class="form-control form-control-sm fw-semibold text-center requerido invoice-numeric" id="quantity${lineId}" name="quantity[]" value="1" size="1" data-invoice-action="line-quantity" data-line-id="${lineId}">
                        </div>
                    </div>
                </td>
                <td class="px-2 py-2 py-lg-4" data-label="Pro/Ser:">
                    <select class="form-select form-select-sm select2 requerido" id="product${lineId}" name="product[]" data-invoice-action="line-product" data-line-id="${lineId}">
                        ${listProducts}
                    </select>
                </td>
                <td class="px-2 py-2 py-lg-4" data-label="Detalles:">
                    <input type="text" class="form-control form-control-sm requerido" name="detail[]" id="detail${lineId}" value="">
                </td>
                <td class="px-2 py-2 py-lg-4" data-label="Gravado:">
                    <select class="form-select form-select-sm requerido" id="gravado${lineId}" name="gravado[]">
                        <option value=""></option>
                        <option value="gravado">Gravado</option>
                        <option value="exento">Exento</option>
                    </select>
                </td>
                <td class="px-2 py-2 py-lg-4" data-label="Precio:">
                    <input type="text" class="form-control form-control-sm requerido invoice-numeric" name="productSubPrice[]" id="productSubPrice${lineId}" value="0" data-invoice-action="line-subprice" data-line-id="${lineId}">
                </td>
                <td class="px-2 py-2 py-lg-4" data-label="IVA:">
                    <select class="form-select form-select-sm requerido" id="rate${lineId}" name="rate[]" data-invoice-action="line-rate" data-line-id="${lineId}">
                        <option value=""></option>
                        <option value="01">0%</option>
                        <option value="02">1%</option>
                        <option value="03">2%</option>
                        <option value="04">4%</option>
                        <option value="05">0%</option>
                        <option value="06">4%</option>
                        <option value="07">8%</option>
                        <option value="08">13%</option>
                        <option value="09">0.5%</option>
                    </select>
                </td>
                <td class="px-2 py-2 py-lg-4 text-end" data-label="Precio:">
                    <input type="text" class="form-control form-control-sm requerido invoice-numeric" name="productPrice[]" id="productPrice${lineId}" value="0" data-invoice-action="line-price" data-line-id="${lineId}">
                </td>
                <td class="px-2 py-2 py-lg-4 text-end" data-label="Tot. lin.:" id="printPriceTotalLine${lineId}">¢0.00</td>
            </tr>
        `;

        const rows = document.querySelector(selectors.rows);
        if (!rows) return;
        const addLine = document.getElementById('btnAddline');
        if (addLine) {
            addLine.remove();
        }
        rows.insertAdjacentHTML('beforeend', rowHtml);
        rows.insertAdjacentHTML('beforeend', renderAddLineRow());

        initSelect2(rows);
    }

    function setTotals() {
        let total = 0;
        document.querySelectorAll('.productCodeList').forEach((elem) => {
            const code = elem.value;
            const priceInput = document.getElementById(`productPrice${code}`);
            const quantityInput = document.getElementById(`quantity${code}`);
            const price = priceInput ? parseFloat(priceInput.value || '0') : 0;
            let quantity = quantityInput ? parseFloat(quantityInput.value || '0') : 0;
            if (!Number.isFinite(quantity) || quantity === 0) {
                quantity = 1;
            }
            if (price > 0) {
                total += price * quantity;
            }
        });
        const totalEl = document.querySelector(selectors.total);
        if (totalEl) {
            totalEl.textContent = formatCurrency(total);
        }
    }

    function updateLineTotal(lineId) {
        const priceInput = document.getElementById(`productPrice${lineId}`);
        const quantityInput = document.getElementById(`quantity${lineId}`);
        const price = priceInput ? parseFloat(priceInput.value || '0') : 0;
        let quantity = quantityInput ? parseFloat(quantityInput.value || '0') : 0;
        if (!Number.isFinite(quantity) || quantity === 0) {
            quantity = 1;
        }
        const totalLine = price > 0 ? formatCurrency(price * quantity) : '¢0.00';
        const totalLineEl = document.getElementById(`printPriceTotalLine${lineId}`);
        if (totalLineEl) {
            totalLineEl.textContent = totalLine;
        }
    }

    function selectRow(select) {
        const option = select.options[select.selectedIndex];
        if (!option) return;
        const lineId = option.getAttribute('data-line-id') || getLineId(select);
        if (!lineId) return;

        const id = option.getAttribute('data-id') || '0';
        const description = option.getAttribute('data-description') || '';
        const subprice = option.getAttribute('data-subprice') || '0';
        const price = option.getAttribute('data-price') || '0';
        const type = option.getAttribute('data-type') || '';
        const cabys = option.getAttribute('data-cabys') || '';
        const rate = option.getAttribute('data-rate') || '';
        const unit = option.getAttribute('data-unit') || '';

        const productId = document.getElementById(`productId${lineId}`);
        const productSubPrice = document.getElementById(`productSubPrice${lineId}`);
        const productPrice = document.getElementById(`productPrice${lineId}`);
        const detail = document.getElementById(`detail${lineId}`);
        const gravado = document.getElementById(`gravado${lineId}`);
        const rateInput = document.getElementById(`rate${lineId}`);
        const cabysInput = document.getElementById(`cabys${lineId}`);
        const unitInput = document.getElementById(`unit${lineId}`);

        if (productId) productId.value = id;
        if (productSubPrice) productSubPrice.value = subprice;
        if (productPrice) productPrice.value = price;
        if (detail) detail.value = description;
        if (gravado) gravado.value = type;
        if (rateInput) rateInput.value = rate;
        if (cabysInput) cabysInput.value = cabys;
        if (unitInput) unitInput.value = unit;

        updateLineTotal(lineId);
        setTotals();
    }

    function setQuantity(lineId) {
        updateLineTotal(lineId);
        setTotals();
    }

    function calculatePrice(lineId, type) {
        const subpriceInput = document.getElementById(`productSubPrice${lineId}`);
        const priceInput = document.getElementById(`productPrice${lineId}`);
        const rateInput = document.getElementById(`rate${lineId}`);
        let subprice = subpriceInput ? parseFloat(subpriceInput.value || '0') : 0;
        let price = priceInput ? parseFloat(priceInput.value || '0') : 0;
        const rate = rateInput ? rateInput.value : '';

        if (!Number.isFinite(subprice)) subprice = 0;
        if (!Number.isFinite(price)) price = 0;

        let taxes = 0;
        switch (rate) {
            case '01': taxes = 0; break;
            case '02': taxes = 1; break;
            case '03': taxes = 2; break;
            case '04': taxes = 4; break;
            case '05': taxes = 0; break;
            case '06': taxes = 4; break;
            case '07': taxes = 8; break;
            case '08': taxes = 13; break;
            case '09': taxes = 0.5; break;
            default: taxes = 0; break;
        }

        if (type === 1 || type === 2) {
            if (rate !== '' && taxes > 0) {
                const impuesto = (taxes / 100) * subprice;
                const total = subprice + impuesto;
                if (priceInput) priceInput.value = total.toFixed(2);
            } else {
                if (priceInput) priceInput.value = subprice;
            }
        } else if (type === 3) {
            if (rate !== '' && taxes > 0) {
                const montoBase = price / (1 + (taxes / 100));
                if (subpriceInput) subpriceInput.value = montoBase.toFixed(2);
            } else {
                if (subpriceInput) subpriceInput.value = price;
            }
        }

        setQuantity(lineId);
    }

    function removeRow(lineId) {
        if (!lineId) return;
        showDeleteConfirm().then((confirmed) => {
            if (!confirmed) return;
            const row = document.getElementById(`rowInvoice${lineId}`);
            if (row) {
                row.remove();
            }
            setTotals();
        });
    }

    document.addEventListener('click', function(event) {
        const addBtn = event.target.closest('[data-invoice-action="line-add"]');
        if (addBtn) {
            newLine();
            return;
        }

        const removeBtn = event.target.closest('[data-invoice-action="line-remove"]');
        if (removeBtn) {
            const lineId = removeBtn.getAttribute('data-line-id') || getLineId(removeBtn);
            removeRow(lineId);
            return;
        }

        const createBtn = event.target.closest('[data-invoice-action="create-invoice"]');
        if (createBtn) {
            const type = createBtn.getAttribute('data-invoice-type') || '0';
            createInvoice(type);
        }
    });

    document.addEventListener('change', function(event) {
        const target = event.target;
        if (!target) return;

        if (target.matches('[data-invoice-action="client-select"]')) {
            selectClient(target);
            return;
        }

        if (target.matches('[data-invoice-action="line-product"]')) {
            selectRow(target);
            return;
        }

        if (target.matches('[data-invoice-action="line-quantity"]')) {
            const lineId = getLineId(target);
            if (lineId) setQuantity(lineId);
            return;
        }

        if (target.matches('[data-invoice-action="line-rate"]')) {
            const lineId = getLineId(target);
            if (lineId) calculatePrice(lineId, 2);
        }
    });

    document.addEventListener('keyup', function(event) {
        const target = event.target;
        if (!target) return;
        if (target.matches('[data-invoice-action="line-subprice"]')) {
            const lineId = getLineId(target);
            if (lineId) calculatePrice(lineId, 1);
        }
        if (target.matches('[data-invoice-action="line-price"]')) {
            const lineId = getLineId(target);
            if (lineId) calculatePrice(lineId, 3);
        }
    });

    document.addEventListener('keydown', function(event) {
        const target = event.target;
        if (target && target.classList.contains('invoice-numeric') && helpers.enterOnlyNumbers) {
            helpers.enterOnlyNumbers(event);
        }
    });

    document.addEventListener('submit', function(event) {
        const form = event.target;
        if (form && form.matches(selectors.form)) {
            if (!validateForm()) {
                event.preventDefault();
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        initSelect2();
        initDateDropper();
        setTotals();
    });
})();
