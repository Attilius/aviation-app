import {shallowMount} from "@vue/test-utils";
import MaterialUiInput from "../../../Components/MaterialUiInput.vue";

describe("MaterialUiInput component test", () => {
    let wrapper;

    // find helper
    const findInput = () => wrapper.find('[data-testId="mui-input"]');
    const findLabel = () => wrapper.find('[data-testId="mui-label"]');

    // component factory
    function createComponent() {
        wrapper = shallowMount(MaterialUiInput, {
            data() {
                return {
                    input: null,

                    labelBaseCssClasses: "test-class-1 test-class-2"
                }
            },
            props: {
                modelValue: "",
                'onUpdate:modelValue': (e) => wrapper.setProps({ modelValue: e }),
                id: "email",
                type: "email",
                label: {
                    _for_: "email",
                    textValue: "Email",
                    customClasses: ["test-color-1"]
                },
                customClasses: ["test-color-2"]
            }
        });
    }

    test("Renders the input", () => {
        createComponent();
        expect(findInput().exists()).toBe(true);
    });

    test("Renders the label", () => {
        createComponent();
        expect(findLabel().exists()).toBe(true);
    });

    test("Checked the props", () => {
        createComponent();
        expect(wrapper.props("id")).toBe("email");
        expect(wrapper.props("type")).toBe("email");
        expect(wrapper.props("id")).toBe("email");
        expect(wrapper.props("customClasses")).toEqual(["test-color-2"]);
        expect(wrapper.props("label")).toEqual({
            _for_: "email",
            textValue: "Email",
            customClasses: ["test-color-1"]
        });
    });

    test("modelValue should be updated", async () => {
        await wrapper.find("input").setValue("test@test.com");
        expect(wrapper.props("modelValue")).toBe("test@test.com");
    });
});
