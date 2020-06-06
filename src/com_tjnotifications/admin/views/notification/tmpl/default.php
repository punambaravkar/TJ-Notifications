<?php

// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\Language\Text;

HTMLHelper::_('formbehavior.chosen','select');
HTMLHelper::_('behavior.formvalidator');
$today = date('Y-m-d');
?>
<script>
	jQuery(document).ready(function()
	{
		jQuery("fieldset").click(function()
		{
			status=this.id+'0';
			statusChange=this.id+'1';
			var check=(jQuery("#"+status).attr("checked"));
		
			if(check=="checked")
			{
				
				var body=(this.id).replace("status", "body_ifr");
				var bodyData=(jQuery("#"+body).contents().find("body").find("p").html());
				if(bodyData=='<br data-mce-bogus="1">')
				{
					alert('Please fill the data');
					jQuery('#'+this.id).find('label[for='+statusChange+']').attr('class','btn active btn-danger');
					jQuery('#'+this.id).find('label[for='+status+']').attr('class','btn');
					return false;
				}	
				else
				{
					jQuery('#'+this.id).find('label[for='+status+']').attr('class','btn active btn-success');
					jQuery('#'+this.id).find('label[for='+statusChange+']').attr('class','btn');
				}
			}
		});
	});
</script>


<form action="<?php echo Route::_('index.php?option=com_tjnotifications&layout=default'); ?>" 
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
		<div class="row-fluid">
                <div class="span12">
				
				  <ul class="nav nav-tabs">
					<li  class="active"><a href="#notification" aria-controls="notification" data-toggle="tab"><?php echo Text::_('COM_TJNOTIFICATIONS_VIEW_NOTIFICATION_TAB_NOTIFICATION') ?></a></li>
					<li><a href="#email" aria-controls="email"  data-toggle="tab"><?php echo Text::_('COM_TJNOTIFICATIONS_VIEW_NOTIFICATION_TAB_Email') ?></a></li>
					<li><a href="#sms" aria-controls="sms"  data-toggle="tab"><?php echo Text::_('COM_TJNOTIFICATIONS_VIEW_NOTIFICATION_TAB_SMS') ?></a></li>
					<li><a href="#push" aria-controls="push"  data-toggle="tab"><?php echo Text::_('COM_TJNOTIFICATIONS_VIEW_NOTIFICATION_TAB_Push') ?></a></li>
					<li><a href="#web" aria-controls="web"  data-toggle="tab"><?php echo Text::_('COM_TJNOTIFICATIONS_VIEW_NOTIFICATION_TAB_Web') ?></a></li>
				  </ul>

				
				<div class="tab-content">
					<div  class="tab-pane active" id="notification">
						<?php foreach ($this->form->getFieldset('primary_fieldset') as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input ; ?></div>
                        </div>
                    <?php endforeach; ?>
					</div>
					
					<div  class="tab-pane" id="email">
						<?php foreach ($this->form->getFieldset('email_fieldset') as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input ; ?></div>
                        </div>
                    <?php endforeach; ?>
					</div>
					
					<div  class="tab-pane" id="sms">
						<?php foreach ($this->form->getFieldset('sms_fieldset') as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input ; ?></div>
                        </div>
                    <?php endforeach; ?>
					</div>
					
					<div  class="tab-pane" id="push">
						<?php foreach ($this->form->getFieldset('push_fieldset') as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input ; ?></div>
                        </div>
                    <?php endforeach; ?>
					</div>
					
					<div  class="tab-pane" id="web">
						<?php foreach ($this->form->getFieldset('web_fieldset') as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input ; ?></div>
                        </div>
                    <?php endforeach; ?>
					</div>
				</div>
				
					<input type="hidden" name="jform[state]" id="jform_state" value="1"/>
					<input type="hidden" name="jform[created_on]" id="jform_created_on" value="<?php echo $today; ?>"/>	
					<input type="hidden" name="jform[updated_on]" id="jform_updated_on" value="<?php echo $today; ?>"/>
                </div>
            </div>
        </fieldset>
    </div>
		<input type="hidden" name="task" value=""/>
    <?php echo HTMLHelper::_('form.token'); ?>
</form>
