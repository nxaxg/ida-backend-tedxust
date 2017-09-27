/**
 *
 *  Web Starter Kit
 *  Copyright 2015 Google Inc. All rights reserved.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      https://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License
 *
 */

'use strict';

// This gulpfile makes use of new JavaScript features.
// Babel handles this without us having to do anything. It just works.
// You can read more about the new JavaScript features here:
// https://babeljs.io/docs/learn-es2015/

import gulp from 'gulp';
import runSequence from 'run-sequence';
import browserSync from 'browser-sync';
import gulpLoadPlugins from 'gulp-load-plugins';
import pkg from './package.json';
const cssPath = './css';
const sftp = require('gulp-sftp');

const $ = gulpLoadPlugins();
const reload = browserSync.reload;


// Lint JavaScript
gulp.task('lint', () =>
  gulp.src('/scripts/**/*.js')
    .pipe($.eslint())
    .pipe($.eslint.format())
    .pipe($.if(!browserSync.active, $.eslint.failOnError()))
);

// Optimize images
gulp.task('images', () =>
  gulp.src('/images/**/*')
    .pipe($.cache($.imagemin({
      progressive: true,
      interlaced: true
    })))
    .pipe(gulp.dest('/img'))
    .pipe($.size({title: 'images'}))
);

////////
//////// Styles procesor
gulp.task('styles', () => {
  const AUTOPREFIXER_BROWSERS = [
    'ie >= 10',
    'ie_mob >= 10',
    'ff >= 30',
    'chrome >= 34',
    'safari >= 7',
    'opera >= 23',
    'ios >= 7',
    'android >= 4.4',
    'bb >= 10'
  ];

  // For best performance, don't add Sass partials to `gulp.src`
  return gulp.src([
    './styles/main.scss',
    // './styles/main.min.scss',
  ])
    .pipe($.sourcemaps.init())
    .pipe($.sass({ precision: 10 }).on('error', $.sass.logError))
    .pipe($.autoprefixer(AUTOPREFIXER_BROWSERS))
    .pipe($.if('*.css', $.cssnano({discardComments: {removeAll: true}})))
    .pipe($.size({title: 'styles'}))
    .pipe($.sourcemaps.write('./'))
    .pipe(gulp.dest('./css' ));
});


////////
//////// Watch styles
gulp.task('styles:watch', ['styles'], () => {
	gulp.watch("./styles/**/*", ['styles']);
});

//SFTP

gulp.task('deploy', function () {
    return gulp.src('./*')
        .pipe(sftp({
            host: '54.148.0.90',
            user: 'ubuntu',
            pass: 'Hb5om2ifqu'
        }));
})


