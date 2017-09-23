var gulp = require('gulp');
var install = require("gulp-install");

var sourceJS = ['./node_modules/vue/dist/vue.min.js', './node_modules/vuetify/dist/vuetify.min.js'];
var destinationJS = './www/js';

var sourceCSS = ['node_modules/vuetify/dist/vuetify.min.css'];
var destinationCSS = 'www/css';

gulp.task('install', function () {
    return gulp
        .src(['./package.json'])
        .pipe(install());
});

gulp.task('js', function () {
    return gulp.src(sourceJS)
        .pipe(gulp.dest(destinationJS));
});

gulp.task('css', function () {
    return gulp.src(sourceCSS)
        .pipe(gulp.dest(destinationCSS));
});

gulp.task('default', ['install', 'css', 'js']);