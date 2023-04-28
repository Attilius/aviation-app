module.exports = {
    reporters: [
        "default",
        [
            "./node_modules/jest-html-reporter",
            {
                "pageTitle": "Test Report"
            }
        ]
    ],
    testRegex: [
        'resources/js/tests/unit/utils/.*.spec.js$',
        'resources/js/tests/unit/components/.*.test.js$',
    ],
    transform: {
        "^.+\\.jsx?$": "babel-jest",
        '^.+\\.vue$': '@vue/vue3-jest',
    },
    testEnvironment: "jsdom",
    testEnvironmentOptions: {
        customExportConditions: ["node", "node-addons"],
    },
}
