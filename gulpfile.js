var gulp = require('gulp');
var sass = require('gulp-sass')(require('sass'));
var autoprefixer = require('gulp-autoprefixer');
var cssnano = require('gulp-cssnano');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');

// Define paths
var paths = {
    styles: {
        src: './src/scss/**/*.scss',
        dest: './assets/'
    },
    scripts: {
        src: './src/js/**/*.js',
        dest: './assets/'
    }
};

// Define tasks
gulp.task('styles', function() {
    return gulp.src(paths.styles.src)
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(cssnano())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(paths.styles.dest));
});

gulp.task('scripts', function() {
    return gulp.src(paths.scripts.src)
        .pipe(concat('main.js'))
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(paths.scripts.dest));
});

gulp.task('watch', function() {
    gulp.watch(paths.styles.src, gulp.series('styles'));
    gulp.watch(paths.scripts.src, gulp.series('scripts'));
});

gulp.task('default', gulp.series('styles', 'scripts', 'watch'));
