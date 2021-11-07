<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StronkController extends Controller
{
    /**
     * Display a listing of the schemas.
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
     * Display a listing of the tables of a certain $schema.
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
     * Generate a DUMP file of the $schema.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSchemaBackUp($schema)
    {
        DB::statement('alter session set "_oracle_script"=true');

        // DB::statement("CREATE OR REPLACE DIRECTORY RESPALDO AS 'D:\Trabajos_U\II_semestre_2021\Administracion_Bases\Proyectos\Proyecto_1\Administrador-Respaldos\Adminstrador-Respaldos-Backend\public\respaldos'");

        DB::statement("CREATE OR REPLACE DIRECTORY RESPALDO AS " . "'" . public_path() . "\\respaldos'");

        // DB::statement('GRANT READ, WRITE ON DIRECTORY RESPALDO TO administrador_fachero');

        $cmd = "EXPDP administrador_fachero/root1234@XE SCHEMAS=". $schema . " DIRECTORY=RESPALDO DUMPFILE=" . $schema .".DMP LOGFILE=". $schema .".LOG";

        shell_exec($cmd);

        $path = 'respaldos/' . $schema . '.DMP';

        return response()->download($path);
    }

    /**
     * Delete the DUMP and LOG file created for the backup of a certain $schema.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteSchemaBackUp($schema)
    {
        $path = 'respaldos/' . $schema . '.DMP';

        File::delete($path);

        $path = 'respaldos/' . $schema . '.LOG';

        File::delete($path);

        return response(null, 204);
    }

    /**
     * Create a back up of a certain $table of a certain $schema.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTableOfSchemaBackUp($schema, $table)
    {
        DB::statement('alter session set "_oracle_script"=true');

        // DB::statement("CREATE OR REPLACE DIRECTORY RESPALDO AS 'D:\Trabajos_U\II_semestre_2021\Administracion_Bases\Proyectos\Proyecto_1\Administrador-Respaldos\Adminstrador-Respaldos-Backend\public\respaldos'");

        DB::statement("CREATE OR REPLACE DIRECTORY RESPALDO AS " . "'" . public_path() . "\\respaldos'");

        // DB::statement('GRANT READ, WRITE ON DIRECTORY RESPALDO TO administrador_fachero');

        $cmd = "EXPDP administrador_fachero/root1234@XE TABLES=". $schema . "." . $table ." DIRECTORY=RESPALDO DUMPFILE=" . $schema . $table .".DMP LOGFILE=". $schema . $table .".LOG";

        shell_exec($cmd);

        $path = 'respaldos/' . $schema . $table . '.DMP';

        return response()->download($path);
    }

    /**
     * Delete the DUMP and LOG file created for the backup of a certain $schema.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteTableOfSchemaBackUp($schema, $table)
    {
        $path = 'respaldos/' . $schema . $table . '.DMP';

        File::delete($path);

        $path = 'respaldos/' . $schema . $table . '.LOG';

        File::delete($path);

        return response(null, 204);
    }

    /**
     * Create a back up of the whole database.
     *
     * @return \Illuminate\Http\Response
     */
    public function createDatabaseBackUp()
    {
        DB::statement('alter session set "_oracle_script"=true');

        // DB::statement("CREATE OR REPLACE DIRECTORY RESPALDO AS 'D:\Trabajos_U\II_semestre_2021\Administracion_Bases\Proyectos\Proyecto_1\Administrador-Respaldos\Adminstrador-Respaldos-Backend\public\respaldos'");

        DB::statement("CREATE OR REPLACE DIRECTORY RESPALDO AS " . "'" . public_path() . "\\respaldos'");

        // DB::statement('GRANT READ, WRITE ON DIRECTORY RESPALDO TO administrador_fachero');

        $cmd = "EXPDP administrador_fachero/root1234@XE FULL=Y  DIRECTORY=RESPALDO DUMPFILE=XE.DMP LOGFILE=XE.LOG";

        shell_exec($cmd);

        $path = 'respaldos/XE.DMP';

        return response()->download($path);
    }

    /**
     * Delete the DUMP and LOG file created for the backup of the database.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteDatabaseBackUp()
    {
        $path = 'respaldos/XE.DMP';

        File::delete($path);

        $path = 'respaldos/XE.LOG';

        File::delete($path);

        return response(null, 204);
    }
}
