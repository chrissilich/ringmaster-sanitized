var gulp = 		require('gulp'),
	sass = 		require('gulp-sass');


var paths = {
	scripts: 	['assets/js/*'],
	images: 	['assets/img/*'],
	styles: 	['assets/sass/*']
};

//gulp.watch('*.scss', function(){
//	//gulp.src('assets/sass/**/*.scss')
//	//	.pipe(sass().on('error', sass.logError))
//	//	.pipe(gulp.dest('assets/css/'));
//});

gulp.task('styles', ['sass'], function() {
	console.log("recompile styles")
});

gulp.task('watch', function() {
	// gulp.watch(paths.scripts, ['scripts']);
	// gulp.watch(paths.images, ['images']);
	gulp.watch(paths.styles, ['styles']);
});

gulp.task('default', ['watch'/*, 'scripts', 'images'*/]);
