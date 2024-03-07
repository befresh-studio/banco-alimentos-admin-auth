<?php

namespace Brackets\AdminAuth\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Inspiring;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Solicitante;
use App\Models\Miembro;
use App\Models\Informe;
use App\Models\Entidade;
use App\Models\Municipio;
use App\Models\TiposOar;

class AdminHomepageController extends Controller
{
    /**
     * Display default admin home page
     *
     * @return Factory|View
     */
    public function index()
    {
        $fecha_3_annos = Carbon::now()->subYears(3);
        $fecha_15_annos = Carbon::now()->subYears(15);

        $informes_vigente = 0;
        $informes_caducado = 0;
        $informes_1_mes_caducar = 0;
        $informes_no_necesita = 0;
        $informes_no_tiene = 0;

        if(Auth::user()->entidad) {
            $menores_3_annos = Miembro::whereIn('solicitante_id', Solicitante::where('entidad_id', Auth::user()->entidad->id)->pluck('id'))->where('fecha_nacimiento', '>', $fecha_3_annos)->count();
            $mayores_15_annos = Miembro::whereIn('solicitante_id', Solicitante::where('entidad_id', Auth::user()->entidad->id)->pluck('id'))->where('fecha_nacimiento', '<', $fecha_15_annos)->count();
            $entre_3_15_annos = Miembro::whereIn('solicitante_id', Solicitante::where('entidad_id', Auth::user()->entidad->id)->pluck('id'))->count() - $menores_3_annos - $mayores_15_annos;
            $solicitantes = Solicitante::where('entidad_id', Auth::user()->entidad->id)->get();

            $menores_3_annos_activos = Miembro::whereIn('solicitante_id', Solicitante::where('entidad_id', Auth::user()->entidad->id)->where('estado', '=', 1)->pluck('id'))->where('fecha_nacimiento', '>', $fecha_3_annos)->count();
            $mayores_15_annos_activos = Miembro::whereIn('solicitante_id', Solicitante::where('entidad_id', Auth::user()->entidad->id)->where('estado', '=', 1)->pluck('id'))->where('fecha_nacimiento', '<', $fecha_15_annos)->count();
            $entre_3_15_annos_activos = Miembro::whereIn('solicitante_id', Solicitante::where('entidad_id', Auth::user()->entidad->id)->where('estado', '=', 1)->pluck('id'))->count() - $menores_3_annos_activos - $mayores_15_annos_activos;
            $solicitantes_activos = Solicitante::where('entidad_id', Auth::user()->entidad->id)->where('estado', '=', 1)->get();


            $menores_3_annos_inactivos = Miembro::whereIn('solicitante_id', Solicitante::where('entidad_id', Auth::user()->entidad->id)->where('estado', '=', 0)->pluck('id'))->where('fecha_nacimiento', '>', $fecha_3_annos)->count();
            $mayores_15_annos_inactivos = Miembro::whereIn('solicitante_id', Solicitante::where('entidad_id', Auth::user()->entidad->id)->where('estado', '=', 0)->pluck('id'))->where('fecha_nacimiento', '<', $fecha_15_annos)->count();
            $entre_3_15_annos_inactivos = Miembro::whereIn('solicitante_id', Solicitante::where('entidad_id', Auth::user()->entidad->id)->where('estado', '=', 0)->pluck('id'))->count() - $menores_3_annos_inactivos - $mayores_15_annos_inactivos;
            $solicitantes_inactivos = Solicitante::where('entidad_id', Auth::user()->entidad->id)->where('estado', '=', 0)->get();

            foreach($solicitantes_activos as $solicitante) {
                if($solicitante->informeActual()->get()->count() > 0) {
                    switch($solicitante->informeActual()->get()[0]->estado_id) {
                        case 2: $informes_vigente++;
                                break;
                        case 3: $informes_caducado++;
                            break;
                        case 4: $informes_1_mes_caducar++;
                            break;
                        case 5: $informes_no_necesita++;
                            break;
                    }
                } else {
                    if($solicitante->informes->count() == 0)
                        $informes_no_tiene++;
                }
            }

            return view('brackets/admin-auth::admin.homepage.index', [
                'solicitantes' => count($solicitantes),
                'solicitantes_activos' => count($solicitantes_activos),
                'solicitantes_inactivos' => count($solicitantes_inactivos),
                'miembros' => Miembro::whereIn('solicitante_id', Solicitante::where('entidad_id', Auth::user()->entidad->id)->pluck('id'))->count(),
                'dnis_14_annos' => Miembro::whereIn('solicitante_id', Solicitante::where('entidad_id', Auth::user()->entidad->id)->pluck('id'))->where('dni', '=', '00000000')->where('fecha_nacimiento', '<', Carbon::now()->subYears(14))->count(),
                'dnis_16_annos' => Miembro::whereIn('solicitante_id', Solicitante::where('entidad_id', Auth::user()->entidad->id)->pluck('id'))->where('dni', '=', '00000000')->where('fecha_nacimiento', '<', Carbon::now()->subYears(16))->count(),
                //'dnis_18_annos' => Miembro::whereIn('solicitante_id', Solicitante::where('entidad_id', Auth::user()->entidad->id)->pluck('id'))->where('dni', '=', '00000000')->where('fecha_nacimiento', '<', Carbon::now()->subYears(18))->count(),
                //'informes' => Informe::whereIn('solicitante_id', Solicitante::where('entidad_id', Auth::user()->entidad->id)->pluck('id'))->count(),
                'informes_vigente' => $informes_vigente,
                'informes_caducado' => $informes_caducado,
                'informes_1_mes_caducar' => $informes_1_mes_caducar,
                'informes_no_necesita' => $informes_no_necesita,
                'informes_no_tiene' => $informes_no_tiene,
                'menores_3' => $menores_3_annos,
                'menores_3_activos' => $menores_3_annos_activos,
                'menores_3_inactivos' => $menores_3_annos_inactivos,
                'entre_3_15' => $entre_3_15_annos,
                'entre_3_15_activos' => $entre_3_15_annos_activos,
                'entre_3_15_inactivos' => $entre_3_15_annos_inactivos,
                'mayores_15' => $mayores_15_annos + count($solicitantes),
                'mayores_15_activos' => $mayores_15_annos_activos + count($solicitantes_activos),
                'mayores_15_inactivos' => $mayores_15_annos_inactivos + count($solicitantes_inactivos),
                //'inspiration' => Inspiring::quote()
            ]);
        } else {
            $menores_3_annos = Miembro::where('fecha_nacimiento', '>', $fecha_3_annos)->count();
            $mayores_15_annos = Miembro::where('fecha_nacimiento', '<', $fecha_15_annos)->count();
            $entre_3_15_annos = Miembro::all()->count() - $menores_3_annos - $mayores_15_annos;
            $solicitantes = Solicitante::all();

            $menores_3_annos_activos = Miembro::where('estado', '=', 1)->where('fecha_nacimiento', '>', $fecha_3_annos)->count();
            $mayores_15_annos_activos = Miembro::where('estado', '=', 1)->where('fecha_nacimiento', '<', $fecha_15_annos)->count();
            $entre_3_15_annos_activos = Miembro::where('estado', '=', 1)->count() - $menores_3_annos_activos - $mayores_15_annos_activos;
            $solicitantes_activos = Solicitante::where('estado', '=', 1)->get();


            $menores_3_annos_inactivos = Miembro::where('estado', '=', 0)->where('fecha_nacimiento', '>', $fecha_3_annos)->count();
            $mayores_15_annos_inactivos = Miembro::where('estado', '=', 0)->where('fecha_nacimiento', '<', $fecha_15_annos)->count();
            $entre_3_15_annos_inactivos = Miembro::where('estado', '=', 0)->count() - $menores_3_annos_inactivos - $mayores_15_annos_inactivos;
            $solicitantes_inactivos = Solicitante::where('estado', '=', 0)->get();

            $entidades = Entidade::all();
            $municipios = Municipio::all();
            $tipos = TiposOar::all();

            foreach($solicitantes as $solicitante) {
                if($solicitante->informeActual()->get()->count() > 0) {
                    switch($solicitante->informeActual()->get()[0]->estado_id) {
                        case 2: $informes_vigente++;
                                break;
                        case 3: $informes_caducado++;
                            break;
                        case 4: $informes_1_mes_caducar++;
                            break;
                        case 5: $informes_no_necesita++;
                            break;
                    }
                } else {
                    if($solicitante->informes->count() == 0)
                        $informes_no_tiene++;
                }
            }

            foreach($municipios as $municipio) {
                if($municipio->entidadesAlmacenes->count() > 0)
                    $municipios_entidades[] = array('nombre' => $municipio->municipio, 'entidades' => $municipio->entidadesAlmacenes->count());
            }

            foreach($tipos as $tipo) {
                if($tipo->entidades->count() > 0)
                    $tipos_entidades[] = array('nombre' => $tipo->descripcion, 'entidades' => $tipo->entidades->count());
            }

            return view('brackets/admin-auth::admin.homepage.index', [
                'solicitantes' => count($solicitantes),
                'solicitantes_activos' => count($solicitantes_activos),
                'solicitantes_inactivos' => count($solicitantes_inactivos),
                'entidades' => count($entidades),
                'municipios_entidades' => $municipios_entidades,
                'tipos_entidades' => $tipos_entidades,
                //'informes' => Informe::all()->count(),
                'informes_vigente' => $informes_vigente,
                'informes_caducado' => $informes_caducado,
                'informes_1_mes_caducar' => $informes_1_mes_caducar,
                'informes_no_necesita' => $informes_no_necesita,
                'informes_no_tiene' => $informes_no_tiene,
                'menores_3' => $menores_3_annos,
                'menores_3_activos' => $menores_3_annos_activos,
                'menores_3_inactivos' => $menores_3_annos_inactivos,
                'entre_3_15' => $entre_3_15_annos,
                'entre_3_15_activos' => $entre_3_15_annos_activos,
                'entre_3_15_inactivos' => $entre_3_15_annos_inactivos,
                'mayores_15' => $mayores_15_annos + count($solicitantes),
                'mayores_15_activos' => $mayores_15_annos_activos + count($solicitantes_activos),
                'mayores_15_inactivos' => $mayores_15_annos_inactivos + count($solicitantes_inactivos),
                //'inspiration' => Inspiring::quote()
            ]);
        }
    }
}
