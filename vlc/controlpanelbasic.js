var fullscreen = "false";
var playpause = "true";
var instop = 0;

var level = 1;
var mutevalue = 0;
var volumevalue = 50;

var tracknumber = 0;
var currenttrack = "";
var options = "";

var rightclock = "";
var rsect;
var rseca;
var rsec;
var rmin;

var ing = 0;
var pering = " ";

var seekwidth = 0;
var seekheight = 0;
var seekpos;
var seektime;
var slider;
var sliderpos = 0;
var seekallow = 657;
var seekbarwidth = -50;
var seekbarheight = -71;
var dewidth = 720;
var deheight = 540;
var dwidth = 0;
var dheight = 0;
var sdwidth = 0;
var sdheight = 0;
var seekbarright = 0;
var seekbarbottom = 0;
var r;

var time;
var timed;
var swidth;
var sheight;
var spos;
var stime;
var ssect;
var sseca;
var ssec;
var smin;

var timeron = 0;
var playing = 0;
var s;
var i;
var itos = 250;
var sect = 0;
var seca = 0;
var sec = 0;
var min = 0;
var ff = 1;

var IE = document.all?true:false;
var dragapproved = 0;
var z, x, y;


document.onclick = seekt;
document.onmousemove = timetellert;

function findPosition()
    {
    var offbase = document.getElementById("vlcset");
    var seektop = 0;
    var seekleft = 0;
    do
        {
        seektop += offbase.offsetTop;
        seekleft += offbase.offsetLeft;
        }
    while (offbase = offbase.offsetParent);
    seekbarheight = (seekbarheight + seektop - 15);
    seekbarwidth = (seekbarwidth + seekleft - 10);
    }

function togglePlaying()
    {
    if (!playing)
        {
        playing = 1;
        }
    else
        {
        playing = 0;
        }
    }

function seekt(e)
    {
    if (playing)
        {
        seek(e);
        }
    }

function timetellert(e)
    {
    if (playing)
        {
        timeteller(e);
        }
    }

function CancelMouseDown(e)
    {
    if (e.cancelable === undefined)
        {
        e.returnValue = false;
        drags();
        }
    else 
        {
        if (e.cancelable)
            {
            e.preventDefault();
            drags(e);
            }
        }
    }

function trackselect()
    {
//    var tracker = videodirectorypath + track;
    var tracker = track;
    vlc.playlist.items.clear();
//    vlc.audio.volume = volumevalue;
    options = ":no-video-title-show";
//    vlc.playlist.add(tracker, track, options);
    vlc.playlist.add("video2.mkv");
    slider = document.getElementById("seekslider");
    findPosition();
    filepath();
    r = setTimeout("resize()", 10)
    }
    
function trackselect3()
    {
    var tracker = "test.mkv";
    var tracker = "the_big_bang_theory_s01_e11.mkv";
    vlc.playlist.items.clear();
    vlc.playlist.add(tracker);
    }

function filepath()
    {
    document.getElementById("leftseekarrow").src = imagedirectorypath + "Imagesv092/Seekbar/seekarrownovideoleft.png";
    document.getElementById("seekbarleft").src = imagedirectorypath + "Imagesv092/Seekbar/seekbaredgeleft.png";
    document.getElementById("seekslider").src = imagedirectorypath + "Imagesv092/Seekbar/vlcseekslidernovideo.png";
    document.getElementById("seekbarright").src = imagedirectorypath + "Imagesv092/Seekbar/seekbaredgeright.png";
    document.getElementById("rightseekarrow").src = imagedirectorypath + "Imagesv092/Seekbar/seekarrownovideoright.png";
    document.getElementById("playpause").src = imagedirectorypath + "Imagesv092/Controlbar/vlcplaybutton.png";
    document.getElementById("stop").src = imagedirectorypath + "Imagesv092/Controlbar/vlcstopbutton.png";
    document.getElementById("fullscreen").src = imagedirectorypath + "Imagesv092/Controlbar/vlcfullscreenbuttonfalse.png";
    document.getElementById("mute").src = imagedirectorypath + "Imagesv092/Controlbar/vlcvolumeindicator0.png";
    document.getElementById("volumebar").src = imagedirectorypath + "Imagesv092/Controlbar/volumebar50.png";
    document.getElementById("infobaredgeleft").src = imagedirectorypath + "Imagesv092/Infobar/vlcinfobaredgeleft.png";
    document.getElementById("infobaredgeright").src = imagedirectorypath + "Imagesv092/Infobar/vlcinfobaredgeright.png";
    document.getElementById("seekbar").style.backgroundImage = "url(" + imagedirectorypath + "Imagesv092/Seekbar/vlcconsoleguiseekbar720pa.png" + ")";
    document.getElementById("controlbar").style.backgroundImage = "url(" + imagedirectorypath + "Imagesv092/Controlbar/vlcconsoleguicontrolbar720pa.png" + ")";
    document.getElementById("infobar").style.backgroundImage = "url(" + imagedirectorypath + "Imagesv092/Infobar/vlcconsoleguiinfobar720p.png" + ")";
    }

function resize()
    {
    dwidth = displaywidth;
    dheight = displayheight;
    document.getElementById("vlc").style.width = dwidth + "px";
    document.getElementById("vlc").style.height = dheight + "px";
    document.getElementById("screen").style.width = dwidth + "px";
    document.getElementById("screen").style.height = dheight + "px";
    document.getElementById("vlcplayer").style.width = dwidth + "px";
    document.getElementById("vlcset").style.width = dwidth + "px";
    sdwidth = dewidth - dwidth;
    sdheight = deheight - dheight;
    seekbarright = (seekbarright + sdwidth);
    seekbarbottom = (seekbarbottom - sdheight);
    seekallow = (seekallow - sdwidth);
    }


function ingstate()
    {
    if (ing == 1)
        {
        pering = ".";
        ing++;
        i=setTimeout("ingstate()", itos);
        }
    else if (ing == 2)
        {
        pering = "..";
        ing++;
        i=setTimeout("ingstate()", itos);
        }
    else if (ing == 3)
        {
        pering = "...";
        ing = 0;
        i=setTimeout("ingstate()", itos);
        }
    else
        {
        pering = " ";
        ing++;
        i=setTimeout("ingstate()", itos);
        }
    }

function rightclocker()
    {
    rsect = Math.floor(vlc.input.length / 1000);
    rseca = Math.floor(rsect / 60);
    rsec = (rsect - rseca * 60);
    rmin = Math.floor(rsect / 60);
    if (rmin < 10)
        {
        if (rsec < 10)
            {
            rightclock = ("/" + "0" + rmin + ":" + "0" + rsec);
            }
        else
            {
            rightclock = ("/" + "0" + rmin + ":" + rsec);
            }
        }
    else
        {
        if (rsec < 10)
            {
            rightclock = ("/" + rmin + ":" + "0" + rsec);
            }
        else
            {
            rightclock = ("/" + rmin + ":" + rsec);
            }
        }
    }

function vlcstate()
    {
    if (vlc.input.state == 0)
        {
        document.getElementById("vlcstatus").innerHTML = ("Idling" + pering);
        s=setTimeout("vlcstate()", 1);
        }
    else if (vlc.input.state == 1)
        {
        document.getElementById("vlcstatus").innerHTML = ("Opening " + currenttrack + pering);
        s=setTimeout("vlcstate()", 1);
        }
    else if (vlc.input.state == 2)
        {
        document.getElementById("vlcstatus").innerHTML = ("Buffering" + currenttrack + pering);
        s=setTimeout("vlcstate()", 1);
        }
    else if (vlc.input.state == 3)
        {
        document.getElementById("vlcstatus").innerHTML = ("Playing " + currenttrack + pering);
        sect = Math.floor(vlc.input.time / 1000);
        seca = Math.floor(sect / 60);
        sec = (sect - seca * 60);
        min = Math.floor(sect / 60);
        if (timeron)
            { 
            if (min < 10)
                {
                if (sec < 10)
                    {
                    document.getElementById("clock").innerHTML = ("0" + min + ":" + "0" + sec + rightclock);
                    }
                else
                    {
                    document.getElementById("clock").innerHTML = ("0" + min + ":" + sec + rightclock);
                    }
                }
            else
                {
                if (sec < 10)
                    {
                    document.getElementById("clock").innerHTML = (min + ":" + "0" + sec + rightclock);
                    }
                else
                    {
                    document.getElementById("clock").innerHTML = (min + ":" + sec + rightclock);
                    }
                }
            }
        else
            {
            rightclocker();
            vlc.video.subtitle = subtitletrack;
            document.getElementById("clock").innerHTML = ("0" + min + ":" + "0" + sec + rightclock);
            timeron = 1;
            document.getElementById("seekslider").src = imagedirectorypath + "Imagesv092/Seekbar/vlcseekslider.png";
            document.getElementById("leftseekarrow").src = imagedirectorypath + "Imagesv092/Seekbar/seekarrowleft.png";
            document.getElementById("rightseekarrow").src = imagedirectorypath + "Imagesv092/Seekbar/seekarrowright.png";
            document.getElementById("fullscreen").src = imagedirectorypath + "Imagesv092/Controlbar/vlcfullscreenbutton.png";
            }
        sliderpos = ((vlc.input.time / vlc.input.length) * seekallow);
        if (IE)
            {
            slider.style.pixelLeft = sliderpos + 27;
            }
        else
            {
            slider.style.left = sliderpos + 27;
            }
        playpause = "false";
        s=setTimeout("vlcstate()", 1);
        }
    else if (vlc.input.state == 4)
        {
        document.getElementById("vlcstatus").innerHTML = ("Paused " + currenttrack);
        playpause = "true";
        s=setTimeout("vlcstate()", 1);
        }
    else if (vlc.input.state == 5)
        {
        document.getElementById("vlcstatus").innerHTML = ("Stopping" + currenttrack + pering);
        s=setTimeout("vlcstate()", 1);
        }
    else if (vlc.input.state == 6)
        {
        tracknumber++;
        if (tracknumber < vlc.playlist.items.count)
            {
            clearTimeout(s, i);
            timeron = 0;
            playpause = "true";
            playpausemouseup();
            }
        else
            {
            instop = 1;
            }
        if (instop)
            {
            sliderpos = 0;
            if (IE)
                {
                slider.style.pixelLeft = sliderpos + 27;
                }
            else
                {
                slider.style.left = sliderpos + 27;
                }
            timeron = 0;
            playing = 0;
            sec = 0;
            min = 0;
            ff = 1;
            itos = 250;
            playpause = "true";
            tracknumber = 0;
            document.getElementById("fullscreen").src = imagedirectorypath + "Imagesv092/Controlbar/vlcfullscreenbuttonfalse.png";
            document.getElementById("playpause").src = imagedirectorypath + "Imagesv092/Controlbar/vlcplaybutton.png";
            document.getElementById("seekslider").src = imagedirectorypath + "Imagesv092/Seekbar/vlcseekslidernovideo.png";
            document.getElementById("leftseekarrow").src = imagedirectorypath + "Imagesv092/Seekbar/seekarrownovideoleft.png";
            document.getElementById("rightseekarrow").src = imagedirectorypath + "Imagesv092/Seekbar/seekarrownovideoright.png";
            document.getElementById("stop").src = imagedirectorypath + "Imagesv092/Controlbar/vlcstopbuttonpress.png";
            document.getElementById("vlcstatus").innerHTML = ("Ended");
            document.getElementById("clock").innerHTML = ("-- : -- / -- : --");
            instop = 0;
            clearTimeout(s, i);
            }
        }
    else if (vlc.input.state == 7)
        {
        document.getElementById("vlcstatus").innerHTML = ("Error!");
        s=setTimeout("vlcstate()", 1);
        }
    else
        {
        document.getElementById("vlcstatus").innerHTML = ("Error!"); 
        s=setTimeout("vlcstate()", 1);       
        }
    }


function leftseekarrowmouseover()
    {
    if (vlc.input.state > 2 && vlc.input.state < 5)
        {
        document.getElementById("leftseekarrow").src = imagedirectorypath + "Imagesv092/Seekbar/seekarrowleftpress.png";
        }
    }
function leftseekarrowmouseout()
    {
    if (vlc.input.state > 2 && vlc.input.state < 5)
        {
        document.getElementById("leftseekarrow").src = imagedirectorypath + "Imagesv092/Seekbar/seekarrowleft.png";
        document.getElementById("rate").innerHTML = ("1.00x");
        ff = 1;
        vlc.input.rate = 1.0;
        itos = 250;
        }
    }
function leftseekarrowmousedown()
    {
    if (vlc.input.state > 2 && vlc.input.state < 5)
        {
        document.getElementById("leftseekarrow").src = imagedirectorypath + "Imagesv092/Seekbar/seekarrowleftclick.png";
        }
    }
function leftseekarrowmouseup()
    {
    if (vlc.input.state > 2 && vlc.input.state < 5)
        {
        document.getElementById("leftseekarrow").src = imagedirectorypath + "Imagesv092/Seekbar/seekarrowleftpress.png";
        if (ff > 0.50)
            {
            ff /= 2;
            document.getElementById("rate").innerHTML = (ff + "0x");
            vlc.input.rate *= ff;
            itos /= ff;
            }
        else
            {
            if (ff > 0.25)
                {
                ff /= 2;
                document.getElementById("rate").innerHTML = (ff + "x");
                vlc.input.rate *= ff;
                itos /= ff;   
                }
            }
        }
    }

function rightseekarrowmouseover()
    {
    if (vlc.input.state > 2 && vlc.input.state < 5)
        {
        document.getElementById("rightseekarrow").src = imagedirectorypath + "Imagesv092/Seekbar/seekarrowrightpress.png";
        }
    }
function rightseekarrowmouseout()
    {
    if (vlc.input.state > 2 && vlc.input.state < 5)
        {
        document.getElementById("rightseekarrow").src = imagedirectorypath + "Imagesv092/Seekbar/seekarrowright.png";
        document.getElementById("rate").innerHTML = ("1.00x");
        ff = 1;
        vlc.input.rate = 1.0;
        itos = 250;
        }
    }
function rightseekarrowmousedown()
    {
    if (vlc.input.state > 2 && vlc.input.state < 5)
        {
        document.getElementById("rightseekarrow").src = imagedirectorypath + "Imagesv092/Seekbar/seekarrowrightclick.png";
        }
    }
function rightseekarrowmouseup()
    {
    if (vlc.input.state > 2 && vlc.input.state < 5)
        {
        document.getElementById("rightseekarrow").src = imagedirectorypath + "Imagesv092/Seekbar/seekarrowrightpress.png";
        if (ff < 4)
            {
            ff *= 2;
            document.getElementById("rate").innerHTML = (ff + ".00x");
            vlc.input.rate *= ff;
            itos /= ff;
            }
        }
    }

function seekslidermouseover()
    {
    if (vlc.input.state > 2 && vlc.input.state < 5)
        {
        document.getElementById("seekslider").src = imagedirectorypath + "Imagesv092/Seekbar/vlcseeksliderpress.png";
        }
    }
function seekslidermouseout()
    {
    if (vlc.input.state > 2 && vlc.input.state < 5)
        {
        document.getElementById("seekslider").src = imagedirectorypath + "Imagesv092/Seekbar/vlcseekslider.png";
        }
    }


function playpausemouseover()
    {
    if (playpause == "true")
        {
        document.getElementById("playpause").src = imagedirectorypath + "Imagesv092/Controlbar/vlcplaybuttonpress.png";
        }
    else
        {
        document.getElementById("playpause").src = imagedirectorypath + "Imagesv092/Controlbar/vlcpausebuttonpress.png";
        }
    }
function playpausemouseout()
    {
    if (playpause == "true")
        {
        document.getElementById("playpause").src = imagedirectorypath + "Imagesv092/Controlbar/vlcplaybutton.png";
        }
    else
        {
        document.getElementById("playpause").src = imagedirectorypath + "Imagesv092/Controlbar/vlcpausebutton.png";
        }
    }
function playpausemousedown()
    {
    if (playpause == "true")
        {
        document.getElementById("playpause").src = imagedirectorypath + "Imagesv092/Controlbar/vlcplaybuttonclick.png";
        }
    else
        {
        document.getElementById("playpause").src = imagedirectorypath + "Imagesv092/Controlbar/vlcpausebuttonclick.png";
        }
    }
function playpausemouseup()
    {
    if (vlc.playlist.items.count == 0)
        {
        document.getElementById("vlcstatus").innerHTML = ("Error! The playlist is empty!");
        document.getElementById("playpause").src = imagedirectorypath + "Imagesv092/Controlbar/vlcplaybuttonpress.png";
        }
    else
        {
        if (playpause == "true")
            {
            if (!timeron)
                {
                currenttrack = track;
                vlc.playlist.playItem(tracknumber);
                vlcstate();
                ingstate();
                }
            else
                {
                vlc.playlist.play();
                }
            document.getElementById("playpause").src = imagedirectorypath + "Imagesv092/Controlbar/vlcpausebuttonpress.png";
            }
        else
            {
            vlc.playlist.togglePause();
            document.getElementById("playpause").src = imagedirectorypath + "Imagesv092/Controlbar/vlcplaybuttonpress.png";
            }
        }
    playing = 1;
    }


function stopmouseover()
    {
    document.getElementById("stop").src = imagedirectorypath + "Imagesv092/Controlbar/vlcstopbuttonpress.png";
    }
function stopmouseout()
    {
    document.getElementById("stop").src = imagedirectorypath + "Imagesv092/Controlbar/vlcstopbutton.png";
    }
function stopmousedown()
    {
    document.getElementById("stop").src = imagedirectorypath + "Imagesv092/Controlbar/vlcstopbuttonclick.png";
    }
function stopmouseup()
    {
    document.getElementById("stop").src = imagedirectorypath + "Imagesv092/Controlbar/vlcstopbuttonpress.png";
    instop = 1;
    tracknumber = vlc.playlist.items.count - 1;
    vlc.playlist.stop();
    }


function fullscreenmouseover()
    {
    document.getElementById("fullscreen").src = imagedirectorypath + "Imagesv092/Controlbar/vlcfullscreenbuttonpress.png";
    }
function fullscreenmouseout()
    {
    document.getElementById("fullscreen").src = imagedirectorypath + "Imagesv092/Controlbar/vlcfullscreenbutton.png";
    }
function fullscreenmousedown()
    {
    document.getElementById("fullscreen").src = imagedirectorypath + "Imagesv092/Controlbar/vlcfullscreenbuttonclick.png";
    }
function fullscreenmouseup()
    {
    document.getElementById("fullscreen").src = imagedirectorypath + "Imagesv092/Controlbar/vlcfullscreenbuttonpress.png";
    vlc.video.toggleFullscreen();
    }
function fullscreenexitclick()
    {
    if (fullscreen=="true")
        {
        vlc.video.toggleFullscreen();
        fullscreen = "false";
        }
    }

function mute()
    {
    if (!mutevalue)
        {
        vlc.audio.toggleMute();
        document.getElementById("mute").src = imagedirectorypath + "Imagesv092/Controlbar/vlcvolumeindicatormute.png";
        document.getElementById("volumebar").src = imagedirectorypath + "Imagesv092/Controlbar/volumebarmute.png";
        mutevalue = 1;
        }
    else
        {
        document.getElementById("mute").src = indicatorvalue;
        mutevalue = 0;
        level = level - 1;
        volumelevel();
        }
    }

function volumelevel()
    {
    if (level==1)
        {
        if (mutevalue)
            {
            mute();
            }
        else
            {
            document.getElementById("mute").src = imagedirectorypath + "Imagesv092/Controlbar/vlcvolumeindicator1.png";
            document.getElementById("volumebar").src = "Imagesv092/Controlbar/volumebar100.png";
            level++;
            vlc.audio.volume = 100;
            indicatorvalue = imagedirectorypath + "Imagesv092/Controlbar/vlcvolumeindicator1.png";
            volumebarvalue = imagedirectorypath + "Imagesv092/Controlbar/volumebar100.png";
            }
        }
    else if (level==2)
        {
        if (mutevalue)
            {
            mute();
            }
        else
            {
            document.getElementById("mute").src = imagedirectorypath + "Imagesv092/Controlbar/vlcvolumeindicator2.png";
            document.getElementById("volumebar").src = imagedirectorypath + "Imagesv092/Controlbar/volumebar150.png";
            level++;
            vlc.audio.volume = 150;
            indicatorvalue = imagedirectorypath + "Imagesv092/Controlbar/vlcvolumeindicator2.png";
            volumebarvalue = imagedirectorypath + "Imagesv092/Controlbar/volumebar150.png";
            }
        }
    else if (level==3)
        {
        if (mutevalue)
            {
            mute();
            }
        else
            {
            document.getElementById("mute").src = imagedirectorypath + "Imagesv092/Controlbar/vlcvolumeindicator3.png";
            document.getElementById("volumebar").src = imagedirectorypath + "Imagesv092/Controlbar/volumebarfull.png";
            level++;
            vlc.audio.volume = 200;
            indicatorvalue = imagedirectorypath + "Imagesv092/Controlbar/vlcvolumeindicator3.png";
            volumebarvalue = imagedirectorypath + "Imagesv092/Controlbar/volumebarfull.png";
            }
        }
    else if (level==4)
        {
        if (mutevalue)
            {
            mute();
            }
        else
            {
            document.getElementById("mute").src = imagedirectorypath + "Imagesv092/Controlbar/vlcvolumeindicatormute.png";
            document.getElementById("volumebar").src = imagedirectorypath + "Imagesv092/Controlbar/volumebarmute.png";
            level = 0;
            vlc.audio.volume = 0;
            indicatorvalue = imagedirectorypath + "Imagesv092/Controlbar/vlcvolumeindicatormute.png";
            volumebarvalue = imagedirectorypath + "Imagesv092/Controlbar/volumebarmute.png";
            }
        }
    else
        {
        if (mutevalue)
            {
            mute();
            }
        else
            {
            document.getElementById("mute").src = imagedirectorypath + "Imagesv092/Controlbar/vlcvolumeindicator0.png";
            document.getElementById("volumebar").src = imagedirectorypath + "Imagesv092/Controlbar/volumebar50.png";
            level++;
            vlc.audio.volume = 50;
            indicatorvalue = imagedirectorypath + "Imagesv092/Controlbar/vlcvolumeindicator0.png";
            volumebarvalue = imagedirectorypath + "Imagesv092/Controlbar/volumebar50.png";
            }
        }
    }


function seek(e) 
    {
    if (IE)
        {
        seekwidth = event.clientX + document.body.scrollLeft - seekbarwidth;
        seekheight = event.clientY + document.body.scrollTop - seekbarheight - seekbarbottom;
        }
    else 
        {
        seekwidth = e.pageX - seekbarwidth;
        seekheight = e.pageY - seekbarheight - seekbarbottom;
        } 
    if (seekwidth < 0)
        {
        seekwidth = 0;
        }
    if (seekheight < 0)
        {
        seekheight = 0;
        }
    if (vlc.input.state > 2 && vlc.input.state < 5)
        {
        if (seekwidth > 84 && seekwidth < 751 - seekbarright)
            {
            if (seekheight > 627 && seekheight < 665)
                {
                seekpos = seekwidth - 92;
                seektime = seekpos * (vlc.input.length / seekallow);
                vlc.input.time = seektime;
                seekwidth = 0;
                seekheight = 0;
                }
            }
        }
    }

function move(e)
    {
    if (IE)
        {
        seekwidth = event.clientX + document.body.scrollLeft - seekbarwidth;
        seekheight = event.clientY + document.body.scrollTop - seekbarheight - seekbarbottom;
        }
    else 
        {
        seekwidth = e.pageX - seekbarwidth;
        seekheight = e.pageY - seekbarheight - seekbarbottom;
        }  
    if (seekwidth < 0)
        {
        seekwidth = 0;
        }
    if (seekheight < 0)
        {
        seekheight = 0;
        }
    seekpos = seekwidth - 92;
    if (dragapproved)
        {
        if (vlc.input.state > 2 && vlc.input.state < 5)
            {
            if (seekwidth > 88  && seekwidth < 751 - seekbarright)
                {
                if (seekheight > 627 && seekheight < 665)
                    {
                    if (IE)
                        {
                        z.style.pixelLeft = temp1 + event.clientX - x;
                        seektime = seekpos * (vlc.input.length / seekallow);
                        vlc.input.time = seektime;
                        document.getElementById("seekbar").onmouseup = undrags;
                        return false;
                        }
                    else
                        {
                        z.style.left = temp1 + e.pageX - x;
                        seektime = seekpos * (vlc.input.length / seekallow);
                        vlc.input.time = seektime;
                        document.getElementById("seekbar").onmouseup = undrags;
                        return false;
                        }
                    }
                return false;
                }
            return false;
            }
        }
    document.getElementById("seekbar").title = seektime;
    }

function drags(e)
    {
    if (IE)
        {
        if (event.srcElement.className == "drag")
            {
            dragapproved = 1;
            z = event.srcElement;
            temp1 = z.style.pixelLeft;
            x = event.clientX;
            temp2 = z.style.pixelTop;
            y = event.clientY;
            document.getElementById("seekslider").onmousemove = move;
            }
        }
    else
        {
        if (e.target.className == "drag")
            {
            dragapproved = 1;
            z = e.target;
            temp1 = z.style.left;
            x = e.pageX;
            temp2 = z.style.top;
            y = e.pageY;
            document.getElementById("seekslider").onmousemove = move;
            }
        }
    if (vlc.input.state > 2 && vlc.input.state < 5)
        {
        document.getElementById("seekslider").src = imagedirectorypath + "Imagesv092/Seekbar/vlcseeksliderclick.png";
        }
    }

function undrags()
    {
    dragapproved = 0;
    if (vlc.input.state > 2 && vlc.input.state < 5)
        {
        if (seekwidth > 88  && seekwidth < 751  - seekbarright)
            {
            if (seekheight > 627 && seekheight < 665)
                {
                document.getElementById("seekslider").src = imagedirectorypath + "Imagesv092/Seekbar/vlcseeksliderpress.png";
                }
            else
                {
                document.getElementById("seekslider").src = imagedirectorypath + "Imagesv092/Seekbar/vlcseekslider.png";
                }
            }
        }
    else
        {
        document.getElementById("seekslider").src = imagedirectorypath + "Imagesv092/Seekbar/vlcseekslider.png";
        }
    }


function timeteller(e)
    {
    if (IE)
        {
        swidth = event.clientX + document.body.scrollLeft - seekbarwidth;
        sheight = event.clientY + document.body.scrollTop - seekbarheight - seekbarbottom;
        }
    else 
        {
        swidth = e.pageX - seekbarwidth;
        sheight = e.pageY - seekbarheight - seekbarbottom;
        }  
    if (swidth < 0)
        {
        swidth = 0;
        }
    if (sheight < 0)
        {
        sheight = 0;
        }
    spos = swidth - 92;
    if (vlc.input.state > 2 && vlc.input.state < 5)
        {
        if (seekwidth > 88  && seekwidth < 751 - seekbarright)
            {
            if (seekheight > 627 && seekheight < 665)
                {
                timed = spos * (vlc.input.length / seekallow);
                ssect = Math.floor(timed / 1000);
                sseca = Math.floor(ssect / 60);
                ssec = (ssect - sseca * 60);
                smin = Math.floor(ssect / 60);
                if (smin < 10)
                    {
                    if (ssec < 10)
                        {
                        document.getElementById("seekbar").title = ("0" + smin + ":" + "0" + ssec + rightclock);
                        }
                    else
                        {
                        document.getElementById("seekbar").title = ("0" + smin + ":" + ssec + rightclock);
                        }
                    }
                else
                    {
                    if (ssec < 10)
                        {
                        document.getElementById("seekbar").title = (smin + ":" + "0" + ssec + rightclock);
                        }
                    else
                        {
                        document.getElementById("seekbar").title = (smin + ":" + ssec + rightclock);
                        }
                    }
                }
            }
        }
    }