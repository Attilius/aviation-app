module.exports = {
    collectCoverage: true,
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
        'resources/js/tests/.*.spec.js$',
        'resources/js/tests/.*.test.js$',
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
