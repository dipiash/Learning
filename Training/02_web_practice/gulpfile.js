var gulp = require('gulp'),
    csso = require('gulp-csso'),
    less = require('gulp-less'),
    path = require('path'),
    LessPluginCleanCSS = require('less-plugin-clean-css'),
    cleancss = new LessPluginCleanCSS({ advanced: true }),
    watch = require('gulp-watch'),
    batch = require('gulp-batch');

gulp.task('less', function () {
  return gulp.src('less/*.less')
    .pipe(less({ plugins: [cleancss] }))
    .pipe(csso())
    .pipe(gulp.dest('css/'));
});

gulp.task('watch', function () {
    watch('less/*.less', batch(function (events, done) {
        gulp.start('less', done);
    }));
});

gulp.task('default', ['less', 'watch'])
