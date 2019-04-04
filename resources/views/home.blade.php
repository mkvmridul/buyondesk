
@extends('layouts.master')

@section('additionalCSS')
	<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/css/homepage.css">
@endsection

@section('contents')


		<div class="container main">
			<button class="button" id="sell" data-toggle="modal" data-target="#login">SELL</button>
			<button class="button" id="buy" data-toggle="modal" data-target="#login">BUY</button>
		</div>


		@if(auth()->check())
			<script type="text/javascript">
				   document.getElementById("buy").onclick = function () {
				        location.href = "/buy/college";
				    };
				    document.getElementById("sell").onclick = function () {
				        location.href = "/sell";
				    };
			</script>
		@endif

		<button style="display: none" type="button" id="login_button" data-toggle="modal" data-target="#login"></button>



		<div class="container">
			<div class="panel about">
				<div class="panel-heading">
					<h1 class="panel-title">About(summary)</h1>
				</div>
				<div class="panel-body summary">
					buyondesk.com is a platform for all college going students, where a student can buy and sell any kinds of stuff that isn't anymore required by seniors but can be useful for Freshmen(juniors) by just sitting on their desk, or in their classroom. we connect each and every student within the college, and each and every student with in the university through our platform where we match a buyer and a seller within the respective college, therefore, making selling and buying process much easier, faster and pleasant for all the students. This Platform contains no external ads, therefore, making your experience much more pleasant.<a href="/about">...(more)</a>
				</div>
			</div>
		</div>

@if(!auth()->check())
	<script type="text/javascript">
		$('#signup').modal('show');
	</script>
@endif

@endsection()

