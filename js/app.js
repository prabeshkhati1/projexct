document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.main-nav');
    if (toggle && nav) {
        toggle.addEventListener('click', () => {
            const open = nav.classList.toggle('open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    const globalSearch = document.getElementById('globalSearch');
    const searchHelp = document.querySelector('.search-help');
    if (globalSearch && searchHelp) {
        globalSearch.addEventListener('input', () => {
            const q = globalSearch.value.trim().toLowerCase();
            if (!q) {
                searchHelp.style.display = 'none';
                return;
            }
            if (q === 'admin' || q === 'admin login') {
                searchHelp.textContent = 'Opening protected admin login...';
                searchHelp.style.display = 'block';
                setTimeout(() => { window.location.href = 'admin-login.php'; }, 450);
            } else {
                searchHelp.textContent = 'Try Solutions, Events, Articles, Feedback or type admin.';
                searchHelp.style.display = 'block';
            }
        });
    }

    document.querySelectorAll('[data-modal-open]').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = document.getElementById(btn.dataset.modalOpen);
            if (target) target.classList.add('open');
        });
    });
    document.querySelectorAll('[data-modal-close]').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.closest('.solution-modal');
            if (target) target.classList.remove('open');
        });
    });
    document.querySelectorAll('.solution-modal').forEach(modal => {
        modal.addEventListener('click', e => {
            if (e.target === modal) modal.classList.remove('open');
        });
    });

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const group = btn.closest('.tabs');
            const panelId = btn.dataset.tab;
            if (!group || !panelId) return;
            group.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.remove('active'));
            const panel = document.getElementById(panelId);
            if (panel) panel.classList.add('active');
        });
    });

    const chatLauncher = document.querySelector('.chat-launcher');
    const chatPanel = document.querySelector('.chat-panel');
    const chatClose = document.querySelector('.chat-close');
    if (chatLauncher && chatPanel) {
        chatLauncher.addEventListener('click', () => {
            chatPanel.classList.toggle('open');
            chatPanel.setAttribute('aria-hidden', chatPanel.classList.contains('open') ? 'false' : 'true');
        });
    }
    if (chatClose && chatPanel) {
        chatClose.addEventListener('click', () => chatPanel.classList.remove('open'));
    }
    document.querySelectorAll('[data-chat-answer]').forEach(btn => {
        btn.addEventListener('click', () => {
            const answer = document.querySelector('.chat-answer');
            if (answer) answer.textContent = btn.dataset.chatAnswer;
        });
    });
});
