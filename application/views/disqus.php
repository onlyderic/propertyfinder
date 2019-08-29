
        <div>
            <div id="disqus_thread"></div>
            <script type="text/javascript">
                <?php #CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE ?>
                var disqus_shortname = 'propertyfinder'; <?php #required: replace example with your forum shortname ?>
                var disqus_identifier = '<?php echo $code; ?>'; <?php #'a unique identifier for each page where Disqus is present'; ?>
                var disqus_title = '<?php echo $title; ?>'; <?php #'a unique title for each page where Disqus is present'; ?>
                var disqus_url = '<?php echo $url; ?>'; <?php #'a unique URL for each page where Disqus is present'; ?>

                <?php # DON'T EDIT BELOW THIS LINE  ?>
                (function() {
                    var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
            <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
        </div>