<?php
include "top.php";

$myFileName = "data/peaks";
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
<section id="table">
    <table>
        <thead>
            <tr>
                <th scope="col">Rank</th>
                <th scope="col">Mountain</th>
                <th scope="col">Elevation (Feet)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            foreach ($records as $record) {
                if ($record != "") {
                    print "<tr>";
                    print "<td>$counter</td>";
                    $counter += 1;
                    print "<td><a href='#$record[0]'>$record[0]</a></td>";
                    print "<td>$record[1]</td>";
                    print "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</section>

<aside id="hikingInfo">
    <div class="trail">
        <h2>Trail Etiquette</h2>
        <p>The Forty-Sixers beliece in the principles of "leave no trace" (<a href="https://lnt.org/">www.lnt.org</a>)</p>
        <ul>
            <li>Plan ahead and prepare</li>
            <li>Camp and travel on durable surfaces</li>
            <li>Pack it in, pack it out</li>
            <li>Properly dispose of what you can't pack out</li>
            <li>Leave what you find</li>
            <li>Respect Wildlife</li>
        </ul>
    </div>
    <div>
        <h2>Forest Preserve Camping Regulations</h2>
        <p>The Department of Environmental Conservation (DEC) maintains registers at main trailheads and other locations. The registers are there for your safety. Sign in, stick to your destination, and sign out when you leave. The registers are also used to compile statistics about wilderness use and, thereby, help determine where and how the DEC allocates its resources.</p>
        <p>If you desire to camp within 150 feet of a road, trail or water supply, you must camp in a location designated as a camping area by DEC. If you want to get away from the crowds and commonly used camping areas, you can camp where you like if you are over 150 feet from trails and/or water. In order to protect the fragile environment of our summits, camping is prohibited above 4000 feet in elevation in the Adirondacks except from December 15th to April 30th. This permits the serious winter camper a chance to enjoy the summits and still do minimal damage.</p>
        <p>Adirondack leantos (open camps) are located along the trails and are on a first come – first serve basis and up to capacity, which varies from six to ten persons. Be ready to share your leanto with others. The intelligent camper does not count on finding a leanto empty, or even available, but takes his/her own shelter. Leantos have been removed in many areas. Check before your trip.</p>
        <ul>
            <li>Camping is allowed at any location below 3,500 feet in elevation, provided the site is at least 150 feet away from any road, trail or water source and except where prohibited by a DEC sign. Within 150 feet of a road, trail or water source, you may camp only at a DEC designated site. These sites are marked by a yellow DEC disk.</li>
            <li>Between 3,500 and 4,000 feet, camping is allowed at designated sites only. These sites are marked by a yellow DEC disk.</li>
            <li>Camping is prohibited in the Adirondacks above 4,000 feet except from December 15th to April 30th.</li>
            <li>Many access points in the High Peaks Region are on private property. Camping is not allowed anywhere on these lands. You are responsible for confirming that you are on Forest Preserve Land before establishing a campsite. Continued public access to private property is assured only if we comply with the landowners’ wishes.</li>
            <li>Careless campers are a significant problem in the High Peaks. Bear canisters constructed of solid, non-pliable material specifically made to resist access by bears are required for overnight camping in the Eastern High Peaks Zone from April 1 to November 30. Even in other areas, you are responsible for keeping your food from bears.</li>
            <li>Adirondack lean-tos (open camps) located along trails are available first-come, first-serve up to their capacity, which varies from six to ten persons, and are meant to be shared. Many lean-tos have been removed. It is best not to depend on finding a lean-to with room, but to pack in a tent.</li>
        </ul>
    </div>
    <div class="groupsRegs">
        <h2>Group Size Limits and Other Regulations</h2>
        <ul>
            <li>Day hiking groups are limited to no more than 15 people in the High Peaks Wilderness Area.</li>
            <li>Camping groups may not be larger than eight people.</li>
            <li>The DEC recommends treating water from any backcountry source by one of the following methods: an appropriate filter, chemicals or a timed, rolling boil of at least two minutes.</li>
            <li>Open fires are not permitted in the Eastern Zone of the High Peaks Wilderness Area.</li>
            <li>In other areas, fires are not recommended, but they are allowed without a permit in most of the Forest Preserve.</li>
            <li>Your trash is your responsibility. Do not burn it. Burying anything other than human waste is prohibited.</li>
            <li>If you need emergency help, the Forect Ranger Emergency Line is (518) 891-0235, but do not count on cellular telephone reception in the High Peaks.</li>
        </ul>
    </div>
</aside>

<article id="peaksInfo">
    <?php
    print "<div id='peakInfo'>";

    foreach ($records as $record) {
        if ($record != "") {
            print "<div id='peak'>";
            print "<h2><a name='$record[0]'></a>$record[0]</h2>";
            print "<a href='#top'>[Back to Top]</a>";
            print "<ul class='peakStats'>";
            print "<li class='elevation'>Elevation:  $record[1] feet</li>";
            print "<li class='ascent'>Ascent of climb:  $record[2] feet</li>";
            print "<li class='distance'>Distance:  $record[3] miles</li>";
            print "<li class='duration'>Average length of hike:  $record[4] hours</li>";
            print "<li class='difficulty'>Difficulty (1-7):  $record[5]</li>";
            print "</ul>";
            print "<iframe src='$record[6]' width='350' height='260' frameborder='0' style='border:0' allowfullscreen></iframe>";
            print "<figure class='peaks'>";
            print "<img src='images/$record[7]'></img>";
            print "</figure>";
            print "<p class='description'>$record[8]</p>";
            print "</div>";
        }
    }
    print "</div>";
    ?>
</article>
<?php
include 'footer.php';
?>