import { shallowMount } from "@vue/test-utils";
import PrimaryButton from "../../../Components/PrimaryButton.vue";

describe("PrimaryButton component test", () => {
    let wrapper;

    const findPrimaryButton = () => wrapper.find('[data-testId="primary-button"]');

    function createComponent() {
        wrapper = shallowMount(PrimaryButton, {
            props: {
                type: "button"
            }
        });
    }

    test("Renders the button", () => {
        createComponent();

        expect(findPrimaryButton().exists()).toBe(true);
    });

    test("Component has a button tag", () => {
        createComponent();

        expect(wrapper.find("button").exists()).toBe(true);
    });

    test("Checking the props with type `button`", () => {
        createComponent();

        expect(wrapper.props().type).toBe("button");
    });
});


