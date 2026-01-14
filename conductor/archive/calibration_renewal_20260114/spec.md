# Specification: Calibration Renewal Notifications (Bahasa Indonesia)

## Overview
This track implements an automated and manual notification system to remind Hospital Admins about upcoming calibration renewals for their devices. The system will send emails in Bahasa Indonesia to all 'Hospital Admin' users associated with a device's customer.

## Functional Requirements
- **Automated Trigger:** A daily scheduled task (cron job) that scans the `devices` table for records where the `next_calibration_date` is exactly 60 days in the future.
- **Manual Trigger:** A custom action in the Filament `DeviceResource` (List or View) to manually send the renewal notification for specific devices.
- **Recipients:** All users with the 'Hospital Admin' role linked to the same `customer_id` as the device.
- **Email Content (Bahasa Indonesia):**
    - Subject: [Rena Calibration] Pengingat Perpanjangan Kalibrasi
    - Body:
        - Greeting to the Admin.
        - Notice that the following devices require calibration renewal within 60 days.
        - Device List (Table): Nama Perangkat, Nomor Seri, Tanggal Kalibrasi Selanjutnya.
        - Action: Direct link to view the dashboard.
- **Tracking:** Ensure the system prevents duplicate automated notifications for the same renewal cycle per device.

## Technical Requirements
- **Notification Class:** Create a Laravel Notification class (`CalibrationRenewalNotification`) using the `mail` channel.
- **Localization:** Use `lang/id/notifications.php` for all email strings.
- **Scheduled Task:** Define the schedule in `routes/console.php` or a dedicated Command class.
- **Filament Action:** Implement a custom `Action` in `DevicesTable` and/or `ViewDevice`.

## Acceptance Criteria
- A daily task correctly identifies devices due for renewal in 60 days and sends emails.
- Manual action correctly triggers the same email for a selected device.
- Emails are delivered to all 'Hospital Admin' users of the relevant customer.
- Email content is entirely in Bahasa Indonesia and includes all required device details and links.
- Verification tests confirm identification logic and recipient selection.
