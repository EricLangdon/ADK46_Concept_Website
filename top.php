<!DOCTYPE html>
<html lang="en">
    <head>
        
        
        <meta charset="utf-8">
        <meta name="author" content="Eric Langdon">
        <meta name="description" content="Final Project">
        <link type="text/css" rel="stylesheet" href="css/custom.css"  media="screen,projection"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="shortcut icon" href="images/thumbnail.png"/>
        
        <?php
        
        
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
//PATH SETUP
        
        $domain = "//";
        $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");
        $domain .= $server;
        $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");
        $path_parts = pathinfo($phpSelf);
        
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
//include all libraries.
//
//
        
        print "<!-- include libraries -->";
        
        require_once('library/security.php');

        if($path_parts['filename']=="join"){
            print "<!-- include form libraries -->";
            include "library/validation-functions.php";
            include "library/mail-message.php";
            
        }
               
        print "<!-- finished including libraries -->";
        ?>
        
    </head>
    <a name="top"></a>
    <!-- ############## body section ################ -->
    <?php
    print '<body id="' . $path_parts['filename'] . '">';
    ?>
    
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.flexslider.js"></script>
    
        <?php
    include "header.php";
    
    
    //TITLE INCLUSION
    //
    
    //Home
    if ($path_parts['filename'] == "index") {
        print '<title class="topTitle">ADK46ers | Home</title>';
        print '<h1 class="topHeader">Home</h1>';
    }

    //About
    if ($path_parts['filename'] == "about") {
        print '<title class="topTitle">ADK46ers | About</title>';
        print '<h1 class="topHeader">About</h1>';
    }

    //Peaks
    if ($path_parts['filename'] == "peaks") {
        print '<title class="topTitle">ADK46ers | Peaks</title>';
        print '<h1 class="topHeader">Peaks</h1>';
    }

    //History
    if ($path_parts['filename'] == "history") {
        print '<title class="topTitle">ADK46ers | History</title>';
        print '<h1 class="topHeader">History</h1>';
    }

    //Join
    if ($path_parts['filename'] == "join") {
        print '<title class="topTitle">ADK46ers | Join</title>';
        print '<h1 class="topHeader">Join</h1>';
    }

    //Gallery
    if ($path_parts['filename'] == "gallery") {
        print '<title class="topTitle">ADK46ers | Gallery</title>';
        print '<h1 class="topHeader">Gallery</h1>';
    }