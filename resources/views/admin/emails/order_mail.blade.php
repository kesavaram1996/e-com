    @component('mail::message')
    # {{ $mailData['body'] }}

    Hello {{ $mailData['name'] }}.

    @component('mail::table')
    | Name       | Measurement         | Quantity          |
    | :--------- | :------------------ | :-------------    |
    @foreach ($mailData['data'] as $data)
    | {{$data->getorderproductvariant->getproduct->name}} | {{$data->getorderproductvariant->measurement.$data->getorderproductvariant->getmeasurementunit->measurement_unit}} | {{$data->quantity}} |
    @endforeach
    @endcomponent

    Thanks,

    {{ config('app.name') }}
    @endcomponent
