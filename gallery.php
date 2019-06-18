<?php
include "top.php";

$myFileName = "data/gallery";
$fileExt = ".csv";
$filename = $myFileName . $fileExt;
//Opens the file
$file = fopen($filename, "r");

//$file will be empty or false if the file does not open
if ($file) {
    // This reads the first row, which in our case is the column headers
    $headers[] = fgetcsv($file);

    //Reads data into our array
    while (!feof($file)) {
        $records[] = fgetcsv($file);
    }
    //closes the file
    fclose($file);
}
?>
?>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="js/jquery.flexslider.js"></script>

<script type="text/javascript">
    var flexsliderStylesLocation = "css/flexslider.css";
    $('<link rel="stylesheet" type="text/css" href="' + flexsliderStylesLocation + '" >').appendTo("head");
    $(window).load(function () {

        $('.flexslider').flexslider({
            animation: "fade",
            slideshowSpeed: 3000,
            animationSpeed: 1000
        });

    });
</script>
<div class="flexslider">
    <ul class="slides">
        <?php
        foreach ($records as $record) {
            if ($record != "") {
                print "<li>";
                print "<img src='images/$record[0]'</img>";
                print "</li>";
            }
        }
        ?>
    </ul>
</div>
<?php
include 'footer.php';
?>