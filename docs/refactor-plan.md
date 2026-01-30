# Refactor Plan (Phase A Baseline)

## Goals
- Stabilize behavior while improving maintainability.
- Reduce coupling between views, JS, and persistence.
- Make setup flow and schedule easier to change safely.

## Scope (Current Hotspots)
- Profile setup flow (Identity, Clinic, Specialties, Location, Schedule).
- Map pin persistence + autosave.
- Schedule configuration + validation.
- Translations (EN/ES) for setup flow.

## Known High-Risk Areas
- Mixed inline JS and Blade logic in setup views.
- Autosave overwriting unrelated fields (e.g., lat/lng).
- Map pin rendering inside hidden tabs (Leaflet redraw timing).
- Schedule validation scattered across front-end and back-end.

## Invariants (Must Not Break)
- Existing data continues to load correctly into setup flow.
- Draft saves do not clear previously saved fields.
- Pin remains authoritative once set.
- Schedule allows days with no hours.
- Language switching remains functional.

## Dependencies / External Services
- Leaflet (OpenStreetMap tiles).
- Select2 (multi-select + dropdowns).
- intl-tel-input (phone input).

## Reference Entry Points
- Setup view: resources/views/register/complete/vet.blade.php
- Setup save: app/Http/Controllers/Auth/RegisterController.php
- Schedule partials: resources/views/schedule/schedule/_fields.blade.php
- Schedule JS: resources/views/schedule/schedule/_script.blade.php

## Phase A Deliverables
- This file (baseline plan).
- Smoke-test checklist.

