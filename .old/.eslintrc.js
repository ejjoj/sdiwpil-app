module.exports = {
  parserOptions: {
    parser: '@babel/eslint-parser',
    ecmaVersion: 2020,
    sourceType: 'module',
    requireConfigFile: false,
  },
  extends: [
    'airbnb-base',
    'plugin:vue/recommended',
  ],
  rules: {
    'vue/no-v-html': 0,
    'max-len': ['error', { code: 200 }],
    'import/extensions': 0,
    'import/no-unresolved': 0,
    'no-console': ['error', { allow: ['warn', 'error'] }],
    'no-mixed-operators': 0,
    'vue/prop-name-casing': 0,
  },
};
