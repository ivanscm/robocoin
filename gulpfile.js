var gulp = require('gulp');
var install = require("gulp-install");

var sourceJS = [
    './node_modules/jquery/dist/jquery.min.js',
    './node_modules/nette-forms/src/assets/netteForms.min.js',
    './node_modules/nette.ajax.js/nette.ajax.js',
    './node_modules/materialize-css/dist/js/materialize.min.js'
];
var destinationJS = './www/js';

var sourceCSS = ['./node_modules/materialize-css/dist/css/materialize.min.css'];
var destinationCSS = './www/css';

var sourceFonts = ['node_modules/materialize-css/dist/fonts/**'];
var destinationFonts = './www/fonts';

gulp.task('install', function () {
    return gulp
        .src(['./package.json'])
        .pipe(install());
});

gulp.task('js', function () {
    return gulp.src(sourceJS)
        .pipe(gulp.dest(destinationJS));
});
gulp.task('fonts', function () {
    return gulp.src(sourceFonts)
        .pipe(gulp.dest(destinationFonts));
});

gulp.task('css', function () {
    return gulp.src(sourceCSS)
        .pipe(gulp.dest(destinationCSS));
});

gulp.task('default', ['install', 'css', 'js', 'fonts']);