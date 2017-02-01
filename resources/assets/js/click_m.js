window.onload = function() 
{
	function handlerAnchors() 
	{
		var state = {title: this.getAttribute("title"), url: this.getAttribute("href", 2)}
		history.pushState( state, state.title, state.url );
		send_url();
		return false;
	}

	$(document).on('click', 'a', handlerAnchors);

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
				if($('#menu_content').is(':hidden'))
				{
					$(".app_to").attr('id', 'menu');
				}

				if(json.menu['home'])
				{
					$('#title_ct').text('Приложения');
				}

				if(json.menu['notice'])
				{
					$('#title_ct').text('Уведомления');
				}

				if(json.menu['search'])
				{
					$('#title_ct').text('Поиск');
				}

				if(json.menu['menu'])
				{
					$('#title_ct').text('Меню');
				}

				if(json.redirect)
				{
					window.location.href = "/?path=home";
				}

				if(json.css != '')
				{
					$("head").html("<style>" + json.css + "</style>" + $("head").html());
				}else
				{
					$("style").remove();
				}

				if(json.error)
				{
					$("#error_window").html(json.content);
					$("#error_window").show(150);
				}else
				{
					if(json.app)
					{
						$(".app_to").attr('id', 	'exit');
						$(".app_to").attr('href', 	'/?path=home');
						$(".apps_list").hide();
						$(".apps_ct").html(json.content);
						$(".apps_ct").show();
					}else
					{
						if($('#menu_content').is(':hidden'))
						{
							$(".app_to").attr('id', 'menu');
							$(".app_to").attr('href','');
							$(".apps_list").html(json.content);
							$(".apps_ct").hide();
							$(".apps_list").show();
						}
					}
				}
			}
		});

		return false;
	}
	send_url();

	window.addEventListener("popstate", function(e)
	{
		send_url();
	});
}

function menu_e(link)
{
	if(link)
	{
		$('#menu_content').hide(150);
		$(".app_to").attr('id', 'menu');
	}else
	{
		if($('.app_to').attr('id') == 'menu')
		{
			$(".app_to").attr('id', 'exit');
			$('#menu_content').show(150);
		}else
		{
			$('#menu_content').hide(150);
			$(".app_to").attr('id', 'menu');
		}
	}
}

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