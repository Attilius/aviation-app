import { shallowMount } from "@vue/test-utils";
import PrimaryButton from "../Components/PrimaryButton.vue";

describe("PrimaryButton component test", () => {
    let wrapper;

    const findPrimaryButton = () => wrapper.find('[data-testId="primary-button"]');

    function createComponent() {
        wrapper = shallowMount(PrimaryButton, {
            props: {
                type: {
                    type: String,
                    default: "submit"
                }
            }
        });
    }

    test("Renders the button", () => {
        createComponent();

        expect(findPrimaryButton().exists()).toBe(true);
    });

    test("Checking the props", () => {
        createComponent();

        expect(wrapper.props().type.type).toBe(String);
        expect(wrapper.props().type.default).toBe("submit");
    });
});


