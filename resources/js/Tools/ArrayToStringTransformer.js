export default class ArrayToStringTransformer {

    constructor(array){
        this.array = array;
    }

    transform(){
        let transformedResult = '';

        this.array.map(item => transformedResult += ' ' + item);

        return transformedResult;
    }
}
