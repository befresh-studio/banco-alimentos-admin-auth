@extends('brackets/admin-ui::admin.layout.default')

@section('body')

	{{--<div class="welcome-quote">

		<blockquote>
			{{ explode(" - ", $inspiration)[0] }}
			<cite>
				{{ explode(" - ", $inspiration)[1] }}
			</cite>
		</blockquote>

	</div>--}}

	@if(Auth::user()->entidad)
		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header">
						<i class="fa fa-user"></i> {{ trans('admin.dashboard.titles.solicitantes') }}
					</div>
					<div class="card-body">
						<h4>
							{{ $solicitantes }} {{ trans('admin.dashboard.titles.solicitantes') }}
						</h4>
						<ul>
							<li><strong>{{ trans('admin.dashboard.titles.menores_3') }}:</strong> {{ $menores_3 }}</li>
							<li><strong>{{ trans('admin.dashboard.titles.de_3_a_15_annos') }}:</strong> {{ $entre_3_15 }}</li>
							<li><strong>{{ trans('admin.dashboard.titles.mayores_15') }}:</strong> {{ $mayores_15 }}</li>
						</ul>
						<p>{{ trans('admin.dashboard.titles.total_beneficiarios') }}: {{ $menores_3 + $entre_3_15 + $mayores_15 }}</p>

						<div class="row">
							<div class="col">
								<h5>
									{{ $solicitantes_activos }} {{ trans('admin.dashboard.titles.solicitantes_activos') }}
								</h5>
								<ul>
									<li><strong>{{ trans('admin.dashboard.titles.menores_3') }}:</strong> {{ $menores_3_activos }}</li>
									<li><strong>{{ trans('admin.dashboard.titles.de_3_a_15_annos') }}:</strong> {{ $entre_3_15_activos }}</li>
									<li><strong>{{ trans('admin.dashboard.titles.mayores_15') }}:</strong> {{ $mayores_15_activos }}</li>
								</ul>
								<p>{{ trans('admin.dashboard.titles.total_beneficiarios') }}: {{ $menores_3_activos + $entre_3_15_activos + $mayores_15_activos }}</p>
							</div>
							<div class="col">
								<h5>
									{{ $solicitantes_inactivos }} {{ trans('admin.dashboard.titles.solicitantes_inactivos') }}
								</h5>
								<ul>
									<li><strong>{{ trans('admin.dashboard.titles.menores_3') }}:</strong> {{ $menores_3_inactivos }}</li>
									<li><strong>{{ trans('admin.dashboard.titles.de_3_a_15_annos') }}:</strong> {{ $entre_3_15_inactivos }}</li>
									<li><strong>{{ trans('admin.dashboard.titles.mayores_15') }}:</strong> {{ $mayores_15_inactivos }}</li>
								</ul>
								<p>{{ trans('admin.dashboard.titles.total_beneficiarios') }}: {{ $menores_3_inactivos + $entre_3_15_inactivos + $mayores_15_inactivos }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col">
				<div class="card">
					<div class="card-header">
						<i class="fa fa-user"></i> {{ trans('admin.dashboard.titles.informes') }}
					</div>
					<div class="card-body">
						<h4>
							{{ ($informes_vigente + $informes_caducado + $informes_1_mes_caducar) }} {{ trans('admin.dashboard.titles.informes') }}
						</h4>
						<ul>
							<li><strong>{{ trans('admin.dashboard.titles.informes_vigente') }}:</strong> {{ $informes_vigente }}</li>
							<li><strong>{{ trans('admin.dashboard.titles.informes_caducado') }}:</strong> {{ $informes_caducado }}</li>
							<li><strong>{{ trans('admin.dashboard.titles.informes_1_mes_caducar') }}:</strong> {{ $informes_1_mes_caducar }}</li>
							<li><strong>{{ trans('admin.dashboard.titles.informes_no_necesita') }}:</strong> {{ $informes_no_necesita }}</li>
							<li><strong>{{ trans('admin.dashboard.titles.informes_no_tiene') }}:</strong> {{ $informes_no_tiene }}</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="col">
				<div class="card">
					<div class="card-header">
						<i class="fa fa-user"></i> {{ trans('admin.dashboard.titles.dnis_no_validos') }}
					</div>
					<div class="card-body">
						<h4>
							{{ $dnis_14_annos }} {{ trans('admin.dashboard.titles.dnis_14_annos') }}
						</h4>
						<h4>
							{{ $dnis_16_annos }} {{ trans('admin.dashboard.titles.dnis_16_annos') }}
						</h4>
					</div>
				</div>
			</div>
		</div>
	@else
		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header">
						<i class="fa fa-sitemap"></i> {{ trans('admin.dashboard.titles.entidades') }}
					</div>
					<div class="card-body">
						<h4>
							{{ $entidades }} {{ trans('admin.dashboard.titles.entidades') }}
						</h4>
						<p>{{ trans('admin.dashboard.titles.municipios') }}</p>
						<ul>
							@foreach($municipios_entidades as $municipio_entidad)
								<li><strong>{{ $municipio_entidad['nombre'] }}:</strong> {{ $municipio_entidad['entidades'] }}</li>
							@endforeach
						</ul>
						<p>{{ trans('admin.dashboard.titles.tipos_entidades') }}</p>
						<ul>
							@foreach($tipos_entidades as $tipo_entidad)
								<li><strong>{{ $tipo_entidad['nombre'] }}:</strong> {{ $tipo_entidad['entidades'] }}</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>

			<div class="col">
				<div class="card">
					<div class="card-header">
						<i class="fa fa-user"></i> {{ trans('admin.dashboard.titles.solicitantes') }}
					</div>
					<div class="card-body">
						<h4>
							{{ $solicitantes }} {{ trans('admin.dashboard.titles.solicitantes') }}
						</h4>
						<ul>
							<li><strong>{{ trans('admin.dashboard.titles.menores_3') }}:</strong> {{ $menores_3 }}</li>
							<li><strong>{{ trans('admin.dashboard.titles.de_3_a_15_annos') }}:</strong> {{ $entre_3_15 }}</li>
							<li><strong>{{ trans('admin.dashboard.titles.mayores_15') }}:</strong> {{ $mayores_15 }}</li>
						</ul>
						<p>{{ trans('admin.dashboard.titles.total_beneficiarios') }}: {{ $menores_3 + $entre_3_15 + $mayores_15 }}</p>

						<div class="row">
							<div class="col">
								<h5>
									{{ $solicitantes_activos }} {{ trans('admin.dashboard.titles.solicitantes_activos') }}
								</h5>
								<ul>
									<li><strong>{{ trans('admin.dashboard.titles.menores_3') }}:</strong> {{ $menores_3_activos }}</li>
									<li><strong>{{ trans('admin.dashboard.titles.de_3_a_15_annos') }}:</strong> {{ $entre_3_15_activos }}</li>
									<li><strong>{{ trans('admin.dashboard.titles.mayores_15') }}:</strong> {{ $mayores_15_activos }}</li>
								</ul>
								<p>{{ trans('admin.dashboard.titles.total_beneficiarios') }}: {{ $menores_3_activos + $entre_3_15_activos + $mayores_15_activos }}</p>
							</div>
							<div class="col">
								<h5>
									{{ $solicitantes_inactivos }} {{ trans('admin.dashboard.titles.solicitantes_inactivos') }}
								</h5>
								<ul>
									<li><strong>{{ trans('admin.dashboard.titles.menores_3') }}:</strong> {{ $menores_3_inactivos }}</li>
									<li><strong>{{ trans('admin.dashboard.titles.de_3_a_15_annos') }}:</strong> {{ $entre_3_15_inactivos }}</li>
									<li><strong>{{ trans('admin.dashboard.titles.mayores_15') }}:</strong> {{ $mayores_15_inactivos }}</li>
								</ul>
								<p>{{ trans('admin.dashboard.titles.total_beneficiarios') }}: {{ $menores_3_inactivos + $entre_3_15_inactivos + $mayores_15_inactivos }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col">
				<div class="card">
					<div class="card-header">
						<i class="fa fa-file-o"></i> {{ trans('admin.dashboard.titles.informes') }}
					</div>
					<div class="card-body">
						<h4>
							{{ ($informes_vigente + $informes_caducado + $informes_1_mes_caducar) }} {{ trans('admin.dashboard.titles.informes') }}
						</h4>
						<ul>
							<li><strong>{{ trans('admin.dashboard.titles.informes_vigente') }}:</strong> {{ $informes_vigente }}</li>
							<li><strong>{{ trans('admin.dashboard.titles.informes_caducado') }}:</strong> {{ $informes_caducado }}</li>
							<li><strong>{{ trans('admin.dashboard.titles.informes_1_mes_caducar') }}:</strong> {{ $informes_1_mes_caducar }}</li>
							<li><strong>{{ trans('admin.dashboard.titles.informes_no_necesita') }}:</strong> {{ $informes_no_necesita }}</li>
							<li><strong>{{ trans('admin.dashboard.titles.informes_no_tiene') }}:</strong> {{ $informes_no_tiene }}</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	@endif

@endsection