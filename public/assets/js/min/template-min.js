$(document).ready(function(){function a(a){console.log("saveTabCookie",a);var e="tab-"+document.URL.replace("/","").replace(":","").replace("%","").replace("#",""),t=a.find("a[role='tab']").attr("href");e.replace(t,""),console.log(e,t),$.cookie(e,t)}if($.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),$.cookie("ball")?$(".navbar-brand img").addClass("animate"):($(".navbar-brand img").addClass("transition"),setTimeout(function(){$(".navbar-brand img").addClass("animate")},500),$.cookie("ball","rolled",{expires:1,path:"/"})),$(document).on("click",".ajax-modal",function(a){a.preventDefault(),console.log("show modal from",$(this).attr("href")),$(".modal-backdrop").remove(),$("#ajax-modals").empty().load($(this).attr("href"),function(){$("#ajax-modals").find(".modal").not("dying").modal()})}),$("body").on("submit",".ajax-modal-form",function(a){a.preventDefault(),console.log("submit modal as ajax");var e=$(this).parents(".modal"),t=$(this);$(this).find("[type='submit']").attr("disabled",1),$("<span class='micro-loader'></span>").prependTo($(this).parents(".modal").find(".modal-footer")),$.ajax($(this).attr("action"),{type:"POST",data:new FormData(this),processData:!1,contentType:!1,dataType:"json"}).done(function(a){if(e.find(".micro-loader").remove(),t.find("[type='submit']").attr("disabled",!1),"success"==a.status)$(".modal").modal("hide"),t.find("[name=success_redirect]").length?document.location.href=t.find("[name=success_redirect]").val():a.data&&a.data.redirect&&(document.location.href=a.data.redirect),a.data&&a.data.refresh&&location.reload();else if("fail"==a.status){if($(".modal .has-error").removeClass("has-error"),$(".modal .help-block").empty(),a.data&&a.data.validation)for(var o in a.data.validation)$(".modal [name='"+o+"']").siblings(".help-block").text(a.data.validation[o][0]).parent().addClass("has-error")}else{var d="Something went wrong and we don't have an error code.";a.message&&(d=a.message),a.data.code&&(d+="<br>Error code: "+a.data.code),$('<div class="alert alert-danger" role="alert">'+d+"</div>").appendTo(".modal .modal-body").delay(3e3).fadeOut()}})}),$("body").on("submit",".ajax-form",function(a){a.preventDefault(),console.log("submit as ajax");var e=$(this);e.find("[type='submit']").attr("disabled",1),$("<span class='micro-loader'></span>").insertBefore(e.find("[type='submit']")),$.ajax($(this).attr("action"),{type:"POST",data:new FormData(this),processData:!1,contentType:!1,dataType:"json"}).done(function(a){if(e.find("[type='submit']").attr("disabled",!1),"success"==a.status)e.find("[name=success_redirect]").length?document.location.href=e.find("[name=success_redirect]").val():a.data&&a.data.redirect&&(document.location.href=a.data.redirect),a.data&&a.data.refresh&&location.reload();else if("fail"==a.status){if(e.find(".has-error").removeClass("has-error"),e.find(".help-block").empty(),a.data&&a.data.validation)for(var t in a.data.validation)$(".modal [name='"+t+"']").siblings(".help-block").text(a.data.validation[t][0]).parent().addClass("has-error")}else{var o="Something went wrong and we don't have an error code.";a.message&&(o=a.message),a.code&&(o+="<br>Error code: "+a.code),$('<div class="alert alert-danger" role="alert">'+o+"</div>").prependTo(e).delay(3e3).fadeOut()}})}),$("body").on("click",".ajax-simple",function(a){a.preventDefault(),console.log("submit as ajax");var e=$(this);e.hasClass("btn")&&e.attr("disabled","disabled");var t=$(this).attr("method")?$(this).attr("method"):"POST";$.ajax(e.attr("href"),{type:t,contentType:!1,dataType:"json"}).done(function(a){e.hasClass("btn")&&e.removeAttr("disabled"),"success"==a.status?(a.data&&a.data.redirect&&(document.location.href=a.data.redirect),a.data&&a.data.refresh&&location.reload()):a.status})}),$(".datepicker").datepicker({format:"mm-dd-yyyy"}),$(".timepicker").timepicker({template:"dropdown"}),$("body").on("shown.bs.modal",function(a){$(".modal .datepicker").datepicker({format:"mm-dd-yyyy"}),$(".modal .timepicker").timepicker({template:"dropdown"}),$(".modal form input:visible, .modal form textarea:visible").first().focus()}),$(".read-more").each(function(){console.log($(this).height()),$(this).height()<42||(console.log("add button"),$("<button class='btn btn-xs btn-default read-more-expand'>Read More</button>").insertAfter(this))}),$(".read-more-expand").on("click",function(){$(this).hasClass("expanded")?$(this).text("Read More").prev().removeClass("read-more-expanded"):$(this).text("Read Less").prev().addClass("read-more-expanded"),$(this).toggleClass("expanded")}),$("[data-show-element]").on("click",function(){console.log("show hide button clicked"),$(this).hide();var a=$(this).attr("data-show-element");console.log(a),$(a).show()}),$("ul.nav-tabs li").on("click",function(){a($(this))}),_GET("show"))window.history.pushState(null,null,document.URL.replace("?show="+_GET("show"),"")),a($("ul.nav-tabs li.active"));else{var e="tab-"+document.URL.replace("/","").replace(":","");$.cookie(e)&&(console.log("found cookie for ",e),$("ul.nav-tabs li a[href='"+$.cookie(e)+"']").click())}});