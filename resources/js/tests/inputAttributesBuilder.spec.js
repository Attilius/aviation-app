import InputAttributesBuilder from "../Tools/InputAttributesBuilder";

const testFormServices = {
    service_1: ['field_a', 'field_b'],
    service_2: ['field_a', 'field_b', 'field_c'],
    service_3: ['field_b']
}

const testInputAttributes = {
    field_a: {
        id: 'field_a',
        type: 'text',
        label: {
            _for_: 'field_a',
            textValue: 'Field A',
            customClasses: ['class-1', 'class-2']
        },
        customClasses: ['class-3', 'class-4', 'class-5']
    },
    field_b: {
        id: 'field_b',
        type: 'text',
        label: {
            _for_: 'field_b',
            textValue: 'Field B',
            customClasses: ['class-1', 'class-2']
        },
        customClasses: ['class-3', 'class-4', 'class-5']
    },
    field_c: {
        id: 'field_c',
        type: 'text',
        label: {
            _for_: 'field_c',
            textValue: 'Field C',
            customClasses: ['class-1', 'class-2']
        },
        customClasses: ['class-3', 'class-4', 'class-5']
    },
}

describe("Input attributes builder tests", () => {
    let builder;

    beforeEach(() => {
        builder = new InputAttributesBuilder();
    });

    // Test cases for normal situations

    test("Build method is a function", () => {
        expect(typeof builder.build).toBe("function");
    });

    test("The formServiceName field is defined", () => {
        expect(builder.formServiceName).toBeDefined();
    });

    test("The formServices field is defined", () => {
        expect(builder._formServices).toBeDefined();
    });

    test("The inputAttributes field is defined", () => {
        expect(builder._inputAttributes).toBeDefined();
    });

    test("Build method type of return is object", () => {
        builder = new InputAttributesBuilder('service_1');
        builder._formServices = testFormServices;
        builder._inputAttributes = testInputAttributes;
        expect(typeof builder.build()).toBe("object");
    });

    test("_getServiceParameters method is a function", () => {
        expect(typeof builder._getServiceParameters).toBe("function");
    });

    test("_getServiceParameters method return an array", () => {
        builder = new InputAttributesBuilder('service_3');
        builder._formServices = testFormServices;
        expect(builder._getServiceParameters()).toStrictEqual(['field_b']);
    });

    test("Build method return correct attributes object for Material Ui component", () => {
        builder = new InputAttributesBuilder('service_3');
        builder._formServices = testFormServices;
        builder._inputAttributes = testInputAttributes;
        expect(builder.build()).toStrictEqual({
            field_b: {"customClasses": ["class-3", "class-4", "class-5"],
                        "id": "field_b",
                        "label": {"_for_": "field_b",
                                  "customClasses": ["class-1", "class-2"],
                                  "textValue": "Field B"
                                 },
                        "type": "text"}
        });
    });

    // Test cases for exceptional situations

    test("Missing argument case should throw an error", () => {
        function expectError() {
            builder.build();
        }
        expect(expectError).toThrow(new Error("Missing argument (formServiceName: )"));
    });

    test("Wrong argument case should throw an error", () => {
        const exceptionArguments = [
            13,
            ['test', 'name'],
            {formServiceName: 'test'},
            true,
            3.14,
            null,
            NaN,
            () => {return 'formServiceName';}
        ];
        function expectError() {
            exceptionArguments.forEach((item) => {
                builder = new InputAttributesBuilder(item);
                builder.build();
            });
        }
        expect(expectError).toThrow("Wrong type of argument (formServiceName: )");
    });

    test("If the argument does not exist should throw an error", () => {
        builder = new InputAttributesBuilder('test');
        function expectError() {
            if(!Object.keys(testFormServices).includes(builder.formServiceName)) {
                builder.build();
            }
        }
        expect(expectError).toThrow(new Error(`Argument ('${builder.formServiceName}') does not exist`));
    });
});
