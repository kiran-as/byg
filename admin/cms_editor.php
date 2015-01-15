<?php 
include("ckeditor_3.6.5/ckeditor/ckeditor.php");
?>

<table cellpadding="0" cellspacing="0" border="0">
<tr><?php 

$CKEditor = new CKEditor();
	  $config = array();
	  $config['toolbar'] = array(
    
    array('Format',
          'TextColor','Bold','Italic','Underline','Strike','-',
          'Subscript','Superscript','-',
          'NumberedList','BulletedList','-'
          ),
    '/',
 
);

	  $events['instanceReady'] = 'function (ev) {
	      alert("Loaded: " + ev.editor.name);
	 }';
	 // $CKEditor->editor("field1", "<p>Initial value.</p>", $config, $events);
	  		  
	  			$CKEditor->editor("field1",$TemplateBody,$config);
				 
	  		?>
		</tr>


</table>
