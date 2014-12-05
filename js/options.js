jQuery(document).ready(function($){
	menu_nr = 1;
	$('.site_menu > li > a > .site_menu_nr').each(function(){
		if ( menu_nr < 10 )
			$(this).text('0' + menu_nr)
		else
			$(this).text(menu_nr)
		menu_nr ++;
	})
	$('.site_menu > li ul .site_menu_nr').each(function(){
		$(this).text('>')
	})

    if($('#show_footer').html() == '0'){
        $('.scroll').hide()
        return;
    }
    // Cache the Window object
    $window = $(window);

    $('#footer').each(function(){
        var $bgobj = $(this);
         // assigning the object
            var obj_height = $bgobj.height()
            if(obj_height < 416 )
                obj_height = 416;
            $bgobj.height('0px') ;
        $(window).load(function(){
            $(window).scroll(function() {
                if (($(window).innerHeight() + $(window).scrollTop()) >= $("body").height() && !$bgobj.hasClass("open")) {
                    $bgobj.stop().animate({
                        'height':obj_height + 'px'
                    },1000).addClass('open')
                    $('body').stop().animate({
                        'margin-top': -obj_height + 'px'
                    },1000).addClass('open')
                    $(".scroll").stop().fadeOut('slow')
                }

                if (($(window).innerHeight() + $(window).scrollTop()) <= $(window).innerHeight() && $bgobj.hasClass("open")) {
                    $bgobj.stop().animate({
                        'height': 0 + 'px'
                    },1000).removeClass('open')
                    $('body').stop().animate({
                        'margin-top': 0 + 'px'
                    },1000).removeClass('open')
                    $(".scroll").stop().fadeIn(2000)
                }
            }); // window scroll Ends
            console.log($("body").height(),' | ',$(window).height())
            if ($("body").height() <= $(window).height()){   //if no scroll available on mouse scroll show footer anyway
                $(window).bind('mousewheel', function(e){
                    if(e.originalEvent.wheelDelta < 0 && !$bgobj.hasClass("open")) {
                        $bgobj.stop().animate({
                            'height':obj_height + 'px'
                        },1000).addClass('open')
                        $('body').stop().animate({
                            'margin-top': -obj_height + 'px'
                        },1000).addClass('open')
                        $(".scroll").stop(true,false).fadeOut('slow')
                    }else if (e.originalEvent.wheelDelta > 0 && $bgobj.hasClass("open")) {
                        $bgobj.stop().animate({
                            'height': 0 + 'px'
                        },1000).removeClass('open')
                        $('body').stop().animate({
                            'margin-top': 0 + 'px'
                        },1000).removeClass('open')
                        $(".scroll").stop(true,false).fadeIn(2000)
                    }
                })
            }
        })
    });
});
/*
 * Create HTML5 elements for IE's sake
 */

//document.createElement("article");
//document.createElement("section");


jQuery(document).ready(function(){
    jQuery.fn.drop = function (margin_top_fill) {
        var drop = this;
        drop.stop().stop().animate({
            'margin-top' : 48 + 85 - 125 + margin_top_fill + 'px'
        },500, function() {
            drop.hide().css('margin-top','0px').fadeIn('fast')
        })
        setTimeout(function(){
            drop.parent().find('.fill').stop().stop().animate({
                'margin-top' : margin_top_fill + 'px'
            });
        },300)
    }
    var last_value_iSec = 0;
    var last_value_iMin = 0;
    var last_value_iHours = 0;
    var last_value_iDays = 0;
    var first_time = 0;
    jQuery.fn.anim_progressbar = function (aOptions) {
        // def values
        var iCms = 1000;
        var iMms = 60 * iCms;
        var iHms = 3600 * iCms;
        var iDms = 24 * 3600 * iCms;
        //date from
        var dateString_from = jQuery('#date_from').html();
        var date_from = new Date();
        date_from.setMonth   (parseInt(dateString_from.substr(0, 2), 10)-1);
        date_from.setDate    (parseInt(dateString_from.substr(3, 2), 10));
        date_from.setFullYear   (parseInt(dateString_from.substr(6, 4), 10));

        //date to
        var dateString_to = jQuery('#date_to').html();
        var date_to = new Date();
        date_to.setMonth    (parseInt(dateString_to.substr(0, 2), 10)-1);
        date_to.setDate    (parseInt(dateString_to.substr(3, 2), 10));
        date_to.setFullYear   (parseInt(dateString_to.substr(6, 4), 10));

        // def options
        var aDefOpts = {
            start: new Date().setTime(new Date(date_from.getFullYear(), date_from.getMonth(), date_from.getDate()).getTime()),
            finish: new Date().setTime(new Date(date_to.getFullYear(), date_to.getMonth(), date_to.getDate()).getTime()),
            interval: 100,
            type : ''
        }

        var aOpts = jQuery.extend(aDefOpts, aOptions);
        var Pb = this;
        // each progress bar
        return this.each(
            function() {
                var iDuration = aOpts.finish - aOpts.start;
                // looping process
                var vInterval = setInterval(
                    function(){
                        var iLeftMs = aOpts.finish - new Date() ; // left time in MS
                        var iElapsedMs = new Date() - aOpts.start, // elapsed time in MS
                        iDays = parseInt(iLeftMs / iDms), // elapsed days
                        iHours = parseInt((iLeftMs - (iDays * iDms)) / iHms), // elapsed hours
                        iMin = parseInt((iLeftMs - (iDays * iDms) - (iHours * iHms)) / iMms), // elapsed minutes
                        iSec = parseInt((iLeftMs - (iDays * iDms) - (iMin * iMms) - (iHours * iHms)) / iCms), // elapsed seconds
                        iPerc = (iElapsedMs > 0) ? iElapsedMs / iDuration * 100 : 0; // percentages
                        var last_value = jQuery(Pb).find('.bottle_counter').html()


                        // display current positions and progress
                        if(aOpts.type == 'iSec'){
                            iPerc = (iSec > 0) ? 100 - (iSec / 60) * 100 : 100;
                            jQuery(Pb).find('.bottle_counter').html(iSec)
                            if(last_value != last_value_iSec)
                                jQuery(Pb).find('.drop').drop(500 - iPerc * 3.75)
                            last_value_iSec = last_value
                        }
                        if(aOpts.type == 'iMin'){
                            //var iTotalMin = parseInt((iDuration > 60 * iMms ) ? 60 : iDuration / iMms) ;
                            iPerc = (iMin > 0) ?  100 - (iMin / 60) * 100 : 100;
                            jQuery(Pb).find('.bottle_counter').html(iMin)
                            if(last_value != last_value_iMin)
                                jQuery(Pb).find('.drop').drop(500 - iPerc * 3.75)
                            last_value_iMin = last_value
                        }
                        if(aOpts.type == 'iHours'){
                            iPerc = (iHours > 0) ? 100 - (iHours / 24) * 100 : 100;
                            jQuery(Pb).find('.bottle_counter').html(iHours)
                            if(last_value != last_value_iHours)
                                jQuery(Pb).find('.drop').drop(500 - iPerc * 3.75)
                            last_value_iHours = last_value
                        }
                        if(aOpts.type == 'iDays'){
                            iPerc = (iDays > 0) ? iElapsedMs / iDuration * 100 : 100;
                            jQuery(Pb).find('.bottle_counter').html(iDays)
                            if(last_value != last_value_iDays)
                                jQuery(Pb).find('.drop').drop(500 - iPerc * 3.75)
                            last_value_iDays = last_value
                        }
                        if(first_time < 4){
                            jQuery(Pb).find('.fill').stop().animate({
                                'margin-top' : 500 - iPerc * 3.75 + 'px'
                            });
                            first_time ++;
                        }
                        if (iPerc >= 100 && iLeftMs < 1000 ) {
                            jQuery(Pb).find('.bottle_counter').html('0')
                            clearInterval(vInterval);
                        }
                    } ,aOpts.interval
                    );
            }
            );
    }

    jQuery('#days').anim_progressbar({
        type : 'iDays'
    });
    jQuery('#hours').anim_progressbar({
        type : 'iHours'
    });
    jQuery('#minutes').anim_progressbar({
        type : 'iMin'
    });
    jQuery('#seconds').anim_progressbar({
        type : 'iSec'
    });

    //Subscription =======================================
    function validateEmail(sEmail) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(sEmail)) {
            return true;
        }
        else {
            return false;
        }
    }

    jQuery("#subscribe").submit(function(event) {
        //preventing from normal submition
        event.preventDefault();
        //validating email
        var sEmail = jQuery('#subscribe .email').val();
        if (jQuery.trim(sEmail).length == 0) {
            jQuery('#contactresult').html('<p class="error one">Please enter a valid email address</p>');
            event.preventDefault();//stops script execution
            return false;
        }
        //if valid email send info to php
        if (validateEmail(sEmail)) {
            jQuery.post(templateDir + "/php/subscribes.php", jQuery("#subscribe").serialize(),function(result){
                jQuery('#contactresult').html(result);
            });
        } else {
            jQuery('#contactresult').html('<p class="bad">Invalid Email Address.Please try again</p>');
            event.preventDefault();
            return false;
        }
    });

    /* ================= CONTACTS FORM ================= */

    jQuery('.contact_form').each(function(){
        var t = jQuery(this);
        var t_result = jQuery('#contact_form_result');

        var validate_email = function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        };
        t.submit(function(event) {
            t_result.html('');
            event.preventDefault();
            var t_values = {};
            var t_values_items = t.find('input[name],textarea[name]');
            t_values_items.each(function() {
                t_values[this.name] = jQuery(this).val();
            });
            if(t_values['name']===''||t_values['email']===''||t_values['message']===''){
                t_result.html('Please fill in all the required fields.');
            }else
            if(!validate_email(t_values['email']))
                t_result.html('Please provide a valid e-mail.');
            else
                jQuery.post(templateDir + "/php/contacts.php", t.serialize(),function(result){
                    t_result.html(result);
                });
        });

    });

    /* ================= TWITTER PLUGIN ================= */
    (function( $ ) {
        $.fn.wt_twitter = function(options) {
            var linkify = function(text){
                text = text.replace(/(https?:\/\/\S+)/gi, function (s) {
                    return '<a class="wt_twitter_post_link_external" href="' + s + '">' + s + '</a>';
                });
                text = text.replace(/(^|)@(\w+)/gi, function (s) {
                    return '<a class="wt_twitter_post_link_user" href="http://twitter.com/' + s + '">' + s + '</a>';
                });
                text = text.replace(/(^|)#(\w+)/gi, function (s) {
                    return '<a class="wt_twitter_post_link_search" href="http://search.twitter.com/search?q=' + s.replace(/#/,'%23') + '">' + s + '</a>';
                });
                return text;
            };
            return this.each(function(){
                var settings = $.extend( {
                    user : '',
                    posts: 5,
                    loading: 'Loading tweets..'
                }, options);
                var t = $(this);
                if(t.attr('data-user'))
                    settings.user = t.attr('data-user');
                if(t.attr('data-posts'))
                    settings.posts = parseInt(t.attr('data-posts'));
                if(t.attr('data-loading'))
                    settings.loading = t.attr('data-loading');
                if(settings.user.length && (typeof settings.posts === 'number' || settings.posts instanceof Number) && settings.posts>0){
                    t.addClass('wt_twitter');
                    if(settings.loading.length)
                        t.html('<div class="wt_twitter_loading">'+settings.loading+'</div>');
                    var t_user = t.attr('data-user');
                    $.getJSON(ajaxurl,'user='+t_user+'&action=get_tweets',function(t_tweets){
                        console.log(t_tweets)
                        t.empty();
                        for(var i=0;i<settings.posts&&i<t_tweets.length;i++){
                            var t_date_str;
                            var t_date_seconds = Math.floor(((new Date()).getTime()-Date.parse(t_tweets[i].created_at))/1000);
                            var t_date_minutes = Math.floor(t_date_seconds/60);
                            if(t_date_minutes){
                                var t_date_hours = Math.floor(t_date_minutes/60);
                                if(t_date_hours){
                                    var t_date_days = Math.floor(t_date_hours/24);
                                    if(t_date_days){
                                        var t_date_weeks = Math.floor(t_date_days/7);
                                        if(t_date_weeks)
                                            t_date_str = 'About '+t_date_weeks+' week'+(1==t_date_weeks?'':'s')+' ago';
                                        else
                                            t_date_str = 'About '+t_date_days+' day'+(1==t_date_days?'':'s')+' ago';
                                    }else
                                        t_date_str = 'About '+t_date_hours+' hour'+(1==t_date_hours?'':'s')+' ago';
                                }else
                                    t_date_str = 'About '+t_date_minutes+' minute'+(1==t_date_minutes?'':'s')+' ago';
                            }else
                                t_date_str = 'About '+t_date_seconds+' second'+(1==t_date_seconds?'':'s')+' ago';
                            var t_message =
                            '<div class="wt_twitter_post'+(i+1==t_tweets.length?' last"':'"')+'>'+
                            linkify(t_tweets[i].text)+
                            '<span class="wt_twitter_post_date">'+
                            t_date_str+
                            '</span>'+
                            '</div>';
                            t.append(t_message);
                        }
                        $('.wt_twitter_post').eq(0).fadeIn('slow');
                    }).fail(function(e) { console.log( e ); });
                }
            });
        };
    })( jQuery );
    
    jQuery('.twitter').wt_twitter();
    var i = 0;
    
    setInterval(function(){
        jQuery('.wt_twitter_post').eq(i).fadeOut('slow', function() {
            i++;
            if( i == jQuery('.wt_twitter_post').length ){
                i=0;
            }
            jQuery('.wt_twitter_post').eq(i).fadeIn('slow');
        });
    },6000);
});



//TITLE TOOL
var custom_top = 0;
var custom_left = 15;
var fade_time = 0;

ShowTooltip = function (e) {
    var text = jQuery(this).next('.show-tooltip-text');
    if (text.attr('class') != 'show-tooltip-text') return false;

    text.fadeIn(fade_time, function () {
        var text_width = text.outerWidth();
        var left = e.clientX + custom_left;
        if (left + text_width > jQuery(window).width()) left = e.clientX - text_width - custom_left;
        text.css('top', e.clientY + custom_top).css('left', left);
    })


    jQuery(this).on('mousemove', MoveTooltip);
    return false;
}
HideTooltip = function (e) {
    var text = jQuery(this).next('.show-tooltip-text');
    if (text.attr('class') != 'show-tooltip-text') return false;

    text.fadeOut(fade_time);

    jQuery(this).off('mousemove');
}

SetupTooltips = function () {
    jQuery('.show-tooltip').each(function () {
        jQuery(this).after(jQuery('<span/>').attr('class', 'show-tooltip-text').html(jQuery(this).attr('title'))).attr('title', '');
    }).hover(ShowTooltip, HideTooltip);
}

MoveTooltip = function (e) {
    var text = jQuery(this).next('.show-tooltip-text');
    var text_width = text.outerWidth();
    var left = e.clientX + custom_left;
    if (left + text_width > jQuery(window).width()) left = e.clientX - text_width - custom_left;
    text.css({
        top: e.clientY + custom_top,
        left: left
    });
}

jQuery(document).ready(function () {
    SetupTooltips();
});



/* ================= IE fix ================= */
if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function(obj, start) {
        for (var i = (start || 0), j = this.length; i < j; i++) {
            if (this[i] === obj) {
                return i;
            }
        }
        return -1;
    }
}


/* ================= COLOR SITE ================= */
jQuery(document).ready(function () {
    jQuery("#site_open").click(function () {
        if (jQuery(this).hasClass("active_open")){
            jQuery("#site_change").stop().animate({
                marginLeft: "0px"
            }, 300);
            jQuery("#site_open").removeClass("active_open");
        }else {
            jQuery("#site_open").addClass("active_open");
            jQuery("#site_change").stop().animate({
                marginLeft: "-150px"
            }, 300)
        }
    });
    //map
    jQuery("#hmtctl").hide()
});

/* ================= TABS ================= */
jQuery(document).ready(function ($) {
    $(".news_tab").click(function () {
        $(".tab_news").css("display","block");
        $(".tab_contact").css("display","none");
        $(".news_tab").addClass("active");
        $(".contact_tab").removeClass("active");
    });

    $(".contact_tab").click(function () {
        $(".tab_contact").css("display","block");
        $(".tab_news").css("display","none");
        $(".contact_tab").addClass("active");
        $(".news_tab").removeClass("active");
    });

    $(".news_content").eq(0).addClass("active");

    $(".news_tabs").click(function(){
        var id = $(this).attr('id')
        $(".news_content.active").fadeOut(function(){
            $("#post-content-" + id).fadeIn().addClass("active");
        }).removeClass('active')

    })

});