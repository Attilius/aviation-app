module.exports = {
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
