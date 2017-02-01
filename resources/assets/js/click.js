window.onload = function() 
{
	$(document).on('click', 'a', handlerAnchors);
	send_url();
	
	function handlerAnchors() 
	{
		var state = {title: this.getAttribute("title"), url: this.getAttribute("href", 2)}
		back = getvalue(location.href);
		now  = getvalue(state.url);

		if(this.getAttribute("target") == "_self")
		{
			window.location.href = this.getAttribute("href", 2);
		}else if(this.getAttribute("target") == "_blank")
		{
			window.open(this.getAttribute("href", 2));
		}else
		{
			if(back['app'] != now['app'])
				$(".apps_ct").hide();
			history.pushState( state, state.title, state.url );
			send_url();
		}
		
		return false;
	}

	function send_url()
	{
		var arr =  location.href.split('?');
		$.ajax({
			url:		'/?content',
			type:		"POST",
			data:		arr[1] + '&history=' + encodeURIComponent(arr[1]),
						
			success: function(data) 
			{
				var json = jQuery.parseJSON(data);
				$("title").html(json.title);
				$('#t').attr("id", "o");

				if(json.menu['home'])
					$('.home_m').attr("id", "t");

				if(json.menu['notice'])
					$('.notice_m').attr("id", "t");

				if(json.menu['search'])
					$('.search_m').attr("id", "t");

				if(json.redirect)
					window.location.href = "/?path=home";

				if(json.error)
					$("#error_window").html(json.content).show(150);
				else
					if(json.app)
					{
						if(json.mini_app)
						{
							$(".mini_app").html(json.content).show();
							$(".notice_m").html($(".notice_m").html() + "<span class=\"notc_red\"></span>");
							history.back();
						}else
						{
							$(".apps_list").hide();
							$(".apps_ct").html(json.content).show();
						}
					}else
					{
						$(".apps_ct").hide();
						$(".apps_list").html(json.content).show();
					}
			}
		});

		return false;
	}

	window.addEventListener("popstate", function(e)
	{
		send_url();
	});

	event.preventDefault();
}

$(document).on('click', '.mini_app .mini_exit', function()
{
	$(".mini_app").html(" ").hide();
});

$(document).on('click', '#error_window #info_block #re_install', function()
{
	$("#error_window").hide(150);
});

function SendForm(result_id) 
{
	$.ajax({
		url:		$("#app_form").attr('action'),
		type:		"POST",
		data:		$("#app_form").serialize(),
		success: function(data) 
		{
			$(result_id).html(data);
		}
	});
}

function getvalue(str)
{
	var i,
	tmp     = [],
	tmp2    = [],
	objRes  = {};

	if(str != '')
	{
		tmp = (str.substr(1)).split('&');
		for(i = 0; i < tmp.length; i += 1)
		{
			tmp2 = tmp[i].split('=');
			if (tmp2[0])
				objRes[tmp2[0]] = tmp2[1];
		}
	}
	return objRes;
}

function close_miniapp()
{
	window.location.reload();
}

function resizewin()
{
	if($(".application").attr('id') == "a_c")
		$(".application").attr('id', 'a_f')
	else
		$(".application").attr('id', 'a_c')
}