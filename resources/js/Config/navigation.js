/**
 * Contain main navigation items, and his attributes.
 *
 * @type {{
 *      contact: {name: string, active: *, href: *},
 *      about: {name: string, active: *, href: *},
 *      services: {name: string, active: *, href: *},
 *      home: {name: string, active: *, href: *}
 *      }}
 */
const mainNavLinkAttributes = {
    home: {
        href: route('home'),
        active: true,
        name: 'Home'
    },
    about: {
        href: route('about'),
        active: false,
        name: 'About'
    },
    services: {
        href: route('home'),
        active: false,
        name: 'Services'
    },
    contact: {
        href: route('home'),
        active: false,
        name: 'Contact'
    },
 /*   dashboard: {
        href: route('dashboard'),
        active: route().current(''),
        name: 'Dashboard'
    } */
};

/**
 * Contain auth navigation items, and his attributes.
 *
 * @type {{
 *      login: {name: string, href: *},
 *      register: {name: string, href: *}
 *      }}
 */
const authNavLinkAttributes = {
    login: {
        href: route('login'),
        name: 'Login'
    },
    register: {
        href: route('register'),
        name: 'Register'
    }
};

export {
    mainNavLinkAttributes,
    authNavLinkAttributes
}
