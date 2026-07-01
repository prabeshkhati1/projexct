# Validation Test Checklist

Use this checklist when recording the prototype demonstration.

## Contact Us form

- Enter `12345` in Full Name: should show letters-only error immediately.
- Enter `test@yahoo.com` in Email: should show Gmail address error.
- Enter `abc123` in Phone: should show numbers-only error.
- Enter `1234567` in Phone: should show 8 to 10 digits error.
- Enter `12345` in Company Name: should show cannot be numbers-only error.
- Leave Country unselected: should show country required error.
- Enter `12345` in Job Title: should show letters-only error.
- Leave Job Details empty or under 20 characters: should show required/minimum length error.
- Submit multiple wrong fields together: all errors should be listed in the summary.

## Event registration form

- Leave all fields empty and submit: all required field errors should be listed.
- Enter numbers in Full Name: should show letters-only error.
- Enter letters in Phone: should show numbers-only error.
- Enter phone shorter than 8 digits or longer than 10 digits: should show length error.
- Use non-Gmail email: should show `@gmail.com` error.

## Feedback form

- Leave rating empty: should show rating required error.
- Enter numbers in Full Name: should show letters-only error.
- Submit review under 15 characters: should show minimum length error.
- Submit valid review: success message should show, then admin can approve it.

## Admin protection

- Open `admin-dashboard.php` without login: should redirect to `admin-login.php`.
- Login with wrong credentials: should show invalid credentials error.
- Login with `admin` / `Admin@123`: dashboard should open.
- Click Logout then press browser back: admin page should require login again.
