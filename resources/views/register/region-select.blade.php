@foreach ($regions as $region)
<option value="{{$region->code}}">{{$region->name}}</option>
@endforeach