@extends('layout')

@section('authentication_form')
	
	@if($errors->any())
		<div class="alert alert-danger alert-icon" role="alert">
			<span class="glyphicon glyphicon-remove-sign"></span>
			<div>
				<b>Hupsis!</b> {{ @$authentication_type == 0 ? 'Rekisteröinnissä' : 'Kirjautumisessa' }} tapahtui virhe eikä vastauksiasi ole vielä tallennettu!
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
	
	<div class="tabs">
		<div class="col-xs-6 tab {{ css(['active' => @$authentication_type == 0]) }}" id="tab-register">
			<a>
				Rekisteröidy <span class="glyphicon glyphicon-lock"></span>
			</a>
		</div>
		<div class="col-xs-6 tab {{ css(['active' => @$authentication_type == 1]) }}" id="tab-login">
			<a>
				Kirjaudu sisään <span class="glyphicon glyphicon-log-in"></span>
			</a>
		</div>
	</div>
	<div class="clearfix"></div>
	
	<input type="hidden" id="authentication_type" name="authentication_type" value="{{ $authentication_type }}">
	
	<div id="authentication-form">
		<div class="tab-content-wrapper">
			<div class="tab-content-row">
				<div class="tab-panel">
					<p class="form-help form-help-register">
						Jatkaaksesi sinun tulee rekisteröityä, jotta järjestelmä voi pitää
						kirjaa vastauksistasi ja sinulle voidaan antaa palautetta.
					</p>
					
					<div class="form-group field-name">
						<label for="user-name" class="control-label col-xs-3">Nimi</label>
						<div class="col-xs-7">
							<input type="text" class="form-control" id="user-name" name="user-name" value="{{ old('user-name') }}">
						</div>
					</div>
					<div class="form-group">
						<label for="user-email" class="control-label col-xs-3">Sähköpostiosoite</label>
						<div class="col-xs-7">
							<input type="text" class="form-control" id="user-email" name="user-email" value="{{ old('user-email') }}">
						</div>
					</div>
					<div class="form-group">
						<label for="user-password" class="control-label col-xs-3">Salasana</label>
						<div class="col-xs-7">
							<input type="password" class="form-control" id="user-password" name="user-password">
						</div>
					</div>
					<div class="form-group field-password-confirmation">
						<label for="user-password_confirmation" class="control-label col-xs-3">Salasana uudestaan</label>
						<div class="col-xs-7">
							<input type="password" class="form-control" id="user-password_confirmation" name="user-password_confirmation">
						</div>
					</div>
				</div>
				<div class="tab-panel">
					<div class="form-help">
						<p>
							Kirjaudu sisään syöttämällä sähköpostiosoitteesi ja salasanasi.
							Jos olet jo suorittanut tämän kokeen ennen, uusia vastauksiasi ei tallenneta.
						</p>
					</div>
					
					<div class="form-group">
						<label for="user-login-email" class="control-label col-xs-3">Sähköpostiosoite</label>
						<div class="col-xs-7">
							<input type="text" class="form-control" id="user-login-email" name="user-login-email" value="{{ old('user-login-email') }}">
						</div>
					</div>
					<div class="form-group">
						<label for="user-login-password" class="control-label col-xs-3">Salasana</label>
						<div class="col-xs-7">
							<input type="password" class="form-control" id="user-login-password" name="user-login-password">
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-3 col-xs-offset-3">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="remember_me"> Muista kirjautuminen
								</label>
							</div>
						</div>
						<div class="col-xs-4">
							<p style="text-align: right; padding: 0.45em 0">
								<a href="/auth/reset">Unohtunut salasana?</a>
							</p>
						</div>
					</div>
				</div>
				
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
@endsection

@section('extra_navigation')
	<li>
		<a href="/course/{{ $test->course->id }}">
			{{ $test->course->title }}
		</a>
	</li>
@endsection

@section('content')
	
	<form action="/test/{{ $test->id }}" method="post" class="test-form form-horizontal {{ css([
			'form-register' => @$authentication_type == 0,
			'form-login' 	=> @$authentication_type == 1,
		]) }}">
		{!! csrf_field() !!}

		<div class="form-group">
			<h1 class="test-title">{{ $test->title }}</h1>
			@if($test->description && strlen($test->description) > 0)
				<div class="test-description">{{ $test->description }}</div>
			@endif
			<input type="hidden" name="test_id" value="{{ $test->id }}">
		</div>
		
		@if(!Auth::check() && $errors->any())
			@yield('authentication_form')
			
			<div class="form-group">
				<button class="btn btn-primary btn-block">
					@if(Auth::check())
						Tarkista vastaukset
					@elseif(!Auth::check())
						<span class="button-text button-text-register">Rekisteröidy</span>
						<span class="button-text button-text-login">Kirjaudu sisään</span>
						<span style="display:inline-block;">ja tarkista vastaukset</span>
					@endif
				</button>
			</div>
			<hr>
		@endif
		
		@if(!$test->hasFeedback() && $validation && !$hasPassed)
			<div class="alert alert-warning alert-icon">
				<span class="glyphicon glyphicon-remove-circle"></span>
				<div>
					<p>
						Sinun pitää vastata oikein vähintään {{ $minimumToPass }} kysymykseen. Et ole saavuttanut vaadittua vähimmäismäärää, joten et voi jatkaa kurssilla eteenpäin ennen sitä. Voit tehdä korjauksia nyt tai odottaa kunnes koe on tarkistettu ja vastaanotat palautetta.
					</p>
					<p id="top-spoiler-warning">
						<a class="spoiler-warning">
							<span class="glyphicon glyphicon-eye-open"></span> Oikeat vastaukset piilotettu. Klikkaa tästä nähdäksesi.
						</a>
					</p>
				</div>
				<div class="clearfix"></div>
			</div>
		@elseif($hasPassedFull)
			<div class="alert alert-success alert-icon">
				<span class="glyphicon glyphicon-ok-circle"></span>
				<div>
					<h4><b>Hurraa!</b> Koe läpäisty!</h4>
					@if($test->course->nextTest)
						<p class="pull-right">
							<a href="/test/{{ $test->course->nextTest->id }}" class="btn btn-success">
								Seuraavaan kokeeseen! <span class="glyphicon glyphicon-chevron-right"></span>
							</a>
						</p>
						<p>
							Olet suorittanut tämän kokeen ja voit nyt jatkaa kurssilla eteenpäin.
						</p>
					@else
						<p class="pull-right">
							<a href="/" class="btn btn-success">
								Palaa etusivulle <span class="glyphicon glyphicon-chevron-right"></span>
							</a>
						</p>
						<p>
							Olet suorittanut koko kurssin. Onneksi olkoon!
						</p>
					@endif
				</div>
				<div class="clearfix"></div>
			</div>
		@elseif($test->hasFeedback())
			<div class="alert alert-success alert-icon">
				<span class="glyphicon glyphicon-ok-circle"></span>
				<div>
					<h4>Olet vastaanottanut koepalautetta!</h4>
					<p>
						Kokeesi on tarkistettu ja täten merkitty hyväksytyksi riippumatta siitä, saitko kaikkia vastauksia oikein.
					</p>
					@if($test->course->nextTest)
						<p class="pull-right">
							<a href="/test/{{ $test->course->nextTest->id }}" class="btn btn-success">
								Seuraavaan kokeeseen! <span class="glyphicon glyphicon-chevron-right"></span>
							</a>
						</p>
						<p>
							Voit nyt jatkaa kurssilla eteenpäin. Halutessasi voit vielä korjata vastauksia.
						</p>
					@else
						<p class="pull-right">
							<a href="/" class="btn btn-success">
								Palaa etusivulle <span class="glyphicon glyphicon-chevron-right"></span>
							</a>
						</p>
						<p>
							Olet suorittanut koko kurssin. Halutessasi voit vielä korjata vastauksia.
						</p>
					@endif
				</div>
				<div class="clearfix"></div>
			</div>
		@endif
		
		<fieldset class="questions">
			<legend>Kysymykset</legend>
			@foreach($test->questions as $qkey => $question)
				<div class="question {{
					css([
						'no-validation'		=> !@$validation,
						'correct'			=> @$validation && @$validation[$question->id]['status'] == \App\Question::CORRECT,
						'partially-correct'	=> @$validation && @$validation[$question->id]['status'] == \App\Question::PARTIALLY_CORRECT,
						'incorrect'			=> @$validation && @$validation[$question->id]['status'] == \App\Question::INCORRECT,
					])
				}}">
					<input type="hidden" name="questions[]" value="{{ $question->id }}">
					<div class="header">
						@if(@$validation)
							<div class="big-validation-icon">
								@if(@$validation[$question->id]['correct'])
									<span class="glyphicon glyphicon-ok-circle"></span>
								@else
									<span class="glyphicon glyphicon-remove-circle"></span>
								@endif
							</div>
						@endif
						
						<div class="number">
							{{ ($qkey + 1) . '. ' }}
						</div>
						<div class="title">
							{{ $question->title }}
							@if($question->subtitle)
								<div class="subtitle">
									{!! nl2br($question->subtitle) !!}
									<div class="clearfix"></div>
								</div>
							@endif
						</div>
						<div class="clearfix"></div>
					</div>
					
					@if(isset($validation) && array_key_exists($question->id, $validation))
						@if($validation[$question->id]['status'] == \App\Question::CORRECT)
							<div class="validation correct">
								<span class="glyphicon glyphicon-ok"></span>
								@if($question->type == 'TEXTAREA')
									Hyväksytty!
								@else
									Oikein!
								@endif
							</div>
						@elseif($validation[$question->id]['status'] == \App\Question::PARTIALLY_CORRECT)
							<div class="validation partially-correct">
								<span class="glyphicon glyphicon-remove"></span>
								@if($question->type == "MULTITEXT")
									{{ $validation[$question->id]['partial'] }} oikein!
								@else
									Osittain oikein!
								@endif
							</div>
						@elseif($validation[$question->id]['status'] == \App\Question::INCORRECT)
							<div class="validation incorrect">
								<span class="glyphicon glyphicon-remove"></span> Väärin!
							</div>
						@endif
					@endif
					
					<div class="form-group has-feedback">
						<div class="answer">
							<?php
								switch($question->type): 
									case 'MULTI':
								?>
									@foreach($question->answers as $answer)
										<div class="checkbox {{
											css([
												'has-answer' => @in_array($answer->id, @$given_answers[$question->id]),
											])
										}}">
											<label>
												{!! Form::checkbox('answer-' . $question->id . '[]', $answer->id, @in_array($answer->id, @$given_answers[$question->id])) !!}
												{{ $answer->text }}
												@if(@$validation && @in_array($answer->id, @$given_answers[$question->id]))
													@if($answer->is_correct)
														<span class="glyphicon glyphicon-ok" style="color:#329f07"></span>
													@else
														<span class="glyphicon glyphicon-remove" style="color:#af000d"></span>
													@endif
												@endif
											</label>
										</div>
									@endforeach

									@if(isset($validation) && @$validation[$question->id]['correct_answers'])
										<hr>
										<div class="correct-answers {{
												css([
													'spoiled' => $test->hasFeedback() || @$hasPassed || @$validation[$question->id]['correct'],
												])
											}}">
											<span class="glyphicon glyphicon-exclamation-sign"></span>
											<h4>Oikeat vastaukset:</h4>
											<ul>
												@foreach($validation[$question->id]['correct_answers'] as $answer)
													<li>{{ $answer['text'] }}</li>
												@endforeach
											</ul>
											<a class="spoiler-warning">
												Oikeat vastaukset piilotettu. Klikkaa tästä nähdäksesi.
											</a>
										</div>
									@endif
								<?php
									break;
									//--------------------------------------------------------------------------
									case 'CHOICE':
								?>
									@foreach($question->answers as $answer)
										<div class="radio {{
											css([
												'has-answer' => (@$given_answers[$question->id] == $answer->id),
											])
										}}">
											<label>
												{!! Form::radio('answer-' . $question->id, $answer->id, @$given_answers[$question->id] == $answer->id) !!}
												{{ $answer->text }}
												@if(@$validation && @$given_answers[$question->id] == $answer->id)
													@if($answer->is_correct)
														<span class="glyphicon glyphicon-ok" style="color:#329f07"></span>
													@else
														<span class="glyphicon glyphicon-remove" style="color:#af000d"></span>
													@endif
												@endif
											</label>
										</div>
									@endforeach

									@if(@$validation && @$validation[$question->id]['correct_answers'])
										<hr>
										<div class="correct-answers {{
												css([
													'spoiled' => $test->hasFeedback() || @$hasPassed || @$validation[$question->id]['correct'],
												])
											}}">
											<span class="glyphicon glyphicon-exclamation-sign"></span>
											<h4>Oikea vastaus:</h4>
											<ul>
												<li>{{ $validation[$question->id]['correct_answers']['text'] }}</li>
											</ul>
											<a class="spoiler-warning">
												Oikeat vastaukset piilotettu. Klikkaa tästä nähdäksesi.
											</a>
										</div>
									@endif
								<?php
									break;
									//--------------------------------------------------------------------------
									case 'TEXT':
								?>
									<div class="row {{
										css([
											'has-success' 	=> (isset($validation) && $validation[$question->id]['correct']),
											'has-error'		=> (isset($validation) && !$validation[$question->id]['correct']),
										])
									}}">
										<div class="col-xs-12">
											{!! Form::text('answer-' . $question->id, @$given_answers[$question->id], [
												'class' => 'form-control',
												'placeholder' => 'Vastaus tähän'
											]) !!}
											@if(@$validation)
												@if(@$validation[$question->id]['correct'])
													<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
												@else
													<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
												@endif
											@endif
										</div>
									</div>
									
									@if(isset($validation) && $validation[$question->id]['correct_answers'])
										<hr>
										<div class="correct-answers {{
												css([
													'spoiled' => $test->hasFeedback() || @$hasPassed || @$validation[$question->id]['correct'],
												])
											}}">
											<span class="glyphicon glyphicon-exclamation-sign"></span>
											<h4>Oikea vastaus:</h4>
											<ul>
												<li>{{ $validation[$question->id]['correct_answers']['text'] }}</li>
											</ul>
											<a class="spoiler-warning">
												Oikeat vastaukset piilotettu. Klikkaa tästä nähdäksesi.
											</a>
										</div>
									@endif
								<?php
									break;
									//--------------------------------------------------------------------------
									case 'MULTITEXT':
								?>
									<div class="multitext">
										<div class="tip alert alert-info">
											<span class="glyphicon glyphicon-exclamation-sign"></span> Vastauksien järjestyksellä ei ole väliä.
										</div>
										@for($i=0; $i < $question->answers->count(); ++$i)
											<div class="row {{
												css([
													'has-success' 	=> (isset($validation) && @$validation[$question->id]['correct_rows'][$i]),
													'has-error'		=> (isset($validation) && @!$validation[$question->id]['correct_rows'][$i]),
												])
											}}">
												<label for="answer-{{ $question->id .'-'. $i }}" class="col-xs-1 control-label">{{ $i+1 }}.</label>
												<div class="col-xs-11">
													{!! Form::text('answer-' . $question->id . '[]', @$given_answers[$question->id][$i], [
														'class' => 'form-control',
														'placeholder' => 'Vastaus tähän',
														'id' => 'answer-' . $question->id .'-'. $i
													]) !!}
													@if(@$validation)
														@if(@$validation[$question->id]['correct_rows'][$i])
	  														<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
	  													@else
															<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
	  													@endif
	  												@endif
												</div>
											</div>
										@endfor

										@if(isset($validation) && $validation[$question->id]['correct_answers'])
											<hr>
											<div class="correct-answers {{
												css([
													'spoiled' => $test->hasFeedback() || @$hasPassed || @$validation[$question->id]['correct'],
												])
											}}">
											<span class="glyphicon glyphicon-exclamation-sign"></span>
												<h4>Oikeat vastaukset:</h4>
												<ul>
													@foreach($validation[$question->id]['correct_answers'] as $answer)
														<li>{{ $answer['text'] }}</li>
													@endforeach
												</ul>
												<a class="spoiler-warning">
													Oikeat vastaukset piilotettu. Klikkaa tästä nähdäksesi.
												</a>
											</div>
										@endif
									</div>
								<?php
									break;
									//--------------------------------------------------------------------------
									case 'TEXTAREA':
								?>
								    {!! Form::textarea('answer-' . $question->id, @$given_answers[$question->id], [
								    	'class' => 'form-control',
								    	'placeholder' => 'Vastaus tähän'
								    ]) !!}

									@if(isset($validation))
										<hr>
										<div class="correct-answers spoiled">
											<span class="glyphicon glyphicon-exclamation-sign"></span>
											<h4>Hyväksytty kirjallinen vastaus:</h4>
											<ul>
												<li>Antamasi vastaus tarkistetaan erikseen, mutta sen ei tule olla tyhjä.</li>
											</ul>
										</div>
									@endif
								<?php
									break;
								?>
							<?php endswitch; ?>
							
							@if(@$feedback[$question->id])
								<div class="answer-feedback">
									<span class="glyphicon glyphicon-ok"></span>
									<h4>Vastauspalaute:</h4>
									<p>
										{!! nl2br($feedback[$question->id]) !!}
									</p>
								</div>
							@endif
						</div>
					</div>

				</div>
			@endforeach
		</fieldset>
		
		@if(!Auth::check() && !$errors->any())
			@yield('authentication_form')
		@endif
		
		<hr>
		<div class="form-group">
			<button class="btn btn-primary btn-block">
				@if(Auth::check())
					Tarkista vastaukset
				@elseif(!Auth::check())
					<span class="button-text button-text-register">Rekisteröidy</span>
					<span class="button-text button-text-login">Kirjaudu sisään</span>
					ja tarkista vastaukset
				@endif
			</button>
		</div>
	</form>

@endsection