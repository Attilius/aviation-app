import { shallowMount } from "@vue/test-utils";
import Checkbox from "../../../Components/Checkbox.vue";

describe("Checkbox component test", () => {
    let wrapper;

    const findCheckboxInput = () => wrapper.find('[data-testId="checkbox-input"]');

    function createComponent() {
        wrapper = shallowMount(Checkbox);
    }

    test("Renders the checkbox", () => {
        createComponent();
        expect(findCheckboxInput().exists()).toBe(true);
    });

    test("Component has input tag", () => {
        createComponent();
        expect(wrapper.find("input").exists()).toBe(true);
    });

    test("Event has been emitted", async () => {
        wrapper.vm.$emit('update:checked', true);
        await wrapper.vm.$nextTick();
        expect(wrapper.emitted("update:checked")).toBeTruthy();
    });

    test("Checkbox set checked test", async () => {
        const checkboxInput = wrapper.find('input[type="checkbox"]');
        await checkboxInput.setChecked();
        expect(checkboxInput.element.checked).toBeTruthy();
    });
});
