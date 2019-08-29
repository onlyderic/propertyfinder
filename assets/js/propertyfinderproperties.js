$(".form-ck").click(function(e){var vid="#"+$(this).attr("data-mod")+"-"+$(this).attr("data-value");$(vid).prop("checked",!$(vid).prop("checked"))});$(".form-opt").click(function(e){var vid="#"+$(this).attr("data-mod")+"-"+$(this).attr("data-value");$(vid).prop("checked",true)});
$.ajax({url:baseurl+"upload/load/"+objprof.tid,dataType:"json"}).done(function(result){$.each(result.file,function(index,file){checked=$("#profilepic").val()==file.name?'checked="checked"':"";$('<div class="pull-left" style="margin:0 5px;" align="center">').html('<img src="'+file.thumbs_url+'" style="height:100px;" /><br/><span class="delete-btn delete appended" data-name="'+file.name+'" data-type="'+file.delete_type+'" data-url="'+file.delete_url+'&delete=true"><label><span>Delete</span></label></span>&nbsp;<span class="rd-btn"><label><input type="radio" name="defaultpic" class="defaultpic" value="'+
file.name+'" '+checked+" /><span>Default</span></label></span>").appendTo($("#uploadedphotos"))});$(".appended").click(function(e){e.preventDefault();obj=$(this);$.ajax({url:$(this).attr("data-url"),type:"POST",data:{"delete":"true","id":objprof.tid}}).done(function(result){if($("#profilepic").val()==obj.attr("data-name"))$("#profilepic").val("");obj.parent().remove();completion()});return false});$(".delete").removeClass("appended");$(".defaultpic").change(function(){$("#profilepic").val($(this).val());
completion()});$("#progress .bar").css("width","0%");$("#progress").addClass("fade")});$("#propdeveloper").autocomplete({source:baseurl+"company/auto_list",minLength:2,change:function(event,ui){if(ui.item){$("#propdeveloperid").val(ui.item.id);$("#propdeveloper").val(ui.item.value)}else $("#propdeveloperid").val("")},select:function(event,ui){if(ui.item){$("#propdeveloperid").val(ui.item.id);$("#propdeveloper").val(ui.item.value)}else{$("#propdeveloperid").val("");$("#propdeveloper").val("")}}});
$("#progressbar").progressbar({value:objprof.propcompletion});$("#slider-range-min").slider({range:"min",step:5,value:objprof.propconstruction,min:-5,max:100,slide:function(event,ui){val=ui.value+"%";$("#divpropcompletion").show();if(ui.value==-5)val="Unspecified";else if(ui.value==100){val="Complete";$("#divpropcompletion").hide()}$("#propconstruction").val(ui.value);$("#propconstructionlbl").html(val)}});val=$("#slider-range-min").slider("value")+"%";$("#divpropcompletion").show();
if($("#slider-range-min").slider("value")==-5)val="Unspecified";else if($("#slider-range-min").slider("value")==100){val="Complete";$("#divpropcompletion").hide()}$("#propconstruction").val($("#slider-range-min").slider("value"));$("#propconstructionlbl").html(val);
$(".proprange").click(function(e){max=$(this).attr("id");if($(this).html()=="Create a range"){$(this).html("Remove range");$("#"+max+"max").show();$("#"+max+"range").val("1")}else{$(this).html("Create a range");$("#"+max+"max").val("");$("#"+max+"max").hide();$("#"+max+"range").val("")}e.preventDefault();return false});
$("#proptype").change(function(e){$("#propclass").find("option").remove().end().append('<option value=""></option>').val("");proptype=$(this).val();if(proptype=="")$("#divpropclass").hide();else{$.each(classifications[proptype],function(i,item){$("#propclass").append($("<option></option>").attr("value",i).text(item))});$("#divpropclass").show()}$("input[name='propfurnished[]']").removeAttr("checked");$(".form-propfurnished").removeClass("active");$("input[name='propfurnish1[]']").removeAttr("checked");
$("input[name='propfurnish2[]']").removeAttr("checked");$("input[name='propfurnish3[]']").removeAttr("checked");$("input[name='propfurnish4[]']").removeAttr("checked");$(".form-propfurnish1").removeClass("active");$(".form-propfurnish2").removeClass("active");$(".form-propfurnish3").removeClass("active");$(".form-propfurnish4").removeClass("active");$("input[name='propfeats1[]']").removeAttr("checked");$("input[name='propfeats2[]']").removeAttr("checked");$("input[name='propfeats3[]']").removeAttr("checked");
$("input[name='propfeats4[]']").removeAttr("checked");$("input[name='propfacilities1[]']").removeAttr("checked");$("input[name='propfacilities2[]']").removeAttr("checked");$("input[name='propfacilities3[]']").removeAttr("checked");$("input[name='propfacilities4[]']").removeAttr("checked");$("#lblpropgarage").html("Garage");switch(proptype){case "CO":case "CSH":case "CR":case "CI":$("#sidenavfurnishings").show();$("#sidenavfeatures").show();$("#sidenavfacilities").show();$("#flsfurnishings").show();
$("#flsfeatures").show();$("#flsfacilities").show();$("#divproprooms").show();$("#divproptoilets").show();$("#divpropgarage").show();$("#divfurnishings1").hide();$("#divfurnishings2").show();$("#divfurnishings3").hide();$("#divfurnishings4").hide();$("#divfeatures1").hide();$("#divfeatures2").show();$("#divfeatures3").hide();$("#divfeatures4").hide();$("#divfacilities1").hide();$("#divfacilities2").show();$("#divfacilities3").hide();$("#divfacilities4").hide();$("#lblpropgarage").html("Parking");
$("#divpropconstruction").show();$("#divpropcompletion").show();$("#divpropfloornum").show();$("#divpropunitnum").show();$("#divpropoccupancy").show();break;case "LLO":case "LLS":case "LF":case "LB":$("#sidenavfurnishings").hide();$("#sidenavfeatures").show();$("#sidenavfacilities").hide();$("#flsfurnishings").hide();$("#flsfeatures").show();$("#flsfacilities").hide();$("#proproomrange").val("");$("#proproommin").val("");$("#proproommax").val("");$("#proptoiletrange").val("");$("#proptoiletmin").val("");
$("#proptoiletmax").val("");$("#propgaragerange").val("");$("#propgaragemin").val("");$("#propgaragemax").val("");$("#divproprooms").hide();$("#divproptoilets").hide();$("#divpropgarage").hide();$("#divpropconstruction").hide();$("#divpropcompletion").hide();$("#propfloornum").val("");$("#divpropfloornum").hide();$("#divpropunitnum").show();$("#divpropoccupancy").hide();$("#divfurnishings1").hide();$("#divfurnishings2").hide();$("#divfurnishings3").hide();$("#divfurnishings4").hide();$("#divfeatures1").hide();
$("#divfeatures2").hide();$("#divfeatures3").show();$("#divfeatures4").hide();$("#divfacilities1").hide();$("#divfacilities2").hide();$("#divfacilities3").hide();$("#divfacilities4").hide();$("#slider-range-min").slider({value:-5});$("#propconstruction").val(-5);$("#propconstructionlbl").html("Unspecified");break;case "HHR":case "HPI":case "HCC":$("#sidenavfurnishings").show();$("#sidenavfeatures").show();$("#sidenavfacilities").show();$("#flsfurnishings").show();$("#flsfeatures").show();$("#flsfacilities").show();
$("#divproprooms").show();$("#proptoiletrange").val("");$("#proptoiletmin").val("");$("#proptoiletmax").val("");$("#propgaragerange").val("");$("#propgaragemin").val("");$("#propgaragemax").val("");$("#divproptoilets").hide();$("#divpropgarage").hide();$("#divfurnishings1").hide();$("#divfurnishings2").hide();$("#divfurnishings3").hide();$("#divfurnishings4").show();$("#divfeatures1").hide();$("#divfeatures2").hide();$("#divfeatures3").hide();$("#divfeatures4").show();$("#divfacilities1").hide();
$("#divfacilities2").hide();$("#divfacilities3").hide();$("#divfacilities4").show();$("#divpropconstruction").show();$("#divpropcompletion").show();$("#divpropfloornum").show();$("#divpropunitnum").show();$("#divpropoccupancy").show();break;default:$("#sidenavfurnishings").show();$("#sidenavfeatures").show();$("#sidenavfacilities").show();$("#flsfurnishings").show();$("#flsfeatures").show();$("#flsfacilities").show();$("#divproprooms").show();$("#divproptoilets").show();$("#divpropgarage").show();
$("#divfurnishings1").show();$("#divfurnishings2").hide();$("#divfurnishings3").hide();$("#divfurnishings4").hide();$("#divfeatures1").show();$("#divfeatures2").hide();$("#divfeatures3").hide();$("#divfeatures4").hide();$("#divfacilities1").show();$("#divfacilities2").hide();$("#divfacilities3").hide();$("#divfacilities4").hide();$("#divpropconstruction").show();$("#divpropcompletion").show();$("#divpropfloornum").show();$("#divpropunitnum").show();$("#divpropoccupancy").show();break}$('[data-spy="scroll"]').each(function(){var $spy=
$(this).scrollspy("refresh")});completion()});$("#propname").change(function(e){completion()});$("#propclass").change(function(e){completion()});$("#proppricemin").change(function(e){completion()});$("#proppriceunit").change(function(e){completion()});$("input[name='propfinance[]']").change(function(e){completion()});$("#proploccity").change(function(e){completion()});$("#proploccountry").change(function(e){completion()});$("#propaddress").change(function(e){completion()});$("#propdesc").change(function(e){completion()});
$("#profilepic").change(function(e){completion()});
$(".form-proppost").click(function(e){if($("#form-proppost-S").is(":checked")&&$("#form-proppost-R").is(":checked")||$("#form-proppost-O").is(":checked"))$("#lblpropprice").html('Price/Rental<span class="required">*</span>');else if($("#form-proppost-R").is(":checked"))$("#lblpropprice").html('Rental<span class="required">*</span>');else $("#lblpropprice").html('Price<span class="required">*</span>');if(!$("#form-proppost-S").is(":checked")&&($("#form-proppost-R").is(":checked")||$("#form-proppost-O").is(":checked"))){$("#tenuresale").find("input").removeAttr("checked");
$("#tenuresale").hide();$("#proptenureyears").val("");$("#proptenureyears").next("span").html("");$("#divproptenureyears").hide();$("#tenurerent").show()}else{$("#tenurerent").find("input").removeAttr("checked");$("#tenurerent").hide();$("#divproptenureyears").show();$("#tenuresale").show()}completion()});$("#freehold").change(function(e){if($(this).is(":checked"))$("#proptenureyears").next("span").html("-Freehold")});$("#leasehold").change(function(e){if($(this).is(":checked"))$("#proptenureyears").next("span").html("-Leasehold")});
$(".form-propfurnished").click(function(e){if($("#form-propfurnished-U").is(":checked")){$("input[name='propfurnish1[]']").removeAttr("checked");$("input[name='propfurnish2[]']").removeAttr("checked");$("input[name='propfurnish3[]']").removeAttr("checked");$("input[name='propfurnish4[]']").removeAttr("checked");$(".form-propfurnish1").removeClass("active");$(".form-propfurnish2").removeClass("active");$(".form-propfurnish3").removeClass("active");$(".form-propfurnish4").removeClass("active")}});
$(".formpublish").click(function(e){$("#pub").val("1");$("#frmrealtynista").submit();e.preventDefault();return false});


        /* *
         * Google maps
         * */

        //var latlng = new google.maps.LatLng(<x?php //echo ( !empty($propcoordlat) ? $propcoordlat : 33.808678 ); ?x>, <x?php //echo ( !empty($propcoordlng) ? $propcoordlng : -117.918921 ); ?x>);
        var latlng = new google.maps.LatLng(objprof.propcoordlat, objprof.propcoordlng);
        var markersArray = [];

        $('.tab-map').click(function(e) {
            if($(this).attr('data-mode') == '') {
                $(this).attr('data-mode', 'loaded');
                
                /* initialize map */
                objprof.propmapzoom = parseInt(objprof.propmapzoom);
                var map = new google.maps.Map(document.getElementById("divmap"), {
                  center: latlng,
                  zoom: objprof.propmapzoom,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                google.maps.event.addListener(map, "click", function (e) { 
                    $('#propcoordlat').val( e.latLng.lat() );
                    $('#propcoordlng').val( e.latLng.lng() );
                }); 

                var marker=new google.maps.Marker({
                    position: latlng,
                });

                markersArray.push(marker);
                marker.setMap(map);

                google.maps.event.addListener(map, 'click', function(event) {
                    if (markersArray) {
                        for (i in markersArray) {
                            markersArray[i].setMap(null);
                        }
                        markersArray.length = 0;
                    }
                    marker = new google.maps.Marker({
                        position: event.latLng,
                        map: map
                    });
                    markersArray.push(marker);
                });
        
            }
        });

        /* *
         * Image uploader
         * */
        
        var uploader = new plupload.Uploader({
                runtimes : 'gears,html5,flash,silverlight,browserplus',
                browse_button : 'btnselectphotos',
                container: 'container',
                max_file_size : '3mb',
                url : baseurl+'upload/index/'+objprof.tid,
                flash_swf_url : baseurl+'assets/js/plupload/plupload.flash.swf',
                silverlight_xap_url : baseurl+'assets/js/plupload/plupload.silverlight.xap',
                filters : [
                        {title : "Image files", extensions : "jpg,jpeg,png"}
                ],

                /* Post init events, bound after the internal events */
                init : {
                        FileUploaded: function(up, file, info) {
                            /* Called when a file has finished uploading */
                            if(info.status == 200 || file.status == 5) {
                                var response = $.parseJSON(info.response);
                                $('#uploadedphotos').append('<div class="pull-left" style="margin:0 5px;" align="center"> <img src="'+baseurl+'photos/'+objprof.tid+'/thumbs/'+response.filename+'" style="height:100px;" /><br/><span class="delete-btn delete appended" data-name="'+response.filename+'" data-type="DELETE" data-url="'+baseurl+'upload/remove/?file='+response.filename+'&delete=true"><label><span>Delete</span></label></span>&nbsp;<span class="rd-btn"><label><input type="radio" name="defaultpic" class="defaultpic" value="'+response.filename+'" /><span>Default</span></label></span> </div>');

                                $('.appended').click(function(e) {
                                    e.preventDefault();
                                    obj = $(this);
                                    $.ajax({
                                        url: $(this).attr('data-url'),
                                        type: 'POST',
                                        data: { 'delete': 'true', 'id': objprof.tid }
                                    }).done(function (result) {
                                        if( $('#profilepic').val() == obj.attr('data-name') ) {
                                            $('#profilepic').val('');
                                        }
                                        obj.parent().remove();
                                        completion();
                                    });
                                    return false;
                                });
                                /* *
                                 * If exists,
                                 * remove the appendedliker class so that next time, 
                                 * the newly added items are the only ones binded to events
                                 * */
                                $('.delete').removeClass('appended');

                                $('.defaultpic').change(function() {
                                    $('#profilepic').val( jQuery(this).val() );
                                    completion();
                                });
                            }
                        }
                }
        });

        uploader.bind('Init', function(up, params) {
            $('#filelist').html("");
        });

        uploader.init();

        uploader.bind('FilesAdded', function(up, files) {
            $.each(files, function(i, file) {
                $('#filelist').append(
                    '<div id="' + file.id + '">' +
                    file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
                '</div>');
            });
        });

        uploader.bind('UploadProgress', function(up, file) {
            if(file.percent == 100) {
                $('#'+file.id).fadeOut();
            } else {
                $('#'+file.id+" b").html('<span>' + file.percent + "%</span>");
            }
        });

        $('#btnuploadphotos').click(function(e) {
            uploader.start();
            e.preventDefault();
        });