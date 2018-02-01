module.exports = function(grunt) {
    grunt.initConfig({
        less: {
            development: {
                options: {
                    comporess: true,
                    sourceMap: true,
                    outputSourceFiles: true,
                    sourceMapURL: 'style.css.map',
                    sourceMapFilename: 'public/css/style.css.map',
                },
                files: {
                    'public/css/style.css': 'public/less/style.less',
                },
            },
            minified: {
                options: {
                    cleancss: true,
                    report: 'min',
                },
                files: {
                    'public/css/style.min.css': 'public/css/style.css',
                },
            },
        },
        concat: {
            options: {
                separator: ';',
            },
            bootstrap: {
                src: [
                    'app/bower_components/angular/angular.min.js',
                    'app/bower_components/angular-aria/angular-aria.js',
                    'app/bower_components/angular-animate/angular-animate.js',
                    'app/bower_components/angular-material/angular-material.js',
                    'app/bower_components/jquery/dist/jquery.js',
                    'app/bower_components/bootstrap/dist/js/bootstrap.js',

                    //'public/js/assets/*.js',
                ],
                dest: 'public/js/bootstrap.js',
            },
            bootstrap_css:{
                src:[
                    'app/bower_components/angular-material/angular-material.css',
                    'app/bower_components/bootstrap/dist/css/bootstrap.min.css',
                ],
                dest: 'public/css/bootstrap.css',
            },
            frontend_js: {
                src: [
                    'public/js/frontend/*.js',
                ],
                dest: 'public/js/frontend.js',
            },
        },
        uglify: {
            options: {
                mangle: false
            },

            bootstrap: {
                files: {
                    'public/js/bootstrap.min.js': 'public/js/bootstrap.js',
                },
            },
            frontend: {
                files: {
                    'public/js/frontend.min.js': 'public/js/frontend.js',
                },
            },
        },
        copy: {
            bootstrapfonts: {
                files: [
                    { expand: true, flatten: true, src: ['app/bower_components/bootstrap/dist/fonts/*'], dest: 'public/fonts/', filter: 'isFile'},
                ]
            },
            fontawesomefonts: {
                files: [
                    { expand: true, flatten: true, src: ['app/bower_components/font-awesome/fonts/*'], dest: 'public/fonts/', filter: 'isFile'},
                ]
            },
        },
        watch: {
            scripts: {
                files: [
                    "public/js/frontend/*.js", "public/js/frontend//**/*.js"
                ],
                tasks: [
                    'concat:frontend_js',
                    'uglify:frontend'
                ]
            },
            css: {
                files: ['public/less/*.less'],
                tasks: ['less'],
                options: {
                    livereload: true,
                },
            },
        },
    });

    // Plugin loading
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');




    // Task definition
    grunt.registerTask('dist', ['less', 'concat', 'uglify']);
    grunt.registerTask('default', ['dist']);
};