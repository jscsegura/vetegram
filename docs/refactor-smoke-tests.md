# Refactor Smoke Tests

Run these after each phase.

## Auth + Access
- Login as existing vet user.
- Open `/register/complete-profile` without errors.
- Forgot password flow validates email and submits.
- Signup form validates email/passwords and submits.

## Setup Flow
- Step 1: Identity loads name/email and allows ID edits.
- Step 2: Clinic fields save and persist on refresh.
- Step 3: Specialties allow multi-select and persist.
- Step 4: Location shows saved pin; changing fields does not clear pin.
- Step 5: Schedule renders and allows save.

## Map
- Click map to drop pin; refresh shows same pin.
- Pin remains when switching tabs and back.

## Schedule
- Can leave a day empty (no hours).
- Overlapping hours show validation error.
- Non-overlapping hours save.

## Home Pages
- Landing: search autocomplete works; contact form submits; back-to-top shows/hides.
- Search: magic search renders and login modal works when shown.
- Profile: country/province toggles show/hide correctly; save validates.
- Book: date picker changes day; reserve hour + modal + submit works.
- Plan/Payment: confirmation dialog opens; payment screen loads methods/cards.
- Notifications: reminder create/edit/delete works; modal opens from list.
- Dash: start appointment opens and navigates to flow.

## Translations
- Toggle ES/EN and verify labels update for setup tabs + buttons.

## Settings (Templates + Availability)
- Index: add hour to day; delete hour; delete all; update mode saves.
- Edit: select date; apply template; add/delete hour; delete all.
- Grooming: save form posts without JS errors.

## Invoice (Credit Note)
- From invoice list, open credit note modal and confirm invoice ID populates.
- From invoice detail, open credit note modal and confirm invoice ID populates.
- Save credit note: validation errors show; confirm dialog appears; success toast shows.

## Quick Regression List
- Auth: login + logout + password reset.
- Setup: tab navigation, autosave, map pin persistence.
- Pets: create pet, upload attachments, vaccines list.
- Appointments: create/edit/reschedule/cancel with notifications.
- Schedule: add segments, copy days, validation errors.
- Admin/WPanel: basic DataTable pages load and actions respond.

## Critical Regression List (Home/Schedule/Settings/Invoice)
- Home: profile save + country toggle; book flow completes; notifications reminder edit works.
- Schedule: add/remove/copy segments; overlap validation blocks submit.
- Settings: add/delete hours; delete all; update mode persists.
- Invoice credit note: modal opens and sets ID; save flow completes.

## Action Router + Config Consistency
- Click data-action buttons: signature modal opens, file-picker triggers, schedule add/remove segment works.
- WPanel actions: enable/disable/pro toggles and delete actions execute without inline handlers.
- Appointment modals: open/close + save actions still fire (create user/pet, attach files, cancel/reschedule).
- Printer pages: `/printer/recipe` and `/printer/invoice` auto-print on load; print button still works.
- Verify no console errors for missing `window.*_CONFIG` objects on key pages.
