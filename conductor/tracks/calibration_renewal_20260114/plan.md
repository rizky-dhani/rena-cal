# Plan: Calibration Renewal Notifications (Bahasa Indonesia)

## Phase 1: Notification Foundation and Localization
This phase focuses on creating the core notification class and ensuring all content is properly localized.

- [x] **Task: Create CalibrationRenewalNotification Class** [326f962]
    - [x] Write Tests: Verify the notification can be instantiated with a collection of devices and contains the correct data structure.
    - [x] Implement: Create `App\Notifications\CalibrationRenewalNotification` extending Laravel's `Notification`, accepting a collection of devices.
- [x] **Task: Localize Notification Content** [bd2f8a1]
    - [x] Write Tests: Ensure Indonesian translation keys for the notification and table headers exist.
    - [x] Implement: Create/update `lang/id/notifications.php` with the subject, body, action labels, and table column headers.
- [ ] **Task: Verify Email Rendering**
    - [ ] Write Tests: Assert that the mail message body contains an HTML table with the device name, serial number, and localized date for each device.
    - [ ] Implement: Update the `toMail` method in the notification class to render a table using a custom Blade markdown view.
- [ ] **Task: Conductor - User Manual Verification 'Notification Foundation' (Protocol in workflow.md)**

## Phase 2: Automated Trigger (Scheduled Task)
This phase implements the daily check to find devices requiring renewal.

- [ ] **Task: Create Renewal Check Command**
    - [ ] Write Tests: Create test cases where multiple devices from the same customer are 60 days from renewal and verify one email is sent with all devices.
    - [ ] Implement: Create a console command `app:send-calibration-renewals` to find devices, group them by `customer_id`, and notify Hospital Admins.
- [ ] **Task: Register Daily Schedule**
    - [ ] Write Tests: Verify the command is registered in the console schedule.
    - [ ] Implement: Add the command to `routes/console.php` to run daily.
- [ ] **Task: Conductor - User Manual Verification 'Automated Trigger' (Protocol in workflow.md)**

## Phase 3: Manual Trigger (Filament Integration)
This phase adds the manual "Send Renewal Notification" button to the dashboard.

- [ ] **Task: Add Manual Action to Devices Table**
    - [ ] Write Tests: Verify the action is visible and calls the notification logic when triggered.
    - [ ] Implement: Add a custom `Action` to `app/Filament/Dashboard/Resources/Devices/Tables/DevicesTable.php`.
- [ ] **Task: Add Manual Action to View Device Page**
    - [ ] Write Tests: Verify the action is present on the `ViewDevice` header.
    - [ ] Implement: Update `app/Filament/Dashboard/Resources/Devices/Pages/ViewDevice.php` header actions.
- [ ] **Task: Conductor - User Manual Verification 'Manual Trigger' (Protocol in workflow.md)**

## Phase 4: Final Polish and Quality Gates
Final verification against project standards.

- [ ] **Task: Final Quality Gate Check**
    - [ ] Implement: Verify code coverage (80-90%), run Pint for formatting, and ensure all docstrings are complete.
- [ ] **Task: Conductor - User Manual Verification 'Final Polish' (Protocol in workflow.md)**
