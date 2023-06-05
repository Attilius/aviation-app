import feedbacks from '../../data/feedbacks.json'

export default class JsonToArrayTransformer {

    constructor(file = null) {
        file ? this.file = feedbacks : file;
    }

    transform() {
        const result = [];

        Object.values(this.file).forEach((item) => {
            result.push(item);
        });

        return result;
    }
}
