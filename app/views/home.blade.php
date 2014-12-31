<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title></title>
	{{ HTML::style('bootstrap.min.css') }}
	<style type="text/css">
	@import url(//fonts.googleapis.com/css?family=Lato:700);

	body {
		font-family: "Lato", Ariel, Tahoma, Ubuntu;
	}

	.url {
		width: 600px;
		margin: 40px auto;
	}

	.alert {
		direction: rtl;
	}
	</style>
</head>
<body>
	<section class="url">
	<div class="row">
		<h1 class="text-center">
			آدرس ها راکوتاه کنید
		</h1>
		<hr />
		<div class="col-xs-12">
			{{ Form::open(array('route' => array('short.url'), 'method' => 'post', 'class' => 'form-horizontal')) }}
			<div class="col-xs-3">
				<button class="btn btn-info btn-block btn-lg" type="submit">کوتاهش کن</button>
			</div>
			<div class="form-group form-group-lg col-xs-9">
				<div class="col-sm-12">
				{{ Form::text('url', null, array('class'=>'form-control', 'placeholder' => 'آدرس را وارد کنید')) }}
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
		{{ Session::get('emp') }}
			@if(Session::has('empty'))
				<div class="alert alert-info" role="alert"><b>ای بابا!</b> آدرس که نمی تونه خالی باشه</div>
			@endif

			@if(Session::has('error'))
				<div class="alert alert-danger" role="alert">آدرسی که وارد کردی درست نیست، مطمئن شو که سایته واقعن هست و آدرس را درست زدی مثه: <b>chakosh.ir</b></div>
			@endif

			@if(Session::has('url'))
				<div class="alert alert-success" role="alert" style="direction:ltr">
					<b>{{ Session::get('url') }}</b>
				</div>
			@endif
	</section>
</body>
</html>
