Swedish club of WA's club membership application
================================================

This project is a membership application for the Swedish Club of WA, written using Yii/PHP. For more information about Yii please visit <http://www.yiiframework.com/>.
This application requires MySQL, PHP, and Apache to run.
It allows users to register with the application as members and edit their details including newsletter preferences.
It also allows administrators to view and edit some of the member's details, and to send batch emails to members based on search criteria.

Project team members:
Ailsa Jade, Bolt	20511379@student.uwa.edu.au
Ramneet, Birdi	20824312@student.uwa.edu.au
Longchang, Wen	10889787@student.uwa.edu.au
Gregory Paul, Collin	20351726@student.uwa.edu.au
Jason Graham, Larke	20924425@student.uwa.edu.au
Long, Ma	20870419@student.uwa.edu.au

Summary of directory structure:
assets/ - this directory holds published asset files. An asset file is a private file that may be published to become accessible to Web users.
ckeditor/ - files for the WYSIWYG text editor component
css/ - style sheets
docs/ - linked-to documents for download from the website
documentation/ - project documentation
.htaccess - web server configuration
images/ - images displayed in the website
index.php - home page
protected/ - this is the application base directory holding all security-sensitive PHP scripts and data files
scripts/ - Javascript files
yii/ - Yii system files
protected/:
	components/ - components of the website
	config/ - Yii configuration
	controllers/ - all controller class files
	data/ - SQL scripts for initial setup of the database
	models/ - all model class files
	runtime/ - this directory holds private temporary files generated during runtime of the application
	views/ - this directory holds all view files (HTML/PHP)
	views/:
		admin/ -  views for the admin controller
		ajax/ - ajax components
		layouts/ - site layout (header and footer)
		mailout/ - mailout views
		members/ - views for the members controller
		shared/ - shared views used by different controller
		site/ - views for the site controller
		site/static/ - static pages

All URLS using Yii (besides any index page, whose name can be omitted) should be in the form [domain]/[path to application directory]/[controller name]/[action name]
Any static page in protected/site/static/ can be linked to by [domain]/[path to application]/site/?view=[page name]
