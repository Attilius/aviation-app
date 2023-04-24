export default class ArrayToStringTransformer {

    constructor(array){
        this.array = array;
    }

    transform(){
        let transformedResult = '';

        if(Array.isArray(this.array)) {
            this.array.map(item => transformedResult += ' ' + item);
        }

        return transformedResult.trim();
    }
}
