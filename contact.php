<?php
$pageTitle = 'Contact Us | AI-Solutions';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/validation.php';
$countries = countries();
$preService = clean_input($_GET['service'] ?? ($_GET['project'] ?? ''));
$values = [
    'full_name' => '', 'email' => '', 'phone' => '', 'company_name' => '', 'country' => '', 'job_title' => '',
    'job_details' => $preService ? 'I am interested in: ' . $preService : ''
];
$errors = [];
$success = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    foreach ($values as $key => $_) {
        $values[$key] = clean_input($_POST[$key] ?? '');
    }
    $errors['full_name'] = validate_name($values['full_name'], 'Full name');
    $errors['email'] = validate_gmail($values['email']);
    $errors['phone'] = validate_phone($values['phone']);
    $errors['company_name'] = validate_company($values['company_name']);
    $errors['country'] = validate_country($values['country'], $countries);
    $errors['job_title'] = validate_job_title($values['job_title']);
    $errors['job_details'] = validate_required_text($values['job_details'], 'Job details', 20, 1000);
    $allErrors = flatten_errors($errors);
    if (!$allErrors) {
        if (db_ready()) {
            run_query('INSERT INTO enquiries (full_name, email, phone, company_name, country, job_title, job_details, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())', [
                $values['full_name'], $values['email'], $values['phone'], $values['company_name'], $values['country'], $values['job_title'], $values['job_details']
            ]);
            log_activity('New contact enquiry from ' . $values['full_name']);
            $success = 'Enquiry submitted successfully. Your customer enquiry has been saved.';
            foreach ($values as $key => $_) { $values[$key] = ''; }
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
                <h1>Contact Us</h1>
                <p class="section-subtitle">Submit software job requirements using a form with live validation and server-side validation. Customers do not need to create accounts or passwords.</p>
            </div>
        </div>
        <div class="grid two">
            <form class="form-card" method="post" data-live-validation novalidate>
                <?php if ($success): ?><div class="form-success"><?= e($success) ?></div><?php endif; ?>
                <div class="form-errors" style="display:<?= flatten_errors($errors) ? 'block' : 'none' ?>">
                    <?php if (flatten_errors($errors)): ?><strong>Please fix these validation errors:</strong><ul><?php foreach (flatten_errors($errors) as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul><?php endif; ?>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="full_name">Full Name <span class="required">*</span></label>
                        <input class="form-control" id="full_name" name="full_name" value="<?= e($values['full_name']) ?>" data-label="Full name" data-validate="required|name" autocomplete="name">
                        <div class="field-errors"><?php foreach ($errors['full_name'] ?? [] as $error): ?><ul><li><?= e($error) ?></li></ul><?php endforeach; ?></div>
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
                        <label for="company_name">Company Name <span class="required">*</span></label>
                        <input class="form-control" id="company_name" name="company_name" value="<?= e($values['company_name']) ?>" data-label="Company name" data-validate="required|company" autocomplete="organization">
                        <div class="field-errors"><?php foreach ($errors['company_name'] ?? [] as $error): ?><ul><li><?= e($error) ?></li></ul><?php endforeach; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="country">Country <span class="required">*</span></label>
                        <select class="form-select" id="country" name="country" data-label="Country" data-validate="required">
                            <option value="">Select country</option>
                            <?php foreach ($countries as $country): ?><option value="<?= e($country) ?>" <?= $values['country'] === $country ? 'selected' : '' ?>><?= e($country) ?></option><?php endforeach; ?>
                        </select>
                        <div class="field-errors"><?php foreach ($errors['country'] ?? [] as $error): ?><ul><li><?= e($error) ?></li></ul><?php endforeach; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="job_title">Job Title <span class="required">*</span></label>
                        <input class="form-control" id="job_title" name="job_title" value="<?= e($values['job_title']) ?>" data-label="Job title" data-validate="required|jobtitle">
                        <div class="field-errors"><?php foreach ($errors['job_title'] ?? [] as $error): ?><ul><li><?= e($error) ?></li></ul><?php endforeach; ?></div>
                    </div>
                    <div class="form-group full">
                        <label for="job_details">Job Details <span class="required">*</span></label>
                        <textarea id="job_details" name="job_details" data-label="Job details" data-validate="required|min:20|max:1000"><?= e($values['job_details']) ?></textarea>
                        <div class="field-errors"><?php foreach ($errors['job_details'] ?? [] as $error): ?><ul><li><?= e($error) ?></li></ul><?php endforeach; ?></div>
                    </div>
                </div>
                <button class="btn" type="submit">Submit Enquiry</button>
            </form>
            <aside class="form-card">
                <h2>Company Information</h2>
                <p>AI-Solutions uses AI to help businesses with software needs and digital employee experience. Use this page to submit job requirements for software services.</p>
                <div class="activity-item"><strong>Address</strong><p>Sunderland, United Kingdom</p></div>
                <div class="activity-item"><strong>Email</strong><p>info@ai-solutions.example</p></div>
                <div class="activity-item"><strong>Opening Hours</strong><p>Monday to Friday, 9:00 AM – 5:00 PM</p></div>
                <h3>Map</h3>
                <div class="notice" style="height:180px; display:grid; place-items:center;">Map placeholder — Sunderland</div>
            </aside>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
