<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StronkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function schemas()
    {
        return DB::select(
            'select username as schema_name
            from sys.dba_users
            order by username'
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tablasDeSchemas($schema)
    {
        return DB::table('all_tables')
            ->select('table_name')
            ->where('owner', $schema)
            ->orderBy('table_name')
            ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSchemaBackUp($schema)
    {
        DB::statement('alter session set "_oracle_script"=true');

        // DB::statement("CREATE OR REPLACE DIRECTORY RESPALDO AS 'D:\Trabajos_U\II_semestre_2021\Administracion_Bases\Proyectos\Proyecto_1\Administrador-Respaldos\Adminstrador-Respaldos-Backend\public\respaldos'");

        DB::statement("CREATE OR REPLACE DIRECTORY RESPALDO AS " . "'" . public_path() . "\\respaldos'");

        // DB::statement('
        //     GRANT READ, WRITE ON DIRECTORY RESPALDO 
        //     TO administrador_fachero
        // ');

        $cmd = "EXPDP administrador_fachero/root1234@XE SCHEMAS=". $schema . "DIRECTORY=RESPALDO DUMPFILE=" . $schema .".DMP LOGFILE=". $schema .".LOG";

        shell_exec($cmd);

        return response(
            [
                'route' => public_path()
            ]
            , 200
        );
    }
}
