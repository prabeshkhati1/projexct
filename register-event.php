<?php
$pageTitle = 'Event Registration | AI-Solutions';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/validation.php';
$events = array_values(array_filter(events(), fn($event) => $event['status'] === 'upcoming'));
$selectedEventId = isset($_GET['event']) ? (int)$_GET['event'] : 0;
$values = ['event_id' => $selectedEventId, 'full_name' => '', 'email' => '', 'phone' => '', 'terms' => ''];
$errors = [];
$success = '';

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $values = [
        'event_id' => (int)($_POST['event_id'] ?? 0),
        'full_name' => clean_input($_POST['full_name'] ?? ''),
        'email' => clean_input($_POST['email'] ?? ''),
        'phone' => clean_input($_POST['phone'] ?? ''),
        'terms' => isset($_POST['terms']) ? 'yes' : '',
    ];
    $eventIds = array_column($events, 'id');
    if (!in_array($values['event_id'], $eventIds, true)) {
        $errors['event_id'][] = 'Please select a valid upcoming event.';
    }
    $errors['full_name'] = validate_name($values['full_name'], 'Full name');
    $errors['email'] = validate_gmail($values['email']);
    $errors['phone'] = validate_phone($values['phone']);
    if ($values['terms'] === '') {
        $errors['terms'][] = 'You must confirm that the registration details are correct.';
    }
    $allErrors = flatten_errors($errors);
    if (!$allErrors) {
        if (db_ready()) {
            run_query('INSERT INTO event_registrations (event_id, full_name, email, phone, created_at) VALUES (?, ?, ?, ?, NOW())', [$values['event_id'], $values['full_name'], $values['email'], $values['phone']]);
            log_activity('New event registration from ' . $values['full_name']);
            $success = 'Registered successfully. Your event registration has been saved.';
            $values = ['event_id' => $values['event_id'], 'full_name' => '', 'email' => '', 'phone' => '', 'terms' => ''];
        } else {
            $errors['database'][] = 'Database is not connected. Please import the SQL file or run install.php first.';
        }
    }
}
include __DIR__ . '/includes/header.php';
?>
<section class="section">
    <div class="container">
        <div class="section-title">
            <div>
                <h1>Event Registration Portal</h1>
                <p class="section-subtitle">Register for upcoming promotional events using validated fields. Past events are intentionally not available in this form.</p>
            </div>
        </div>
        <div class="grid two">
            <form class="form-card" method="post" data-live-validation novalidate>
                <?php if ($success): ?><div class="form-success"><?= e($success) ?></div><?php endif; ?>
                <div class="form-errors" style="display:<?= flatten_errors($errors) ? 'block' : 'none' ?>">
                    <?php if (flatten_errors($errors)): ?><strong>Please fix these validation errors:</strong><ul><?php foreach (flatten_errors($errors) as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="event_id">Select Event <span class="required">*</span></label>
                    <select class="form-select" id="event_id" name="event_id" data-label="Select event" data-validate="required" data-error-target="event_id_errors">
                        <option value="">Choose upcoming event</option>
                        <?php foreach ($events as $event): ?>
                            <option value="<?= e($event['id']) ?>" <?= (int)$values['event_id'] === (int)$event['id'] ? 'selected' : '' ?>><?= e($event['title']) ?> — <?= e($event['date']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div id="event_id_errors" class="field-errors"><?php foreach ($errors['event_id'] ?? [] as $error): ?><ul><li><?= e($error) ?></li></ul><?php endforeach; ?></div>
                </div>
                <div class="form-group">
                    <label for="full_name">Full Name <span class="required">*</span></label>
                    <input class="form-control" id="full_name" name="full_name" value="<?= e($values['full_name']) ?>" data-label="Full name" data-validate="required|name" data-error-target="full_name_errors" autocomplete="name">
                    <div id="full_name_errors" class="field-errors"><?php foreach ($errors['full_name'] ?? [] as $error): ?><ul><li><?= e($error) ?></li></ul><?php endforeach; ?></div>
                </div>
                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input class="form-control" id="email" name="email" value="<?= e($values['email']) ?>" data-label="Email address" data-validate="required|emailgmail" autocomplete="email">
                    <div class="field-errors"><?php foreach ($errors['email'] ?? [] as $error): ?><ul><li><?= e($error) ?></li></ul><?php endforeach; ?></div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number <span class="required">*</span></label>
                    <input class="form-control" id="phone" name="phone" value="<?= e($values['phone']) ?>" data-label="Phone number" data-validate="required|phone" inputmode="numeric" autocomplete="tel">
                    <div class="field-errors"><?php foreach ($errors['phone'] ?? [] as $error): ?><ul><li><?= e($error) ?></li></ul><?php endforeach; ?></div>
                </div>
                <div class="form-group">
                    <label><input type="checkbox" name="terms" value="yes" <?= $values['terms'] ? 'checked' : '' ?> data-label="Registration confirmation" data-validate="required"> I confirm these registration details are correct.</label>
                    <div class="field-errors"><?php foreach ($errors['terms'] ?? [] as $error): ?><ul><li><?= e($error) ?></li></ul><?php endforeach; ?></div>
                </div>
                <button class="btn" type="submit">Register Event</button>
            </form>

            <aside class="form-card">
                <h2>Registration Summary</h2>
                <p>Only the required customer information is collected: selected event, full name, Gmail address and phone number.</p>
                <h3>Upcoming Events</h3>
                <?php foreach ($events as $event): ?>
                    <div class="activity-item">
                        <strong><?= e($event['title']) ?></strong>
                        <p><?= e($event['date']) ?> · <?= e($event['time']) ?><br><?= e($event['location']) ?></p>
                    </div>
                <?php endforeach; ?>
            </aside>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
