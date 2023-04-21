/**
 * Contain form services and his input field(s).
 */
const formServices = {
    login: ['email', 'password'],
    register: ['full_name', 'email', 'password', 'password_confirmation'],
    confirmPassword: ['password'],
    twoFactorChallenge: ['code', 'recovery_code'],
    forgotPassword: ['email'],
    resetPassword: ['email', 'password', 'password_confirmation'],
    subscribe: ['email'],
    updateUserProfileInformation: ['full_name', 'email'],
    updatePassword: ['current_password', 'new_password', 'password_confirmation'],
    bookFlight: ['departure_from', 'arriving_at', 'departure_date', 'return_date', 'passengers', 'cabin_class', 'travel_type'],
};

export default formServices;
