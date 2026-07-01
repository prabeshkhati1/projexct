</main>

<footer class="site-footer">
    <div>
        <div class="footer-brand">
            <img src="assets/img/logo.svg" alt="AI-Solutions logo">
            <strong>AI-Solutions</strong>
        </div>
        <p>AI-powered software solutions, prototypes and dashboards for businesses.</p>
    </div>
    <div>
        <h3>Quick Links</h3>
        <a href="solutions.php">Solutions / Past Work</a>
        <a href="events.php">Events & Gallery</a>
        <a href="feedback.php">Feedback</a>
        <a href="contact.php">Contact Us</a>
    </div>
    <div>
        <h3>Company</h3>
        <a href="articles.php">Articles</a>
        <a href="admin-login.php">Admin Area</a>
        <a href="README.md">Project README</a>
    </div>
    <div>
        <h3>Contact</h3>
        <p>Sunderland, United Kingdom</p>
        <p>info@ai-solutions.example</p>
        <p>Copyright © <?= date('Y') ?> AI-Solutions</p>
    </div>
</footer>

<button class="chat-launcher" type="button" aria-label="Open quick help">💬</button>
<div class="chat-panel" aria-hidden="true">
    <div class="chat-head"><strong>AI-Solutions Help</strong><button type="button" class="chat-close" aria-label="Close chat">×</button></div>
    <p>Hello! I can help with services, events, contact form and admin demo guidance.</p>
    <button type="button" data-chat-answer="Use the Solutions page to view services and past work. Each card has details and feedback.">Services</button>
    <button type="button" data-chat-answer="Use Contact Us to submit job requirements. All fields have live validation and database storage.">Contact form</button>
    <button type="button" data-chat-answer="Default admin login is username: admin and password: Admin@123. Change this before real deployment.">Admin login</button>
    <div class="chat-answer" aria-live="polite"></div>
</div>
</body>
</html>
