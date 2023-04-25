export default class ArrayToStringTransformer {

    constructor(array = []) {
        this.array = array;
    }

    transform() {
        let transformedResult = '';

        if(this._arrayContentValidator(this.array)) {
            this.array.map(item => transformedResult += ' ' + item);
        }

        return transformedResult.trim();
    }

    _arrayContentValidator(array) {
        let validResult = false;

        if(Array.isArray(array) && array.length > 0) {
            for (let i = 0; i < array.length; i++) {
                typeof array[1] === 'string' ? validResult = true : validResult;
            }
        }
        return validResult;
    }
}
