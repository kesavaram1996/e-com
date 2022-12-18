<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesPerson;
use App\Models\DailyLog;
use App\Models\SalesVisit;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class DailyLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin_id = auth()->user()->id;
        $sales = SalesPerson::where('admin_id',$admin_id )->get();
        if ($request->ajax()) {
            $data = DailyLog::with('getsales')->where('admin_id',$admin_id )->whereDate('created_at', Carbon::today())->get();

            if($request->get('end_date') != null || $request->get('search') != null || $request->get('sales_filter') != null){
                $query = DailyLog::with('getsales')->where('admin_id',$admin_id );
                // Date Filter
                if ($request->get('end_date') != null){
                    $start_date = $request->get('start_date');
                    $end_date = $request->get('end_date');
                    $query->whereBetween('created_at', [$start_date, $end_date]);
                }
                // search Filter
                if ($request->get('search') != null){
                    $query->where('id', 'like', '%'.$request->get('search').'%');
                }
                
                // sales Filter
                if ($request->get('sales_filter') != null){
                    $query->where('user_id',$request->get('sales_filter'));
                }
      
                $data = $query->get();
            }
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btns = '';
                        $btns .= '<a href="' . route('daily_logs.show', $row->id) . '" style="margin-right:10px" title="Table View"><i class="fa-solid fa-eye"></i></a>';
                        $btns .= '<a href="" style="margin-right:10px" title="Map View"><i class="fa-solid fa-location-dot"></i></a>';
                        return $btns;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.sales_persons.daily_logs',compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $date = DailyLog::where('id',$id)->value('created_at');
        $sales_id = DailyLog::where('id',$id)->value('user_id');
        $sales_details = DailyLog::with('getsales')->where('id',$id)->get();
        
        $data = SalesVisit::with('getuser','getbuyer')->whereDate('created_at',$date)->where('order_by',$sales_id)->get();
        if ($request->ajax()) {
            $data = SalesVisit::with('getuser','getbuyer')->whereDate('created_at',$date)->where('order_by',$sales_id)->get();

            // if($request->get('end_date') != null || $request->get('search') != null || $request->get('sales_filter') != null){
            //     $query = DailyLog::with('getsales')->where('admin_id',$admin_id );
            //     // Date Filter
            //     if ($request->get('end_date') != null){
            //         $start_date = $request->get('start_date');
            //         $end_date = $request->get('end_date');
            //         $query->whereBetween('created_at', [$start_date, $end_date]);
            //     }
            //     // search Filter
            //     if ($request->get('search') != null){
            //         $query->where('id', 'like', '%'.$request->get('search').'%');
            //     }
                
            //     // sales Filter
            //     if ($request->get('sales_filter') != null){
            //         $query->where('user_id',$request->get('sales_filter'));
            //     }
      
            //     $data = $query->get();
            // }
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('visited_at', function ($data) {
                        return date('H:i:s', strtotime($data->created_at));
                    })
                    // ->editColumn('address', function ($data) {
                    //     $address = '<span>.$data->get.</span><br>';
                    //     return $address;
                    // })
                    ->editColumn('status', function ($data) {
                        if($data->order_status == 0){
                            $label = '<label class="label label-danger">No Order</label>';
                            return $label;
                        }else{
                            $label = '<label class="label label-success">Ordered</label>';
                            return $label;
                        }
                    })
                    ->rawColumns(['address','status'])
                    ->make(true);
        }
        return view('admin.sales_persons.visit_log',compact('data','sales_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
