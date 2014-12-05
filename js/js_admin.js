jQuery(function() {
    jQuery( ".datepicker" ).datepicker();
});
jQuery(document).ready(function($) {
    //disabling logo fields
    if (jQuery(".logo_field:eq(2)").attr('value') != '') {
        jQuery(".logo_field:eq(0),.logo_field:eq(1)").css('background-color','#f1f1f1')
    }else if(jQuery(".logo_field:eq(1)").attr('value') != ''){
        jQuery(".logo_field:eq(0)").css('background-color','#f1f1f1')    
        jQuery(".logo_field:eq(1)").css('background-color','#fff')
    }else {
        jQuery(".logo_field").css('background-color','#fff')
    }
    jQuery(".logo_field").on('focusout focusin keyup', function() {
        if (jQuery(".logo_field:eq(2)").attr('value') != '') {
            jQuery(".logo_field:eq(0),.logo_field:eq(1)").css('background-color','#f1f1f1')
        }else if(jQuery(".logo_field:eq(1)").attr('value') != ''){
            jQuery(".logo_field:eq(0)").css('background-color','#f1f1f1')    
            jQuery(".logo_field:eq(1)").css('background-color','#fff')
        }else {
            jQuery(".logo_field").css('background-color','#fff')
        }
    })
    //disabling favicon fields
    if (jQuery(".favicon_field:eq(1)").attr('value') != '') {
        jQuery(".favicon_field:eq(0)").css('background-color','#f1f1f1')
    }else {
        jQuery(".favicon_field").css('background-color','#fff')
    }
    jQuery(".favicon_field").on('focusout focusin keyup', function() {
        if (jQuery(".favicon_field:eq(1)").attr('value') != '') {
            jQuery(".favicon_field:eq(0)").css('background-color','#f1f1f1')
        }else {
            jQuery(".favicon_field").css('background-color','#fff')
        }
    })
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
    jQuery('#add_skill').unbind('click').live('click', function(){
        var skills = jQuery('.skills_nr').attr("value");
        if (isNaN(skills))
            skills = 0 ;
        skills++;
        jQuery('.skills_nr').attr("value", skills)
        jQuery('#skills').before('<div class="row"><div class="span2" class="skill_order"><i>Skill '+skills+' unsaved</i></div><div class="span5"><input id="theme_options[skill_'+skills+']" class="skill" type="text" name="theme_options[skill_'+skills+']" /><label for="theme_options[skill_'+skills+']"> Enter the skill name</label></div><div class="span3"><input id="theme_options[skill_'+skills+'_val]" type="text" class="skill_val" name="theme_options[skill_'+skills+'_val"] /><label for="theme_options[skill_'+skills+'_val]">Enter the skill Value from 1 to 100</label></div><div class="span2"><input type="button" class="btn btn-danger remove_skill" value="Remove Skill" /></div></div>')
    })
    jQuery('.remove_skill').unbind('click').live('click', function(){
        var skills = jQuery('.skills_nr').attr("value");
        if (isNaN(skills) || skills == 0)
            skills = 1 ;
        skills--;
        jQuery('.skills_nr').attr("value", skills)
        jQuery(this).parent().parent().remove();
        // start updating attributes after removing a skill
        var i;
        i = 1;
        jQuery('.skill').each(function(){
            jQuery(this).attr({
                'id':'theme_options[skill_'+i+']',
                'name':'theme_options[skill_'+i+']'
            })
            i++;
        })
        var i = 1;
        jQuery('.skill_order').each(function(){
            jQuery(this).html("Skill " + i)
            i++;
        })
        var i = 1;
        jQuery('.skill_val').each(function(){
            jQuery(this).attr({
                'id':'theme_options[skill_'+i+'_val]',
                'name':'theme_options[skill_'+i+'_val]'
            })
            i++;
        })
    //end updating attributes after removing a skill
    })                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                	  
});