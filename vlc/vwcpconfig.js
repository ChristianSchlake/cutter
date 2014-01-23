/*VLC Web Control Panel: Configuration File*/



//Directory Settings

/*You can set these variables to point to image or video files
in other folders than the one containing your HTML file.  Please 
make sure to leave the images in their respective folders in
the "Imagesv092" folder, or your filepaths will be incorrect.*/

var imagedirectorypath = "";
var videodirectorypath = "";

/*If you wish to place the .js libraries or external CSS file
in another directory you will need to set the references manually
in the head of your HTML file.  By default the filepaths are set
to whatever folder contains your HTML file.*/


//Video File Settings

/*Enter the file path or url for the video file in this variable.*/

var track = "video.mkv";

/*If you are using any softsubs for your video, you will need 
to set the proper subtitle track below. Setting 
the value to zero disables subtitles.*/

var subtitletrack = 0;


//Video Display Settings

/*You may set the height and width of the webplugin to be displayed 
in the webpage by setting the variables to the proper dimensions.*/

var displaywidth = 720;

var displayheight = 540;