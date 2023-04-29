import ArrayToStringTransformer from '../../../Utils/ArrayToStringTransformer';

describe("Array to string transformer tests", () => {
    let transformer;

    beforeEach(() => {
        transformer = new ArrayToStringTransformer();
    });

    // Test cases for normal situations

    test("Transform method is a function", () => {
        expect(typeof transformer.transform).toBe("function");
    });

    test("The array field is defined", () => {
        expect(transformer.array).toBeDefined();
    });

    test("The value of array filed is empty array when no have been add parameter for the constructor", () => {
        expect(transformer.array).toEqual([]);
    });

    test("Transform method type of return is string", () => {
        expect(typeof transformer.transform()).toBe("string");
    });

    test("Transform method returns items of array chained in a string", () => {
        const arrayOfCorrectContents = ['class-1', 'class-2'];

        transformer = new ArrayToStringTransformer(arrayOfCorrectContents);
        expect(transformer.transform()).toBe("class-1 class-2");
    });

    // Test cases for exceptional situations

    test("Transform method returns empty string if the type of parameter is not an array or " +
        "the content of array is not (only) string", () => {
        const arrayOfInvalidContents = [
            'first',
            13,
            3.14,
            true,
            null,
            NaN,
            {key: 'value'},
            ['first', 13, {class: 'class-13'}, 'last'],
            [['test']],
            () => {return 'test-class'},
            [false]
        ];

        arrayOfInvalidContents.forEach((item) => {
            transformer = new ArrayToStringTransformer(item);
        });
        expect(transformer.transform()).toBe("");
    });
});
