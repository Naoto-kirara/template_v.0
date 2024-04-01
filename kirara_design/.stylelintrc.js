module.exports = {
  "extends": [
    "stylelint-config-standard-scss",
    "stylelint-config-recess-order"
  ],
  ignoreFiles: [
    '**/node_modules/**',
  ],
  rules: {
    // ベンダープレフィックの修正はしない
    "property-no-vendor-prefix": null,
    "selector-id-pattern": null, // idでkebab-case以外も許容
    "selector-class-pattern": null, // classでkebab-case以外も許容
    "keyframes-name-pattern": null, // keyframesでkebab-case以外も許容
    "scss/at-mixin-pattern": null, // mixinでkebab-case以外も許容
    "scss/dollar-variable-pattern": null, // $変数でkebab-case以外も許容
    // コメントの整形はさせる
    "comment-empty-line-before": "always",
    // メディアクエリの演算子を禁止する（いまはとりあえず）
    "media-feature-range-notation": "prefix",
  }
};