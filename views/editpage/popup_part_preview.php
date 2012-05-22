	<div id="part-revision-preview-dialog" class="window">
		<div class="titlebar">
		<?php echo __('Part Revision content preview'); ?>
		<a href="#" class="close">[x]</a>
		</div> 
		
		<div class="content">
			<p><?php echo __('This is unfiltered content preview'); ?></p>
			<div id="part-revision-preview-code">
			</div>
		</div>
	</div>

	<div id="part-revision-diff-dialog" class="window">
		<div class="titlebar">
		<?php echo __('Part Revision differences preview'); ?>
		<a href="#" class="close">[x]</a>
		</div> 
		
		<div class="content">
			<p><?php echo __('This is unfiltered content <b>diff</b> preview'); ?></p>
			<div id="part-revision-preview-diff">
			</div>
		</div>
	</div>

<script type="text/javascript">
// <![CDATA[
        $('.preview_revision').live('click', function() {
            // START show popup
            var id = 'div#part-revision-preview-dialog';
            
            $('div#add-part-dialog div.content form input#part-name-field').val('');
	    
	    var partid = $(this).attr('rel');
	    
	    $('#part-revision-preview-code').load('<?php echo get_url('plugin/part_revisions/preview').'/'; ?>'+partid);
	    
            //Get the screen height and width
            var maskHeight = $(document).height();
            var maskWidth = $(window).width();

            //Set height and width to mask to fill up the whole screen
            $('#mask').css({'width':maskWidth,'height':maskHeight,'top':0,'left':0});

            //transition effect
            $('#mask').show();
            $('#mask').fadeTo("fast",0.5);

            //Get the window height and width
            var winH = $(window).height();
            var winW = $(window).width();

            //Set the popup window to center
            $(id).css('top',  winH/2-$(id).height()/2);
            $(id).css('left', winW/2-$(id).width()/2);

            //transition effect
            $(id).fadeIn("fast"); //2000

            $(id+" :input:visible:enabled:first").focus();
            // END show popup
        });
        $('.diff_revision').live('click', function() {
            // START show popup
            var id = 'div#part-revision-diff-dialog';
            
            $('div#add-part-dialog div.content form input#part-name-field').val('');
	    
	    var partid = $(this).attr('rel');
	    
	    $('#part-revision-preview-diff').load('<?php echo get_url('plugin/part_revisions/diff').'/'; ?>'+partid);
	    
            //Get the screen height and width
            var maskHeight = $(document).height();
            var maskWidth = $(window).width();

            //Set height and width to mask to fill up the whole screen
            $('#mask').css({'width':maskWidth,'height':maskHeight,'top':0,'left':0});

            //transition effect
            $('#mask').show();
            $('#mask').fadeTo("fast",0.5);

            //Get the window height and width
            var winH = $(window).height();
            var winW = $(window).width();

            //Set the popup window to center
            $(id).css('top',  winH/2-$(id).height()/2);
            $(id).css('left', winW/2-$(id).width()/2);

            //transition effect
            $(id).fadeIn("fast"); //2000

            $(id+" :input:visible:enabled:first").focus();
            // END show popup
        });

        $('.filter_part').live('click', function() {
	    var partname = $(this).attr('rel');
	    
	    $('#part_revisions_container').load('<?php echo get_url('plugin/part_revisions/getlist') ?>', {name: partname, page_id: <?php echo $page_id ?>});
	    });

// ]]>
</script>
	