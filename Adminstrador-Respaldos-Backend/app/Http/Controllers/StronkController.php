<?php

namespace App\Http\Controllers;

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
    public function tablasDeSchemas(Request $request)
    {
        return DB::select(
            'select table_name from all_tables where owner = ? order by table_name', 
            [$request->input('schema_name')]
        );
        return DB::table('all_tables')
            ->select('table_name')
            ->where('owner', $request->input('schema_name'))
            ->orderBy('table_name')
            ->get();
    }
}
