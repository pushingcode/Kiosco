<?php

namespace App\UtilidadesClass;

use App\Ejercicio;
use Carbon\Carbon;


/**
 * This is a Summary.
 *
 * This is a Description. It may span multiple lines
 * or contain 'code' examples using the _Markdown_ markup
 * language.
 *
 * @see Markdown
 *
 * @param int        $parameter1 A parameter description.
 * @param \Exception $e          Another parameter description.
 *
 * @\Doctrine\Orm\Mapper\Entity()
 *
 * @return string
 */
Class UtilidadesClass
{
    //
    /**
     * This is a Summary.
     *
     * This is a Description. It may span multiple lines
     * or contain 'code' examples using the _Markdown_ markup
     * language.
     *
     * @see Markdown
     *
     * @param string        $controlador.
     * @param \Exception $e          Another parameter description.
     *
     * @\Doctrine\Orm\Mapper\Entity()
     *
     * @return string
     */
    public static function checkEjercicio($controlador)
    {
        //paso 1 verificamos que el ejercicio existe
        //paso 2 verificamos el estado del ejercicio
            //Si el ejercicio se encuentra vencido
            //mandamos a renovar via route
            //Si el ejercicio esta ok terminamos
        $record = Ejercicio::all();
        if ($record->isEmpty()) {
            $result = false;
        } else {
            $record = Ejercicio::orderBy('created_at', 'desc')->first();

            $fiscal = $record->toArray();
            $dateIni = Carbon::parse($fiscal['inicio']);
            $dateFin = Carbon::parse($fiscal['fin']);
            $preMessage = 'No es posible iniciar '. $controlador .'.';

            if ($fiscal['estado'] == 'abierto' && $dateIni->isFuture()) {
                $result = [
                    'estado'=> false,
                    'razon' => $preMessage .' El ejercicio inicia en el futuro '. $dateIni->diffForHumans()
                ];
            } elseif ($fiscal['estado'] == 'abierto' && $dateFin->isPast()) {
                $result = [
                    'estado'=> false,
                    'razon' => $preMessage .' El ejercicio esta vencido desde '. $dateFin->diffForHumans()
                ];
            } elseif ($fiscal['estado'] == 'cerrado') {
                $result = [
                    'estado'=> false,
                    'razon' => $preMessage.' El ejercicio esta cerrado'
                ];;
            } else {
                $result = [
                    'estado'=>true,
                    'razon' =>'esta ok'
                ];
            }
        }
        return $result;
        
    }
}