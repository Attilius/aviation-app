import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faStar, faQuoteRight, faQuoteLeft, faPlane, faUsers, faMapLocationDot,
         faHandshake, faPhone, faEnvelope, faLocationDot, faClock, faHouse, faFax,
         faPassport, faSuitcaseRolling, faMugHot, faBan, faMagnifyingGlass, faXmark,
         faCircleExclamation, faCircleUser, faPencil, faCaretDown, faCircle, faAngleRight,
         faCheck, faAngleDown, faBriefcase, faSuitcase, faCartFlatbedSuitcase, faMinus, faPlus,
         faPhoneVolume, faCircleInfo } from '@fortawesome/free-solid-svg-icons';
import { faStar as faStarStroke, faStarHalfStroke, faCreditCard,
        faClock as faClockRegular, faCircle as faCircleRefular } from '@fortawesome/free-regular-svg-icons';
import { faAvianex } from '@fortawesome/free-brands-svg-icons';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

library.add( faStar, faStarHalfStroke, faStarStroke, faQuoteLeft, faQuoteRight, faPlane, faUsers, faMapLocationDot,
             faHandshake, faPhone, faEnvelope, faLocationDot, faClock, faHouse, faFax, faPassport, faSuitcaseRolling,
             faMugHot, faAvianex, faBan, faMagnifyingGlass, faCreditCard, faXmark, faCircleExclamation, faCircleUser,
             faPencil, faCaretDown, faCircle, faClockRegular, faAngleRight, faCheck, faAngleDown, faBriefcase,
             faSuitcase, faCartFlatbedSuitcase, faMinus, faPlus, faPhoneVolume, faCircleRefular, faCircleInfo );

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .component('font-awesome-icon', FontAwesomeIcon)
            .mount(el);
    },
    progress: {
        color: '#87cefa',
    },
});
