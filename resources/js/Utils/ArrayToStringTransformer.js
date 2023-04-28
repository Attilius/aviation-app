export default class ArrayToStringTransformer {

    constructor(array = []) {
        this.array = array;
    }

    /**
     * It transforms the content of array to string.
     *
     * @returns {string}
     */
    transform() {
        let transformedResult = '';

        if(this._arrayContentValidator(this.array)) {
            this.array.map(item => transformedResult += ' ' + item);
        }

        return transformedResult.trim();
    }

    /**
     * It investigates the type of attribute is an array and the content of array it type is string.
     *
     * @param array
     * @returns {boolean}
     * @private
     */
    _arrayContentValidator(array) {
        let validResult = false;

        if(Array.isArray(array) && array.length > 0) {
            for (let i = 0; i < array.length; i++) {
                if(typeof array[i] === 'string') {
                    validResult = true
                } else {
                    validResult = false;
                    break;
                }
            }
        }
        return validResult;
    }
}
