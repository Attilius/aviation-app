/**
 * Contain input items and his attributes.
 */
const inputAttributes = {
    name: {
        id: 'name',
        type: 'text',
        label: {
            _for_: 'name',
            textValue: 'Name',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    first_name: {
        id: 'first_name',
        type: 'text',
        label: {
            _for_: 'first_name',
            textValue: 'First Name*',
            customClasses: ['text-custom_blue', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-custom_blue']
    },
    last_name: {
        id: 'last_name',
        type: 'text',
        label: {
            _for_: 'last_name',
            textValue: 'Last Name*',
            customClasses: ['text-custom_blue', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-custom_blue']
    },
    email: {
        id: 'email',
        type: 'email',
        label: {
            _for_: 'email',
            textValue: 'Email',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    password: {
        id: 'password',
        type: 'password',
        label: {
            _for_: 'password',
            textValue: 'Password',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    password_confirmation: {
        id: 'password_confirmation',
        type: 'password',
        label: {
            _for_: 'password_confirmation',
            textValue: 'Confirm Password',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    code: {
        id: 'email',
        type: 'text',
        label: {
            _for_: 'code',
            textValue: 'Code',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    recovery_code: {
        id: 'recovery_code',
        type: 'text',
        label: {
            _for_: 'recovery_code',
            textValue: 'Recovery Code',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    current_password: {
        id: 'current_password',
        type: 'password',
        label: {
            _for_: 'current_password',
            textValue: 'Current Password',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    new_password: {
        id: 'new_password',
        type: 'password',
        label: {
            _for_: 'new_password',
            textValue: 'New Password',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    departure_from: {
        id: 'departure_from',
        type: 'text',
        label: {
            id: 'departure_from_label',
            _for_: 'departure_from',
            textValue: 'Departure from*',
            customClasses: ['text-baseGray', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-custom_blue', 'focus:border-b-lightskyblue', 'text-custom_blue']
    },
    arriving_at: {
        id: 'arriving_at',
        type: 'text',
        label: {
            id: 'arriving_at_label',
            _for_: 'arriving_at',
            textValue: 'Arriving at*',
            customClasses: ['text-baseGray', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-custom_blue', 'focus:border-b-lightskyblue', 'text-custom_blue']
    },
    departure_date: {
        id: 'departure_date',
        type: 'date',
        label: {
            id: 'departure_date_label',
            _for_: 'departure_date',
            textValue: 'Departure date*',
            customClasses: ['text-baseGray', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-custom_blue', 'focus:border-b-lightskyblue', 'text-custom_blue']
    },
    return_date: {
        id: 'return_date',
        type: 'date',
        label: {
            id: 'return_date_label',
            _for_: 'return_date',
            textValue: 'Return date*',
            customClasses: ['text-baseGray', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-custom_blue', 'focus:border-b-lightskyblue', 'text-custom_blue']
    },
    passengers: {
        id: 'passengers',
        type: 'text',
        label: {
            id: 'passengers_label',
            _for_: 'passengers',
            textValue: 'Passengers',
            customClasses: ['text-baseGray', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-baseGray', 'focus:border-b-lightskyblue', 'text-custom_blue', 'px-3', 'cursor-pointer']
    },
    cabin_class: {
        id: 'cabin_class',
        label: {
            id: 'cabin_class_label',
            _for_: 'cabin_class',
            textValue: 'Cabin',
            customClasses: ['text-baseGray', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-custom_blue', 'focus:border-b-lightskyblue', 'text-custom_blue']
    },
    travel_type: {
        id: 'travel_type',
        label: {
            id: 'travel_type_label',
            _for_: 'travel_type',
            textValue: 'Travel type*',
            customClasses: ['text-baseGray', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-custom_blue', 'focus:border-b-lightskyblue', 'text-custom_blue']
    },
    subject: {
        id: 'subject',
        type: 'text',
        label: {
            _for_: 'subject',
            textValue: 'Subject',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    message: {
        id: 'message',
        name: 'message',
        rows: '50',
        cols: '50',
        maxlength: '200',
        label: {
            _for_: 'message',
            textValue: 'Message',
            customClasses: ['text-whitesmoke', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-whitesmoke', 'focus:border-b-lightskyblue', 'text-whitesmoke']
    },
    passenger: {
        id: 'passenger',
        label: {
            id: 'passenger_label',
            _for_: 'passenger',
            textValue: 'Passenger',
            customClasses: ['text-baseGray', 'peer-focus:text-lightskyblue']
        },
        customClasses: ['border-b-custom_blue', 'focus:border-b-lightskyblue', 'text-custom_blue']
    },
};

export default inputAttributes;

