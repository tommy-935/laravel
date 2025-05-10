import SecureStorage from '_@/js/utils/secureStorage'

export function getToken () {
        const storage = new SecureStorage('app', 'custom-secret-key')
        const token = storage.get('token');
        return token ? token : null;
};

export function checkLogin (token) {
        const storage = new SecureStorage('app', 'custom-secret-key')
        storage.set('token', token);
}

export function goToAdmin () {
        window.location.href = '/admin'
};

export function goToLogin () {
        window.location.href = '/login'
}

export function goToCart () {
        window.location.href = '/shipping-cart'
};

export function goToCheckout () {
        window.location.href = '/checkout'
};

export function goToResetPassword () {
        window.location.href = '/reset-password'
};