const Validator = (() => {
    const patterns = {
        name: /^[A-Za-z][A-Za-z\s.'-]{1,59}$/,
        jobtitle: /^[A-Za-z][A-Za-z\s'-]{1,79}$/,
        phone: /^\d{8,10}$/,
        company: /^[A-Za-z0-9\s&.,'-]{2,100}$/,
        gmail: /^[A-Za-z0-9._%+-]+@gmail\.com$/i
    };

    function valueOf(field) {
        if (field.type === 'checkbox') return field.checked ? field.value : '';
        if (field.type === 'radio') {
            const form = field.form;
            const selected = form ? form.querySelector(`input[name="${field.name}"]:checked`) : null;
            return selected ? selected.value : '';
        }
        return (field.value || '').trim();
    }

    function rulesFor(field) {
        return (field.dataset.validate || '').split('|').map(r => r.trim()).filter(Boolean);
    }

    function labelOf(field) {
        return field.dataset.label || field.getAttribute('aria-label') || field.name || 'This field';
    }

    function validateField(field) {
        const value = valueOf(field);
        const rules = rulesFor(field);
        const label = labelOf(field);
        const errors = [];

        if (rules.includes('required') && !value) errors.push(`${label} is required.`);
        if (value) {
            if (rules.includes('name') && !patterns.name.test(value)) errors.push(`${label} must contain letters only. Numbers and symbols are not allowed.`);
            if (rules.includes('jobtitle') && !patterns.jobtitle.test(value)) errors.push(`${label} must contain letters only and cannot contain numbers.`);
            if (rules.includes('company')) {
                if (!/[A-Za-z]/.test(value)) errors.push(`${label} must include letters and cannot be numbers only.`);
                if (!patterns.company.test(value)) errors.push(`${label} can only contain letters, numbers, spaces and normal company punctuation.`);
            }
            if (rules.includes('emailgmail') && !patterns.gmail.test(value)) errors.push(`${label} must be a valid Gmail address ending with @gmail.com.`);
            if (rules.includes('phone')) {
                if (!/^\d+$/.test(value)) errors.push(`${label} must contain numbers only. Letters are not allowed.`);
                else if (!patterns.phone.test(value)) errors.push(`${label} must be 8 to 10 digits long.`);
            }
            const minRule = rules.find(r => r.startsWith('min:'));
            if (minRule) {
                const min = Number(minRule.split(':')[1]);
                if (value.length < min) errors.push(`${label} must be at least ${min} characters.`);
            }
            const maxRule = rules.find(r => r.startsWith('max:'));
            if (maxRule) {
                const max = Number(maxRule.split(':')[1]);
                if (value.length > max) errors.push(`${label} must be no more than ${max} characters.`);
            }
        }
        if (rules.includes('rating') && value && !['1','2','3','4','5'].includes(value)) errors.push('Rating must be between 1 and 5 stars.');
        return errors;
    }

    function showFieldErrors(field, errors) {
        const holderId = field.dataset.errorTarget;
        let holder = holderId ? document.getElementById(holderId) : null;
        if (!holder) holder = field.closest('.form-group')?.querySelector('.field-errors');
        if (!holder) return;
        if (errors.length) {
            holder.innerHTML = `<ul>${errors.map(e => `<li>${e}</li>`).join('')}</ul>`;
            field.classList.add('invalid');
            field.classList.remove('valid');
        } else {
            holder.innerHTML = '';
            field.classList.remove('invalid');
            if (valueOf(field)) field.classList.add('valid');
        }
    }

    function validateForm(form, show = true) {
        const fields = Array.from(form.querySelectorAll('[data-validate]'));
        const all = [];
        const seenRadio = new Set();
        fields.forEach(field => {
            if (field.type === 'radio') {
                if (seenRadio.has(field.name)) return;
                seenRadio.add(field.name);
            }
            const errors = validateField(field);
            if (show) showFieldErrors(field, errors);
            errors.forEach(error => all.push(error));
        });
        const summary = form.querySelector('.form-errors');
        if (summary) {
            summary.innerHTML = all.length ? `<strong>Please fix these validation errors:</strong><ul>${all.map(e => `<li>${e}</li>`).join('')}</ul>` : '';
            summary.style.display = all.length ? 'block' : 'none';
        }
        return all;
    }

    function init() {
        document.querySelectorAll('form[data-live-validation]').forEach(form => {
            form.querySelectorAll('[data-validate]').forEach(field => {
                ['input','change','blur'].forEach(evt => {
                    field.addEventListener(evt, () => showFieldErrors(field, validateField(field)));
                });
            });
            form.addEventListener('submit', e => {
                const errors = validateForm(form, true);
                if (errors.length) {
                    e.preventDefault();
                    form.querySelector('.form-errors')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        });
    }

    return { init, validateField, validateForm };
})();

document.addEventListener('DOMContentLoaded', Validator.init);
