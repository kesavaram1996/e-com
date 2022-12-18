@if(!blank($data))
      @foreach($data as $row)
      <tr>
       <td>{{ $row->id}}</td>
       <td>{{ $row->getuser->name }}</td>
       <td>{{ $row->getaddress->phone }}</td>
       <td>
            @if($row->user_id == $row->order_by)
            Buyer
            @else
            Sales: {{$row->getorderbyuser->name}}
            @endif                
      </td>
       <td>{{ $row->final_total }}</td>
       <!-- <td>{{ $row->delivery_charge }}</td> -->
       <td>{{ $row->final_total }}</td>
       <td>{{ $row->payment_method }}</td>
       <td>
            @if($row->active_status == 'received')
                  <label class="label label-primary">Received</label>
            @elseif($row->active_status == 'processed')
                  <label class="label label-primary">Processed</label>
            @elseif($row->active_status == 'shipped')
                  <label class="label label-info">Shipped</label>
            @elseif($row->active_status == 'delivered')
                 <label class="label label-success">Delivered</label>
            @elseif($row->active_status == 'cancelled')
                 <label class="label label-danger">Cancelled</label>
            @elseif($row->active_status == 'returned')
                 <label class="label label-warning">Returned</label>
            @endif
       </td>
       <td class="text-center">
            <a href="{{route('admin_orders.show', $row->id)}}" style="margin-right:10px" title="View"><i class="fa-solid fa-eye"></i></a>
       </td>
      </tr>
      @endforeach
      <tr>
            <td colspan="9" align="center">
                  {!! $data->links('pagination::bootstrap-4') !!}
            </td>
      </tr>
@else
      <tr>
            <td colspan="9" align="center">
                  No Data Found
            </td>
      </tr>
@endif
