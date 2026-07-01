<?php
$pageTitle = 'Feedback & Reviews | AI-Solutions';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/validation.php';
$values = ['full_name'=>'','email'=>'','subject'=>'','rating'=>'','review'=>''];
$errors = [];
$success = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    foreach ($values as $key => $_) { $values[$key] = clean_input($_POST[$key] ?? ''); }
    $errors['full_name'] = validate_name($values['full_name'], 'Full name');
    $errors['email'] = validate_gmail($values['email']);
    $errors['subject'] = validate_required_text($values['subject'], 'Subject', 3, 120);
    $errors['rating'] = validate_rating($values['rating']);
    $errors['review'] = validate_required_text($values['review'], 'Review', 15, 700);
    if (!flatten_errors($errors)) {
        if (db_ready()) {
            run_query('INSERT INTO feedback_reviews (full_name, email, subject, rating, review, status, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())', [$values['full_name'], $values['email'], $values['subject'], (int)$values['rating'], $values['review'], 'pending']);
            log_activity('New feedback submitted by ' . $values['full_name']);
            $success = 'Feedback submitted successfully. It is pending admin approval before being displayed.';
            foreach ($values as $key => $_) { $values[$key] = ''; }
        } else {
            $errors['database'][] = 'Database is not connected. Please import the SQL file or run install.php first.';
        }
    }
}
$reviews = seeded_reviews();
if (db_ready()) {
    $stmt = run_query("SELECT full_name AS name, subject, rating, review, created_at FROM feedback_reviews WHERE status = 'approved' ORDER BY created_at DESC");
    $dbReviews = $stmt ? $stmt->fetchAll() : [];
    if ($dbReviews) $reviews = $dbReviews;
}
include __DIR__ . '/includes/header.php';
?>
<section class="section">
    <div class="container">
        <div class="section-title">
            <div>
                <h1>Feedback & Reviews</h1>
                <p class="section-subtitle">Customers can submit feedback and ratings. Reviews are moderated in the admin area before display.</p>
            </div>
        </div>
        <div class="grid two">
            <form class="form-card" method="post" data-live-validation novalidate>
                <h2>Submit Your Review</h2>
                <?php if ($success): ?><div class="form-success"><?= e($success) ?></div><?php endif; ?>
                <div class="form-errors" style="display:<?= flatten_errors($errors) ? 'block' : 'none' ?>">
                    <?php if (flatten_errors($errors)): ?><strong>Please fix these validation errors:</strong><ul><?php foreach (flatten_errors($errors) as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="full_name">Full Name <span class="required">*</span></label>
                    <input class="form-control" id="full_name" name="full_name" value="<?= e($values['full_name']) ?>" data-label="Full name" data-validate="required|name" autocomplete="name">
                    <div class="field-errors"><?php foreach ($errors['full_name'] ?? [] as $error): ?><ul><li><?= e($error) ?></li></ul><?php endforeach; ?></div>
                </div>
                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input class="form-control" id="email" name="email" value="<?= e($values['email']) ?>" data-label="Email" data-validate="required|emailgmail" autocomplete="email">
                    <div class="field-errors"><?php foreach ($errors['email'] ?? [] as $error): ?><ul><li><?= e($error) ?></li></ul><?php endforeach; ?></div>
                </div>
                <div class="form-group">
                    <label for="subject">Subject <span class="required">*</span></label>
                    <input class="form-control" id="subject" name="subject" value="<?= e($values['subject']) ?>" data-label="Subject" data-validate="required|min:3|max:120">
                    <div class="field-errors"><?php foreach ($errors['subject'] ?? [] as $error): ?><ul><li><?= e($error) ?></li></ul><?php endforeach; ?></div>
                </div>
                <div class="form-group">
                    <label for="rating">Your Rating <span class="required">*</span></label>
                    <select class="form-select" id="rating" name="rating" data-label="Rating" data-validate="required|rating">
                        <option value="">Select rating</option>
                        <?php for ($i=5; $i>=1; $i--): ?><option value="<?= $i ?>" <?= $values['rating'] === (string)$i ? 'selected' : '' ?>><?= $i ?> star<?= $i > 1 ? 's' : '' ?></option><?php endfor; ?>
                    </select>
                    <div class="field-errors"><?php foreach ($errors['rating'] ?? [] as $error): ?><ul><li><?= e($error) ?></li></ul><?php endforeach; ?></div>
                </div>
                <div class="form-group">
                    <label for="review">Your Review <span class="required">*</span></label>
                    <textarea id="review" name="review" data-label="Review" data-validate="required|min:15|max:700"><?= e($values['review']) ?></textarea>
                    <div class="field-errors"><?php foreach ($errors['review'] ?? [] as $error): ?><ul><li><?= e($error) ?></li></ul><?php endforeach; ?></div>
                </div>
                <button class="btn" type="submit">Submit Review</button>
                <p class="section-subtitle">Reviews appear after admin approval.</p>
            </form>

            <section>
                <div class="section-title"><h2>What People Say</h2><span class="pill">Filter: Approved</span></div>
                <?php foreach ($reviews as $review): ?>
                    <article class="review-item">
                        <p class="rating"><?= e(star_rating($review['rating'])) ?></p>
                        <h3><?= e($review['subject']) ?></h3>
                        <p><?= e($review['review']) ?></p>
                        <strong>— <?= e($review['name']) ?></strong>
                    </article>
                <?php endforeach; ?>
            </section>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
