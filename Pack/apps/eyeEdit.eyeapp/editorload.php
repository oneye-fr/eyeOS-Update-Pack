<?php
if (!defined('USR')) return;
echo "
<script language=\"javascript\" type=\"text/javascript\" src=\"${appinfo['appdir']}tiny_mce/tiny_mce.js\"></script>
<script language=\"javascript\" type=\"text/javascript\">
	tinyMCE.init({
	    language : \""._L('en')."\",
		mode : \"textareas\",
		theme : \"advanced\",
		plugins : \"style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras\",
		theme_advanced_buttons1 : \"bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect\",
		theme_advanced_buttons2 : \"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor\",
		theme_advanced_buttons3 : \"tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen\",
		theme_advanced_buttons4 : \"insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking\",
		theme_advanced_toolbar_location : \"top\",
		theme_advanced_toolbar_align : \"left\",
		theme_advanced_path_location : \"bottom\",
	    plugin_insertdate_dateFormat : \""._L('%d/%m/%Y')."\",
	    plugin_insertdate_timeFormat : \""._L('%H:%M:%S')."\",
		extended_valid_elements : \"a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]\",
		external_link_list_url : \"example_link_list.js\",
		external_image_list_url : \"example_image_list.js\",
		flash_external_list_url : \"example_flash_list.js\",
		theme_advanced_resize_horizontal : true,
		theme_advanced_resizing : true,
		apply_source_formatting : true,
        force_br_newlines : true,
        force_p_newlines : false,
        fix_list_elements : true,
        fix_table_elements : true,
        docs_language : \"en\",
    });
</script>";
?>