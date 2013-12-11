<?php
// URL location of your feed
$feedUrl = "http://feeds.feedburner.com/mobipon?format=xml";

//Total results to display
$displayAmount = 10;
 
// Fetch feed from URL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $feedUrl);
curl_setopt($curl, CURLOPT_TIMEOUT, 3);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);

// FeedBurner requires a proper USER-AGENT...
curl_setopt($curl, CURL_HTTP_VERSION_1_1, true);
curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate");
curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3");
$feedContent = curl_exec($curl);
curl_close($curl);

// Output Feed
if($feedContent && !empty($feedContent)) {
  $feedXml = @simplexml_load_string($feedContent);
    if($feedXml) { ?>
      <div class="span3">
        <h5>Local Coupon Marketing News | Mobipon</h5>
        <ul class="list post-list">
		  <?php 
		  $i=0; 
		  foreach($feedXml->channel->item as $item) { 
		    if($i<$displayAmount){
              $i++; ?>
              <li class="post-thumb">
                <h5 class="title"><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h5>
                <small><?php echo $item->pubDate; ?></small>
                <p class="post-desciption"><?php echo $item->description; ?></p>
              </li>
            <?php } ?>
          <?php } ?>
        </ul>
      </div>
    <?php } ?>
<?php } ?>
