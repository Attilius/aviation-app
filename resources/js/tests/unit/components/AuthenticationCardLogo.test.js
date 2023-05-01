import {shallowMount} from "@vue/test-utils";
import AuthenticationCardLogo from "../../../Components/AuthenticationCardLogo.vue";

describe("AuthenticationCardLogo component test", () => {
    let wrapper;

    // helper
    const findImage = () => wrapper.find('[data-testId="image-logo"]');

    // component factory
    function createComponent() {
        wrapper = shallowMount(AuthenticationCardLogo);
    }

    test("Renders logo image", () => {
        createComponent();
        expect(findImage().exists()).toBe(true);
    });

    test("Check image src settings", () => {
        createComponent();
        const logoImagePath = "/img/logos/lorem-logo.png";
        expect(findImage().attributes().src).toBe(logoImagePath);
    });

    test("Check alt attribute value is not empty", () => {
        createComponent();
        expect(findImage().attributes().alt).toBeTruthy();
    });
});
