import ArrayToStringTransformer from '../Tools/ArrayToStringTransformer';

const testArray = ['class-1', 'class-2'];

describe("Array to string transformer tests", () => {
    const transformer = new ArrayToStringTransformer();

    test("Transform method is a function", () => {
        expect(typeof transformer.transform).toBe("function");
    });

    test("Transform method returns empty string if the type of parameter is not an array", () => {
        expect(transformer.transform()).toBe("");
    });

    test("Transform method returns", () => {
        transformer.transform = jest.fn(() => {
            return "test result";
        });
        transformer.transform();
        expect(transformer.transform).toHaveReturned();
    });

    test("Transform method type of return is string", () => {
        transformer.transform = jest.fn(() => {
            return "test result";
        });
        expect(typeof transformer.transform()).toBe("string");
    });


    test("Transform method returns items of array in a string", () => {
        transformer.transform = jest.fn(() => {
            let testResult= "";
            testArray.map(item => testResult += " " + item)
            return testResult.trim();
        });
        transformer.transform();
        expect(transformer.transform()).toBe("class-1 class-2");
    });
});
