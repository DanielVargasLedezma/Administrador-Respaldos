<?php

namespace App\Http\Controllers;

use App\Http\Requests\DumpFileRequest;
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

        $cmd = "EXPDP administrador_fachero/root1234@XE SCHEMAS=" . $schema . " DIRECTORY=RESPALDO DUMPFILE=" . $schema . ".DMP LOGFILE=" . $schema . ".LOG";

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

        $cmd = "EXPDP administrador_fachero/root1234@XE TABLES=" . $schema . "." . $table . " DIRECTORY=RESPALDO DUMPFILE=" . $schema . $table . ".DMP LOGFILE=" . $schema . $table . ".LOG";

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

    /**
     * Receives the DUMP file and recovers a schema backup.
     * 
     * @return \Illuminate\Http\Response
     */
    public function recoverSchemaBackUp(DumpFileRequest $request, $schema)
    {
        $request->validated();

        DB::statement('alter session set "_oracle_script"=true');

        DB::statement("CREATE OR REPLACE DIRECTORY RECUPERACION AS " . "'" . public_path() . "\\respaldos\\restore'");

        $newFileName = $schema . '.' . $request->file->extension();

        $request->file->move(public_path('respaldos\\restore'), $newFileName);

        $cmd = "IMPDP administrador_fachero/root1234@XE SCHEMAS=" . $schema . " DIRECTORY=RECUPERACION DUMPFILE=" . $schema . ".DMP LOGFILE=" . $schema . ".LOG";

        shell_exec($cmd);

        $path = 'respaldos/restore/' . $schema . ".LOG";

        return response()->download($path);
    }

    /**
     * Delete the DUMP and LOG file received for the recover of a certain $schema.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteRecoverSchemaBackUp($schema)
    {
        $path = 'respaldos/restore/' . $schema . '.DMP';

        File::delete($path);

        $path = 'respaldos/restore/' . $schema . '.LOG';

        File::delete($path);

        return response(null, 204);
    }

    /**
     * Createa a tablespace with a certain $request->input('name').
     *
     * @return \Illuminate\Http\Response
     */
    public function createTablespace(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
        ]);

        DB::statement('alter session set "_oracle_script"=true');

        DB::statement("CREATE TABLESPACE " . $fields['name'] . " DATAFILE '" . public_path() . "\\tablespaces\\" . $fields['name'] . ".DBF' SIZE 100M AUTOEXTEND ON NEXT 50");

        return response(['message' => 'Tablespace creado con éxito'], 201);
    }

    /**
     * Create a tablespace with a certain $request->input('name').
     *
     * @return \Illuminate\Http\Response
     */
    public function createTemporaryTablespace(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
        ]);

        DB::statement('alter session set "_oracle_script"=true');

        DB::statement("CREATE TEMPORARY TABLESPACE " . $fields['name'] . "_TEMP TEMPFILE '" . public_path() . "\\tablespaces\\" . $fields['name'] . "_TEMP.DBF' SIZE 25M AUTOEXTEND ON NEXT 50");

        return response(['message' => 'Tablespace creado con éxito'], 201);
    }

    /**
     * Returns the public path of respaldos.
     *
     * @return \Illuminate\Http\Response
     */
    public function publicPath()
    {
        return response(['path' => public_path() . "\\respaldos"], 200);
    }

    /**
     * Delete a certain $tablespace.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteTablespace($tablespace)
    {
        DB::statement('alter session set "_oracle_script"=true');

        DB::statement("DROP TABLESPACE " . $tablespace . " INCLUDING CONTENTS AND DATAFILES");

        return response(null, 204);
    }

    /**
     * Display a listing of the tablespaces.
     *
     * @return \Illuminate\Http\Response
     */
    public function tablespaces()
    {
        return DB::table('USER_TABLESPACES')
            ->select('TABLESPACE_NAME')
            ->get();
    }

    /**
     * Display a listing of the columns of a certain $table of a certain $schema.
     *
     * @return \Illuminate\Http\Response
     */
    public function columnOfATableOfASchema($schema, $table)
    {
        return DB::select("select column_name from all_tab_columns where table_name ='" . $table . "' AND OWNER ='" . $schema . "'");
    }

    /**
     * Resize a certain $tablespace.
     *
     * @return \Illuminate\Http\Response
     */
    public function resizeTablespace(Request $request)
    {
        $fields = $request->validate([
            "tablespace" => "required",
            "size" => "required",
        ]);

        DB::statement('alter session set "_oracle_script"=true');

        $resultado = DB::table("v\$datafile")
            ->select("NAME")
            ->where("NAME", "LIKE", "%" . $fields['tablespace'] . "%")
            ->get();

        $resultado = $resultado[0]->name;

        DB::statement("ALTER DATABASE DATAFILE '$resultado' resize " . $fields['size'] . "M");

        return response(['route' => 'Resize exitoso'], 200);
    }

    /**
     * Resize a certain $tablespace.
     *
     * @return \Illuminate\Http\Response
     */
    public function resizeTemporaryTablespace(Request $request)
    {
        $fields = $request->validate([
            "tablespace" => "required",
            "size" => "required",
        ]);

        DB::statement('alter session set "_oracle_script"=true');

        $resultado = DB::table("v\$tempfile")
            ->select("NAME")
            ->where("NAME", "LIKE", "%" . $fields['tablespace'] . "%")
            ->get();

        $resultado = $resultado[0]->name;

        DB::statement("ALTER DATABASE DATAFILE '$resultado' resize " . $fields['size'] . "M");

        return response(['route' => 'Resize exitoso'], 200);
    }


    public function createEstadisticaSchema(Request $request)
    {
        $fields = $request->validate([
            "schema" => "required",
        ]);

        $schema = $fields['schema'];

        DB::statement('alter session set "_oracle_script"=true');

        DB::raw("EXECUTE dbms_stats.gather_schema_stats('$schema' ,cascade=> true)");

        return response(null, 204);
    }
    public function createEstadisticaTabla(Request $request)
    {
        $fields = $request->validate([
            "schema" => "required",
            "tabla" => "required",
        ]);

        $schema = $fields['schema'];

        $tabla = $fields['tabla'];

        DB::statement('alter session set "_oracle_script"=true');

        DB::raw("EXECUTE dbms_stats.gather_table_stats('$schema', '$tabla' ,cascade=> true)");

        return response(null, 204);
    }

    public function doMonitoreoEstado()
    {
        return DB::table("V\$INSTANCE")
            ->select()
            ->get();
    }

    public function doMonitoreoParametros()
    {
        return DB::table("V\$system_parameter")
            ->select('name', 'value', 'description')
            ->get();
    }

    public function doMonitoreoConexiones()
    {
        return DB::table("V\$session")
            ->select('osuser', 'username', 'machine', 'program')
            ->where('username', '<>', null)
            ->get();
    }

    /**
     * Resize a certain $tablespace.
     *
     * @return \Illuminate\Http\Response
     */
    public function createIndexOnColumnOfTableOfSchema(Request $request)
    {
        $fields = $request->validate([
            "schema" => "required",
            "table" => "required",
            "campos" => "required",
        ]);

        DB::statement('alter session set "_oracle_script"=true');

        $validacion = DB::table('USER_TABLESPACES')
            ->select('TABLESPACE_NAME')
            ->where('TABLESPACE_NAME', 'INDEX_DATA')
            ->get();

        if (!$validacion) {
            DB::statement("CREATE TABLESPACE INDEX_DATA DATAFILE '" . public_path() . "\\tablespaces\\INDEX_DATA.DBF' SIZE 125M AUTOEXTEND ON NEXT 50");
        }

        $campos = explode(', ', $fields['campos']);

        $query = "CREATE INDEX " . $fields['schema'] . "_" . $fields['table'] . "_" . time() . " ON " . $fields['schema'] . "." . $fields['table'] . "(" . $fields['campos'] . ") TABLESPACE INDEX_DATA";

        DB::statement($query);

        return response(['message' => 'Index creado con éxito'], 201);
    }

    /**
     * Analize all the tables of a schema.
     *
     * @return \Illuminate\Http\Response
     */
    public function analizeSchema(Request $request)
    {
        $fields = $request->validate([
            "schema" => "required",
        ]);

        DB::statement('alter session set "_oracle_script"=true');

        $tablas = DB::table('all_tables')
            ->select('table_name')
            ->where('owner', $fields['schema'])
            ->orderBy('table_name')
            ->get();

        foreach ($tablas as $tabla) {
            DB::statement("ANALYZE TABLE " . $fields['schema'] . "." . $tabla->table_name . " COMPUTE STATISTICS");
        }

        return response(['message' => 'Tablas re-analizadas'], 200);
    }

    /**
     * Analize a table the tables of a schema.
     *
     * @return \Illuminate\Http\Response
     */
    public function analizeTableOfSchema(Request $request)
    {
        $fields = $request->validate([
            "schema" => "required",
            "tabla" => "required",
        ]);

        DB::statement('alter session set "_oracle_script"=true');

        DB::statement("ANALYZE TABLE " . $fields['schema'] . "." . $fields['tabla'] . " COMPUTE STATISTICS");

        return response(['message' => 'Tablas re-analizadas'], 200);
    }
}
