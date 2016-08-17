<?php

//print_r($_GET);

$url=isset($_GET['url'])?$_GET['url']:'';
$hstring=isset($_GET['hstring'])?$_GET['hstring']:'{NBSP}';
$highlight=isset($_GET['highlight'])?(int)$_GET['highlight']:1;

//var_dump($highlight);

$contents='';
$strange_guy=chr(194).chr(160);
$count=0;
$replace_with="<mark>".$hstring."</mark>";
$errors=array();
if (!empty($url)) {
  if (filter_var($url, FILTER_VALIDATE_URL) === false) {
    $errors['url'][]="$url is not a valid URL";
  }
}

if (!empty($url) && count($errors)==0) {
  $contents=file_get_contents($url);
  $count=substr_count($contents, $strange_guy);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>NBSP space char detector</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/vnd.microsoft.icon" href="http://heavydots.com/favicon.ico" />
  <link rel="shortcut icon" type="image/x-icon" href="http://heavydots.com/favicon.ico" />
  
  <style type="text/css">
    pre {
      white-space: pre-wrap;       /* css-3 */
      white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
      white-space: -pre-wrap;      /* Opera 4-6 */
      white-space: -o-pre-wrap;    /* Opera 7 */
      word-wrap: break-word;       /* Internet Explorer 5.5+ */
      
      background: #eee;
      border: 1px solid #ccc;
    }
  </style>

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <div class="twelve column" style="margin-top: 5%">
        
        <div style="text-align: center;">
          <p>
            <img src="http://heavydots.com/images/logo-hd-signature-horizontal.png" alt="HeavyDots Logo" width="181" height="37" style="border: none;" />
          </p>

          <h3 style="cursor: pointer;" onclick="window.location=window.location.href.split('?')[0]">NBSP space char detector</h3>
        </div>
        
        <div style="border-bottom: 1px solid #eee; margin: 30px 0;"></div>
        
        <p>
          Sometimes when copying text from different sources and pasting it into a website's backoffice you can end up with a strange 
          char like this that looks like the normal space char but browsers render it as a non-breaking space (<strong><?php echo htmlentities('&nbsp;'); ?></strong>). <br /><br />
          This char might cause strange behavior on some devices, such as sticking two words together on an Android powered smartphone. 
          <br /><br />
          The reasons why it appears and the consequences can vary, this tool right here is ment to help you find it on your page so you can do something about it.. because you can't really see it, it's invisible! :-)
        </p>
        
        <p><strong>Related links</strong></p>
        
        <ul>
          <li>Stack Overflow Post 1: <a target="_blank" href="http://stackoverflow.com/questions/26962323/what-is-this-insane-space-character-google-chrome">What is this INSANE space character??? (google chrome)</a></li>
          <li>Stack Overflow Post 2: <a target="_blank" href="http://stackoverflow.com/questions/17982104/how-do-i-check-for-this-odd-space-character-in-objective-c">How do I check for this odd space character - “ ” in Objective-C?</a></li>
          <li>Github page for this PHP script: <a target="_blank" href="https://github.com/HeavyDots/nbsp-space-char-detect">https://github.com/HeavyDots/nbsp-space-char-detect</a></li>
        </ul>
        
        <p>Brought to you by the <a target="_blank" href="http://heavydots.com/">HeavyDots</a> team. Enjoy and give feedback in the comments below!</p>
        
        <div style="border-bottom: 1px solid #eee; margin: 30px 0;"></div>
        
        <form method="get" action="">
          <div class="row">
            <div class="twelve columns">
              <label for="url">Enter URL to check</label>
              <input class="u-full-width" type="text" placeholder="http://example.com/some/page.html" id="url" name="url" value="<?php echo htmlentities($url); ?>">
            </div>
          </div>
          
          <div class="row">
            <div class="six columns">
              <label for="highlight">Highlight occurrences</label>
              <select class="u-full-width" id="highlight" name="highlight">
                <option value="1" <?php if ($highlight==1): ?> selected="selected"<?php endif; ?>>Yes</option>
                <option value="0" <?php if ($highlight==0): ?> selected="selected"<?php endif; ?>>No</option>
              </select>
            </div>
            <div class="six columns">
              <label for="hstring">Highlight string</label>
              <input class="u-full-width" type="text" placeholder="http://example.com/some/page.html" id="hstring" name="hstring" value="<?php echo htmlentities($hstring); ?>">
            </div>
          </div>
          
          <input class="button-primary" type="submit" value="Check url">
        </form>
        
        <?php if (!empty($url) && count($errors)==0): ?>
        
        <?php if ($count): ?>
          <h4 style="color: orange; background: lightyellow; padding: 10px; text-align: center;">Found <?php echo $count; ?> whitespace<?php echo $count>1?'s':''; ?>!</h4>
        <?php else: ?>
          <h4 style="color: green; background: lightgreen; padding: 10px; text-align: center;">Congrats! No strange white spaces found!</h4>
        <?php endif; ?>
        
        <pre><?php 
        
        if ($highlight) {
          $replace_with_tmp='#N-B-S-P-H-E-R-E#';
          $contents=str_replace($strange_guy, $replace_with_tmp, $contents);
        }
        
        $contents= htmlspecialchars($contents); 
        
        if ($highlight) {
          $contents=str_replace($replace_with_tmp, $replace_with, $contents);
        }
        
        echo $contents;
        
        ?></pre>
        <?php endif; ?>
          
          
        <div id="disqus_thread"></div>
        <script>

        /**
         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables */
        
        var disqus_config = function () {
            this.page.url = 'http://tools.heavydots.com/nbsp-space-char-detect';  // Replace PAGE_URL with your page's canonical URL variable
            this.page.identifier = 'nbsp-space-char-detect'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };
        
        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = '//nbsp-space-char-detect.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
        </script>
        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        
      </div>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>