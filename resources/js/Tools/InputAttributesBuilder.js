import inputAttributes from "../Config/inputAttributes.js";
import formServices from "../Config/formServices.js";

export default class InputAttributesBuilder {
    _formServices = formServices

    constructor(formServiceName) {
        this.formServiceName = formServiceName;
    }

    /**
     * Specify the input fields of a given form service in an array.
     * @returns array
     */
    #getServiceParameters() {
        return this._formServices[this.formServiceName];
    }

    build() {
        let materialUiInputAttributes = {};

        this.#getServiceParameters().forEach((item) => {
            materialUiInputAttributes[item] = inputAttributes[item];
        });

        return materialUiInputAttributes;
    }
}
