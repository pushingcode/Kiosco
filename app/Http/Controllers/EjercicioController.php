<?php

namespace App\Http\Controllers;

use App\Ejercicio;
use App\User;
use App\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Gate;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Carbon;

class EjercicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FormBuilder $formBuilder)
    {
        //
        $ejercicios = Ejercicio::all();
        //dd($ejercicios);
        $form = $formBuilder->create(\App\Forms\ConfirmActionForm::class, [
            'method' => 'POST',
            'url' => '' //se deja vacio porque se trabajara con JQuery
        ]);

        return view('admin.viewEjercicios', compact('ejercicios', 'form'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Kris\LaravelFormBuilder\FormBuilder  $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        //permisos
        $user = User::find(Auth::id());
        if (!$user->can('crear-ejercicio')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        $model = Config::firstOrFail();

        $model = $model->toArray();
        
        $form = $formBuilder->create(\App\Forms\NuevoEjerForm::class, [
            'method'    => 'POST',
            'url'       => route('ejercicio.store')
        ], [
            'model'     => $model['id']
        ]);

        $decript = 'Segun la ley, las actividades economicas regulares 
        deberan estar comprendidos en un periodo de 12 meses continuos,
         de lo contrario se considera una actividad irregular. 
         Consulte con su contador para escoger la forma que mas le convenga';

        return view('admin.createConfig', compact('form', 'decript'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find(Auth::id());
        if (!$user->can('crear-ejercicio')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        //$form = $formBuilder->create(\App\Forms\NuevoEjerForm::class);

        //if (!$form->isValid()) {
         //   return redirect()->back()->withErrors($form->getErrors())->withInput();
        //}

        //$input = $form->getFieldValues();
        //validamos si existen periodos abiertos
        //validamos si el periodo abierto esta en posibilidad de cierre

        $ejercicio = Ejercicio::where('estado', '=', 'abierto')->get();
        if ($ejercicio->isEmpty()) {
            //no existe ninguno abierto
            //creamos el ejercicio nuevo
            $ejercicio = new Ejercicio();

            $ejercicio->conf_id     = $request->conf;
            $ejercicio->inicio      = $request->inicio;
            $ejercicio->fin         = $request->fin;
            $ejercicio->tipo        = $request->tipo;
            $ejercicio->estado      = $request->estado;

            $ejercicio->save();
            return redirect()
            ->back()
            ->with('creado ejercicio de '. $request->inicio .' al '. $request->fin);
            
        } else {
            # code...
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ejercicio  $ejercicio
     * @return \Illuminate\Http\Response
     */
    public function show(Ejercicio $ejercicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ejercicio  $ejercicio
     * @return \Illuminate\Http\Response
     */
    public function edit(Ejercicio $ejercicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ejercicio  $ejercicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ejercicio $ejercicio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ejercicio  $ejercicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormBuilder $formBuilder, Ejercicio $ejercicio)
    {
        //
        $user = User::find(Auth::id());
        if (!$user->can('eliminar-empresa')) {
            return redirect()->back()->withErrors('Permisos insuficientes');
        }

        $form = $formBuilder->create(\App\Forms\ConfirmActionForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $input = $form->getFieldValues();

        if (!Hash::check($input['password'], Auth::user()->password)) {

            activity('danger')
            ->performedOn($ejercicio)
            ->causedBy($user)
            ->withProperties(['accion' => 'cierre ejercicio'])
            ->log('Validacion NO aprobada');

            return redirect()->back()->withErrors('Password Incorrecto');
        }
        $date = Carbon::parse($ejercicio->fin);

        if (!$date->isPast()) {
            $ejercicio->tipo = 'irregular';
        }

        $ejercicio->estado = 'cerrado';
        $ejercicio->save();

        return redirect()
        ->route('ejercicio', 302)
        ->with('Ejercicio economico '.$ejercicio->inicio.' cerrado de forma '. $ejercicio->tipo);
    }
}
