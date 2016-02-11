

var loc = window.location;
var mis;
nN = navigator.appName;

function getText(e){
    function winop(mis){
        $.fancybox({
            autoSize: false,
            autoDimensions: false,
            width: 900,
            height: 500,
            fitToView: false,
            padding: 0,
            //title: this.title,
            href: '',
            type: 'iframe'
        });
    }
    if (!e) e= window.event;
    if((e.ctrlKey) && ((e.keyCode==10)||(e.keyCode==13))){
        if(nN == 'Microsoft Internet Explorer'){
            if(document.selection.createRange()){
                var range = document.selection.createRange();
                mis = range.text;
                winop(mis);
            }
        }else{
            if(window.getSelection()){
                mis = window.getSelection();
                winop(mis);
            }else if(document.getSelection()){
                mis = document.getSelection();
                winop(mis);
            }
        }
        return true;
    }
    return true;
}
document.onkeypress = getText;




    var $left = -65;
    var RegionTooltip = function(cont,tooltip){
        var $this = tooltip;
        this.cont = cont;
        this.init = function(){
            $(this.cont).bind('mouseover',function(){
                $($this).show();
            });
            $(this.cont).bind('mouseout',function(){
                $($this).hide();
            });
            $(this.cont).bind('mousemove',function(e){
                   $($this).css({
                left : e.pageX + $left
                ,top : e.pageY - 79
            });
            });
        }
        this.init();
    }
        $(document).ready(function(){
            var tool = $('#map_tooltip');
            var Tooltip = new RegionTooltip('.map AREA, .map .l_side',tool);
            jQuery(".map AREA").mouseover(function(){
                var bishkekMap = '.'+$(this).attr('id');
                var regionInfo = '.'+$(this).attr('id')+'-info';
                tool.find('.title').text($(regionInfo).attr('title'));
                jQuery(bishkekMap).css('display', 'inline');
            }).mouseout(function(){
                var bishkekMap = '.'+$(this).attr('id');
                jQuery(bishkekMap).css('display', 'none');
            });
            $('#south,#west,#west1,#east,#north,#center','form').live('click',function(){
                if($(this).attr('type')!='checkbox')
                    $('#location').val($(this).attr('id'));

                $.ajax({data:{location:$(this).attr('id')},type:'POST', success:function(resp){
                    $('#offices_inner').html(resp);
                }
                });
                return false;
            });

            $('input:checkbox','form').live('click',function(){
                var name = $(this).attr('name');
                if(name == "branch"){
                    $('div.row').css("display", "none");
                    $('div#branch').css("display", "block");
                }else if(name == "kassa"){
                    $('div.row').css("display", "none");
                    $('div#sberkassa').css("display", "block");
                }else if(name == "atm"){
                    $('div.row').css("display", "none");
                    $('div#ATM').css("display", "block");
                    $('div#kicb-ATM').css("display", "block");
                    $('div#asia-ATM').css("display", "block");
                }else if(name == "all"){
                    $('div.row').css("display", "block");
                }

                return false;
            });

            $('a','.city_field').live('click',function(){
                var loc = $(this).attr('location');
                if (loc)
                {
                    if(loc == 'bishkek')
                    {
                        $.ajax({data:{location:$(this).attr('id')},type:'POST', success:function(resp){
                            $('#offices_inner').html(resp);
                        }
                        });
                    }else{
                        $('#' + loc).click();
                        $('.map').show();
                    }

                }
                else{
                    $.ajax({data:{region_id:$(this).attr('region')},type:'POST', success:function(resp){
                        $('#offices_inner').html(resp);
                        $('.map').hide();
                    }
                    });
                }
                $('.city_field').hide();
                $('.curr_pos').text($(this).text());
                if (loc){
                    $('.curr_pos').attr('city_id', '0');
                }else{
                    $('.curr_pos').attr('city_id', $(this).attr('region'));
                }

                return false;
            });
                    $('a[region=1]').click();
        //            $('.curr_pos').live('click',function(){
//                $('.pos_list').toggle('fast');
//            })
            $('.curr_pos').live('click',function(){
//                $('.top_menu .opacity_field').hide();
                if($(this).next().hasClass('city_field'))
                    $(this).next().toggle();
            });


            $('#mapcontent').live('click',function(){
                    $.fancybox({
                        autoSize: false,
                        autoDimensions: false,
                        width: 951,
                        height: 580,
                        fitToView: false,
                        padding: 0,
                        //title: this.title,
                        href: '',
                        type: 'iframe',
                        'callbackOnClose': function() {
                            $("#fancy_content").empty();
                        }
                    });
            });

        })
		
		