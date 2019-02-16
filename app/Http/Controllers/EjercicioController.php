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

class EjercicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ejercicios = Ejercicio::all();
        //dd($ejercicios);
        return view('admin.viewEjercicios', compact('ejercicios'));
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

        $form = $formBuilder->create(\App\Forms\ConFiscForm::class);

        $input = $form->getFieldValues();
        $model = Config::find($input['conf']);
        
        unset($form);
        
        $form = $formBuilder->create(\App\Forms\NuevoEjerForm::class, [
            'method' => 'POST',
            'model' => $model,
            'url' => route('ejercicio.store')
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
    public function destroy(Ejercicio $ejercicio)
    {
        //
    }
}
