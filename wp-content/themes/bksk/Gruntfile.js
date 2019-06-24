module.exports = function(grunt) {

    // 1. All configuration goes here 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        concat: {   
/*
		    home: {
		        src: [
			        'js/froogaloop2.min.js',
		            'js/jquery.cookie.js',
		            'js/jquery.cycle.js',
		            'js/home.dev.js', 
		        ],
		        dest: 'js/home.min.js',
		    },
		    reponsive: {
		        src: [
			        'js/jquery.uniform.js',
		            'js/jquery.responsify.init.js',
		        ],
		        dest: 'js/responsive.min.js',
		    }
*/
		},
		uglify: {
		    build_theme: {
		        src: 'js/theme.js',
		        dest: 'js/theme.min.js'
		    }
		},
		
		sass: {
	        options: {
				style: 'compressed',
	        },
	        dist: {		        
		        files: {
			        'css/style.css': 'css/style.scss',
		        }
		    }
		},
/*
		    responsive: {
		        options: {
		            compress: true,
		            yuicompress: true,
		            optimization: 2
		        },
		        files: {
		            'css/responsive.css': 'css/responsive.less',	            
		        } 
			},
*/
		cssmin: { // Begin CSS Minify Plugin
			target: {
			files: [{
				expand: true,
				cwd: 'css',
				src: ['*.css', '!*.min.css'],
				dest: 'css',
				ext: '.min.css'
			}]
  		}
		},
		watch: {
			options: {
				livereload: true
			},
		    scripts: {
		        files: ['js/*.js'],
		        tasks: ['uglify'],
		        options: {
		            spawn: false,
		        },
		    },
		    css: {
			    files: ['css/*.scss'],
			    tasks: ['sass', 'cssmin'],
			    options: {
			        spawn: false,
			    },
			} 
		}

    });

    // 3. Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['watch']);

};