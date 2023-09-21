<!DOCTYPE html>
<html lang="en">
<head>
<title>{{env('APP_NAME')}}</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<link rel="stylesheet" href="{{asset('front/css/bootstrap.min.css')}}" type="text/css">
<body style="background-color:#fff; font-family:arial; font-size:14px;">
<center>
	<table width="800" cellspacing="0" style="border:1px solid #043278; border-radius:5px; overflow:hidden">
		<tr>
			<td bgcolor="#043278" style="padding:10px 20px;">
				<table style="width:100%;">
					<tr>
						<td width="40%" style="color:#fff;">
							<img src="{{URL::asset('img/pinkcityemaillogo.png')}}">
						</td>
						<td style="color:#fff">
							&nbsp;
						</td>
					</tr>
				</table>
			</td>
		</tr>
		@yield('content')
		
	</table>
</center>
</body>
</html>