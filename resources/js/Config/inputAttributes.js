/**
 * Contain input items and his attributes.
 */
const inputAttributes = {
    full_name: {
        id: 'full_name',
        type: 'text',
        label: {
            _for_: 'full_name',
            value: 'Name',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    first_name: {
        id: 'first_name',
        type: 'text',
        label: {
            _for_: 'first_name',
            value: 'First Name',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    last_name: {
        id: 'last_name',
        type: 'text',
        label: {
            _for_: 'last_name',
            value: 'Last Name',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    email: {
        id: 'email',
        type: 'email',
        label: {
            _for_: 'email',
            value: 'Email',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    password: {
        id: 'password',
        type: 'password',
        label: {
            _for_: 'password',
            value: 'Password',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    password_confirmation: {
        id: 'password_confirmation',
        type: 'password',
        label: {
            _for_: 'password_confirmation',
            value: 'Confirm Password',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    code: {
        id: 'email',
        type: 'text',
        label: {
            _for_: 'code',
            value: 'Code',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    recovery_code: {
        id: 'recovery_code',
        type: 'text',
        label: {
            _for_: 'recovery_code',
            value: 'Recovery Code',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    current_password: {
        id: 'current_password',
        type: 'password',
        label: {
            _for_: 'current_password',
            value: 'Current Password',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    new_password: {
        id: 'new_password',
        type: 'password',
        label: {
            _for_: 'new_password',
            value: 'New Password',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    departure_from: {
        id: 'departure_from',
        type: 'text',
        label: {
            _for_: 'departure_from',
            value: 'Departure from*',
            customClasses: ['text-baseGray', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-baseGray', 'focus:border-b-lightskyblue', 'text-baseGray']
    },
    arriving_at: {
        id: 'arriving_at',
        type: 'text',
        label: {
            _for_: 'arriving_at',
            value: 'Arriving at*',
            customClasses: ['text-baseGray', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-custom_blue', 'focus:border-b-lightskyblue', 'text-custom_blue']
    },
    departure_date: {
        id: 'departure_date',
        type: 'date',
        label: {
            _for_: 'departure_date',
            value: 'Departure date*',
            customClasses: ['text-baseGray', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-custom_blue', 'focus:border-b-lightskyblue', 'text-custom_blue']
    },
    return_date: {
        id: 'return_date',
        type: 'date',
        label: {
            _for_: 'return_date',
            value: 'Return date*',
            customClasses: ['text-baseGray', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-custom_blue', 'focus:border-b-lightskyblue', 'text-custom_blue']
    },
    passengers: {
        id: 'passengers',
        type: 'text',
        label: {
            _for_: 'passengers',
            value: 'Passengers',
            customClasses: ['text-baseGray', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-baseGray', 'focus:border-b-lightskyblue', 'text-custom_blue', 'px-3', 'cursor-pointer']
    },
    cabin_class: {
        id: 'cabin_class',
        label: {
            _for_: 'cabin_class',
            value: 'Cabin',
            customClasses: ['text-custom_blue', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-custom_blue', 'focus:border-b-lightskyblue', 'text-custom_blue']
    },
    travel_type: {
        id: 'travel_type',
        label: {
            _for_: 'travel_type',
            value: 'Travel type',
            customClasses: ['text-custom_blue', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-custom_blue', 'focus:border-b-lightskyblue', 'text-custom_blue']
    },
};

export default inputAttributes;

