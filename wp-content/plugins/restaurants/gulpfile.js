/**
 * WordPress Theme-specific Gulp file.
 *
 * Instructions
 *
 * In command line, cd into the project directory and run these commands:
 * npm init
 * sudo npm install --save-dev gulp gulp-util gulp-load-plugins browser-sync
 * sudo npm install --save-dev gulp-sourcemaps gulp-autoprefixer gulp-line-ending-corrector gulp-filter gulp-merge-media-queries gulp-cssnano gulp-sass gulp-concat gulp-uglify gulp-notify gulp-imagemin gulp-rename gulp-wp-pot
 *
 * Implements:
 * 			1. Live reloads browser with BrowserSync.
 * 			2. CSS: Sass to CSS conversion, error catching, Autoprixing, Sourcemaps,
 * 				 CSS minification, and Merge Media Queries.
 * 			3. JS: Concatenates & uglifies Vendor and Custom JS files.
 * 			4. Images: Minifies PNG, JPEG, GIF and SVG images.
 * 			5. Watches files for changes in CSS or JS.
 * 			6. Watches files for changes in PHP.
 * 			7. Corrects the line endings.
 *      8. InjectCSS instead of browser page reload.
 *      9. Generates .pot file for i18n and l10n.
 *
 * @since 1.0.0
 * @author Ahmad Awais (@mrahmadawais) and Chris Wilcoxson (@slushman)
 */

/**
 * Project Configuration for gulp tasks.
 */
// Project related.
var project 					= 'restaurants'; // Project Name.
var projectURL 					= 'menus.dev'; // Project URL. Could be something like localhost:8888.
var productURL 					= './'; // Theme/Plugin URL. Leave as is.

// Translation related.
var text_domain 				= 'restaurants';
var destFile 					= 'restaurants.pot';
var package 					= 'Restaurants';
var bugReport 					= 'http://www.dccmarketing.com/contact';
var lastTranslator 				= 'Chris Wilcoxson <chrisw@dccmarketing.com>';
var team 						= 'DCC Marketing <web@dccmarketing.com>';
var translatePath 				= './assets/languages'

// Public styles
var styleSRC 					= './src/scss/restaurants-public.scss'; // Path to main .scss file.
var styleDestination 			= './assets/css'; // Path to place the compiled CSS file.

// Admin styles
var adminStyleSRC 				= './src/scss/restaurants-admin.scss'; // Path to admin.scss file.
var adminStyleDestination 		= './assets/css'; // Path to place the compiled CSS file.
// Default set to root folder.

// JS Public
var jsPublicSRC 				= './src/public-js/*.js'; // Path to JS public scripts folder.
var jsPublicDestination 		= './assets/js/'; // Path to place the compiled JS public scripts file.
var jsPublicFile 				= 'restaurants-public'; // Compiled JS public file name
// Default set to public i.e. public.js.

// JS Admin
var jsAdminSRC 					= './src/admin-js/*.js'; // Path to JS admin scripts folder.
var jsAdminDestination 			= './assets/js/'; // Path to place the compiled JS admin scripts file.
var jsAdminFile 				= 'restaurants-admin'; // Compiled JS admin file name.
// Default set to admin i.e. admin.js.

// Images related.
var imagesSRC 					= './src/images/*.{png,jpg,gif,svg}'; // Images source folder
var imagesDestination 			= './assets/images/'; // Images destination folder. Must be different than source.

// Watch files paths.
var styleWatchFiles 			= './src/scss/**/*.scss'; // Path to all *.scss files.
var vendorJSWatchFiles 			= './src/js/*.js'; // Path to all vendor JS files.
var publicJSWatchFiles 			= './src/public-js/*.js'; // Path to all public JS files.
var adminJSWatchFiles 			= './src/admin-js/*.js'; // Path to all admin JS files.
var projectPHPWatchFiles 		= './*.php'; // Path to all PHP files.

var zipFiles 					= [ './**',
									'!node_modules/**/*',
									'!src/**/*',
									'!.git/**/*',
									'!node_modules',
									'!src',
									'!.git',
									'!*.zip' ];

/**
* Load gulp plugins and assing them semantic names.
*/
var gulp 						= require( 'gulp' ); // Gulp of-course
var plugins 					= require( 'gulp-load-plugins' )();
var browserSync 				= require( 'browser-sync' ).create(); // Reloads browser and injects CSS.
var reload 						= browserSync.reload; // For manual browser reload.

/**
 * Browsers you care about for autoprefixing.
 */
const AUTOPREFIXER_BROWSERS = [
	'last 2 version',
	'> 1%',
	'ie >= 9',
	'ie_mob >= 10',
	'ff >= 30',
	'chrome >= 34',
	'safari >= 7',
	'opera >= 23',
	'ios >= 7',
	'android >= 4',
	'bb >= 10'
];

/**
 * Live Reloads, CSS injections, Localhost tunneling.
 *
 * @link http://www.browsersync.io/docs/options/
 */
gulp.task( 'browser-sync', function() {
	browserSync.init({
		proxy: projectURL,
		open: true,
		injectChanges: true,
 		browser: "google chrome"
	});
});

/**
 * Creates style.css.
 */
gulp.task( 'publicStyle', function () {
 	gulp.src( styleSRC )
		.pipe( plugins.sourcemaps.init() )
		.pipe( plugins.sass( {
			errLogToConsole: true,
			includePaths: ['./sass'],
			outputStyle: 'compact',
			precision: 10
		} ) )
		.on( 'error', console.error.bind(console) )
		.pipe( plugins.sourcemaps.write( { includeContent: false } ) )
		.pipe( plugins.sourcemaps.init( { loadMaps: true } ) )
		.pipe( plugins.autoprefixer( AUTOPREFIXER_BROWSERS ) )
		.pipe( plugins.sourcemaps.write ( './' ) )
		.pipe( plugins.lineEndingCorrector() )
		.pipe( gulp.dest( styleDestination ) )
		.pipe( plugins.filter( '**/*.css' ) ) // Filtering stream to only css files
		.pipe( plugins.mergeMediaQueries( { log: true } ) ) // Merge Media Queries only for final version.

 		.pipe( plugins.cssnano())
 		.pipe( plugins.lineEndingCorrector() )
 		.pipe( gulp.dest( styleDestination ) )

 		.pipe( plugins.filter( '**/*.css' ) ) // Filtering stream to only css files
 		.pipe( browserSync.stream() ) // Reloads style.css if that is enqueued.
 		.pipe( plugins.notify( { message: 'TASK: "publicStyle" Completed! 💯', onLast: true } ) );
});

/**
 * Creates admin.css.
 */
gulp.task( 'adminStyle', function () {
 	gulp.src( adminStyleSRC )
 		.pipe( plugins.sourcemaps.init() )
 		.pipe( plugins.sass( {
 			errLogToConsole: true,
 			includePaths: ['./sass'],
 			outputStyle: 'compact',
 			precision: 10
 		} ) )
 		.on( 'error', console.error.bind(console) )
 		.pipe( plugins.sourcemaps.write( { includeContent: false } ) )
 		.pipe( plugins.sourcemaps.init( { loadMaps: true } ) )
		.pipe( plugins.autoprefixer( AUTOPREFIXER_BROWSERS ) )
		.pipe( plugins.sourcemaps.write ( './' ) )
		.pipe( plugins.lineEndingCorrector() )
		.pipe( gulp.dest( adminStyleDestination ) )
		.pipe( plugins.filter( '**/*.css' ) ) // Filtering stream to only css files
		.pipe( plugins.mergeMediaQueries( { log: true } ) ) // Merge Media Queries only for final version.

 		.pipe( plugins.cssnano())
 		.pipe( plugins.lineEndingCorrector() )
 		.pipe( gulp.dest( adminStyleDestination ) )

 		.pipe( plugins.filter( '**/*.css' ) ) // Filtering stream to only css files
 		.pipe( browserSync.stream() ) // Reloads style.css if that is enqueued.
 		.pipe( plugins.notify( { message: 'TASK: "adminStyle" Completed! 💯', onLast: true } ) );
});

/**
 * Concatenate and uglify vendor JS scripts.
 */
gulp.task( 'vendorsJs', function() {
	gulp.src( jsVendorSRC )
		.pipe( plugins.concat( jsVendorFile + '.js' ) )
		.pipe( plugins.lineEndingCorrector() )
		.pipe( gulp.dest( jsVendorDestination ) )
		.pipe( plugins.rename( {
			basename: jsVendorFile,
			suffix: '.min'
		}))
		.pipe( plugins.uglify() )
		.pipe( plugins.lineEndingCorrector() )
		.pipe( gulp.dest( jsVendorDestination ) )
		.pipe( plugins.notify( { message: 'TASK: "vendorsJs" Completed! 💯', onLast: true } ) );
});

/**
 * Concatenate and uglify public JS scripts.
 */
gulp.task( 'publicJS', function() {
	gulp.src( jsPublicSRC )
		.pipe( plugins.concat( jsPublicFile + '.js' ) )
		.pipe( plugins.lineEndingCorrector() )
		.pipe( gulp.dest( jsPublicDestination ) )
		.pipe( plugins.rename( {
			basename: jsPublicFile,
			suffix: '.min'
		}))
		.pipe( plugins.uglify() )
		.pipe( plugins.lineEndingCorrector() )
		.pipe( gulp.dest( jsPublicDestination ) )
		.pipe( plugins.notify( { message: 'TASK: "publicJS" Completed! 💯', onLast: true } ) );
});

/**
 * Concatenate and uglify admin JS scripts.
 */
gulp.task( 'adminJS', function() {
	gulp.src( jsAdminSRC )
		.pipe( plugins.concat( jsAdminFile + '.js' ) )
		.pipe( plugins.lineEndingCorrector() )
		.pipe( gulp.dest( jsAdminDestination ) )
		.pipe( plugins.rename( {
			basename: jsAdminFile,
			suffix: '.min'
		}))
		.pipe( plugins.uglify() )
		.pipe( plugins.lineEndingCorrector() )
		.pipe( gulp.dest( jsAdminDestination ) )
		.pipe( plugins.notify( { message: 'TASK: "adminJS" Completed! 💯', onLast: true } ) );
});

/**
 * Minifies PNG, JPEG, GIF and SVG images.
 */
gulp.task( 'images', function() {
 	gulp.src( imagesSRC )
 		.pipe( plugins.imagemin({
 			progressive: true,
 			optimizationLevel: 3, // 0-7 low-high
 			interlaced: true,
 			svgoPlugins: [{removeViewBox: false}]
 		}))
 		.pipe( gulp.dest( imagesDestination ) )
 		.pipe( plugins.notify( { message: 'TASK: "images" Completed! 💯', onLast: true } ) );
});

/**
 * WP POT Translation File Generator.
 */
gulp.task( 'translate', function () {
 	return gulp.src( projectPHPWatchFiles )
 		.pipe( sort() )
 		.pipe( plugins.wpPot({
 			domain        : text_domain,
 			destFile      : destFile,
 			package       : package,
 			bugReport     : bugReport,
 			lastTranslator: lastTranslator,
 			team          : team
 		}) )
 		.pipe( gulp.dest(translatePath) )
 		.pipe( plugins.notify( { message: 'TASK: "translate" Completed! 💯', onLast: true } ) );
});

// gulp.task( 'zipIt', function() {
// 	return gulp.src( zipFiles )
// 		.pipe( plugins.zip( project + '.zip' ) )
// 		.pipe( gulp.dest( './' ) );
// });

/**
 * Watches for file changes and runs specific tasks.
 */
gulp.task( 'default', ['publicStyle', 'adminStyle', /*'vendorsJs',*/ 'publicJS', 'adminJS', 'browser-sync'], function () {
 	gulp.watch( projectPHPWatchFiles, reload ); // Reload on PHP file changes.
 	gulp.watch( styleWatchFiles, [ 'publicStyle', 'adminStyle' ] ); // Reload on SCSS file changes.
 	//gulp.watch( vendorJSWatchFiles, [ 'vendorsJs', reload ] ); // Reload on vendorsJs file changes.
 	gulp.watch( publicJSWatchFiles, [ 'publicJS', reload ] ); // Reload on publicJS file changes.
 	gulp.watch( adminJSWatchFiles, [ 'adminJS', reload ] ); // Reload on adminJS file changes.
});
