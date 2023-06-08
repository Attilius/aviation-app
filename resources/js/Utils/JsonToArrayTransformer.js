export default class JsonToArrayTransformer {

    constructor(file) {
        this.file = file;
    }

    transform() {
        const result = [];

        Object.values(this.file).forEach((item) => {
            result.push(item);
        });

        return result;
    }
}
