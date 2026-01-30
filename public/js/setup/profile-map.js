(function() {
    const module = window.SetupCompleteProfile = window.SetupCompleteProfile || {};
    const mapModule = module.map = module.map || {};
    mapModule.state = mapModule.state || {
        map: null,
        marker: null,
        pinDot: null,
        geocodeController: null
    };

    function setMapLoading(isLoading) {
        const loader = document.getElementById('mapLoading');
        const mapEl = document.getElementById('clinicMap');
        if (!loader) return;
        loader.classList.toggle('d-none', !isLoading);
        if (mapEl) {
            mapEl.classList.toggle('map-hidden', isLoading);
        }
    }

    async function geocode(query, signal = null) {
        if (!query) return null;
        const url = `https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(query)}`;
        let res = null;
        try {
            res = await fetch(url, { headers: { 'Accept-Language': 'es,en' }, signal });
        } catch (_e) {
            return null;
        }
        if (!res.ok) return null;
        const data = await res.json();
        if (!data.length) return null;
        const bbox = data[0].boundingbox
            ? [
                [parseFloat(data[0].boundingbox[0]), parseFloat(data[0].boundingbox[2])],
                [parseFloat(data[0].boundingbox[1]), parseFloat(data[0].boundingbox[3])]
              ]
            : null;
        return { lat: parseFloat(data[0].lat), lng: parseFloat(data[0].lon), bbox };
    }

    function ensureMarkerIcon() {
        if (mapModule.markerIcon) {
            return mapModule.markerIcon;
        }
        mapModule.markerIcon = L.divIcon({
            className: 'clinic-pin',
            html: '<div style="width:16px;height:16px;background:#4bc6f9;border:3px solid #152630;border-radius:50%;box-shadow:0 0 0 4px rgba(75,198,249,.25);"></div>',
            iconSize: [16, 16],
            iconAnchor: [8, 8]
        });
        return mapModule.markerIcon;
    }

    function setMarker(lat, lng) {
        const state = mapModule.state;
        if (!state.map) {
            return;
        }
        const markerIcon = ensureMarkerIcon();
        if (!state.marker) {
            state.marker = L.marker([lat, lng], { icon: markerIcon, draggable: true }).addTo(state.map);
            state.marker.on('dragend', function(e) {
                const pos = e.target.getLatLng();
                $('#lat').val(pos.lat.toFixed(6));
                $('#lng').val(pos.lng.toFixed(6));
                $('#lat, #lng').trigger('change');
            });
        } else {
            state.marker.setLatLng([lat, lng]);
            state.marker.setIcon(markerIcon);
        }
        $('#lat').val(lat.toFixed(6));
        $('#lng').val(lng.toFixed(6));
        $('#lat, #lng').trigger('change');
    }

    mapModule.setMarker = setMarker;

    mapModule.syncMapToStoredPin = function() {
        const state = mapModule.state;
        const latRaw = $('#lat').val();
        const lngRaw = $('#lng').val();
        if (!latRaw || !lngRaw) {
            return false;
        }
        const lat = parseFloat(latRaw);
        const lng = parseFloat(lngRaw);
        if (isNaN(lat) || isNaN(lng)) {
            return false;
        }
        if (state.map) {
            state.map.invalidateSize();
        }
        setMarker(lat, lng);
        if (state.map) {
            state.map.setView([lat, lng], 16);
        }
        if (state.marker) {
            state.marker.setZIndexOffset(1000);
        }
        if (state.map) {
            if (!state.pinDot) {
                state.pinDot = L.circleMarker([lat, lng], {
                    radius: 6,
                    color: '#152630',
                    weight: 2,
                    fillColor: '#4bc6f9',
                    fillOpacity: 0.95
                }).addTo(state.map);
            } else {
                state.pinDot.setLatLng([lat, lng]);
            }
        }
        if (state.map) {
            setTimeout(() => {
                state.map.invalidateSize();
                state.map.setView([lat, lng], 16);
            }, 250);
        }
        return true;
    };

    mapModule.updateMapFromAddress = async function() {
        const state = mapModule.state;
        if (!state.map) {
            return;
        }
        const countryText = $('#country option:selected').text();
        const provinceText = $('#province option:selected').text();
        const cantonText = $('#canton option:selected').text();
        const districtText = $('#district option:selected').text();
        const altProvince = $('#province_alternate').val();
        const altCanton = $('#canton_alternate').val();
        const address = $('#vetaddress').val();
        const hasSavedPin = $('#lat').val() !== '' && $('#lng').val() !== '';
        if (hasSavedPin) {
            mapModule.syncMapToStoredPin();
            return;
        }

        const parts = [];
        if (countryText) parts.push(countryText);
        if (countryText && countryText.toLowerCase().includes('costa') && provinceText) parts.push(provinceText);
        if (countryText && countryText.toLowerCase().includes('costa') && cantonText) parts.push(cantonText);
        if (countryText && countryText.toLowerCase().includes('costa') && districtText) parts.push(districtText);
        if (altProvince) parts.push(altProvince);
        if (altCanton) parts.push(altCanton);
        if (!hasSavedPin && address) parts.push(address);

        const query = parts.filter(Boolean).join(', ');
        if (!query) {
            return;
        }
        if (state.geocodeController) {
            state.geocodeController.abort();
        }
        state.geocodeController = new AbortController();
        setMapLoading(true);
        const result = await geocode(query, state.geocodeController.signal);
        setMapLoading(false);
        if (result) {
            const onlyCountry =
                !!countryText &&
                !address &&
                !provinceText &&
                !cantonText &&
                !districtText &&
                !altProvince &&
                !altCanton;
            if (onlyCountry && result.bbox) {
                state.map.fitBounds(result.bbox, { padding: [20, 20] });
            } else {
                state.map.setView([result.lat, result.lng], 14);
            }
            setMarker(result.lat, result.lng);
        }
    };

    mapModule.onStep4Active = function() {
        const state = mapModule.state;
        if (!state.map) {
            return;
        }
        setTimeout(() => {
            state.map.invalidateSize();
            mapModule.syncMapToStoredPin();
            setTimeout(() => {
                state.map.invalidateSize();
                mapModule.syncMapToStoredPin();
            }, 350);
        }, 200);
    };

    mapModule.init = function() {
        const mapEl = document.getElementById('clinicMap');
        if (!mapEl || typeof L === 'undefined') {
            return;
        }
        const state = mapModule.state;
        const initialLat = parseFloat($('#lat').val() || '0');
        const initialLng = parseFloat($('#lng').val() || '0');
        const defaultCenter = (initialLat && initialLng) ? [initialLat, initialLng] : [9.933, -84.083];

        state.map = L.map('clinicMap').setView(defaultCenter, (initialLat && initialLng) ? 16 : 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(state.map);

        if (initialLat && initialLng) {
            setMarker(initialLat, initialLng);
        }

        state.map.on('click', function(e) {
            setMarker(e.latlng.lat, e.latlng.lng);
        });

        $('#country, #province, #canton, #district').on('change', function() {
            mapModule.updateMapFromAddress();
        });
        $('#province_alternate, #canton_alternate').on('input', function() {
            mapModule.updateMapFromAddress();
        });

        const hadPin = mapModule.syncMapToStoredPin();
        if (!hadPin) {
            setMapLoading(true);
            mapModule.updateMapFromAddress().finally(() => {
                setMapLoading(false);
            });
        }
        if (state.map && state.map.whenReady) {
            state.map.whenReady(() => {
                mapModule.syncMapToStoredPin();
            });
        }
    };
})();
