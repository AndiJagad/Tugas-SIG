<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marker;
use App\Models\Polygon;
use DB;
use Yajra\DataTables\Facades\DataTables;

class PetaCRUDController extends Controller
{
    public function index()
    {
        return view('crud');
    }

    public function getListMarker(Request $request)
    {
        DB::statement('set @rownum = 0'); // Menggunakan string langsung
        $data = Marker::select([DB::raw('@rownum  := @rownum  + 1 AS no'), 'markers.*']);
        
        $datatables = Datatables::of($data);
        return $datatables
            ->filter(function($query) use($request) {
                $query->where('name', 'LIKE', '%' . $request->get('search')['value'] . '%');
            })
            ->addcolumn('action', function($data) {
                $btn = '<div class="btn-group">';
                $btn .= '<span class="btn btn-primary" onClick="#" data-toggle="tooltip" data-placement="top" title="Google API"><i class="fa fa-eye"></i></span>';
                $btn .= '<span class="btn btn-primary" onClick="#" data-toggle="tooltip" data-placement="top" title="Leaflet"><i class="fa fa-eye"></i></span>';
                $btn .= '<span class="btn btn-primary" onClick="edit_data(' . $data->id . ')" data-toggle="tooltip" data-placement="top" title="Edit Data"><i class="fa fa-edit"></i></span>';
                $btn .= '<span class="btn btn-danger" onClick="delete_data(' . $data->id . ')" data-toggle="tooltip" data-placement="top" title="Hapus Data"><i class="fa fa-times"></i></span>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }


    public function getListPolygon(Request $request)
    {
        DB::statement('set @rownum = 0'); // Gunakan string langsung di sini
        $data = Polygon::select([DB::raw('@rownum  := @rownum  + 1 AS no'), 'polygons.*']);

        $datatables = Datatables::of($data);
        return $datatables
            ->addColumn('action', function($data) {
                $btn = '<div class="btn-group">';
                $btn .= '<span class="btn btn-primary" onClick="#" data-toggle="tooltip" data-placement="top" title="Google API"><i class="fa fa-eye"></i></span>';
                $btn .= '<span class="btn btn-primary" onClick="#" data-toggle="tooltip" data-placement="top" title="Leaflet"><i class="fa fa-eye"></i></span>';
                $btn .= '<span class="btn btn-primary" onClick="edit_data('.$data->id.')" data-toggle="tooltip" data-placement="top" title="Edit Data"><i class="fa fa-edit"></i></span>';
                $btn .= '<span class="btn btn-danger" onClick="delete_data('.$data->id.')" data-toggle="tooltip" data-placement="top" title="Hapus Data"><i class="fa fa-times"></i></span>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }
}
