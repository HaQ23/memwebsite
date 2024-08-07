const { src, dest, series, parallel, watch } = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const cssnano = require("gulp-cssnano");
const autoprefixer = require("gulp-autoprefixer");
const rename = require("gulp-rename");
const babel = require("gulp-babel");
const uglify = require("gulp-uglify");
const webp = require("gulp-webp");
const sourcemaps = require("gulp-sourcemaps");
const browserSync = require("browser-sync").create();
const reload = browserSync.reload;
const clean = require("gulp-clean");
const kit = require("gulp-kit");
const purgecss = require("gulp-purgecss");
const paths = {
	html: "./html/**/*.kit",
	sass: "./src/sass/**/*.scss",
	js: "./src/js/**/*.js",
	img: "./src/assets/**/*",
	sassDest: "./dist/css",
	jsDest: "./dist/js",
	imgDest: "./dist/assets",
	dist: "./dist",
};
function startSass(done) {
	src(paths.sass)
		.pipe(sourcemaps.init())
		.pipe(sass({ outputStyle: "compressed" }).on("error", sass.logError))
		.pipe(autoprefixer())
		.pipe(rename({ suffix: ".min" }))
		.pipe(sourcemaps.write())
		.pipe(dest(paths.sassDest));
	done();
}
function javaScript(done) {
	src(paths.js)
		.pipe(sourcemaps.init())

		.pipe(
			babel({
				presets: ["@babel/env"],
			})
		)
		.pipe(uglify())
		.pipe(rename({ suffix: ".min" }))
		.pipe(sourcemaps.write())
		.pipe(dest(paths.jsDest));
	done();
}

function converImg(done) {
	src(paths.img).pipe(webp()).pipe(dest(paths.imgDest));
	done();
}
function startBrowserSync(done) {
	browserSync.init({
		server: {
			baseDir: "./",
		},
	});
	done();
}
function watchForChanges(done) {
	watch("./*.html").on("change", reload);
	watch(
		[paths.html, paths.sass, paths.js],
		parallel(startSass, javaScript, handleKit)
	).on("change", reload);
	watch(paths.img, converImg).on("change", reload);
	done();
}
function cleanStuff(done) {
	src(paths.dist, { read: false }).pipe(clean());
	done();
}
function handleKit(done) {
	src(paths.html).pipe(kit()).pipe(dest("./"));
	done();
}
const mainFunctions = parallel(
	handleKit,
	startSass,
	javaScript,
	converImg,
	startBrowserSync
);
exports.cleanStuff = cleanStuff;
exports.default = series(mainFunctions, watchForChanges);
