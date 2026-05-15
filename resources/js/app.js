import './bootstrap';

window.togglePassword = function (btn) {
    const wrapper = btn.closest('.password-toggle');
    const input = wrapper.querySelector('input');
    const showIcon = wrapper.querySelector('.password-eye');
    const hideIcon = wrapper.querySelector('.password-eye-off');

    if (input.type === 'password') {
        input.type = 'text';
        showIcon?.classList.add('hidden');
        hideIcon?.classList.remove('hidden');
    } else {
        input.type = 'password';
        showIcon?.classList.remove('hidden');
        hideIcon?.classList.add('hidden');
    }
};
