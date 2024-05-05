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
        dest: './assets/css/' // Separate folder for CSS files
    },
    scripts: {
        src: './src/js/**/*.js',
        dest: './assets/js/' // Separate folder for JS files
    },
    userStyles: {
        src: './src/user/scss/**/*.scss', // Path to user-specific SCSS files
        dest: './assets/user/css' // Separate folder for user-specific CSS files
    },
    userScripts: {
        src: './src/user/js/**/*.js', // Path to user-specific JS files
        dest: './assets/user/js' // Separate folder for user-specific JS files
    }
};

// Task to compile user-specific SCSS files
gulp.task('userStyles', function() {
    return gulp.src(paths.userStyles.src)
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(cssnano())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(paths.userStyles.dest));
});

// Task to compile user-specific JS files
gulp.task('userScripts', function() {
    return gulp.src(paths.userScripts.src)
        .pipe(concat('user.js'))
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(paths.userScripts.dest));
});

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
    gulp.watch(paths.userStyles.src, gulp.series('userStyles')); // Watch user-specific SCSS files
    gulp.watch(paths.userScripts.src, gulp.series('userScripts')); // Watch user-specific JS files
});

gulp.task('default', gulp.series('styles', 'scripts', 'userStyles', 'userScripts', 'watch'));
