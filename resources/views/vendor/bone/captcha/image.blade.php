<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<img src="{{ $route }}"
alt="https://github.com/igoshev/laravel-captcha"
style="width:{{ $width }}px;height:{{ $height }}px;"
id = "captchaImg">

&nbsp;&nbsp;
<a onclick="refreshcaptcha('{{ $route }}&_='+Math.random());var captcha=document.getElementById('{{ $input_id }}');if(captcha){captcha.focus()}" title="Refresh" style="cursor:pointer;"><i class="fa fa-refresh" style="font-size:30px;"></i></a>

 <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
 <script type="text/javascript">
 	function refreshcaptcha(data){
 		$('#captchaImg').attr('src', data);
 	}
 </script>