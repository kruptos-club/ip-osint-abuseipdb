<?php
$ch = curl_init();
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $url = $_POST['ip'];
    $_SESSION['url'] = $url;
    curl_setopt($ch, CURLOPT_URL, "https://www.abuseipdb.com/check/$url/json?key=PpDNjt74E2jaBnXv0qmq6gHPEJimDd0v0sIOPZ1x&days=90");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close ($ch);
    $result1 = json_decode($result, true);
    $result1 = $result1[0];
    $_SESSION['result1'] = $result1;
    unset($_POST);
}
$result2 = $_SESSION['result1'];
$ip = $_SESSION['url'];
?>
<section>
    <h1>OSINT IP info</h1>
    <?php
    if ($result2) {
        echo '<h5>Please do not refresh the browser. It will cause querying the DB again. Please scroll down to view the result.</h5>';
    }
    ?>
    <div>
        <div>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <div>
                    <h3>Check IP reputation</h3>
                    <input type="text" name="ip" id="ip" placeholder="Enter an IP. eg: 8.8.8.8" required="">
                </div>
                <div><br/></div>
                <div>
                    <input type="submit" id="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
</section>
<section>
    <?php
    if ($result2) {
        echo
            '
<h4>Details of IP ' . $result2["ip"] . ' are,</h4><br/>
<h4>The IP with ISO code <strong>&quot;' . $result2["isoCode"] . '&quot;</strong> belongs to <strong>' . $result2["country"] . '</strong></h4><br/>';
        echo '<h4>The IP is <strong>';  echo $result2["isWhitelisted"] ? 'Whitelisted' : 'Blacklisted' ; echo '</strong></h4><br/>';
        echo '<h4>Abuse level Confidence score is <strong>' . $result2["abuseConfidenceScore"] . '</strong></h4><br/><br/>';
        echo '<p>Confidence of abuse is a rating (scaled 0-100) of how confident we are, based on user reports, that an IP address is entirely malicious. So a rating of 100 means we are sure an IP address is malicious, while a rating of 0 means we have no reason to suspect it is malicious.</p>';
    }
    else {
        echo '<h4>Details of IP <strong>' . $ip . '</strong> not found</h4><br/><br/>';
    }
    ?>
</section>
