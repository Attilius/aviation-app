import inputAttributes from "../Config/inputAttributes.js";
import formServices from "../Config/formServices.js";

export default class InputAttributesBuilder {
    _formServices = formServices
    _inputAttributes = inputAttributes

    constructor(formServiceName = '') {
        this.formServiceName = formServiceName;
    }

    /**
     * Specify the name of input fields of a given form service in an array.
     *
     * @returns array
     * @private
     */
    _getServiceParameters() {
        return this._formServices[this.formServiceName];
    }

    /**
     * It builds an object from attributes for an input field.
     *
     * @returns {{}}
     */
    build() {
        let resultInputAttributes = {};

        if(this.formServiceName !== '' && typeof this.formServiceName === 'string'
            && Object.keys(this._formServices).includes(this.formServiceName)) {

            this._getServiceParameters().forEach((item) => {
                resultInputAttributes[item] = this._inputAttributes[item];
            });

        } else {
            if (this.formServiceName === '') {
                throw new Error('Missing argument (formServiceName: )');
            }

            if (typeof this.formServiceName !== 'string') {
                throw new Error('Wrong type of argument (formServiceName: )');
            }

            if (!Object.keys(this._formServices).includes(this.formServiceName)) {
                throw new Error(`Argument ('${this.formServiceName}') does not exist`);
            }
        }

        return resultInputAttributes;
    }
}
