module.exports = {
    root: true,
    parser: 'babel-eslint',
    parserOptions: {
        sourceType: 'module'
    },
    extends: ['vue', 'plugin:jasmine/recommended'],
    // required to lint *.vue files
    plugins: [
        'html',
        'jasmine'
    ],
    globals: {
        window: true,
        document: true,
        WatchTower: true,
    },
    // check if imports actually resolve
    'settings': {
        'import/resolver': {
          'webpack': {
            'config': 'webpack.config.js'
          }
        },
        'import/alias': {
            components: './resources/assets/app/components'
        }
    },
    // add your custom rules here
    'rules': {
        'no-multiple-empty-lines': ['error', { max: 2, maxEOF: 1 }],
        'camelcase': 'off'
    }
};
