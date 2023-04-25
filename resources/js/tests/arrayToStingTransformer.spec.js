import ArrayToStringTransformer from '../Tools/ArrayToStringTransformer';

const testArray = ['class-1', 'class-2'];
const testObject = {key: 'value'};
const testAssocArray = ['class-test', 13, {class: 'class-13'}]

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
        transformer = new ArrayToStringTransformer(testArray);
        expect(transformer.transform()).toBe("class-1 class-2");
    });

    // Test cases for exceptional situations

    test("Transform method returns empty string if the type of parameter is not an array", () => {
        transformer = new ArrayToStringTransformer(testObject);
        expect(transformer.transform()).toBe("");
    });

    test("Transform method returns empty string if the parameter is an associative array", () => {
        transformer = new ArrayToStringTransformer(testAssocArray);
        expect(transformer.transform()).toBe("");
    });
});
