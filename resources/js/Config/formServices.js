/**
 * Contain form services and his input field(s).
 */
const formServices = {
    login: ['email', 'password'],
    register: ['name', 'email', 'password', 'password_confirmation'],
    confirmPassword: ['password'],
    twoFactorChallenge: ['code', 'recovery_code'],
    forgotPassword: ['email'],
    resetPassword: ['email', 'password', 'password_confirmation'],
    subscribe: ['email'],
    updateUserProfileInformation: ['name', 'email'],
    updatePassword: ['current_password', 'new_password', 'password_confirmation'],
    bookFlight: ['departure_from', 'arriving_at', 'departure_date', 'return_date', 'passengers', 'cabin_class', 'travel_type'],
    contact: ['name', 'email', 'subject', 'message'],
    addPassenger: ['passenger'],
    setPassenger: ['first_name', 'last_name'],
    setContactPerson: ['country_code', 'phone_number', 'email']
};

export default formServices;
