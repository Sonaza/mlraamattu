@extends('layout.public')

@section('title', 'Tilaa kirjekurssi')

@section('sidebar_content')
	Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia tempore eaque quas odio dolore perspiciatis natus fugit ex, dolorem! Cum totam rerum doloribus, facere similique atque reiciendis dignissimos odit voluptatem expedita voluptate! Cum quo, ipsum dolore accusamus voluptatibus eius saepe minus, at vero dignissimos exercitationem. Aliquid recusandae ducimus, facere saepe iusto, sunt nam sint iure, alias earum dicta modi libero.
@endsection

@section('content')

	<h2>Tilaa kirjekurssi postiisi</h2>
	
	<p>
		Tilaa Raamattuopiston kirjekurssi postiisi täyttämällä tämä lomake.
	</p>
	
	@if($errors->any())
		<div class="alert alert-danger alert-icon" role="alert">
			<i class="fa fa-exclamation"></i>
			<div>
				<b>Hupsis!</b> Tilauslomakkeen tarkistus kohtasi virheitä!
				<hr>
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
	@endif
	
	<form action="/mailcourse" method="post" class="form-horizontal">
		{!! csrf_field() !!}
		<fieldset>
			<legend>
				Valitse kurssi
			</legend>
			<div class="form-group fancy-radio">
				<div class="col-xs-12">
					<div class="radio active">
						<label>
							<input type="radio" name="course" value="Maailman valo" checked>
							<b>Maailman valo</b> (Jeesuksen elämä, 25 opintovihkoa)
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="course" value="Löytöjä raamatusta">
							<b>Löytöjä raamatusta</b> (Raamatun opetus, 26 opintovihkoa)
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="course" value="Raamattu avautuu">
							<b>Raamattu avautuu</b> (Raamatun opetus, 25 opintovihkoa)
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="course" value="Paavalin matkassa">
							<b>Paavalin matkassa</b> (12 opintovihkoa)
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="course" value="Ilmestyskirja avautuu">
							<b>Ilmestyskirja avautuu</b> (16 opintovihkoa)
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="course" value="Elämää ja Terveyttä">
							<b>Elämää ja Terveyttä</b> (18 opintovihkoa)
						</label>
					</div>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<legend>Yhteystietosi</legend>
			<div class="form-group">
				<label class="control-label col-xs-4" for="name">Nimi<small>Pakollinen</small></label>
				<div class="col-xs-8">
					<input type="text" class="form-control" id="name" name="name" placeholder="Nimi" value="{{ old('name') }}">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-4" for="address">Lähiosoite<small>Pakollinen</small></label>
				<div class="col-xs-8">
					<input type="text" class="form-control" id="address" name="address" placeholder="Lähisoite" value="{{ old('address') }}">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-4" for="city">Postinumero ja -toimipaikka<small>Pakollinen</small></label>
				<div class="col-xs-8">
					<input type="text" class="form-control" id="city" name="city" placeholder="Postinumero ja -toimipaikka" value="{{ old('city') }}">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-4" for="phone">Puhelinnumero</label>
				<div class="col-xs-8">
					<input type="text" class="form-control" id="phone" name="phone" placeholder="Postinumero ja -toimipaikka" value="{{ old('phone') }}">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-4" for="email">Sähköposti</label>
				<div class="col-xs-8">
					<input type="text" class="form-control" id="email" name="email" placeholder="Postinumero ja -toimipaikka" value="{{ old('email') }}">
				</div>
			</div>
		</fieldset>
		<fieldset>
			<legend></legend>
			<div class="form-group">
				<div class="col-xs-7">
					<p style="padding-top:8px">
						Varmista, että tietosi ovat oikein ja jatka eteenpäin.
					</p>
				</div>
				<div class="col-xs-5">
					<button type="submit" class="btn btn-block btn-primary">
						<span class="glyphicon glyphicon-ok"></span> Tilaa kurssi
					</button>
				</div>
			</div>
		</fieldset>
	</form>

@endsection